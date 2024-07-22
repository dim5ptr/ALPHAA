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

        // Make the API call to login the user on the external service
        $apiResponse = Http::withHeaders([
            'x-api-key' => config('app.api_key'),
            'dev-key' => '12',
        ])->post(config('app.base_url') . '/sso/login.json', [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ]);

        if ($apiResponse->failed()) {
            return back()->withErrors('Login ke layanan eksternal gagal.');
        }

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
    $user->sendEmailVerificationNotification(); // Mengirim email verifikasi

    // Make the API call to register the user on the external service
    $apiResponse = Http::withHeaders([
        'x-api-key' => config('app.api_key'),
    ])->post(config('app.base_url') . '/sso/register.json', [
        'email' => $request->input('email'),
        'password' => $request->input('password'),
        'address' => $request->input('alamat'),
    ]);

    if ($apiResponse->failed()) {
        return redirect()->route('register')->withErrors('Pendaftaran ke layanan eksternal gagal.');
    }

    // Redirect ke halaman dengan pesan sukses
    return redirect()->route('register.confirmation')->with('success', 'Pendaftaran berhasil! Silakan cek email Anda untuk konfirmasi.');
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

    public function userVerify(Request $request)
    {
        $apiResponse = Http::withHeaders([
            'Authorization' => '',
            'x-api-key' => config('app.api_key'),
        ])->post(config('app.base_url') . '/sso/user_verify.json', [
            'activation_key' => '24BD-0BA8-1FD5-0928-A98B-E83D-EA67-2F33',
            'ip_address' => 'MDX-SSA',
        ]);

        if ($apiResponse->failed()) {
            return redirect()->route('verify')->withErrors('Verifikasi ke layanan eksternal gagal.');
        }

        return redirect()->route('dashboard')->with('success', 'Verifikasi berhasil!');
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

        // Make the API call to update the personal info on the external service
        $apiResponse = Http::withHeaders([
            'x-api-key' => config('app.api_key'),
            'Authorization' => '0f031be1caef52cfc46ecbb8eee10c77',
        ])->post(config('app.base_url') . '/sso/update_personal_info.json', [
            'fullname' => $request->input('fullname'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);

        if ($apiResponse->failed()) {
            return redirect()->back()->withErrors('Perbarui info pribadi di layanan eksternal gagal.');
        }

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

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->user_password = Hash::make($request->password);
        $user->save();

        // Make the API call to change the password on the external service
        $apiResponse = Http::withHeaders([
            'x-api-key' => config('app.api_key'),
            'Authorization' => '0f031be1caef52cfc46ecbb8eee10c77',
        ])->post(config('app.base_url') . '/sso/change_password.json', [
            'password' => $request->input('password'),
            'address' => 'MDX-SSA',
        ]);

        if ($apiResponse->failed()) {
            return redirect()->route('profil')->withErrors('Perubahan kata sandi di layanan eksternal gagal.');
        }

        return redirect()->route('profil')->with('success', 'Kata sandi berhasil diubah!');
    }

    public function updateProfilePicture(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = $file->store('public/user/profile');
            $user->user_profil_url = $filePath;
            $user->save();

            // Make the API call to update the profile picture on the external service
            $apiResponse = Http::withHeaders([
                'x-api-key' => config('app.api_key'),
                'Authorization' => '0f031be1caef52cfc46ecbb8eee10c77',
            ])->post(config('app.base_url') . '/sso/update_profile_picture.json', [
                'address' => 'MDX-SSA',
                'fullname' => 'MDX User',
                'phone' => '081321155025',
            ]);

            if ($apiResponse->failed()) {
                return redirect()->back()->withErrors('Perbarui foto profil di layanan eksternal gagal.');
            }

            return redirect()->route('profil')->with('success', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->route('profil')->with('error', 'Tidak ada foto yang diunggah.');
    }

    public function updatePersonalInfo(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,user_username,' . $user->id,
            'birthday' => 'required|date',
            'phone' => 'required|string|max:15',
            'gender' => 'required|string|in:male,female',
            'address' => 'required|string|max:255',
        ]);

        $user->user_fullname = $request->input('fullname');
        $user->user_username = $request->input('username');
        $user->user_birthday = $request->input('birthday');
        $user->user_phone = $request->input('phone');
        $user->user_gender = $request->input('gender');
        $user->user_address = $request->input('address');
        $user->save();

        // Make the API call to update the personal info on the external service
        $apiResponse = Http::withHeaders([
            'x-api-key' => config('app.api_key'),
            'Authorization' => '0f031be1caef52cfc46ecbb8eee10c77',
        ])->post(config('app.base_url') . '/sso/update_personal_info.json', [
            'fullname' => $request->input('fullname'),
            'username' => $request->input('username'),
            'birthday' => $request->input('birthday'),
            'phone' => $request->input('phone'),
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
        ]);

        if ($apiResponse->failed()) {
            return redirect()->back()->withErrors('Perbarui info pribadi di layanan eksternal gagal.');
        }

        return redirect()->back()->with('success', 'Informasi pribadi berhasil diperbarui!');
    }
}
