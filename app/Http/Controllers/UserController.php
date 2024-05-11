<?php

namespace App\Http\Controllers;

use App\Models\DataUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
        $ids = DataUser::find($id);
        if (!$ids) {
            return redirect()
                ->back()
                ->with("error", "Data user tidak ditemukan.");
        }
        $profil = $request->file("profil");
        $data = [
            "id" => $id,
            "user_fullname" => $request->input("fullname"),
            "user_username" => $request->input("username"),
            "user_password" => bcrypt($request->input("password")),
            "user_email" => $request->input("email"),
            "user_notelp" => $request->input("notelp"),
            "user_alamat" => $request->input("alamat"),
            "user_level" => $request->input("level"),
            "user_status" => $request->input("status"),
        ];
        DataUser::updateDataUser($id, $data, $profil);
        Log::notice(
            "🟡 DataUser " . $request->input("nama") . " berhasil diubah"
        );
        return redirect()
            ->back()
            ->with("success", "Data user berhasil diperbarui!");
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
