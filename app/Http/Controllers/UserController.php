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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\VerificationEmail;


class UserController extends Controller
{
    const API_URL='http://192.168.1.24:14041/api';
    const API_KEY='5af97cb7eed7a5a4cff3ed91698d2ffb';

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        try {
            $response = Http::withHeaders([
                'x-api-key' => self::API_KEY,
            ])->post(self::API_URL . '/sso/login.json', [
                'username' => $request->email,
                'password' => $request->password,
            ]);

            $responseData = $response->json();

            // Log response for debugging
            Log::info('API Response', ['response' => $responseData]);

            if ($response->successful() && isset($responseData['data']['access_token'])) {

                // Simpan access token ke session
                session(['access_token' => $responseData['data']['access_token']]);

                // Jika personal_info tersedia dalam respons, simpan data tersebut ke session juga
                if (isset($responseData['data']['personal_info'])) {
                    $personalInfo = $responseData['data']['personal_info'];
                    session([
                        'birthday' => $personalInfo['birthday'],
                        'full_name' => $personalInfo['full_name'],
                        'gender' => $personalInfo['gender'],
                        'phone' => $personalInfo['phone'],
                        'username' => $personalInfo['username'],
                        'email' => $request->email, // Simpan email ke session
                    ]);

                    // Simpan URL gambar profil ke session jika tersedia
                    if (isset($personalInfo['profile_picture'])) {
                        session(['profile_picture' => $personalInfo['profile_picture']]);
                    }
                }

                return redirect()->route('dashboard');
            } else {
                // Tangani hasil respons berdasarkan nilai result
                $errorMessages = [
                    2 => 'Error 2 occurred. Please check the details.',
                    3 => 'Error 3 occurred. Please check the details.',
                    4 => 'Error 4 occurred. Please check the details.',
                ];

                // Jika result tidak sesuai dengan errorMessages, tampilkan pesan default
                $resultCode = $responseData['result'] ?? null;
                $errorMessage = $errorMessages[$resultCode] ?? 'The provided credentials do not match our records.';

                return back()->withErrors([
                    'error' => $errorMessage,
                ])->withInput();
            }

        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Exception caught in login method', ['error' => $e->getMessage()]);

            // Tangani kesalahan jika terjadi kesalahan dalam melakukan permintaan HTTP
            return back()->withErrors([
                'error' => 'Something went wrong. Please try again later.'
            ])->withInput();
        }
    }

    public function Alogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        try {
            $response = Http::withHeaders([
                'x-api-key' => self::API_KEY,
            ])->post(self::API_URL . '/sso/login.json', [
                'username' => $request->email,
                'password' => $request->password,
            ]);

            $responseData = $response->json();

            // Log response for debugging
            Log::info('API Response', ['response' => $responseData]);

            if ($response->successful() && isset($responseData['data']['access_token'])) {

                // Simpan access token ke session
                session(['access_token' => $responseData['data']['access_token']]);

                // Jika personal_info tersedia dalam respons, simpan data tersebut ke session juga
                if (isset($responseData['data']['personal_info'])) {
                    $personalInfo = $responseData['data']['personal_info'];
                    session([
                        'birthday' => $personalInfo['birthday'],
                        'full_name' => $personalInfo['full_name'],
                        'gender' => $personalInfo['gender'],
                        'phone' => $personalInfo['phone'],
                        'username' => $personalInfo['username'],
                        'email' => $request->email, // Simpan email ke session
                    ]);

                    // Simpan URL gambar profil ke session jika tersedia
                    if (isset($personalInfo['profile_picture'])) {
                        session(['profile_picture' => $personalInfo['profile_picture']]);
                    }
                }

                return redirect()->route('Adashboard');
            } else {
                // Tangani hasil respons berdasarkan nilai result
                $errorMessages = [
                    2 => 'Error 2 occurred. Please check the details.',
                    3 => 'Error 3 occurred. Please check the details.',
                    4 => 'Error 4 occurred. Please check the details.',
                ];

                // Jika result tidak sesuai dengan errorMessages, tampilkan pesan default
                $resultCode = $responseData['result'] ?? null;
                $errorMessage = $errorMessages[$resultCode] ?? 'The provided credentials do not match our records.';

                return back()->withErrors([
                    'error' => $errorMessage,
                ])->withInput();
            }

        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Exception caught in login method', ['error' => $e->getMessage()]);

            // Tangani kesalahan jika terjadi kesalahan dalam melakukan permintaan HTTP
            return back()->withErrors([
                'error' => 'Something went wrong. Please try again later.'
            ])->withInput();
        }
    }

    public function register(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users,user_email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Send request to SSO API
            $response = Http::withHeaders([
                'x-api-key' => self::API_KEY,
            ])->post(self::API_URL . '/sso/register.json', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $dataResponse = $response->json();

            // Log response from API
            Log::info('API Response', ['response' => $dataResponse]);

            if ($response->successful() && isset($dataResponse['result'])) {
                if ($dataResponse['result'] === 1) {
                    // Send verification email
                    Mail::to($request->email)->send(new VerificationEmail($request->email));

                    return redirect('register.confirmation')->with('success_message', $dataResponse['data']);
                } else {
                    return back()->withErrors([
                        'error_message' => $dataResponse['data'],
                    ])->withInput();
                }
            } else {
                // Log error if response is not successful
                Log::error('API Response Error', ['response' => $dataResponse]);
                return back()->withErrors([
                    'error_message' => 'Registration failed. Please try again!',
                ])->withInput();
            }
        } catch (\Exception $e) {
            // Log exception
            Log::error('Exception caught in register method', ['error' => $e->getMessage()]);
            return back()->withErrors([
                'error_message' => 'Something went wrong, please try again!',
            ])->withInput();
        }
    }

    public function Aregister(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users,user_email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Send request to SSO API
            $response = Http::withHeaders([
                'x-api-key' => self::API_KEY,
            ])->post(self::API_URL . '/sso/register.json', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $dataResponse = $response->json();

            // Log response from API
            Log::info('API Response', ['response' => $dataResponse]);

            if ($response->successful() && isset($dataResponse['result'])) {
                if ($dataResponse['result'] === 1) {
                    // Send verification email
                    Mail::to($request->email)->send(new VerificationEmail($request->email));

                    return redirect('register.confirmation')->with('success_message', $dataResponse['data']);
                } else {
                    return back()->withErrors([
                        'error_message' => $dataResponse['data'],
                    ])->withInput();
                }
            } else {
                // Log error if response is not successful
                Log::error('API Response Error', ['response' => $dataResponse]);
                return back()->withErrors([
                    'error_message' => 'Registration failed. Please try again!',
                ])->withInput();
            }
        } catch (\Exception $e) {
            // Log exception
            Log::error('Exception caught in register method', ['error' => $e->getMessage()]);
            return back()->withErrors([
                'error_message' => 'Something went wrong, please try again!',
            ])->withInput();
        }
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

    // public function update(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'fullname' => 'required|string|max:255',
    //         'username' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255',
    //         'notelp' => 'nullable|numeric',
    //         'alamat' => 'nullable|string|max:255',
    //         'password' => 'nullable|string|min:8|confirmed',
    //         'birthday' => 'required|date',
    //         'gender' => 'required|integer|in:0,1', // 0 for Female, 1 for Male
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $user = User::find($id);
    //     if ($request->has('password')) {
    //         $user->user_password = Hash::make($request->password);
    //     }
    //     $user->user_fullname = $request->fullname;
    //     $user->user_username = $request->username;
    //     $user->user_email = $request->email;
    //     $user->user_notelp = $request->notelp;
    //     $user->user_alamat = $request->alamat;
    //     $user->user_level = $request->level;
    //     $user->user_status = $request->status;

    //     if ($request->hasFile('profil')) {
    //         $file = $request->file('profil');
    //         $filePath = $file->store('public/user/profile');
    //         $user->user_profil_url = $filePath;
    //     }

    //     $user->save();

    //     try {
    //         $apiResponse = Http::withHeaders([
    //             'x-api-key' => self::API_KEY,
    //             'Authorization' => session('access_token'),
    //             'Content-Type' => 'application/json',
    //         ])->post(self::API_URL . '/sso/update_personal_info.json', [
    //             'fullname' => $request->input('fullname'),
    //             'username' => $request->input('username'),
    //             'birthday' => $request->input('birthday'),
    //             'phone' => $request->input('notelp'),
    //             'gender' => $request->input('gender'),
    //             'address' => $request->input('alamat'),
    //         ]);

    //         if ($apiResponse->failed()) {
    //             return redirect()->back()->withErrors('Perbarui info pribadi di layanan eksternal gagal.');
    //         }

    //         return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    //     } catch (\Exception $e) {
    //         Log::error('Exception caught in update method', ['error' => $e->getMessage()]);
    //         return redirect()->back()->withErrors('Something went wrong. Please try again.');
    //     }
    // }
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user_id = auth()->id(); // Ambil user ID dari auth

        $url = config('services.api.base_url') . '/sso/update_profile_picture.json';

        $headers = [
            'x-api-key' => env('API_KEY'),
            'Authorization' => '29f9046aacc1ac739654f04ef434e722',
        ];

        $response = Http::withHeaders($headers)->attach(
            'image',
            file_get_contents($request->file('image')->getRealPath()),
            $request->file('image')->getClientOriginalName()
        )->post($url, ['user_id' => $user_id]);

        Log::info('Profile Picture Update API Response', [
            'url' => $url,
            'response' => $response->json(),
            'status' => $response->status()
        ]);

        if ($response->successful()) {
            Log::info('Profile picture updated successfully for user ID: ' . $user_id);
            Session::flash('success', 'Profile picture updated successfully!');
        } else {
            Log::error('Failed to update profile picture', [
                'user_id' => $user_id,
                'error' => $response->body()
            ]);
            Session::flash('error', 'Failed to update profile picture');
        }

        return redirect()->back();
    }
    public function updatePersonalInfo(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'birthday' => 'required|date_format:Y-m-d',
            'phone' => 'required|string|max:20',
            'gender' => 'required|integer|in:0,1', // 1. Male, 0. Female
            'address' => 'required|string|max:255',
        ]);

        $user_id = auth()->id(); // Ambil user ID dari auth

        $url = config('services.api.base_url') . '/sso/update_personal_info.json';

        $headers = [
            'x-api-key' => env('API_KEY'),
            'Authorization' => '0f031be1caef52cfc46ecbb8eee10c77',
        ];

        $response = Http::withHeaders($headers)->post($url, array_merge($validated, ['user_id' => $user_id]));

        Log::info('Personal Info Update API Response', [
            'url' => $url,
            'response' => $response->json(),
            'status' => $response->status()
        ]);

        if ($response->successful()) {
            Log::info('Personal info updated successfully for user ID: ' . $user_id);
            Session::flash('success', 'Personal info updated successfully!');
        } else {
            Log::error('Failed to update personal info', [
                'user_id' => $user_id,
                'error' => $response->body()
            ]);
            Session::flash('error', 'Failed to update personal info');
        }

        return redirect()->back();
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

        try {
            $apiResponse = Http::withHeaders([
                'x-api-key' => self::API_KEY,
                'Authorization' => session('access_token'),
            ])->post(self::API_URL . '/sso/change_password.json', [
                'password' => $request->input('password'),
                'address' => 'MDX-SSA',
            ]);

            if ($apiResponse->failed()) {
                return redirect()->route('profil')->withErrors('Perubahan kata sandi di layanan eksternal gagal.');
            }

            return redirect()->route('profil')->with('success', 'Kata sandi berhasil diubah!');
        } catch (\Exception $e) {
            Log::error('Exception caught in changePassword method', ['error' => $e->getMessage()]);
            return redirect()->route('profil')->withErrors('Something went wrong. Please try again.');
        }
    }
}
