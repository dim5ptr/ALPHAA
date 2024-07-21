<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Verified;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            "user_username" => $request->input("username"),
            "user_password" => $request->input("password"),
        ];

        $user = User::where("user_username", $credentials["user_username"])->first();

        if (!$user || !Hash::check($credentials["user_password"], $user->user_password)) {
            return back()->withErrors([
                "message" => "Username atau password Anda salah.",
            ]);
        }

        if (!$user->hasVerifiedEmail()) {
            return back()->withErrors([
                "message" => "Silakan konfirmasi email Anda terlebih dahulu.",
            ]);
        }

        Auth::login($user);
        Log::info("🟢 User " . $user->user_fullname . " berhasil login");

        return redirect()->route("dashboard");
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

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan cek email Anda untuk konfirmasi.');
    }


    public function verifyEmail($id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('login')->withErrors(['message' => 'Link konfirmasi tidak valid.']);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            Log::info("🟢 User " . $user->user_fullname . " berhasil konfirmasi email");
        }

        return redirect()->route('login')->with('success', 'Email berhasil dikonfirmasi! Silakan login.');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'notelp' => 'nullable|numeric',
            'alamat' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find($id);
        if ($request->has('password')) {
            $user->user_password = Hash::make($request->password);
        }
        $user->user_fullname = $request->fullname;
        $user->user_username = $request->username;
        $user->user_email = $request->email;
        $user->user_notelp = $request->notelp;
        $user->user_alamat = $request->alamat;
        $user->user_level = $request->level;
        $user->user_status = $request->status;

        if ($request->hasFile('profil')) {
            $file = $request->file('profil');
            $filePath = $file->store('public/user/profile');
            $user->user_profil_url = $filePath;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
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
