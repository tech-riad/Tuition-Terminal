<?php

use App\Http\Controllers\Backend\Setting\SettingController;
use Illuminate\Support\Facades\Route ;


Route::middleware(['auth'])->group(function () {

Route::get('/admin/user-agent', [SettingController::class, 'userAgent'])->name('admin.user.agent')->middleware('auth')->middleware('permission:user-agent');
Route::post('/admin/user-agent-add', [SettingController::class, 'userAgentAdd'])->name('admin.user.agent.add')->middleware('auth')->middleware('permission:user-agent-add');
});
