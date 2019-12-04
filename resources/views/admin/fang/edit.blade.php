@extends('admin.public.public')

@section('css')
    <link rel="stylesheet" href="{{ staticAdminPath() }}lib/webuploader/0.1.5/webuploader.css">
    <link rel="stylesheet" href="{{ staticAdminPath() }}static/h-ui/css/delpic.css">
@endsection

@section('content')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源管理
        <span class="c-gray en">&gt;</span> 修改房源
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>

    @include('admin.public.msg')

    <article class="page-container">
        <form class="form form-horizontal" id="form-article-add" action="{{ route('admin.fang.update',$fang) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" value="{{ $fang->fang_name }}" class="input-text" name="fang_name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>小区名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $fang->fang_xiaoqu }}" name="fang_xiaoqu">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>房源地址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 150px;">
                        <select name="fang_province" onchange="changeCity(this,'fang_city','市')" class="select">
                             <option value="0">请选择省份</option>
                            @foreach($Pdata as $item)
                                <option @if($fang->fang_province == $item->id) selected @endif value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </span>
                    <span class="select-box" style="width: 150px;">
                        <select id="fang_city" name="fang_city" onchange="changeCity(this,'fang_region','区')" class="select">
                            @foreach($cdata as $item)
                            <option @if($fang->fang_city == $item->id) selected @endif value="{{$item->id}}">{{ $item->name }}</option>
                                @endforeach
                        </select>
                    </span>
                    <span class="select-box" style="width: 150px;">
                        <select id="fang_region" name="fang_region" class="select">
                            @foreach($rdata as $item)
                                <option @if($fang->fang_region == $item->id) selected @endif value="{{$item->id}}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </span>
                    <span class="select-box" style="width: 362px;">
                        <input type="text" class="select" value="{{ $fang->fang_addr }}" placeholder="房源详细地址" name="fang_addr">
                        <input type="hidden" name="fang_addr2" value="{{ $fang->fang_addr }}">
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源朝向：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 150px;">
                        <select name="fang_direction" class="select">
                            <option value="0">请选择房源朝向</option>
                            @foreach($attrs['fang_direction']['son'] as $item )
                            <option @if($fang->fang_direction ==$item['id'] ) selected @endif value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源面积：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <input type="text" class="select" value="{{ $fang->fang_build_area }}" placeholder="房源面积" name="fang_build_area">
                    </span>
                    <span class="select-box" style="width: 362px;">
                        <input type="text" class="select" value="{{ $fang->fang_using_area }}" placeholder="使用面积" name="fang_using_area">
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>建筑年代：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <input type="text" class="select" placeholder="建筑年代" value="{{ $fang->fang_year }}" name="fang_year">
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源租金：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <input type="text" value="{{ $fang->fang_rent }}" class="select" name="fang_rent">
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源楼层：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 80px;">
                        <input type="text" class="select" value="{{ $fang->fang_floor }}" placeholder="房源楼层" name="fang_floor">
                    </span>
                    <span class="select-box" style="width: 150px;">
                        <select name="fang_shi" class="select">
                            @for($i=1;$i<=5;$i++)
                            <option @if($fang->fang_shi == $i) selected @endif value="{{ $i }}">{{ $i }}室</option>
                                @endfor
                        </select>
                    </span>
                    <span class="select-box" style="width: 150px;">
                        <select name="fang_ting" class="select">
                            @for($i=1;$i<=5;$i++)
                                <option @if($fang->fang_ting == $i) selected @endif value="{{ $i }}">{{ $i }}厅</option>
                            @endfor
                        </select>
                    </span>
                    <span class="select-box" style="width: 150px;">
                        <select name="fang_wei" class="select">
                            @for($i=1;$i<=3;$i++)
                                <option @if($fang->fang_wei == $i) selected @endif value="{{ $i }}">{{ $i }}卫</option>
                            @endfor
                        </select>
                    </span>
                    <span class="select-box" style="width: 150px;">
                        <select name="fang_rent_class" class="select">
                            <option value="0">请选择租赁方式</option>
                             @foreach($attrs['fang_rent_class']['son'] as $item )
                                <option @if($fang->fang_rent_class ==$item['id'] ) selected @endif value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>配套设施：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    @foreach($attrs['fang_config']['son'] as $item)
                    <div class="check-box">
                        <label>
                            <input type="checkbox" @if(in_array($item['id'],explode(',',$fang->fang_config))) checked @endif  value="{{ $item['id'] }}" name="fang_config[]">
                            {{ $item['name'] }}
                        </label>
                    </div>
                        @endforeach
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源区域：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <select name="fang_area" class="select">
                            <option value="0">房源区域</option>
                             @foreach($attrs['fang_area']['son'] as $item )
                                <option @if($fang->fang_area ==$item['id'] ) selected @endif value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>租金范围：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <select name="fang_rent_range" class="select">
                            <option value="0">租金范围</option>
                            @foreach($attrs['fang_rent_range']['son'] as $item )
                                <option @if($fang->fang_rent_range ==$item['id'] ) selected @endif value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>租期方式：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <select name="fang_rent_type" class="select">
                            <option value="0">租期方式</option>
                            @foreach($attrs['fang_rent_type']['son'] as $item )
                                <option @if($fang->fang_rent_type ==$item['id'] ) selected @endif value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源状态：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <label>
                            <input name="fang_status" type="radio" value="0" @if($fang->fang_status == '0') checked @endif>
                            待租
                        </label>
                    </div>
                    <div class="radio-box">
                        <label>
                            <input name="fang_status" type="radio" value="1" @if($fang->fang_status == '1') checked @endif>
                            已租
                        </label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>是否推荐：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <label>
                            <input name="is_recommend" type="radio" value="0" @if($fang->fang_status == '0') checked @endif>
                            不推荐
                        </label>
                    </div>
                    <div class="radio-box">
                        <label>
                            <input name="is_recommend" type="radio" value="1" @if($fang->fang_status == '1') checked @endif>
                            推荐
                        </label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源房东：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <select name="fang_owner" class="select">
                            <option value="0">房源房东</option>
                            @foreach($owner as $item )
                                <option @if($fang->fang_owner == $item['id'] ) selected @endif value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源小组：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width: 362px;">
                        <select name="fang_group" class="select">
                            @foreach($attrs['fang_group']['son'] as $item )
                                <option @if($fang->fang_group == $item['id'] ) selected @endif value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源摘要：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="fang_desn" class="textarea">{{ $fang->fang_desn }}</textarea>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源图片：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div class="uploader-thum-container">
                        <div id="filePicker">选择图片</div>
                        <input type="hidden" value="{{ $fang->fang_pics }}" name="fang_pic" id="pic">
                        <div id="imgList">
                            @foreach($fang->pics as $src)
                                <div class="imgbox">
                                    <img src="{{ $src }}" alt="">
                                    <p class="delbtn">X</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>房源详情：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea id="fang_body" name="fang_body">
                        {{ $fang->fang_body }}
                    </textarea>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button class="btn btn-primary radius" type="submit">修改新房源</button>
                </div>
            </div>
        </form>
    </article>

