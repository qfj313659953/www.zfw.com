<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //为统一输出接口格式，依赖注入的验证错误输出方式修改
        //判断是否是ajax请求
        if($request->ajax()){
            //判断是否是表单验证类异常
            if($exception instanceof ValidationException){
                //返回固定格式响应数据 json格式
                return response()->json(['status' => 2,'msg'=>'验证失败','data'=>$exception->validator->getMessageBag()
                ]);
            }
            //ajax请求非验证类异常输出
            return parent::render($request, $exception);

        }
        if($exception instanceof LoginException){
            //账号或密码有误
            $data = ['status' => $exception->getCode(),'msg'=>$exception->getMessage()];
            return response()->json($data,401);
        }elseif($exception instanceof MyValidateException){//验证异常类处理
            $data = ['status' => $exception->getCode(),'msg'=>$exception->getMessage()];
            return response()->json($data,401);
        }
        return parent::render($request, $exception);
    }
}
