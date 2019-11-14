@extends('admin.public.public')



@section('content')
    <article class="page-container">
        @include('admin.public.msg')
        <nav class="breadcrumb">
            <i class="Hui-iconfont">&#xe67f;</i>首页
            <span class="c-gray en">&gt;</span> 用户中心
            <span class="c-gray en">&gt;</span> 用户修改
            <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
                <i class="Hui-iconfont">&#xe68f;</i>
            </a>
        </nav>
        <form action="{{ route('admin.user.update',['id'=>$data->id]) }}" method="post" class="form form-horizontal" id="form-member-add">
            @csrf
            @method('PUT')
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>账户：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $data->username }}" name="username">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>实名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $data->truename }}" name="truename">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <input name="sex" type="radio" value="先生" id="sex-1" @if($data->sex == '先生' ) checked @endif>
                        <label for="sex-1">男</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="sex-2" value="女士" name="sex" @if($data->sex == '女士' ) checked @endif>
                        <label for="sex-2">女</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $data->phone }}" placeholder="" id="mobile" name="phone">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" placeholder="@" value="{{ $data->email }}" name="email" id="email">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">修改密码</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box changepw">
                        <input type="radio" id="path1" name="pathType" value="1">
                        <label for="path1">选中修改密码</label>
                    </div>
                    <div class="radio-box changepw">
                        <input type="radio" checked id="path2" name="pathType" value="0">
                        <label for="path2">选中不修改密码</label>
                    </div>
                </div>
            </div>
            <div id="password" style="display: none;">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">密码：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="password" class="input-text" placeholder="请输入密码" value="" name="password">
                    </div>
                </div>
                <div id="password" class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">确认密码：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="password" class="input-text" placeholder="请再次输入密码" value="" name="password_confirmation">
                    </div>
                </div>
            </div>

            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;个人信息修改&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>

@endsection

@section('js')

    <script type="text/javascript">

        $(function(){
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

        });
        $("input:radio[name='pathType']").on('ifChecked',function(ev){
            let status = $(this).val();
            if(status == '1'){
                $("#password").css('display','block');
            }else{
                $("#password").css('display','none');
            }
        })
    </script>
@endsection
