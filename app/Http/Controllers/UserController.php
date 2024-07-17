<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            "user_username" => $request->input("username"),
            "user_password" => $request->input("password"),
        ];
        $user = User::where("user_username", $credentials["user_username"])->first();
        if ($user && Hash::check($credentials["user_password"], $user->user_password)) {
            Auth::login($user);
            Log::info("🟢 User " . $user->user_fullname . " berhasil login");
            return redirect()->route("dashboard");
        } else {
            return back()->withErrors([
                "message" => "Username atau password Anda salah.",
            ]);
        }
    }

    public function register(Request $request)
{
    $request->validate([
        'fullname' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users',
        'email' => 'required|string|email|max:255|unique:users',
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

    // Kirim notifikasi verifikasi email
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

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi data
        $request->validate([
            'profil' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,user_username,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'email' => 'required|string|email|max:255|unique:users,user_email,' . $user->id,
            'notelp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ]);

        // Handle file upload
        if ($request->hasFile('profil')) {
            // Delete old profile picture if it exists
            if ($user->user_profil_url) {
                Storage::delete('public/user/profile/' . basename($user->user_profil_url));
            }

            // Upload new profile picture
            $fileName = $request->file('profil')->store('public/user/profile');
            $user->user_profil_url = Storage::url($fileName);
        }

        // Update user data
        $user->user_fullname = $request->fullname;
        $user->user_username = $request->username;
        if ($request->filled('password')) {
            $user->user_password = bcrypt($request->password);
        }
        $user->user_email = $request->email;
        $user->user_notelp = $request->notelp;
        $user->user_alamat = $request->alamat;

        $user->save();

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui!');
    }
}
