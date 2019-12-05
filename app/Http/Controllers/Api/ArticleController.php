<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Model\Article;
use App\Model\ArticleCount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends BaseController
{
    //资讯列表
    public function index()
    {
        $fields = ['id','title','desn','pic','created_at'];
        $data = Article::orderBy('created_at','desc')->select($fields)->paginate($this->pagesize);

        //return $data;
        return ['status' => 0,'msg'=>'ok','data'=>$data];
    }
    //资讯详情
    public function show(Article $article)
    {
        return ['status'=> 0,'msg'=>'文章详情获取成功','data'=>$article];

    }

    //浏览历史
    public function history(Request $request)
    {
        //表单验证
        try{
            $data = $this->validate($request,[
               'openid' => 'required',
               'art_id' => 'required'
            ]);
        }catch (\Exception $e) {
            throw new MyValidateException('数据异常',3);
        }
        //先根据数据查询数据表，看是否已存在,返回模型
        $model = ArticleCount::where($data)->first();
        $data['vdt'] = date('Y-m-d');
        if(!$model){
            //如果不存在就添加数据
            $data['click'] = 1;
           // dd($data);
            $model = ArticleCount::create($data);
        }else{
            //如果已经存在就给点击数+1
            ArticleCount::increment('click');
        }

       return response()->json(['status'=>0,'msg'=>'记录成功','data'=>$model->click],201);
    }


}
