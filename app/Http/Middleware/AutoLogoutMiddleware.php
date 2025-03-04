<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use App\Models\UserLoginLog;

 class AutoLogoutMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $lastActivity = Session::get('last_activity');

            if (!in_array($user->role_id, [1, 6])) {
                if ($lastActivity && Carbon::parse($lastActivity)->diffInMinutes(now()) >= 10) {

                    $newPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 12);

                    $user->password = Hash::make($newPassword);
                    $user->save();

                    $userLog = new UserLoginLog();
                    $userLog->user_id = $user->id;
                    $userLog->name = $user->name;
                    $userLog->phone = $user->phone;
                    $userLog->logout_at = Carbon::now();
                    $userLog->logout_reason = 'Inactive';
                    $userLog->logout_duration_apx = 'Admin';
                    $userLog->user_agent = request()->header('User-Agent');
                    $userLog->ip_address = request()->ip();
                    $userLog->save();

                    Auth::logout();
                    Session::forget('last_activity');

                    return redirect()->route('employee.login')->with('message', 'You were inactive for 20 minutes. Your password has been reset.');
                }
            }

            Session::put('last_activity', now());
        }

        return $next($request);
    }
}

