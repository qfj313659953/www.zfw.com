@extends('admin.public.public')

@section('css')
    <link rel="stylesheet" href="{{ staticAdminPath() }}lib/webuploader/0.1.5/webuploader.css">
    <link rel="stylesheet" href="{{ staticAdminPath() }}static/h-ui/css/delpic.css">
@endsection


@section('content')

    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源管理
        <span class="c-gray en">&gt;</span> 房源属性添加
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>
    <article class="page-container">
        @include('admin.public.msg')
        <form class="form form-horizontal" id="form-fangattr-add" method="post" action="{{ route('admin.fangAttr.store') }}">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>顶级属性：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="pid" id="pid" class="select">
                    @foreach($attrpid as $id=>$name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
				</select>
				</span> </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>属性名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ old('name') }}" placeholder="" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">字段名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ old('field_name') }}" placeholder="" name="field_name">
                </div>
            </div>



            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">图标：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div class="uploader-thum-container">
                        <div id="filePicker">选择图片</div>
                        <div class="imgbox" style="display: none">
                            <input type="hidden" name="icon" id="pic">
                            <img src=""  style="width: 100px;" alt="" id="showpic">
                            <p onclick="delpic()">X</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">

                    <button class="btn btn-primary radius" type="submit">添加房源属性</button>

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
                multiple : false
            },
            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            // 表单传额外值
            formData: {
                _token: "{{ csrf_token() }}",
                nodename: 'fangattr'
            },
            // 上传表单名称
            fileVal: 'file'
        });
        //回调方法监听
        uploader.on('uploadSuccess',function (file,{url}) {
            $('#pic').val(url);
            $('#showpic').attr('src',url);
            $('.imgbox').slideDown('slow');
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
        $("#form-fangattr-add").validate({
            rules:{
                name : {
                    required:true
                },
                field_name : {
                    fieldname : true
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
        jQuery.validator.addMethod("fieldname", function(value, element) {
           // console.log($('#pid').val());
            //添加顶级属性的时候字段名称不得为空
           var bool = $('#pid').val() == 0 ? false : true;
            //只能填写字母
           var reg = /[a-zA-Z_]+/;
            return  bool || (reg.test(value));

        }, "顶级属性必须填写对应的字段名称");
    </script>
@endsection
