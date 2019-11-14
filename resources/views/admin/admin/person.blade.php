@extends('admin.public.public')



@section('content')
    <article class="page-container">
        @include('admin.public.msg')
        <form action="{{route('admin.admin.personedit')}}" method="post" class="form form-horizontal" id="form-person-edit">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>账户：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $data->username }}" disabled name="username">
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
                        <input name="sex" type="radio" id="sex-1" value="先生" @if($data->sex == '先生' ) checked @endif>
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
            <div id="password" style="display: none">
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
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/jquery.contextmenu/jquery.contextmenu.r2.js"></script>
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/jquery.validation/1.14.0/messages_zh.js"></script>
    <script type="text/javascript">

        $(function(){
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

          // console.log($('.changepw .checked').find('input:radio').val());
            $("input:radio[name='pathType']").on('ifChecked',function(ev){
                let status = $(this).val();
                if(status == '1'){
                   $("#password").css('display','block');
                }else{
                    $("#password").css('display','none');
                }
            })
            $("#form-person-edit").validate({
                rules:{
                    username:{
                        required : true,
                    },
                    truename : {
                        required : true,
                    },
                    sex : {
                        required : "#sex:checked"
                    },


                },
                onkeyup:false,
                focusCleanup:true,
                success: "valid",
                submitHandler:function(form){
                    var url = $(form).attr("action");
                    var data = $(form).serializeArray();
                    var obj = {};
                    data.map((item,key)=>{
                        obj[item.name] = item.value;
                    })

                    $(form).ajaxSubmit({
                        type:'put',
                        url,
                        data:obj,
                        success:ent => {
                            let {msg} = ent;
                            layer.msg(msg,{icon:1,time:1000},function(){
                                parent.layer.closeAll();
                            });
                        },
                        error:(XmlHttpRequest, textStatus, errorThrown) => {
                            layer.msg('个人信息修改失败!',{icon:1,time:1000});
                        }
                    })


                }
            })




        });

    </script>
@endsection
