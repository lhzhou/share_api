<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\Validation\Validator;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function formatValidationErrors(Validator $validator)
    {
        $result = [
            'code' => -1,
            'message' => '验证失败',
            'errors' => [],
        ];
        $errors = $validator->errors()->messages();
        foreach ($errors as $field => $error) {
            foreach ($error as $key => $value) {
                array_push($result['errors'], [
                    'field' => $field,
                    'message' => $value
                ]);
            }
        }


        echo json_encode($result);exit();

    }



}
