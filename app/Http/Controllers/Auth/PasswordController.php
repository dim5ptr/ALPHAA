<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Update the user's password
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect back with a status message
        return back()->with('status', 'password-updated');
    }
}
