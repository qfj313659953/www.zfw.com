@extends('admin.public.public')

@section('content')

    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 资讯管理
        <span class="c-gray en">&gt;</span> 资讯列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新">
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>
    <div class="page-container">
        @include('admin.public.msg')
        <div class="text-c">

            </span> 日期范围：
            <input type="text" value="{{ request()->get('st') }}" name="st" id="st"
                   class="input-text Wdate" style="width:120px;">
            -
            <input type="text" value="{{ request()->get('et') }}" name="et" id="et"
                   class="input-text Wdate" style="width:120px;">
            <input type="text" name="kw" id="kw" value="{{ request()->get('kw') }}" placeholder=" 资讯名称"
                   style="width:250px" class="input-text">
            <button name="" id="" class="btn btn-success" type="button" onclick="search()">
                <i class="Hui-iconfont">&#xe665;</i> 搜资讯
            </button>


        </div>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius">
                    <i class="Hui-iconfont">&#xe6e2;</i> 批量删除
                </a>
                {!! $addBtn !!}

            </span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                <thead>
                <tr class="text-c">
                    <th width="25">
                        <input type="checkbox" name="" value=""></th>
                    <th width="80">ID</th>
                    <th>标题</th>
                    <th width="80">分类</th>
                    <th width="80">来源</th>
                    <th width="120">更新时间</th>
                    <th width="120">操作</th>
                </tr>
                </thead>

            </table>

        </div>
    </div>

@endsection

@section('js')
    <script src="{{ staticAdminPath() }}lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script src="{{ staticAdminPath() }}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script>
        let dataTable = $('.table-sort').dataTable({
            //初始化排序
            columnDefs: [{
                //根据索引不进行排序
                targets: [0, 4, 6], orderable: false
            }],
            order: [{{request()->get('field') ?? 1}} , "{{ request()->get('order') ?? 'desc' }}"],
            //设置每页显示数
            lengthMenu: [10, 20, 30, 50, 100],
            //关闭搜索,由于效率过低
            searching: false,
            //从第几条数据开始
            displayStart: {{ request()->get('start') ?? 0 }},
            //开启服务器模式
            serverSide: true,
            //ajax发送请求
            ajax: {
                //请求地址
                url: '{{ route('admin.article.index') }}',
                data : function(res){
                   // console.log(res);
                    res.kw = $('#kw').val();
                    res.st = $('#st').val();
                    res.et = $('#et').val();
                }
            },
            columns: [
                {data: 'aa', defaultContent: '<input type=checkbox name=ids[] />'},
                {'data': 'id', 'className': 'text-c'},
                {'data': 'title'},
                {'data': 'cates.cname'},
                {'data': 'author'},
                {'data': 'updated_at'},
                {'data': 'actionBtn', 'className': 'text-c'}
            ],
            createdRow: function(row,data) {
                var td = $(row).find('td:first-child');
                td.val(data['id']);
            }



        });

        function search(){
            //重新加载数据
            dataTable.api().ajax.reload();
        }

        //删除文章，事件委托
        $('.table-sort').on('click','.deluser',function(){

            layer.confirm('您确定要删除此文章吗',{
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
                    }

                })
            })
            return false;
        });



    </script>
@endsection
