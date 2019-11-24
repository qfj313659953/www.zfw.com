<?php

namespace App\Http\Controllers\Admin;

use App\Model\Fang;
use App\Model\City;
use App\Model\FangAttr;
use App\Model\FangOwner;
use Illuminate\Http\Request;
use App\Http\Requests\FangRequest;
use App\Http\Controllers\Controller;

class FangController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Fang::with('fangOwner')->paginate($this->pagesize);
        $addBtn = Fang::addBtn('admin.fang.create','房源');
        return view('admin.fang.index',compact('data','addBtn'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //获取省
        $Pdata = $this->getCity();

        //获取房源属性
        $attrs = FangAttr::all()->toArray();
        $attrs = subtree2($attrs);
        //获取房源房东
        $owner = FangOwner::all();
        return view('admin.fang.create',compact('Pdata','attrs','owner'));
    }


    //获取城市信息
    public function getCity($pid = 0)
    {
        $pid = $pid == 0 ? request()->get('pid',0) : $pid;
        return City::where('pid',$pid)->get();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FangRequest $request)
    {
       // dd($request->except(['_token','file']));
        Fang::create($request->except(['_token','file']));

        return redirect(route('admin.fang.index'))->with('success','添加房源成功');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function show(Fang $fang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function edit(Fang $fang)
    {
        //获取省
        $Pdata = $this->getCity();
        //获取市
        $cdata = $this->getCity($fang->fang_province);
        dump($fang->fang_province);
        //获取区
        $rdata = $this->getCity($fang->fang_city);

        //获取房源属性
        $attrs = FangAttr::all()->toArray();
        $attrs = subtree2($attrs);
        //获取房源房东
        $owner = FangOwner::all();

        return view('admin.fang.edit',compact('Pdata','cdata','rdata','attrs','owner','fang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fang $fang)
    {
        $fang->update($request->except(['_token','_method','file','fang_addr2']));
        return redirect(route('admin.fang.index'))->with('success','修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fang $fang)
    {
        //
        $fang->delete();
        return ['status' => 0,'msg' => '删除成功'];
    }
}
