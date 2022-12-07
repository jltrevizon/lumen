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
    }

    /**
     * @OA\Post(
     *     path="/api/password/send-code",
     *     tags={"passwords"},
     *     summary="Send Code",
     *     operationId="SendCode",
     *     @OA\Response(
     *         response="200",
     *         description="Successful send code",
     *         value = @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Email enviado or El usuario no existe",
     *              ),
     *          ),
     *     ),
     *     @OA\Response(
     *        response="409",
     *        description="",
     *     ),
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         value = @OA\JsonContent(
     *              required={"email"},
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  format="email"
     *              )
     *         )
     *     )
     * )
     */

    public function sendCodePassword(Request $request){
        try {
            $code = $this->generateCode(6);
            $user = User::where('email', $request->input('email'))
                        ->first();
            $passwordReset = new PasswordResetCode();
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

    /**
     * @OA\Post(
     *     path="/api/password/reset",
     *     tags={"passwords"},
     *     summary="Reset password",
     *     operationId="ResetPassword",
     *     @OA\Response(
     *         response="200",
     *         description="Successful reset password",
     *         value = @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Password changed",
     *              ),
     *          ),
     *     ),
     *     @OA\Response(
     *        response="409",
     *        description="",
     *        value = @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Code not available",
     *              ),
     *          ),
     *     ),
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         value = @OA\JsonContent(
     *              required={"email","password","code"},
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  format="email"
     *              ),
     *              @OA\Property(
     *                  property="code",
     *                  type="integer",
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  format="password"
     *              )
     *         )
     *     )
     * )
     */

    public function passwordReset(Request $request){
        $user = User::where('email', $request->input('email'))
                        ->first();
        $passwordResetCode = PasswordResetCode::where('user_id', $user->id)
                                        ->where('active', true)
                                        ->orderBy('created_at','desc')
                                        ->first();
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
