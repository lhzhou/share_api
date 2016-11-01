<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class AccountModel extends Model
{
    protected   $table = 'account';

    protected   $fillable = ['mobile' , 'password' , 'full_name' , 'pid'];

    protected   $dateFormat = 'U';


    
    public static function checkUserName($mobile)
    {
        return self::where('mobile' , $mobile)->whereNull('deleted_at')->count();

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
        return self::where($params)->whereNull('deleted_at')->first();
    }

}
