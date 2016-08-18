<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SplitModel extends Model
{
    protected   $table = 'split_mode';
    protected   $fillable = ['lv1','lv2','lv3','lv4','is_index'];
    protected   $dateFormat = 'U';



    public static function getIndex()
    {
        return self::where('is_index' , 1 )->whereNull('deleted_at')->first()->toArray();
    }
    
    


    //
}
