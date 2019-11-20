<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Model\Node;
use App\Model\Services\RoleService;

class RoleController extends BaseController
{
    /**
     * 角色列表
     *
     */
    public function index(Request $request)
    {
        //获取所有的角色

        /*$roles = Role::paginate($this->pagesize)->toArray();
        $data = Role::find(1)->admins->toArray();
        dd($roles);
        dd($data);*/

        $data = (new RoleService())->getList($request,$this->pagesize);
        $addbtn = Role::addBtn('admin.role.create','角色');
        return view('admin.role.index',compact('data','addbtn'));
    }

    //搜索
    public function search(Request $request)
    {
        $kw = $request->get('kw');
        $data = Role::where('name','like',"%{$kw}%")->get();

        return response()->json(['status' => 0,'data'=>$data]);

    }

    /**
     * 显示
     */
    public function create()
    {
        //获取所有的权限
        $nodeData = Node::all()->toArray();
        //变成树状
        $nodeData = get_tree_list($nodeData);
        //所有一切的权限

        //显示角色添加
        return view('admin.role.create',compact('nodeData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //表单验证
        $data = $this->validate($request,[
            'name' => 'required|unique:roles,name'
        ]);
        //验证通过写入数据表，返回一个对象
        $model = Role::create($request->all(['name','desc']));
       // dd($request->all(['name','desc']));
        //先根据role_id在关联模型中查询，有则删除，没有不作任何操作
        //sync（）同步,删除原有权限 ，添加新的权限
        $model->nodes()->sync($request->get('node_ids'));

        return redirect(route('admin.role.index'))->with('success','角色添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //获取所有的权限
        $nodeData = Node::all()->toArray();
        //变成树状
        $nodeData = get_tree_list($nodeData);
        //
        $role_node = $role->nodes()->pluck('id')->toArray();
        //dd($role_node);
        return view('admin.role.update',compact('role','nodeData','role_node'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        $this->validate($request,[
            'name' => 'required|unique:roles,name,'.$role->id,
        ]);

        //验证通过写入数据表
        $role->update($request->all(['name','desc']));
        //把数据同步到中间表中

        $role->nodes()->sync($request->get('node_ids'));
        return redirect(route('admin.role.index'))->with('success','角色修改成功');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
