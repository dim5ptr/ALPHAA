<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DataUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_fullname',
        'user_username',
        'user_password',
        'user_email',
        'user_notelp',
        'user_alamat',
        'user_profil_url',
        'user_level',
        'user_status',
    ];
    protected $hidden = [
        'user_password',
    ];

    public static function register($data)
    {
        return self::create($data);
    }

    public static function createDataUser($data, UploadedFile $profil = null)
    {
        $user = $data;
        if ($profil) {
            $path = $profil->store('public/user/profile');
            $user['user_profil_url'] = $path;
        }
        DB::table('users')->insert($user);
    }

    public static function readDataUserAll()
    {
        $data = DB::table('users')->get();
        return $data;
    }

    public static function readDataUserPaginate()
    {
        $data = DB::table('users')->paginate(10);
        return $data;
    }

    public static function readDataUserById($id)
    {
        $data = DB::table('users')->where('id', $id)->first();
        return $data;
    }

    public static function upload_profile($id, $data)
    {
        $user = self::find($id);
        if ($user->user_profil_url) {
            Storage::delete($user->user_profil_url);
        }
        if ($data) {
            $path = $data->store('public/user/profile');
            $user->user_profil_url = $path;
        }
        $user->save();
    }

    protected static function updateDataUser ($id, $data, UploadedFile $profil = null)
    {
        $user = DB::table('users')->where('id', $id)->first();
        if ($user) {
            if ($profil && $user->user_profil_url) {
                Storage::delete($user->user_profil_url);
                $path = $profil->store('public/user/profile');
                $data['user_profil_url'] = $path;
            }
            DB::table('users')->where('id', $id)->update($data);
            return $data;
        }
        return null;
    }

    protected static function deleteDataUser ($id)
    {
        return DB::table('users')->where('id', $id)->delete();
    }
}
