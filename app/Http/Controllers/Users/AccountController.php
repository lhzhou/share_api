<?php

namespace App\Http\Controllers\Users;

use App\Models\Admin\SplitModel;
use App\Models\Users\WalletModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Users\AccountModel;
use Validator;

class AccountController extends Controller
{
    public  $temp = [];

    public function login(Request $request)
    {


        $rules= [
            'mobile' => 'required',
            'password' => 'required',
        ];

        $this->validate($request, $rules);



        $params['mobile']     =  $request->input('mobile');
        $params['password']     =  md5(md5($request->input('password')));

        if ($userInfo = AccountModel::login($params))
        {
            return \Response::json(
                [
                    'status' => 0,
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


        $rules= [
            'mobile' => 'required|alpha_dash',
            'password' => 'required',
            'full_name' => 'required',
        ];

        $this->validate($request, $rules);



        if (AccountModel::checkUserName($request->input('mobile')))
        {
            return \Response::json(
                [
                    'status' => 1,
                    'message' => '登录账号已经存在'
                ]
            );

        }


        $params['mobile']     =  $request->input('mobile');
        $params['password']     =  md5(md5($request->input('password')));
        $params['full_name']    =  $request->input('full_name');
        $params['pid']          =  ($request->input('pid'))? $request->input('pid') : 0;

         if ($results = AccountModel::create($params))
         {
             WalletModel::create(['u_id' => $results->id]);

             return \Response::json(
                 [
                     'status' => 0,
                     'results' => $results,
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


        while ($sonData = AccountModel::getUserInfo($sonData->pid)) {
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
