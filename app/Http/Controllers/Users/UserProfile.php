<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserProfile extends Controller
{
    public function register(Request $request)
    {
        $params['username']     =  $request->input('username');
        $params['password']     =  md5(md5($request->input('password')));
        $params['full_name']    =  $request->input('full_name');
        $params['pid']          =  $request->input('pid');

        return $params;



    }
}
