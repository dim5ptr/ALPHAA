<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Ambil token dari sesi atau dari header permintaan
        $token = session('access_token') ?? $request->header('Authorization');

        if (!$token) {
            return redirect()->route('login')->withErrors(['error' => 'You need to log in first.']);
        }

        // Verifikasi token dengan API
        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->get(config('app.api_url') . '/verify-token'); // Sesuaikan dengan endpoint verifikasi token API Anda

        if ($response->failed()) {
            // Jika verifikasi gagal, arahkan ke halaman login
            return redirect()->route('login')->withErrors(['error' => 'Invalid token. Please log in again.']);
        }

        return $next($request);
    }
}
