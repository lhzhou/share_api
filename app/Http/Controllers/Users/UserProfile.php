<?php

namespace App\Http\Controllers\Users;

use App\Models\Admin\SplitModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Users\UserProfile AS User;
use Validator;

class UserProfile extends Controller
{
    public  $temp = [];

    public function login(Request $request)
    {

        $messages = [
            'username.required' => '请输入手机号。',
            'password.required' => '请输入密码。',
        ];

        $rules= [
            'username' => 'required',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(
                [
                    'status' => -1,
                    'message' => $validator->errors()->first()
                ]
            );
        }

        $params['username']     =  $request->input('username');
        $params['password']     =  md5(md5($request->input('password')));

        if ($userInfo = User::login($params))
        {
            return \Response::json(
                [
                    'status' => 1,
                    'results' => $userInfo
                ]
            );

        }else{
            return \Response::json(
                [
                    'status' => -1,
                    'message' => '账号密码错误'
                ]
            );
        }

    }


    public function register(Request $request)
    {
        $messages = [
            'username.required' => '请输入用户名。',
            'password.required' => '请输入密码。',
            'full_name.required' => '请输入姓名'
        ];

        $rules= [
            'username' => 'required|alpha_dash',
            'password' => 'required',
            'full_name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json(
                [
                    'status' => -1,
                    'message' => $validator->errors()->all()
                ]
            );
        }


        if (User::checkUserName($request->input('username')))
        {
            return \Response::json(
                [
                    'status' => 1,
                    'message' => '登录账号已经存在'
                ]
            );

        }


        $params['username']     =  $request->input('username');
        $params['password']     =  md5(md5($request->input('password')));
        $params['full_name']    =  $request->input('full_name');
        $params['pid']          =  $request->input('pid');


         if (User::create($params))
         {
             return \Response::json(
                 [
                     'status' => 1,
                     'message' => '账号创建成功'
                 ]
             );
         }else{
             return \Response::json(
                 [
                     'status' => -1,
                     'message' => '账号创建失败'
                 ]
             );
         }
    }


    public function addMoney($userId = '8', $articleId = '')
    {
        $price = .08;
        $sonData = User::getUserInfo($userId);
        $split = SplitModel::getIndex();
        $userSplit = [];
        $son = [];
        $i = 1;
        $user = $sonData;


        while ($sonData = User::getUserInfo($sonData->pid)) {
            if ($i >= 4)
                break;
            $son["lv$i"] = $sonData;
            $i++;
        }

        $j = 1;

        foreach ($split as $item => $value)
        {
            if (isset($son[$item])){
                $userSplit[$item]['articleId'] = $articleId;
                $userSplit[$item]['userID'] = $son[$item]->id;
                $userSplit[$item]['username'] = $son[$item]->username;
                $userSplit[$item]['lower'] = ($price/100)*$value;
            }

            $j++;

        }

        //更新积分

        foreach ($userSplit as $item) {

            echo "<p>".$item['username']."</p>";
        }

        //写入日志


        echo "<p>点击账号:".$user->username."收益金额:".$price."</p>";
        echo "<p>第一层收益:".$userSplit['lv1']['username']."收益金额:".$userSplit['lv1']['lower']."</p>";
        echo "<p>第二层收益:".$userSplit['lv2']['username']."收益金额:".$userSplit['lv2']['lower']."</p>";
        echo "<p>第三层收益:".$userSplit['lv3']['username']."收益金额:".$userSplit['lv3']['lower']."</p>";

        


    }
}
