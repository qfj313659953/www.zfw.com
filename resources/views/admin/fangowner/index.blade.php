@extends('admin.public.public')

@section('content')

    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源管理
        <span class="c-gray en">&gt;</span> 房源属性列表
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
                    <th>房源属性</th>
                    <th width="80">图标</th>
                    <th width="120">操作</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="item in lists" >
                        <td v-text="item.id"></td>
                        <td :style="'padding-left:'+(item.level*20)+ 'px'" v-text="item.name"></td>
                        <td>
                            <img :src="item.icon" style="width:100px" alt="">
                        </td>
                        <td v-html="item.actionBtn">

                        </td>
                    </tr>
                </tbody>

            </table>

        </div>
    </div>

@endsection

@section('js')
    <script src="{{ staticAdminPath() }}lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script src="{{ staticAdminPath() }}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script src="/js/vue.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                lists: []
            },
            mounted() {
                $.get("{{ route('admin.fangAttr.index') }}").then(ret => {
                    //console.log(ret);
                    this.lists= ret;
                })
            }

        })

        //删除文章，事件委托
        $('.table-sort').on('click','.deluser',function(){

            layer.confirm('您确定要删除此属性吗',{
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
