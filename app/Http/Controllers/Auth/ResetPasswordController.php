<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Models\User;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/dashboard';

    public function reset(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && $user->google_id) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Akaun ini menggunakan log masuk Google. Sila gunakan butang "Login dengan Google".']);
        }

        $request->validate($this->rules(), $this->validationErrorMessages());

        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response == \Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return redirect()->route('login')
            ->with('status', 'Kata laluan anda telah berjaya direset!');
    }
}