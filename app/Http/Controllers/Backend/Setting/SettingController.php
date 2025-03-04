<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Exports\ApplicationPaymentExport;
use App\Exports\ConfoirmJobExport;
use App\Exports\DueExport;
use App\Exports\DueExportDateWise;
use App\Exports\DueJobExport;
use App\Exports\PaymentExportDateWise;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\ApplicationPayment;
use App\Models\DeskNumber;
use App\Models\DuePayments;
use App\Models\Parents;
use App\Models\Tutor;
use App\Models\TutorConvertParent;
use App\Models\User;
use App\Models\WebSetting;
use Faker\Provider\UserAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index(){
        // dd('hi');
        return view('backend.setting.setting_sidenav');

    }
    public function websiteSetting(){
        $data = WebSetting::first();

        if ($data && isset($data->set_point_date)) {
            $data->set_point_date = \Carbon\Carbon::parse($data->set_point_date)->format('Y-m-d');
        }
        return view('backend.setting.website_setting',compact('data'));
    }

    public function smsSetting(){
        return view('backend.setting.sms_setting');
    }

    public function ReferenceTableSetting(){
        return view('backend.setting.reference_table_setting');
    }

    public function webMail(){
        return view('backend.setting.web_mail');
    }

    public function paymentSetPoint(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'set_point_date' => 'required|date',
            ]);

            $setting = WebSetting::first();
            $setting->set_point_date = $request->set_point_date;
            $setting->update();

            return response()->json(['message' => 'Date saved successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Error saving date: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while saving the date'], 500);
        }
    }

    public function exportDueJob(Request $request)
    {
        return Excel::download(new DueJobExport, 'due_job_all.xlsx');
    }
    public function exportConfirmJob(Request $request)
    {
        return Excel::download(new ConfoirmJobExport, 'confirm_job_all.xlsx');
    }
    public function exportPayment(Request $request)
    {
        return Excel::download(new ApplicationPaymentExport, 'payment_all.xlsx');
    }
    public function exportDue(Request $request)
    {
        return Excel::download(new DueExport, 'due_all.xlsx');
    }
    public function exportData(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = ApplicationPayment::whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return Excel::download(new PaymentExportDateWise($data), 'payments_from_' . $startDate . '_to_' . $endDate . '.xlsx');
    }
    public function exportDateWise(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = DuePayments::whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return Excel::download(new DueExportDateWise($data), 'due_from_' . $startDate . '_to_' . $endDate . '.xlsx');
    }


    public function userAgent(Request $request)
    {
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 10);
        $userAgent = DeskNumber::orderBy('id', 'desc')->paginate(20);
        return view('backend.setting.user_agent',compact('userAgent','currentRoute','paginationLimit'));
    }

    public function userAgentAdd(Request $request)
    {
        $validated = $request->validate([
            'desk_number' => 'required|integer',
            'user_agent' => 'required|string|max:255',
        ]);

        // Save to database
        $userAgent = new DeskNumber();
        $userAgent->desk_number = $request->desk_number;
        $userAgent->user_agent = $request->user_agent;
        $userAgent->save();

        return response()->json(['status' => true, 'message' => 'User Agent added successfully!']);
    }

    public function convertParentIndex(Request $request)
    {

        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 10);
        $converted = TutorConvertParent::orderBy('id', 'desc')->paginate(20);
        return view('backend.setting.convert_parent',compact('currentRoute','paginationLimit','converted'));


    }

    public function convertTutorParent(Request $request)
    {
        try {
            $fromTutorId = $request->input('from_tutor_id');
            $toTutorId = $request->input('to_tutor_id');

            $tutors = Tutor::whereBetween('unique_id', [$fromTutorId, $toTutorId])->get();

            if ($tutors->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No tutors found in the specified range.'], 404);
            }

            $parentsCreated = [];
            foreach ($tutors as $tutor) {
                $existingParent = Parents::where('phone', $tutor->phone)->exists();

                if ($existingParent) {
                    continue;
                }

                $parent = new Parents();
                $parent->name = $tutor->name;
                $parent->phone = $tutor->phone;
                $parent->email = $tutor->email ?? '';
                $parent->otp = rand(1234, 9999);
                $parent->phone_verified_at = now();
                $parent->password = Hash::make(123456);
                $parent->save();

                $parent->get_parent_unique_id();

                $parentsCreated[] = $parent;
            }

            $tutorConvert = new TutorConvertParent();
            $tutorConvert->from_tutor_id = $fromTutorId;
            $tutorConvert->to_tutor_id = $toTutorId;
            $tutorConvert->success = count($parentsCreated);
            $tutorConvert->action_by = Auth::user()->id;
            $tutorConvert->save();

            return response()->json([
                'success' => true,
                'message' => count($parentsCreated) . ' parents successfully created.',
                'data' => $parentsCreated,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // For Manually Model Role Update
    public function modelRoleSetup(Request $request)
    {
        $users = User::where('role_id', $request->role_id)->get();

        $insertData = [];

        foreach ($users as $user) {
            $insertData[] = [
                'role_id' => $user->role_id,
                'model_id' => $user->id,
                'model_type' => 'App\Models\User',
            ];
        }

        DB::table('model_has_roles')->insertOrIgnore($insertData);

        session()->flash('success', 'Roles assigned successfully!');
        return redirect()->back();
    }


}
