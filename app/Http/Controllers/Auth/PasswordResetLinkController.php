<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\RedirectResponse;

class PasswordResetLinkController extends Controller
{
    public function create(Request $request, $token = null)
    {
        return view('auth.forgot-password')->with([
            'token' => $token,
            'user_email' => $request->input('user_email'),
        ]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['user_email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('user_email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['user_email' => __($status)]);
    }

    public function showResetPasswordForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'user_email' => $request->input('user_email'),
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'user_email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $response = Http::withHeaders([
            'x-api-key' => config('services.backbone.api_key'),
        ])->post(config('services.backbone.base_url') . '/sso/change_password.json', [
            'user_email' => $request->input('user_email'),
            'password' => $request->input('password'),
        ]);

        if ($response->successful()) {
            return redirect()->route('login')->with('status', 'Password changed successfully. Please login with your new password.');
        } else {
            return back()->withErrors(['user_email' => 'Failed to change password. Please try again.']);
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'user_email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('user_email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('user_email'))
                ->withErrors(['user_email' => __($status)]);
    }
}
