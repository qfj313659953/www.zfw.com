@extends('admin.public.public')

@section('content')

    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源管理
        <span class="c-gray en">&gt;</span> 房东列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新">
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>
    <div class="page-container">
        @include('admin.public.msg')

        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                {!! $addBtn !!}
                 <a id="clickbtn" href="{{ route('admin.fangOwner.export') }}" class="btn btn-primary radius">
                    <i class="Hui-iconfont">&#xe600;</i> 生成excel导出文件
                </a>
                <a href="{{ $excelpath }}"  class="btn btn-success radius" style="display:@if($isshow) inline-block; @else none; @endif ">下载excel文件</a>
            </span>

        </div>
        <div class="mt-20" id="app">
            <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="80">房东姓名</th>
                    <th width="50">房东性别</th>
                    <th width="50">房东年龄</th>
                    <th>联系电话</th>
                    <th>身份证号</th>
                    <th>邮箱地址</th>
                    <th width="120">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                <tr>
                    <td class="text-c">{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->sex }}</td>
                    <td>{{ $item->age }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->card }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        {!! $item->showBtn('admin.fangOwner.show') !!}
                        {!! $item->editBtn('admin.fangOwner.edit') !!}
                        {!! $item->delBtn('admin.fangOwner.destroy') !!}
                    </td>
                </tr>
                    @endforeach
                </tbody>

            </table>
        {{ $data->appends(request()->except('page'))->links() }}
        </div>
    </div>

@endsection

@section('js')


    <script>
        //显示身份证图片
        $('.showbtn').click(function(){
           let url = $(this).attr('href');
           $.get(url).then(({status,msg,data})=>{
               if(status == 0){
                   let content = '';
                   data.forEach(item=>{
                       content += '<img style="margin-right:10px;width:150px;" src=' + item + '/>';
                   });
                   //弹窗
                   layer.open({
                       type: 1,
                       skin: 'layui-layer-rim', //加上边框
                       area: ['500px', '300px'], //宽高
                       content
                   });
               }

           });
            return false;
        });
        $('#clickbtn').click(function(){
            layer.msg('数据正在生成中，请您耐心等待一会！！');
        })

        //删除文章，事件委托
        $('.table-sort').on('click','.deluser',function(){

            layer.confirm('您确定要删除此房东信息吗',{
                btn : ['确定','取消']
            },()=>{
                //请求地址
                let url = $(this).attr('href');
                //使用fetch来实现异步ajax请求
                fetch(url,{
                    //请求类型
                    method: 'delete',
                    //指定请求头
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        //json字符串传递数据，需要的头部信息
                        'content-type':'application/json'
                    },
                }).then(res=>{
                    return res.json();
                }).then(ret=>{
                    // console.log(ret);
                    if(ret.status == 0){
                        $(this).parents('tr').remove();
                        layer.msg(ret.msg,{
                            time:1000,
                            icon : 1
                        });
                        location.replace(location.href);
                    }

                })
            })
            return false;
        });




    </script>
@endsection
