<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class WalletModel extends Model
{
    protected  $table = 'wallet';

    protected  $fillable = ['u_id','balance' , 'share' , 'lower'];

    protected  $dateFormat = 'U';


//    public static function increment($amount , $userId)
//    {
//
//    }
    
    
}
