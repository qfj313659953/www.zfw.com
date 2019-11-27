<?php

namespace App\Exceptions;

use Exception;

class MyValidateException extends Exception
{
    public $status = [
        3 => '数据异常，验证不通过',

    ];
}
