<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\NewAccessToken;
use Stringable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'msuser';

    public $timestamps = false;

    public static function myCrypt($password)
    {
        $cryptedPassword = '';
        $rotate = 41;

        for ($i = 0; $i < strlen($password); $i = $i + 1)
        {
            $baru[$i] = substr($password,$i,1);
        }

        for ( $i = 0; $i < strlen($password); $i = $i + 1 )
        {
            $asc = ord($baru[$i]);
            $asc = $asc + (($i + 1) * $rotate);
            $kumpul = $asc / 16 + 65;
            $hsl1 = chr($kumpul);
            $kumpul = $asc % 16 + 65;
            $hsl2 = chr($kumpul);
            $cryptedPassword = $cryptedPassword . $hsl1 . $hsl2;
        }

        //dd(var_dump($cryptedPassword));
        return $cryptedPassword;
    }

    public function isLoginValid($userid, $password)
    {
        $password = $this::myCrypt($password);

        $result = DB::selectOne(
            'SELECT userid FROM msuser WHERE userid = :userid AND pass = :password',
            [
                'userid' => $userid,
                'password' => $password
            ]
        );

        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function deleteData($param)
    {
        $deleted = DB::delete(
            'DELETE FROM personal_access_tokens WHERE tokenable_id = :tokenable_id',
            [
                'tokenable_id' => $param['tokenable_id']
            ]
        );
    }

    function updateData($id)
    {
        $updated = DB::update(
            'update personal_access_tokens set expires_at=dateadd(day,1,created_at),namauser=(select userid from msuser where id=tokenable_id ) where id=:id',
            [
                'id' => $id
            ]
        );
    }

}
