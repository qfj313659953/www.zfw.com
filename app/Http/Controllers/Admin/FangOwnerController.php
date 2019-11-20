<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FangOwnerRequest;
use App\Model\FangOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FangOwnerController extends Controller
{
    /**列表页
     */
    public function index()
    {
        //
        return '列表';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.fangOwner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FangOwnerRequest $request)
    {
        $data = $request->except(['_token','file']);
        FangOwner::create($data);
        return redirect(route('admin.fangOwner.index'))->with('success','添加房东成功');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function show(FangOwner $fangOwner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function edit(FangOwner $fangOwner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FangOwner $fangOwner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function destroy(FangOwner $fangOwner)
    {
        //
    }
}
