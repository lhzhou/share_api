<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class SplitModel extends Model
{
    protected  $table = 'split';

    protected  $fillable = ['id','name' , 'ratio'];

    protected  $dateFormat = 'U';
}
