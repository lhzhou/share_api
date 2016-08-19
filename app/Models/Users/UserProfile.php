<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected   $table = 'user_profile';

    protected   $fillable = ['username' , 'password' , 'full_name' , 'pid'];

    protected   $dateFormat = 'U';


    public static function checkUserName($username)
    {
        return self::where('username' , $username)->whereNull('deleted_at')->count();

    }


    public static function getSon($pid)
    {

        return self::where('pid' , $pid)->whereNull('deleted_at')->get();
    }

    public static function getUserInfo($id)
    {

        return self::where('id' , $id)->whereNull('deleted_at')->first();
    }


    public static function login($params)
    {
        return self::where($params)->whereNull('deleted_at')->first()->toArray();
    }

}
