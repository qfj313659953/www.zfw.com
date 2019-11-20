<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleAddRequest;
use App\Model\Article;
use App\Model\Services\ArticleService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Cate;

class ArticleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){

            return (new ArticleService())->getList($request,$this->pagesize);
        }

        $addBtn = Article::addBtn('admin.article.create','资讯');

        return view('admin.article.index',compact('addBtn'));
    }

    /**
     * 添加显示
     */
    public function create()
    {
        $pcate = Cate::all()->toArray();
        $cateList = treeLevel($pcate);
        //dd($cateList);
        return view('admin.article.create',compact('cateList'));
    }

    /**
     * 添加处理
     */
    public function store(ArticleAddRequest $request)
    {
        $data = $request->except(['_token','file']);
       // dump($data);
        //入库
        Article::create($data);
        return redirect(route('admin.article.index'))->with('success','添加成功');
    }





    public function show()
    {

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Article $article)
    {
        //获取参数
        $url_query = $request->all();
        //读取分类信息
        $pcate = Cate::all()->toArray();
        $cateList = treeLevel($pcate);
        return view('admin.article.edit',compact('cateList','article','url_query'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $url = $request->get('url');
        $article->update($request->except(['_token','file','_method','url']));
        $url = route('admin.article.index') . '?' . http_build_query($url);
        return redirect($url)->with('success','修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return ['status' => 0,'msg' => '文章删除成功'];
    }
}
