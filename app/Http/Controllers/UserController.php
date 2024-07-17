<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function createDataUser()
    {
        return view("web.create.datauser");
    }
    public function updateDataUser($id)
    {
        $data = DataUser::readDataUserById($id);
        return view("web.update.datauser", ["datauser" => $data]);
    }
    public function login(Request $request)
    {
        $credentials = [
            "user_username" => $request->input("username"),
            "user_password" => $request->input("password"),
        ];
        $user = DataUser::where(
            "user_username",
            $credentials["user_username"]
        )->first();
        if (
            $user &&
            Hash::check($credentials["user_password"], $user->user_password)
        ) {
            Auth::login($user);
            Log::info("🟢 User " . $user->user_nama . " berhasil login");
            return redirect()->route("dashboard");
        } else {
            return back()->withErrors([
                "message" => "Username atau password Anda salah.",
            ]);
        }
    }
    public function register(Request $request)
    {
        $data = [
            "user_fullname" => $request->input("username"),
            "user_username" => $request->input("username"),
            "user_password" => bcrypt($request->input("password")),
            "user_email" => $request->input("email"),
            "user_notelp" => $request->input("notelp"),
            "user_alamat" => $request->input("alamat"),
        ];

        $user = DataUser::register($data);

        if ($user) {
            Log::info(
                "🟢 User bernama " .
                    $request->input("username") .
                    " telah mendaftar"
            );
            return redirect()
                ->route("login")
                ->with("success", "Pendaftaran akun berhasil!");
        } else {
            return back()->withInput();
        }
    }
    public function upload_profile(Request $request, $id)
    {
        $profil = $request->file("profil");
        if ($profil) {
            DataUser::upload_profile($id, $profil);
            Log::debug("🟣 File baru berhasil ditambahkan/disimpan");
            return back()->with("success", "Foto profil berhasil diperbarui!");
        }
        return back()->with("failed", "Foto profil gagal diperbarui!");
    }
    public function create(Request $request)
    {
        $profil = $request->file("profil");
        $data = [
            "user_fullname" => $request->input("fullname"),
            "user_username" => $request->input("username"),
            "user_password" => bcrypt($request->input("password")),
            "user_email" => $request->input("email"),
            "user_notelp" => $request->input("notelp"),
            "user_alamat" => $request->input("alamat"),
            "user_level" => $request->input("level"),
            "user_status" => $request->input("status"),
        ];
        DataUser::createDataUser($data, $profil);
        Log::info(
            "🟢 DataUser " . $request->input("nama") . " berhasil ditambahkan"
        );
        return redirect()
            ->back()
            ->with("success", "Data user berhasil ditambahkan!");
    }
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Validasi data
    $request->validate([
        'profil' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'fullname' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,'.$user->id,
        'password' => 'nullable|string|min:8|confirmed',
        'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
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
        $user->password = bcrypt($request->password);
    }
    $user->user_email = $request->email;
    $user->user_notelp = $request->notelp;
    $user->user_alamat = $request->alamat;

    $user->save();

    return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui!');
}
    public function delete($id)
    {
        $user = DataUser::find($id);
        if ($user) {
            Log::alert("🔴 DataUser dengan ID : " . $id . " berhasil dihapus");
            $user->delete();
            return redirect()
                ->back()
                ->with("deleted", "Data user berhasil dihapus!");
        } else {
            Log::error("🔴 DataUser dengan ID : " . $id . " gagal dihapus");
            return redirect()
                ->back()
                ->with("error", "Data user tidak ditemukan.");
        }
    }
}
