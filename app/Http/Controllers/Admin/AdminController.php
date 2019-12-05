<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Admin;
use App\Model\Services\AdminService;
#引入邮件类
use Illuminate\Mail\Message;
use Mail;
#引入角色模型
use App\Model\Role;


class AdminController extends BaseController
{
    //用户列表
    public function index(Request $request)
    {
        $userid = auth()->id();
        $data = (new AdminService())->getList($request,$this->pagesize,$userid);
        $addbtn = Admin::addBtn('admin.user.create','用户');
        return view('admin.admin.index',compact('data','addbtn'));

    }
    //用户添加
    public function create()
    {
        //获取所有的角色
        $roles = Role::pluck('name','id');

        return view('admin.admin.create',compact('roles'));

    }

    public function store(Request $request)
    {
        $data = $this->validate($request,[
           'username' => 'required|unique:admins,username' ,
            'truename' => 'required',
            'email' => 'nullable|email',
            'password' => 'nullable|confirmed',
            'phone' => 'nullable|min:6',
            'sex'   => 'in:先生,女士',
            'role_id' => 'required'
        ],[
            'role_id.required' => '必须选一个角色'
        ]);
       // dd($data);die;
        Admin::create($request->except(['_token','password_confirmation']));
        Mail::raw('添加用户成功',function(Message $message) use($data) {
            //主题
            $message->subject('添加用户通知');
            //发给谁
            $message->to($data['email'],'Miss qian');
        });
        return redirect(route('admin.admin.index'))->with('success','新用户添加成功');
    }

    //用户修改展示
    public function edit(Request $request,int $id)
    {
        $roles = Role::pluck('name','id');
        $data = Admin::find($id);
        return view('admin.admin.edit',compact('data','roles'));

    }

    //用户修改
    public function update(Request $request,int $id)
    {
        $data = $this->validate($request,[
            'username' => 'required|unique:admins,username,'.$id,
            'truename' => 'required',
            'email' => 'nullable|email',
            'password' => 'nullable|confirmed',
            'phone' => 'nullable|min:6',
            'sex'   => 'in:先生,女士',
            'role_id' => 'required'
        ],[
            'role_id.required' => '必须选一个角色'
        ]);
        if(!$data['password']){
            unset($data['password']);
        }
        //dump($data);die;
        //修改个人信息
        Admin::where('id',$id)->update($data);
        return redirect(route('admin.admin.index'))->with('success','用户修改成功');
    }


    //个人信息展示
    public function person()
    {
        $data = auth()->user();
        return view('admin.admin.person',compact('data'));

    }

    //个人信息修改
    public function personedit(Request $request)
    {
        $id = auth()->id();
        $data = $this->validate($request,[
            'truename' => 'required',
            'email' => 'nullable|email',
            'password' => 'nullable|confirmed',
            'phone' => 'nullable|min:6',
            'sex'   => 'in:先生,女士'
        ]);
        if(!$data['password']){
            unset($data['password']);
        }
        //dump($data);die;
        //修改个人信息
        Admin::where('id',$id)->update($data);
        return ['status' => 0,'msg' => '个人信息修改成功'];
    }

    //删除用户
    public function del(int $id)
    {
        Admin::destroy($id);
        return ['status'=> 0,'msg'=>'账号删除成功'];

    }

    //回收站展示
    public function restore(Request $request)
    {
        $userid = auth()->id();
        $data = (new AdminService())->getList($request,$this->pagesize,$userid,1);

        return view('admin.admin.restore',compact('data'));
    }


    //恢复用户
    public function renew(Request $request)
    {
        $id = $request->get('id');
        //dd($id);
        //恢复软删除用户
        Admin::where('id',$id)->restore();
        //return view('admin.admin.index');
        return ['status' => 0,'msg' => '恢复用户'];
    }

    //批量删除
    public function delAll(Request $request)
    {
        $ids = $request->get('ids');
        Admin::destroy($ids);
        return ['status' => 0,'msg'=>'批量删除成功'];


    }


}
