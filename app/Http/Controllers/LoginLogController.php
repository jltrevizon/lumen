<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginLogController extends Controller
{

    public function create(Request $request){
        $loginLog = new LoginLog();
        $loginLog->user_id = Auth::id();
        $loginLog->device_description = $request->input('device_description');
        $loginLog->save();
        return $loginLog;
    }

    public function getUser(Request $request){
        return LoginLog::where('user_id', $request->input('user_id'))
                    ->get();
    }

}
