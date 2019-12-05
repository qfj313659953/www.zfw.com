<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\MyValidateException;
use App\Model\FangOwner;
use App\Model\Notice;
use App\Model\Renting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoticeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Notice::with(['fangowner','renting'])->paginate($this->pagesize);
        return view('admin.notice.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //获取数据
        if($request->ajax()){
            //房东数据
            $fdata = FangOwner::all();
            //租客数据
            $rdata = Renting::all();
            return [$fdata,$rdata];
        }
        return view('admin.notice.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request,[
               'cnt' => 'required'
            ]);

            //入库操作
            Notice::create($request->except('_token'));

            return ['status'=>0,'msg'=>'成功','url'=>route('admin.notice.index')];


        }catch (\Exception $e){
           throw new MyValidateException('数据异常',3);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        //
    }
}
