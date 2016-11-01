<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class WalletRecordModel extends Model
{
    protected  $table = 'wallet_record';

    protected  $fillable = ['u_id','type' , 'article_id' , 'amount'];

    protected  $dateFormat = 'U';
}
