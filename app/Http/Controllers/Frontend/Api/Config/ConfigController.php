<?php

namespace App\Http\Controllers\Frontend\Api\Config;

use App\Http\Controllers\Controller;
use App\Models\Curriculam;
use App\Models\Day;
use App\Models\Degree;
use App\Models\Department;
use App\Models\PwaDownload;
use App\Models\Study;
use App\Models\TeachingMethod;
use App\Models\WebLead;
use Exception;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;


class ConfigController extends Controller
{
    use ApiResponse;
    public function allDepartment()
    {
       try
       {
        $departments = Department::all();
        return $this->resposeSuccess('data get successfully',$departments);
       }catch(Exception $e)
       {
        return $this->resposeError('',$e->getMessage());
       }

    }



    public function allConfigData()
    {
        try
        {
            $studies = Study::all();
            $days = Day::all();
            $degree = Degree::all();
            $curriculam = Curriculam::all();
            $teaching_method = TeachingMethod::all();

          $config_data =[
            'studies' =>$studies,
            'days' => $days,
            'degrees' => $degree,
            'curriculams' => $curriculam,
            'teaching_methods' => $teaching_method,
          ];
        return $this->resposeSuccess('data get successfully',$config_data);
        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }
    }

    public function hireTutor(Request $request)
    {

        $validator = Validator()->make($request->all(), [
            'phone' => 'required|regex:/^(01)[0-9]{9}$/'

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        $webLead = new WebLead();
        $webLead->name = $request->name;
        $webLead->location = $request->location;
        $webLead->class = $request->class;
        $webLead->tutor_gender = $request->tutor_gender;
        $webLead->phone = $request->phone;
        $webLead->save();

        return response()->json(['message' => 'Your requirement sent successfully.']);





    }
    public function pwaCount(Request $request)
    {
        $count = PwaDownload::firstOrCreate([], ['count' => 0]);
        $count->increment('count');

    }

    public function pwaCountGet()
    {
        $count = PwaDownload::value('count');
        return response()->json(['success' => true, 'count' => $count]);

    }

}
