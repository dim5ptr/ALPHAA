<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @param  Request  $request
     * @param  string|null  $token
     * @return \Illuminate\View\View
     */
    public function create(Request $request, $token = null)
    {
        return view('auth.forgot-password')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Http::withHeaders([
            'x-api-key' => config('services.backbone.api_key'),
        ])->post(config('services.backbone.base_url') . '/sso/forgot_password.json', [
            'email' => $request->input('email'),
        ]);

        if ($response->successful()) {
            return back()->with('status', 'Password reset link sent! Please check your email.');
        } else {
            return back()->withErrors(['email' => 'Failed to send reset link. Please try again.']);
        }
    }

    /**
     * Show the reset password form.
     *
     * @param  Request  $request
     * @param  string|null  $token
     * @return \Illuminate\View\View
     */
    public function showResetPasswordForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle the password change request.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $response = Http::withHeaders([
            'x-api-key' => config('services.backbone.api_key'),
            'Authorization' => '0f031be1caef52cfc46ecbb8eee10c77', // Replace with actual authorization token if needed
        ])->post(config('services.backbone.base_url') . '/sso/change_password.json', [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if ($response->successful()) {
            return redirect()->route('login')->with('status', 'Password changed successfully. Please login with your new password.');
        } else {
            return back()->withErrors(['email' => 'Failed to change password. Please try again.']);
        }
    }

    /**
     * Store a new password reset link request.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Send the password reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Determine the response based on the status
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}
