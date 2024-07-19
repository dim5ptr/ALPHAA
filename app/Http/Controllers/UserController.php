<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            "user_username" => $request->input("username"),
            "user_password" => $request->input("password"),
        ];

        $user = User::where("user_username", $credentials["user_username"])->first();

        if (!$user) {
            return back()->withErrors([
                "message" => "Username atau password Anda salah.",
            ]);
        }

        if (!Hash::check($credentials["user_password"], $user->user_password)) {
            return back()->withErrors([
                "message" => "Username atau password Anda salah.",
            ]);
        }

        Auth::login($user);
        Log::info("🟢 User " . $user->user_fullname . " berhasil login");

        return redirect()->route("dashboard");
    }

    public function showVerificationStatus(Request $request)
    {
        $activationKey = $request->query('activation_key');
        $url = "http://192.168.1.24:14041/api/sso/user_verify.json?activation_key={$activationKey}";

        return view('verification', ['url' => $url]);
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Email verifikasi baru telah dikirim.');
    }

    public function register(Request $request)
{
    $request->validate([
        'fullname' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,user_username',
        'email' => 'required|string|email|max:255|unique:users,user_email',
        'notelp' => 'required|string|max:20',
        'alamat' => 'required|string|max:255',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $data = [
        'user_fullname' => $request->input('fullname'),
        'user_username' => $request->input('username'),
        'user_password' => bcrypt($request->input('password')),
        'user_email' => $request->input('email'),
        'user_notelp' => $request->input('notelp'),
        'user_alamat' => $request->input('alamat'),
    ];

    $user = User::create($data);

    $user->sendEmailVerificationNotification();

    Log::info("🟢 User bernama " . $request->input("username") . " telah mendaftar");

    return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan verifikasi email Anda.');
}

public function verifyEmail(Request $request)
{
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->route('dashboard')->with('success', 'Email sudah diverifikasi.');
    }

    if ($request->user()->markEmailAsVerified()) {
        Auth::login($request->user()); // Log the user in after email verification
        event(new \Illuminate\Auth\Events\Verified($request->user()));
    }

    return redirect()->route('dashboard')->with('success', 'Email berhasil diverifikasi.');
}

public function resendVerificationEmail(Request $request)
{
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->route('dashboard');
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('success', 'Link verifikasi email baru telah dikirim.');
}

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6',
            'address' => 'required|string',
        ]);

        $response = Http::withHeaders([
            'x-api-key' => config('services.backbone.api_key'),
            'Authorization' => '0f031be1caef52cfc46ecbb8eee10c77'
        ])->post(config('services.backbone.base_url') . '/sso/change_password.json', [
            'password' => $request->input('password'),
            'address' => $request->input('address')
        ]);

        if ($response->successful()) {
            return response()->json([
                'message' => 'Password changed successfully.',
                'data' => $response->json()
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to change password.',
                'error' => $response->body()
            ], $response->status());
        }
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'profil' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,user_username,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'email' => 'required|string|email|max:255|unique:users,user_email,' . $user->id,
            'notelp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ]);

        $phoneValidationResponse = Http::withHeaders([
            'x-api-key' => config('services.backbone.api_key')
        ])->post(config('services.backbone.base_url') . '/sso/validate_phone.json', [
            'phone' => $request->input('notelp')
        ]);

        if (!$phoneValidationResponse->successful()) {
            return back()->withErrors([
                "message" => "Phone validation failed: " . $phoneValidationResponse->body(),
            ]);
        }

        if ($request->hasFile('profil')) {
            if ($user->user_profil_url) {
                Storage::delete('public/user/profile/' . basename($user->user_profil_url));
            }

            $fileName = $request->file('profil')->store('public/user/profile');
            $user->user_profil_url = Storage::url($fileName);

            $response = Http::withHeaders([
                'x-api-key' => config('services.backbone.api_key'),
                'Authorization' => '29f9046aacc1ac739654f04ef434e722',
                'Enctype' => 'multipart/form-data'
            ])->attach(
                'image', file_get_contents($request->file('profil')->getRealPath()), $request->file('profil')->getClientOriginalName()
            )->post(config('services.backbone.base_url') . '/sso/update_profile_picture.json');

            if (!$response->successful()) {
                return redirect()->route('profil')->with('error', 'Failed to update profile picture.');
            }
        }

        $user->update([
            'user_fullname' => $request->input('fullname'),
            'user_username' => $request->input('username'),
            'user_password' => $request->input('password') ? bcrypt($request->input('password')) : $user->user_password,
            'user_email' => $request->input('email'),
            'user_notelp' => $request->input('notelp'),
            'user_alamat' => $request->input('alamat'),
        ]);

        Log::info("🟢 User bernama " . $request->input("username") . " telah diperbarui");

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui!');
    }

    public function deleteProfilePicture(Request $request)
    {
        $user = Auth::user();

        if ($user->user_profil_url) {
            Storage::delete('public/user/profile/' . basename($user->user_profil_url));
            $user->user_profil_url = null;
            $user->save();

            Log::info("🟢 User bernama " . $user->user_fullname . " telah menghapus foto profil");

            return redirect()->route('profil')->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->route('profil')->with('error', 'Foto profil tidak ditemukan.');
    }
}
