<?php

namespace App\Http\Controllers\Users;

use App\Models\Users\AccountModel;
use App\Models\Users\SplitModel;
use App\Models\Users\WalletModel;
use App\Models\Users\WalletRecordModel;
use App\Models\Users\WithdrawalsModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    public function balance(Request $request)
    {
        $params['u_id'] = $request->input('user_id');

        $balance = WalletModel::find($params)->first();
        if ($balance)
        {
               $arr =  [
                   'status' => 0,
                   'results' => $balance
               ];
        }else{
            $arr =  [
                'status' => -1,
                'message' => '获取余额失败'
            ];
        }
        return \Response::json($arr);
    }

    public function withdrawals(Request $request)
    {
        $rules = [
            'amount'    => 'required',
            'alipay_account' => 'required',
            'alipay_name' => 'required',
            'user_id' => 'required',
        ];

        $this->validate($request, $rules);

        $params =  $request->only('amount','alipay_account' , 'alipay_name');
        $params['created_by'] =$request->input('user_id');

        if (WithdrawalsModel::create($params)){
            $arr =  [
                'status' => 0,
                'message' =>  '体现申请成功'
            ];
        }else{
            $arr =  [
                'status' => 0,
                'message' =>  '体现申请失败'
            ];
        }

        return \Response::json($arr);
    }

    public function withdrawalsLog(Request $request)
    {
        $rules = [
            'user_id' => 'required',
        ];

        $this->validate($request, $rules);

        $params['created_by'] =  $request->input('user_id');

        if ($results = WithdrawalsModel::where($params)->orderBy('id' , 'DESC')->get() ){
            $arr =  [
                'status' => 0,
                'results' => $results
            ];
        }else{
            $arr =  [
                'status' => 0,
                'message' =>  '没有找到体现记录'
            ];
        }

        return \Response::json($arr);

    }

    public function increase(Request $request)
    {
        $userID = $request->input('user_id');
        $amount = $request->input('amount');

        $articleId = 10001;

        $price = $amount;
        $sonData = AccountModel::find($userID);

        $split = SplitModel::all();
        $userSplit = [];
        $son = [];
        $i = 1;
        $user = $sonData;


        while ($sonData = AccountModel::find($sonData->pid)) {
            if ($i >= 4)
                break;
            $son["lv$i"] = $sonData;
            $i++;
        }


        $j = 1;

        foreach ($split as $item => $value)
        {

            if (isset($son[$value->name])){
                $userSplit[$item]['articleId'] = $articleId;
                $userSplit[$item]['userID'] = $son[$value->name]->id;
                $userSplit[$item]['username'] = $son[$value->name]->mobile;
                $userSplit[$item]['lower'] = ($price/100)*$value->ratio;
            }
        }

        //更新积分

        //更新自己余额

        WalletModel::where(['u_id' => $userID ] )
            ->increment('balance' , $amount);

        // 更新分享收益
        WalletModel::where(['u_id' => $userID ] )
            ->increment('share' , $amount);

        $log[] = [
            'u_id' => $userID,
            'type' =>  'share',
            'article_id' => $articleId,
            'amount' => '+'.$amount,
            'created_at' => time(),
            'updated_at' => time(),

        ];


        // 更新上级积分

        foreach ($userSplit as $item => $value) {

            // 更新余额
            WalletModel::where(['u_id' => $value['userID'] ] )
                ->increment('balance' , $value['lower']);
            // 更新下级收益
            WalletModel::where(['u_id' => $value['userID'] ] )
                ->increment('lower' , $value['lower']);

            $log[] = [
                'u_id' => $value['userID'],
                'type' =>  'lower',
                'article_id' => $articleId,
                'amount' => '+'.$value['lower'],
                'created_at' => time(),
                'updated_at' => time(),

            ];
        }

        
        WalletRecordModel::insert($log);





    }
}
