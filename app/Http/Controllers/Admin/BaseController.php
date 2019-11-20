<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    //
    protected $pagesize = 1;

    public function __construct()
    {
        $this->pagesize = env('PAGESIZE');
    }

    //上传文件
    public function upfile(Request $request)
    {
        //获取节点名称
        $nodename = $request->get('nodename');
        //获取上传表单文件域名称对应的对象
        $file = $request->file('file');
        // dump($file);
        $url = $file->store($nodename,$nodename);
        return ['status' => 0,'url' => '/uploads/'.$url];
    }

    //删除图片
    public function delpic(Request $request)
    {
        //$id = $request->get('id');
        $url = $request->get('url');
        $path_url = public_path($url);
        if(is_file($path_url)){
            unlink($path_url);
        }
        return ['status' => 0,'msg'=>'图片删除成功'];

    }




}