@endsection

@section('js')
    <!-- 引入 ueditor js类库 -->
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/ueditor/1.4.3/ueditor.config.js"></script>
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/ueditor/1.4.3/ueditor.all.min.js"></script>
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
    <!-- 引入webuploader插件 类库JS-->
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/webuploader/0.1.5/webuploader.min.js"></script>
    <!-- 表单前端验证插件 jquery validate -->
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/jquery.validation/1.14.0/messages_zh.js"></script>

    <script>
        function changeCity(obj,fieldname,str){
            let val = obj.value;
            $.get('{{ route("admin.fang.getcity") }}',{pid:val}).then(ret=>{
                ret = [{ id : 0, name:'请选择'+str},...ret];
                let html = '';
                ret.forEach(item=>{
                   html += `<option value="${ item.id }">${ item.name }</option>`;
                });
                $('#'+fieldname).html(html);
            });
        }




        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
        //表单验证
        $("#form-article-add").validate({
            rules: {
                fang_name: {
                    required: true
                },
                fang_xiaoqu: {
                    required: true
                },
                fang_province: {
                    required: true,
                    min:1,
                },
                fang_city: {
                    required: true,
                    min:1,
                },
                fang_region: {
                    required: true,
                    min:1,
                },
                fang_addr: {
                    required: true,
                },
                fang_direction: {
                    required: true,
                    min:1,
                },
                fang_build_area: {
                    required: true,
                },
                fang_using_area: {
                    required: true,
                },
                fang_year: {
                    required: true,
                },
                fang_rent: {
                    required: true,
                },
                fang_floor: {
                    required: true,
                },
                fang_shi: {
                    required: true,
                    min:1,
                },
                fang_ting: {
                    required: true,
                    min:1,
                },
                fang_wei: {
                    required: true,
                    min:1,
                },
                fang_rent_class: {
                    required: true,
                    min:1,
                },
                fang_config: {
                    required: true,
                },
                fang_area: {
                    required: true,
                    min:1,
                },
                fang_rent_range: {
                    required: true,
                    min:1,
                },
                fang_rent_type: {
                    required: true,
                    min:1,
                },
                fang_owner: {
                    required: true,
                    min:1,
                },
                fang_group: {
                    required: true,
                    min:1,
                },
                fang_pic: {
                    required: true,
                },
                fang_body: {
                    required: true,
                },


            },
            onkeyup: false,
            success: "valid",
            submitHandler: function (form) {
                form.submit();
            }
        });


        // 异步文件上传
        var uploader = WebUploader.create({
            // 自动上传
            auto: true,
            // swf文件路径
            swf: '{{ staticAdminPath() }}lib/webuploader/0.1.5/Uploader.swf',
            // 文件接收服务端
            server: '{{ route('admin.base.upfile') }}',
            // 选择文件的按钮
            pick: '#filePicker',
            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            // 表单传额外值
            formData: {
                _token: "{{ csrf_token() }}",
                nodename: 'fang'
            },
            // 上传表单名称
            fileVal: 'file'
        });
        // 回调方法监听
        uploader.on('uploadSuccess', function (file, {url}) {
            var val = $('#pic').val();
            $('#pic').val(val + '#' + url);

            var imgbox = $('<div class="imgbox"></div>');
            var imgObj = $('<img />');
            imgObj.attr('src',url);
            var span = $('<p class="delbtn">X</p>');
            imgbox.append(imgObj,span);
            $('#imgList').append(imgbox);
        });

        //点击删除图片
        $('#imgList').on('click','.delbtn',function(){
            let url = $(this).prev().attr('src');
            // console.log(url);
            $.get('{{route("admin.base.delpic")}}',{url}).then(ret=>{
                let val = $('#pic').val();
                let replaceVal = '#' + url;
                val = val.replace(replaceVal,'');
                $('#pic').val(val);
                $(this).parent().remove();
            });
        });

        // 富文本
        var ue = UE.getEditor('fang_body', {
            // 初始化高度
            initialFrameHeight: 500
        });
    </script>
@endsection
