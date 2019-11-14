@extends('admin.public.public')

@section('content')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i>首页
        <span class="c-gray en">&gt;</span> 用户中心
        <span class="c-gray en">&gt;</span> 回收站
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
                <a href="{{route('admin.admin.index')}}" class="btn btn-warning radius">
                     用户管理
                </a>
            </span>
            </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
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
                    <td>{{$item->id}}</td>
                    <td>{{$item->username}}</td>
                    <td>{{$item->truename}}</td>
                    <td>{{$item->sex}}</td>
                    <td>{{$item->phone}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->created_at}}</td>
                    <td class="td-manage">
                        <a onclick="restoreData( {{$item->id}} ,this)" class="label label-secondary radius renew">恢复</a>
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
        function restoreData(id,obj) {
            let url = "{{ route('admin.user.renew') }}";
                //console.log(url);
                $.ajax({
                    url,
                    data:{id}
                }).then(res=>{
                   // console.log(res);
                    let {msg} = res;
                    $(obj).parents('tr').remove();
                    layer.msg(msg,{icon:1,time:1000});
                    //页面刷新
                    location.replace(location.href);
                })
            return false;
        }

    </script>


@endsection
