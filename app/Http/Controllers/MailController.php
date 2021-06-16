<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendCode;
use App\Models\User;
use App\Models\PasswordResetCode;
use Illuminate\Support\Facades\Mail;
use App\Repositories\UserRepository;
use Exception;

class MailController extends Controller
{

    public function __construct(SendCode $sendCode)
    {
        $this->sendCode = $sendCode;
    }

    public function testCode(SendCode $sendCode){
        //return $sendCode->send();
    }

    public function sendCodePassword(Request $request){
        try {

            $code = $this->generateCode(6);
            $passwordReset = new PasswordResetCode();
            $user = User::where('email', $request->input('email'))
                        ->first();
                        return $user;
            $passwordReset->user_id = $user->id;
            $passwordReset->code = $code;
            $passwordReset->save();
            if($user){
                $this->sendCode->SendCodePassword($user->name, $code, $user->email);
                return response()->json(['message' => 'Email enviado'], 200);
            } else {
                return response()->json(['message' => 'El usuario no existe'], 200);
            }
        } catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function generateCode($length){
        return substr(str_shuffle("0123456789"), 0, $length);
    }

    public function passwordReset(Request $request){
        $user = User::where('email', $request->input('email'))
                        ->first();
        $passwordResetCode = PasswordResetCode::where('user_id', $user->id)
                                        ->where('active', true)
                                        ->orderBy('created_at','desc')
                                        ->first();
        //return $passwordResetCode;
        if($passwordResetCode && $passwordResetCode->code == $request->input('code')){
            $user->password = app('hash')->make($request->input('password'));
            $user->save();
            $passwordResetCode->active = false;
            $passwordResetCode->save();
            return response()->json(['message' => 'Password changed']);
        } else {
            return response()->json(['message' => 'Code not available']);
        }

    }
}
