<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->google_id) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['email' => 'Akaun ini menggunakan log masuk Google. Sila gunakan butang "Login dengan Google" di halaman log masuk.']);
        }
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('status', 'Pautan reset kata laluan telah dihantar ke emel anda!');
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Kami tidak dapat mencari pengguna dengan alamat emel tersebut.']);
    }
}