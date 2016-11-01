<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class WithdrawalsModel extends Model
{
    //用户取款

    protected  $table = 'withdrawals';

    protected  $fillable = ['alipay_account' , 'alipay_name' , 'amount' , 'status' , 'remarks' , 'created_by'];

    protected  $dateFormat = 'U';
}
