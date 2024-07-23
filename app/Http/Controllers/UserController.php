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
use App\Mail\VerificationEmail;


class UserController extends Controller
{
    const API_URL='http://192.168.1.24:14041/api';
    const API_KEY='5af97cb7eed7a5a4cff3ed91698d2ffb';

    // public function login(Request $request)
    // {
    //     // Validasi input
    //     $credentials = $request->validate([
    //         'email' => 'required|string|email|max:255',
    //         'password' => 'required|string|min:8',
    //     ]);

    //     // Ambil pengguna berdasarkan email
    //     $user = User::where("user_email", $credentials["email"])->first();

    //     // Cek apakah pengguna ada dan password cocok
    //     if (!$user || !Hash::check($credentials["password"], $user->user_password)) {
    //         Log::warning('Login gagal: Email atau password salah.', [
    //             'email' => $credentials["email"]
    //         ]);
    //         return back()->withErrors([
    //             "message" => "Email atau password Anda salah.",
    //         ])->withInput();
    //     }

    //     // Cek apakah email pengguna sudah diverifikasi
    //     if (!$user->hasVerifiedEmail()) {
    //         Log::warning('Login gagal: Email belum diverifikasi.', [
    //             'email' => $credentials["email"]
    //         ]);
    //         return back()->withErrors([
    //             "message" => "Silakan konfirmasi email Anda terlebih dahulu.",
    //         ])->withInput();
    //     }

    //     // Login pengguna
    //     Auth::login($user);
    //     Log::info("🟢 Pengguna " . $user->user_fullname . " berhasil login");

    //     // Panggil API untuk login pengguna pada layanan eksternal menggunakan metode GET
    //     try {
    //         $response = Http::withHeaders([
    //             'x-api-key' => self::API_KEY,
    //             'dev-key' => '12',
    //         ])->get(self::API_URL . '/sso/login.json', [
    //             'email' => $credentials['email'],
    //             'password' => $credentials['password'],
    //         ]);

    //         $dataResponse = $response->json();

    //         // Log respons API
    //         Log::info('Respons API', ['response' => $dataResponse]);

    //         if ($response->successful() && isset($dataResponse['result'])) {
    //             if ($dataResponse['result'] === 1) {
    //                 return redirect()->route("dashboard");
    //             } else {
    //                 Log::warning('Login eksternal gagal: ' . $dataResponse['data'], [
    //                     'email' => $credentials["email"]
    //                 ]);
    //                 return back()->withErrors([
    //                     'error_message' => $dataResponse['data'],
    //                 ])->withInput();
    //             }
    //         } else {
    //             // Log error API jika respons tidak sukses
    //             Log::error('Kesalahan Respons API', ['response' => $dataResponse]);
    //             return back()->withErrors([
    //                 'error_message' => 'Login ke layanan eksternal gagal.',
    //             ])->withInput();
    //         }
    //     } catch (\Exception $e) {
    //         // Log pengecualian
    //         Log::error('Exception tertangkap di metode login', ['error' => $e->getMessage()]);
    //         return back()->withErrors([
    //             'error_message' => 'Terjadi kesalahan, silakan coba lagi!',
    //         ])->withInput();
    //     }
    // }
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





//     public function register(Request $request)
// {
//     $request->validate([
//         'fullname' => 'required|string|max:255',
//         'username' => 'required|string|max:255|unique:users,user_username',
//         'email' => 'required|string|email|max:255|unique:users,user_email',
//         'notelp' => 'required|string|max:20',
//         'alamat' => 'required|string|max:255',
//         'password' => 'required|string|min:8|confirmed',
//     ]);

//     $data = [
//         'user_fullname' => $request->input('fullname'),
//         'user_username' => $request->input('username'),
//         'user_password' => bcrypt($request->input('password')),
//         'user_email' => $request->input('email'),
//         'user_notelp' => $request->input('notelp'),
//         'user_alamat' => $request->input('alamat'),
//     ];

//     $user = User::create($data);
//     $user->sendEmailVerificationNotification(); // Mengirim email verifikasi

//     // Make the API call to register the user on the external service
//     $apiResponse = Http::withHeaders([
//         'x-api-key' => config('app.api_key'),
//     ])->post(config('app.base_url') . '/sso/register.json', [
//         'email' => $request->input('email'),
//         'password' => $request->input('password'),
//         'address' => $request->input('alamat'),
//     ]);

//     if ($apiResponse->failed()) {
//         return redirect()->route('register')->withErrors('Pendaftaran ke layanan eksternal gagal.');
//     }

//     // Redirect ke halaman dengan pesan sukses
//     return redirect()->route('register.confirmation')->with('success', 'Pendaftaran berhasil! Silakan cek email Anda untuk konfirmasi.');
// }

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
