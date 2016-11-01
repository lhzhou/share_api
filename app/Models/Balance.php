<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected  $table = 'balance';

    protected  $hidden = ['id' , 'u_id' , 'created_at' , 'updated_at' , 'deleted_at' ];
}
