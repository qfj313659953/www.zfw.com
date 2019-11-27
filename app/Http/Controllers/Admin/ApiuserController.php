<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ApiuserRequest;
use App\Model\Apiuser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiuserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Apiuser::paginate($this->pagesize);
        $addBtn = Apiuser::addBtn('admin.apiuser.create','接口账号');
        return view('admin.apiuser.index',compact('data','addBtn'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.apiuser.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApiuserRequest $request)
    {

        Apiuser::create($request->except('_token'));

        return ['status' => 0,'msg'=> '添加成功','url'=>route('admin.apiuser.index')];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Apiuser  $apiuser
     * @return \Illuminate\Http\Response
     */
    public function show(Apiuser $apiuser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Apiuser  $apiuser
     * @return \Illuminate\Http\Response
     */
    public function edit(Apiuser $apiuser)
    {
        return view('admin.apiuser.edit',compact('apiuser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Apiuser  $apiuser
     * @return \Illuminate\Http\Response
     */
    public function update(ApiuserRequest $request, Apiuser $apiuser)
    {
        //
        $apiuser->update($request->except(['_token','_method']));
        return ['status' => 0,'msg'=> '修改成功','url'=>route('admin.apiuser.index')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Apiuser  $apiuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apiuser $apiuser)
    {
        //
    }
}
