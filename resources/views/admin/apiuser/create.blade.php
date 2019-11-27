@extends('admin.public.public')

@section('css')
    <link rel="stylesheet" href="{{ staticAdminPath() }}lib/webuploader/0.1.5/webuploader.css">
    <link rel="stylesheet" href="{{ staticAdminPath() }}static/h-ui/css/delpic.css">
@endsection


@section('content')

    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 接口账号管理
        <span class="c-gray en">&gt;</span> 接口账号添加
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>
    <article class="page-container" id="app">
        @include('admin.public.msg')
        <form class="form form-horizontal" id="form-fangowner-add" method="post" @click="dopost" action="{{ route('admin.apiuser.store') }}">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>账号：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" style="width: 360px" class="input-text" v-model="formData.username" name="username">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password" style="width: 360px" v-model="formData.password" class="input-text" name="password">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>token：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" style="width: 360px" class="input-text" v-model="formData.token" name="token">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>请求次数：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" style="width: 360px" class="input-text" v-model="formData.click"  name="click">
                </div>
            </div>

            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">

                    <button class="btn btn-primary radius" type="button">添加接口账号</button>

                </div>
            </div>
        </form>
    </article>

@endsection

@section('js')
    {{--验证类--}}
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/jquery.validation/1.14.0/messages_zh.js"></script>
    <script type="text/javascript" src="/js/vue.js"></script>


    <script>
        new Vue({
            el : '#app',
            //初始化数据
            data : {
                //初始化表单数据
                formData : {
                    _token : "{{ csrf_token() }}",
                    username : "",
                    password : "",
                    token : "",
                    click : "2000"
                }
            },
            //方法
            methods : {
                dopost(){
                    //前端表单验证,用户名、密码、token都不能为空
                    if(this.formData.username && this.formData.password && this.formData.token){
                        let url = "{{ route('admin.apiuser.store') }}";
                        $.post(url,this.formData).then(ret=>{
                            if(ret.status == 0){
                                //添加数据成功
                                layer.msg(ret.msg,{icon:1,timeout:1000},()=>{
                                    location.href = ret.url;
                                })
                            }else{
                                //验证不通过
                                layer.msg(ret.msg,{icon:2,timeout:1000});
                            }
                        })
                    }else{
                        layer.msg('数据不得为空',{icon:2,timeout:1000});
                    }

                }
            }

        });



        //表单验证
        $("#form-fangowner-add").validate({
            rules:{
                name : {
                    required:true
                },
                age : {
                    required:true,
                    digits: true,
                    min:1,
                    max:110
                },
                phone : {
                    required:true,
                    checkPhone:true
                },
                card : {
                    required:true,
                    checkCard:true
                },
                address : {
                    required:true
                },
                pic : {
                    required:true
                },
                email : {
                    required: true,
                    email:true
                }

            },
            onkeyup : false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                form.submit();
            }
        })
        // 自定义验证
        jQuery.validator.addMethod("checkPhone", function(value, element) {
           var reg = /^1[3456789]\d{9}$/;
            return  this.optional(element) || (reg.test(value));
        }, "手机号码的格式不合法");

        jQuery.validator.addMethod("checkCard", function(value, element) {
            var card = value.replace(' ','');
            var len = card.length;
            var bool = len == 18 ? true : false;
            var reg = /\d{17}[\dx]$/i;
            return  this.optional(element) || ((reg.test(value)) && bool);
        }, "身份证号码不合法");
    </script>
@endsection
