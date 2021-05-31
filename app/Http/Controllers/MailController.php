<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendCode;
use App\Models\User;
use App\Models\PasswordResetCode;

class MailController extends Controller
{
    public function testCode(SendCode $sendCode){
        return $sendCode->send();
    }

    public function sendCodePassword(SendCode $sendCode, Request $request){
        $user = User::where('email', $request->json()->get('email'))
                    ->first();
        $code = $this->generateCode(6);
        $sendCode->SendCodePassword($user->name, $code, $user->email);
        $passwordResetCode = new PasswordResetCode();
        $passwordResetCode->user_id = $user->id;
        $passwordResetCode->code = $code;
        $passwordResetCode->save();
       // return $code;
    }

    public function generateCode($length){
        return substr(str_shuffle("0123456789"), 0, $length);
    }

    public function passwordReset(Request $request){
        $user = User::where('email', $request->json()->get('email'))
                        ->first();
        $passwordResetCode = PasswordResetCode::where('user_id', $user->id)
                                        ->where('active', true)
                                        ->orderBy('created_at','desc')
                                        ->first();
        //return $passwordResetCode;
        if($passwordResetCode && $passwordResetCode->code == $request->json()->get('code')){
            $user->password = app('hash')->make($request->json()->get('password'));
            $user->save();
            $passwordResetCode->active = false;
            $passwordResetCode->save();
            return response()->json(['message' => 'Password changed']);
        } else {
            return response()->json(['message' => 'Code not available']);
        }

    }
}
