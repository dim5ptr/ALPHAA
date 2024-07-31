<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\RegisterMail;
use App\Mail\ActivationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Verified;
use App\Mail\VerificationEmail;


class UserController extends Controller
{
    const BASE_URL='http://192.168.1.24:14041/api';
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
            'Authorization' => 'Bearer ' . session('access_token'),
        ])->post(self::BASE_URL . '/sso/login.json', [
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
        } elseif (isset($responseData['data']) && $responseData['result'] === 2) {
            return back()->withErrors([
                'error' => $responseData['data'],
            ])->withInput();
        } elseif (isset($responseData['data']) && $responseData['result'] === 3) {
            return back()->withErrors([
                'error' => $responseData['data'],
            ])->withInput();
        } elseif (isset($responseData['data']) && $responseData['result'] === 4) {
            return back()->withErrors([
                'error' => $responseData['data'],
            ])->withInput();
        }
        //     return redirect()->route('dashboard');
        // } else {
        //     // Tangani hasil respons berdasarkan nilai result
        //     $errorMessages = [
        //         2 => 'Error 2 occurred. Please check the details.',
        //         3 => 'Error 3 occurred. Please check the details.',
        //         4 => 'Error 4 occurred. Please check the details.',
        //     ];

        //     // Jika result tidak sesuai dengan errorMessages, tampilkan pesan default
        //     $resultCode = $responseData['result'] ?? null;
        //     $errorMessage = $errorMessages[$resultCode] ?? 'The provided credentials do not match our records.';

        //     // Log the error message for debugging
        //     Log::error('Login failed', ['error' => $responseData['message'] ?? $errorMessage]);

        //     return back()->withErrors([
        //         'error' => $responseData['message'] ?? $errorMessage,
        //     ])->withInput();
        // }

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
            ])->post(self::BASE_URL . '/sso/login.json', [
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
            ])->post(self::BASE_URL . '/sso/register.json', [
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

                    return redirect('register-confirmation')->with('success_message', $dataResponse['data']);
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
            ])->post(self::BASE_URL . '/sso/register.json', [
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
    //         ])->post(self::BASE_URL . '/sso/update_personal_info.json', [
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
    public function showuploadProfilePicture()
    {
        return view ('uploadprofile');
    }

    public function updateProfilePicture(Request $request)
    {
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');

            $requestData = [
                'profile_picture' => $file,
            ];

            $response = Http::withHeaders([
                'Authorization' => session('access_token'),
                'x-api-key' => self::API_KEY,
            ])->attach('profile_picture', $file->getPathname(), $file->getClientOriginalName())
            ->post(self::BASE_URL . '/sso/update_profile_picture.json', $requestData);

            $data = $response->json();

            Log::info('Update Profile Picture Response:', ['response' => $data]);

            if ($response->successful()) {
                $filename = $file->getClientOriginalName();
                $file->storeAs('public/user/profile', $filename);

                // Simpan path gambar ke session
                session(['profile_picture' => 'storage/user/profile/' . $filename]);

                // Memanggil metode save untuk menyimpan gambar di API atau di tempat lain jika diperlukan
                $this->saveProfilePictureToAPI($filename);

                return redirect()->route('profil')->with('success', 'Profile picture uploaded successfully.');
            } else {
                return redirect()->back()->with('error', 'An error occurred while uploading profile picture.');
            }
        } else {
            return redirect()->back()->with('error', 'No file uploaded.');
        }
    }

    protected function saveProfilePictureToAPI($filename)
    {
        // Implementasikan logika untuk menyimpan gambar ke API jika diperlukan
        // Contoh:
        $response = Http::withHeaders([
            'Authorization' => session('access_token'),
            'x-api-key' => self::API_KEY,
        ])->post(self::BASE_URL . '/sso/save_profile_picture.json', [
            'profile_picture' => $filename,
        ]);

        $data = $response->json();

        Log::info('Save Profile Picture Response:', ['response' => $data]);
    }
    public function updatePersonalInfo(Request $request)
    {
        $response = Http::withHeaders([
            'x-api-key' => self::API_KEY,
            'Authorization' => session('access_token'),
        ])->post(self::BASE_URL . '/sso/update_personal_info.json', [
            'fullname' => $request->fullname,
            'username' => $request->username,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'gender' => $request->gender == 'Male' ? 1 : 0,
        ]);

        $data = $response->json();

        Log::info('Update Personal Info Response:', ['response' => $data]);

        if ($response->successful()) {
            session([
                'full_name' => $request->fullname,
                'username' => $request->username,
                'birthday' => $request->birthday,
                'gender' => $request->gender,
                'phone' => $request->phone,
            ]);

            // Memanggil metode save untuk menyimpan informasi pribadi di API jika diperlukan
            $this->savePersonalInfoToAPI($request);

            return redirect('/profil')->with('success', 'Data has been saved!');
        } else {
            return redirect()->back()->with('error', 'Failed to save data! Please try again.');
        }
    }

    protected function savePersonalInfoToAPI($request)
    {
        // Implementasikan logika untuk menyimpan informasi pribadi ke API jika diperlukan
        // Contoh:
        $response = Http::withHeaders([
            'Authorization' => session('access_token'),
            'x-api-key' => self::API_KEY,
        ])->post(self::BASE_URL . '/sso/save_personal_info.json', [
            'fullname' => $request->fullname,
            'username' => $request->username,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'gender' => $request->gender == 'Male' ? 1 : 0,
        ]);

        $data = $response->json();

        Log::info('Save Personal Info Response:', ['response' => $data]);
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

//     public function changePassword(Request $request)
// {
//     // Validasi input
//     $validator = Validator::make($request->all(), [
//         'password' => 'required|string|min:6',
//         'password_confirmation' => 'required|string|same:password',
//     ]);

//     if ($validator->fails()) {
//         return redirect()->back()
//                          ->withErrors($validator)
//                          ->withInput();
//     }

//     // Ambil data dari request
//     $password = $request->input('password');

//     // Konfigurasi API
//     $apiUrl = env('BASE_URL') . '/sso/change_password.json';
//     $apiKey = env('API_KEY');
//     $authToken = '0f031be1caef52cfc46ecbb8eee10c77';

//     // Kirim request ke API
//     $response = Http::withHeaders([
//         'x-api-key' => $apiKey,
//         'Authorization' => $authToken,
//     ])->post($apiUrl, [
//         'password' => $password,
//     ]);

//     // Log respons API
//     Log::info('API Response:', [
//         'status' => $response->status(),
//         'body' => $response->body(),
//         'headers' => $response->headers(),
//     ]);

//     // Tangani respons API
//     if ($response->successful()) {
//         return redirect()->route('change-password')
//                          ->with('success', 'Password changed successfully.');
//     } else {
//         return redirect()->route('change-password')
//                          ->with('error', 'Failed to change password.');
//     }
// }

public function ChangePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:6',
            'confirm_new_password' => 'required|same:new_password',
        ]);


        $access_token = session('access_token');

        $response = Http::withHeaders([
            'Authorization' => $access_token,
            'x-api-key' => self:: API_KEY,
        ])->post(self::BASE_URL . '/sso/change_password.json', [
            'password' => $request->new_password,
        ]);

        if ($response->successful()) {
            // Password berhasil diubah
            Auth::logout(); // Logout pengguna
            Session::flash('success', 'Password changed successfully. Please log in again.'); // Pesan sukses
            return Redirect::route('confirmpw'); // Redirect ke halaman login

        // Ambil access token dari session
        $accessToken = session('access_token');

        // Periksa apakah access token ada
        // if (!$accessToken) {
        //     return redirect()->route('login')->withErrors(['error' => 'Access token not found. Please login again.']);
        // }

        // Periksa apakah pengguna sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['error' => 'User not logged in.']);
        }

        // Ambil email pengguna yang sudah login
        $userEmail = auth()->user()->email;

        // Verifikasi password lama dengan memanggil endpoint login
        $loginResponse = Http::withHeaders([
            'x-api-key' => self::API_KEY
        ])->post(self::BASE_URL . '/sso/login.json', [
            'username' => $userEmail, // Gunakan email pengguna yang sudah login
            'password' => $request->old_password,
        ]);

        // Periksa apakah respon login berhasil
        if ($loginResponse->successful() && isset($loginResponse['data']['access_token'])) {
            // Ganti password
                $changePasswordResponse = Http::withHeaders([
                    'Authentication' => $accessToken,
                    'x-api-key' => self::API_KEY
                ])->post(self::BASE_URL . '/sso/change_password.json', [
                    'password' => $request->new_password,
                ]);

                // Periksa apakah perubahan password berhasil
                if ($changePasswordResponse->successful()) {
                    session()->forget('access_token');
                    auth()->logout();


                    // Redirect dengan pesan sukses
                    return redirect()->route('login')->with('success', 'Password changed successfully. Please login again.');
                } else {
                    // Tangani kesalahan validasi atau kesalahan lain dari API
                    $errorMessages = $changePasswordResponse->json();
                    if ($changePasswordResponse->status() == 422) {
                        return back()->withErrors($errorMessages)->withInput();
                    } else {
                        // Redirect dengan pesan kesalahan
                        return back()->withErrors(['error' => 'Failed to change password. Please try again later.'])->withInput();
                    }
                }

            } else {
                // Gagal mengubah password
                Session::flash('error', 'Failed to change password. Please try again.'); // Pesan error
                return Redirect::back(); // Kembali ke halaman sebelumnya
            }
        }
    }



public function logout(Request $request)
{
    $apiUrl = env('BASE_URL') . '/sso/logout.json'; // Base URL from environment
    $apiKey = env('API_KEY'); // API Key from environment
    $authToken = session('access_token'); // Authentication token from session


    $response = Http::withHeaders([
        'Authorization' => $authToken,
        'x-api-key' => $apiKey,
        'Content-Type' => 'application/json'
    ])->post($apiUrl, []);

    // Log the API response
    Log::info('Logout API Response:', $response->json());

    if ($response->successful() || $response->json()['data'] == 'Token expired') {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to login page
        return redirect()->route('login')->with('status', 'You have been logged out.');
    } else {
        // Log the failed response for debugging
        Log::error('Logout failed:', $response->json());

        // Redirect back with an error message
        return redirect()->back()->with('error', 'Logout gagal!');
    }
}
}
