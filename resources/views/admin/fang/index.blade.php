@extends('admin.public.public')

@section('content')

    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源管理
        <span class="c-gray en">&gt;</span> 房源列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新">
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>
    <div class="page-container">
        @include('admin.public.msg')

        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <div class="text-c"> 日期范围：
                <input value="{{ request()->get('st') }}" type="text" onfocus="WdatePicker({})" name="st" class="input-text Wdate" style="width:120px;">
                -
                <input value="{{ request()->get('et') }}" type="text" onfocus="WdatePicker({})" name="et" class="input-text Wdate" style="width:120px;">
                <input value="{{ request()->get('kw') }}" type="text" class="input-text" style="width:250px" placeholder="输入搜索的账号" id="kw">
                <button type="button" class="btn btn-success radius" onclick="searchBtn()">
                    <i class="Hui-iconfont">&#xe665;</i> 搜索一下
                </button>
            </div>
            <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l">
                    {!! $addBtn !!}
                </span>
            </div>

        </div>
        <div class="mt-20" id="app">
            <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="80">房源名称</th>
                    <th width="50">小区地址</th>
                    <th width="50">租赁方式</th>
                    <th>房源业主</th>
                    <th>房源租金</th>
                    <th>是否推荐</th>
                    <th>房源状态</th>
                    <th>配套设施</th>
                    <th width="120">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                <tr>
                    <td class="text-c">{{ $item->id }}</td>
                    <td>{{ $item->fang_name }}</td>
                    <td>{{ $item->fang_addr }}</td>
                    <td>{{ $item->getNameById($item->fang_rent_type) }}</td>
                    <td>{{ $item->fangOwner->name }}</td>
                    <td>{{ $item->fang_rent }}</td>
                    <td>{{ $item->is_recommend == '0' ? '否' : '是' }}</td>
                    <td>{{ $item->fang_status == 0 ? '待租' : '已租' }}</td>
                    <td>{{ $item->getNameById(explode(',',$item->fang_config)) }}</td>
                    <td>
                        {!! $item->editBtn('admin.fang.edit') !!}
                        {!! $item->delBtn('admin.fang.destroy') !!}
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

            layer.confirm('您确定要删除此房源信息吗',{
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
