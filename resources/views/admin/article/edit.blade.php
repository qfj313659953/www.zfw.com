@extends('admin.public.public')

@section('css')
    <link rel="stylesheet" href="{{ staticAdminPath() }}lib/webuploader/0.1.5/webuploader.css">
    <style>
        .imgbox {
            width: 100px;
            height: auto;
            position: relative;
            margin-left:100px;
        }
        .imgbox img {
            width: 100%;
            height: 100%;
        }
        .imgbox p {
            font-size:18px;
            color: #fff;
            position: absolute;
            cursor:pointer;
            right:8px;
            top:5px;
        }
    </style>
@endsection

@section('content')

    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 资讯管理
        <span class="c-gray en">&gt;</span> 资讯修改
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>
    <article class="page-container">
        <form class="form form-horizontal" id="form-article-add" method="post" action="{{ route('admin.article.update',['id'=>$article->id,'url'=>$url_query]) }}">
            @csrf
            @method('put')
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>文章标题：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $article->title }}" placeholder="" id="articletitle" name="title">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">来源：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $article->author }}" placeholder="" id="articletitle2" name="author">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类栏目：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="cid" class="select">
					<option value="0">全部栏目</option>
                    @foreach($cateList as $item)
					<option value="{{ $item['id'] }}" @if($item['id'] == $article->cid) selected @endif>{{ $item['html'] }}{{ $item['cname'] }}</option>
                    @endforeach

				</select>
				</span> </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">文章摘要：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="desn"  class="textarea"  placeholder="说点什么...最少输入10个字符">
                        {{ $article->desn }}
                    </textarea>

                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">缩略图：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div class="uploader-thum-container">
                        <div id="filePicker">选择图片</div>
                        <div class="imgbox">
                            <input type="hidden" name="pic" id="pic" value="{{ $article->pic }}">
                            <img src="{{ $article->pic }}"  style="width: 100px;" alt="" id="showpic">
                            <p onclick="delpic('{{ $article->id }}','{{ $article->pic }}')">X</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">文章内容：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea id="content" name="body">{{ $article->body }}</textarea>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">

                    <button class="btn btn-primary radius" type="submit">修改文章</button>

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
    {{--富文本类--}}
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/ueditor/1.4.3/ueditor.config.js"></script>
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/ueditor/1.4.3/ueditor.all.min.js"> </script>
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
    <script>
        //富文本的引用
        var ue = UE.getEditor('content',{
            initialFrameHeight : 500,
        });
        //点击删除图片
       function delpic(id,url){
          $.get('{{route("admin.base.delpic")}}',{id,url}).then(ret=>{
            $('#pic').val('');
            $('#showpic').attr('src','');
            $('.imgbox').slideUp('slow');
          });
       }


        //异步文件上传
        var uploader = WebUploader.create({
            //自动上传
            auto: true,
            //swf文件路径
            swf : '{{ staticAdminPath() }}lib/webuploader/0.1.5/Uploader.swf',
            // 文件接收服务端
            server: '{{ route('admin.base.upfile') }}',
            // 选择文件的按钮
            pick: '#filePicker',
            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            // 表单传额外值
            formData: {
                _token: "{{ csrf_token() }}",
                nodename : 'article'
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


        //表单验证
        $("#form-article-add").validate({
            rules:{
                title : {
                    required:true
                },
                desn : {
                    required : true,
                },

            },
            onkeyup : false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                form.submit();
            }
        })


    </script>
    @endsection
