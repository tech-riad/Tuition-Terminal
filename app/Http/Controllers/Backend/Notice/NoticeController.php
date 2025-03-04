<?php

namespace App\Http\Controllers\Backend\Notice;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function allNotice()
    {
        return view('backend.notice.all_notice');
    }

    public function noticeTutorFilter(Request $request)
    {
        // dd($request->all());
        $tutors = Tutor::whereBetween('created_at', [$request->date_from, $request->date_to])->get();

        $numbers = $tutors->pluck('phone')->toArray();
        $count = count($numbers); // Get the total count of numbers

        return response()->json([
            'status' => 'success',
            'numbers' => $numbers,
            'count' => $count
        ]);
    }

}
