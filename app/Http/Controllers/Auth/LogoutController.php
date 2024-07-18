<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        // Get the API key from the environment or configuration
        $apiKey = config('services.api.key');
        $baseUrl = config('services.api.base_url');
        $authorizationToken = '49d843007dabb68bfddf309df8441dd0'; // example token, replace with actual logic to retrieve

        // Send the logout request to the external API
        $response = Http::withHeaders([
            'Authorization' => $authorizationToken,
            'x-api-key' => $apiKey
        ])->post($baseUrl . '/sso/logout.json');

        if ($response->successful()) {
            // Invalidate user session in your application
            Auth::logout();
            Session::flush();

            // Redirect to the login page with a success message
            return redirect()->route('login')->with('success', 'You have been logged out successfully.');
        } else {
            // Handle the error response from the API
            return redirect()->back()->with('error', 'Failed to logout. Please try again.');
        }
    }
}
