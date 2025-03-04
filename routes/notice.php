<?php

use App\Http\Controllers\Backend\Notice\NoticeController;
use Illuminate\Support\Facades\Route ;



Route::middleware(['auth'])->group(function () {
    Route::get('/admin/all-notice',[ NoticeController::class,'allNotice'])->name('admin.all.notice');

    Route::post('/admin/all-notice/tutor-filter',[ NoticeController::class,'noticeTutorFilter'])->name('admin.all.notice.tutor.filter');



});
