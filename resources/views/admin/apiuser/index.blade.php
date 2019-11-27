@extends('admin.public.public')

@section('content')

    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 接口账号管理
        <span class="c-gray en">&gt;</span> 接口账号列表
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
            </span>

        </div>
        <div class="mt-20" id="app">
            <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="80">姓名</th>
                    <th width="100">密码</th>
                    <th width="100">token</th>
                    <th>请求次数</th>
                    <th width="120">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                <tr class="text-c">
                    <td class="text-c">{{ $item->id }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->plainpass }}</td>
                    <td>{{ $item->token }}</td>
                    <td>{{ $item->click }}</td>
                    <td>
                        {!! $item->editBtn('admin.apiuser.edit') !!}
                        {!! $item->delBtn('admin.apiuser.destroy') !!}
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
