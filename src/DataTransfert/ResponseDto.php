<?php

namespace App\DataTransfert;

use App\Constant\Code;

class ResponseDto {

    public static $output = [
        'code' => Code::CODE_200,
        'error' => false,
        'message' => 'Success!'
    ];

}