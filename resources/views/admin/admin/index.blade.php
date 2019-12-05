@extends('admin.public.public')



@section('content')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i>首页
        <span class="c-gray en">&gt;</span> 用户中心
        <span class="c-gray en">&gt;</span> 用户管理
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>
    @include('admin.public.msg')
    <div class="page-container">
        <form>
            <div class="text-c"> 日期范围：
                <input type="text" value="{{ request()->get('st') }}" name="st" onfocus="WdatePicker()" id="datemin" class="input-text Wdate" style="width:120px;">
                -
                <input type="text" value="{{ request()->get('et') }}" name="et" onfocus="WdatePicker()" id="datemax" class="input-text Wdate" style="width:120px;">
                <input type="text" value="{{ request()->get('kw') }}" name="kw" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" >
                <button type="submit" class="btn btn-success radius" id="" name="">
                    <i class="Hui-iconfont">&#xe665;</i> 搜用户
                </button>
            </div>
        </form>

        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" onclick="delAll()" class="btn btn-danger radius">
                    <i class="Hui-iconfont">&#xe6e2;</i> 批量删除
                </a>
{{--                <a href="{{route('admin.user.create')}}" class="btn btn-primary radius">--}}
{{--                    <i class="Hui-iconfont">&#xe600;</i> 添加用户--}}
{{--                </a>--}}
                {!! $addbtn !!}
                <a href="{{route('admin.user.restore')}}" class="btn btn-warning radius">
                     回收站
                </a>
            </span>
            </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="25"><input type="checkbox" name="" value=""></th>
                    <th width="80">ID</th>
                    <th width="100">账号</th>
                    <th width="">实名</th>
                    <th width="40">性别</th>
                    <th width="90">手机</th>
                    <th width="150">邮箱</th>
                    <th width="130">加入时间</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                <tr class="text-c">
                    <td><input type="checkbox" value="{{$item->id}}" name="ids[]"></td>
                    <td>{{$item->id}}</td>
                    <td>{{$item->username}}</td>
                    <td>{{$item->truename}}</td>
                    <td>{{$item->sex}}</td>
                    <td>{{$item->phone}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->created_at}}</td>
                    <td class="td-manage">
                        {!! $item->editBtn('admin.user.edit') !!}
                        {!! $item->delBtn('admin.user.del') !!}
                    </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $data->appends(request()->except('page'))->links() }}
    </div>

    @endsection

@section('js')
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script>
        const _token = "{{ csrf_token() }}";
        $('.deluser').click(function(){
            let url = $(this).attr('href');
            //console.log(url);
            layer.confirm('您确定要删除该账号吗？',{
                btn : ['确定','不删']
            },()=>{   //箭头函数保证this的指向不变

                $.ajax({
                    url,
                    type:'delete',
                    data: {_token}
                }).then(res=>{
                    //console.log(res);
                    //把当前的行去除
                    $(this).parents('tr').remove();
                    //提示删除成功
                    layer.msg(res.msg,{icon:1,time:1000});
                    //页面刷新
                    location.replace(location.href);
                })
            })
            //jquery 中取消默认行为
            return false;
        })

        function delAll(){
            var inputs = $('input[name="ids[]"]:checked');
            //console.log(inputs);
            var ids = [];
            inputs.map((key,item)=>{
               ids.push($(item).val());
            });
            //console.log(ids);
            $.ajax({
                url:"{{ route('admin.user.delAll') }}",
                type:'delete',
                data : {_token , ids}
            }).then(ret=> {
                inputs.map((key,item) => {
                    $(item).parents('tr').remove();
                });
                layer.msg(ret.msg,{icon:1,time:1000});
                //页面刷新
                location.replace(location.href);
            });

        }
    </script>


@endsection
