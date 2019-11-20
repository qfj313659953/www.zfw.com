@extends('admin.public.public')

@section('css')
    <link rel="stylesheet" href="{{ staticAdminPath() }}lib/webuploader/0.1.5/webuploader.css">
    <link rel="stylesheet" href="{{ staticAdminPath() }}static/h-ui/css/delpic.css">
@endsection


@section('content')

    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源管理
        <span class="c-gray en">&gt;</span> 房东添加
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>
    <article class="page-container">
        @include('admin.public.msg')
        <form class="form form-horizontal" id="form-fangowner-add" method="post" action="{{ route('admin.fangOwner.store') }}">
            @csrf

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>房东姓名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ old('name') }}" placeholder="" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>性别：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <input name="sex" type="radio" id="sex-1" value="先生" checked >
                        <label for="sex-1">先生</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="sex-2" value="女士" name="sex" >
                        <label for="sex-2">女士</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>房东年龄：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ old('age') }}" placeholder="" name="age">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>联系电话：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ old('phone') }}" placeholder="" name="phone">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>身份证号：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ old('card') }}" placeholder="" name="card">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>家庭住址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ old('address') }}" placeholder="" name="address">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>邮箱地址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ old('email') }}" placeholder="" name="email">
                </div>
            </div>


            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>身份证图片：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div class="uploader-thum-container">
                        <div id="filePicker">选择图片</div>
                        <input type="hidden" name="pic" id="pic">
                        <div id="imgbox"></div>
                        {{--<div class="bigbox">
                            <div class="imgbox" style="display: none">
                                <img src=""  style="width: 100px;" alt="" class="showpic">
                                <p onclick="delpic()">X</p>
                            </div>
                        </div>--}}


                    </div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">

                    <button class="btn btn-primary radius" type="submit">添加房东</button>

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
    {{--图片上传类--}}
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/webuploader/0.1.5/webuploader.min.js"></script>

    <script>
        $(function(){
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

        });
        //异步文件上传
        var uploader = WebUploader.create({
            //自动上传
            auto: true,
            //swf文件路径
            swf : '{{ staticAdminPath() }}lib/webuploader/0.1.5/Uploader.swf',
            // 文件接收服务端
            server: '{{ route('admin.base.upfile') }}',
            // 选择文件的按钮
            pick: {
                id : '#filePicker',
                //设置单张上传还是多张上传
                multiple : true
            },
            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            // 表单传额外值
            formData: {
                _token: "{{ csrf_token() }}",
                nodename: 'fangowner'
            },
            // 上传表单名称
            fileVal: 'file'
        });
        //回调方法监听
        uploader.on('uploadSuccess',function (file,{url}) {
            var val = $('#pic').val();
            $('#pic').val(val + '#' + url);

            var imgObj = $('<img />');
            imgObj.attr('src',url);
            $('#imgbox').append(imgObj);


          // $('.imgbox').clone(true).appendTo('.bigbox');
            /*$('#showpic').attr('src',url);
            $('.imgbox').slideDown('slow');*/
        });

        //点击删除图片
        function delpic(){
            let url = $('#pic').val();
            $.get('{{route("admin.base.delpic")}}',{url}).then(ret=>{
                $('#pic').val('');
                $('#showpic').attr('src','');
                $('.imgbox').slideUp('slow');
            });
        }



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
