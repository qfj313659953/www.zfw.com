<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\FangAttrRequest;
use App\Model\FangAttr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FangAttrController extends Controller
{
    /**
     * 房源属性列表
     */
    public function index(Request $request)
    {
        if($request->ajax()){
          $data = FangAttr::all()->toArray();
            $data = treeLevel($data);
           return $data;
        }

        $addBtn = FangAttr::addBtn('admin.fangAttr.create','房源属性');
        return view('admin.fangAttr.index',compact('addBtn'));
    }

    /**
     * 添加显示
     */
    public function create()
    {
        $attrpid = FangAttr::where('pid',0)->pluck('name','id');
        $attrpid[0] = '==顶级==';
        return view('admin.fangAttr.create',compact('attrpid'));
    }

    /**
     * 添加房源属性
     */
    public function store(FangAttrRequest $request)
    {
        $data = $request->except(['file','_token']);
        //dd($data);
        FangAttr::create($data);

       return redirect(route('admin.fangAttr.index'))->with('success','房源属性添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\FangAttr  $fangAttr
     * @return \Illuminate\Http\Response
     */
    public function show(FangAttr $fangAttr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\FangAttr  $fangAttr
     * @return \Illuminate\Http\Response
     */
    public function edit(FangAttr $fangAttr)
    {
        $attrpid = FangAttr::where('pid',0)->pluck('name','id')->toArray();
        $attrpid[0] = '==顶级==';
        //dump($attrpid);die;
        ksort($attrpid);
        return view('admin.fangAttr.edit',compact('fangAttr','attrpid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\FangAttr  $fangAttr
     * @return \Illuminate\Http\Response
     */
    public function update(FangAttrRequest $request, FangAttr $fangAttr)
    {
        //dd($request->except(['_token','file','_method']));
        $fangAttr->update($request->except(['_token','file','_method']));
        return redirect(route('admin.fangAttr.index'))->with('success','属性修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\FangAttr  $fangAttr
     * @return \Illuminate\Http\Response
     */
    public function destroy(FangAttr $fangAttr)
    {
        $fangAttr->delete();
        return ['status' => 0,'msg' => '属性删除成功'];
    }
}
