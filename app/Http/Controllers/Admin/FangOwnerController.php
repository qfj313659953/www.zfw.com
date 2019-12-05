<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FangOwnerRequest;
use App\Jobs\FangOwnerExcelJob;
use App\Model\FangOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
#引入导出的excel类
use Maatwebsite\Excel\Facades\Excel;
#引入导出数据类
use App\Exports\FangOwnerExport;

class FangOwnerController extends BaseController
{
    /**列表页
     */
    public function index()
    {
        $excelpath = public_path('/uploads/fangownerexcel/fangowner.xlsx');
        $isshow = file_exists($excelpath) ? true : false;
        $data = FangOwner::paginate($this->pagesize);
        $addBtn = FangOwner::addBtn('admin.fangOwner.create','房东');
        return view('admin.fangOwner.index',compact('data','addBtn','excelpath','isshow'));
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
        $pics = $fangOwner->pic;
        $arr = explode('#',$pics);
        //判断是否存在图片
        if(count($arr) <= 1){
            return ['status'=>1,'msg'=>'图片不存在','data'=>[]];
        }
        array_shift($arr);
        return ['status' => 0,'msg' => '成功','data'=>$arr];
    }

    public function export()
    {
        #导出并保存到服务器指定的磁盘中,参数3为文件保存的节点名称
        $all = FangOwner::paginate(5)->toArray();
        $num = $all['last_page'];
        for($i = 1;$i<=$num;$i++){
            $offset = ($i - 1) * 5;
            $this->dispatch(new FangOwnerExcelJob($offset,$i));
        }
        return redirect(route('admin.fangOwner.index'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function edit(FangOwner $fangOwner)
    {
        //dd($fangOwner);
        return view('admin.fangOwner.edit',compact('fangOwner'));
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
        $fangOwner->update($request->except(['_token','_method','file']));
        return redirect(route('admin.fangOwner.index'))->with('success','房东修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function destroy(FangOwner $fangOwner)
    {
        $fangOwner->delete();
        return ['status' => 0,'msg' => '房东信息删除成功'];
    }
}
