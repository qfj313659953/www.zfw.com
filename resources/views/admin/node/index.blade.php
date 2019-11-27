@extends ('admin.public.public')

@section('content')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 权限管理
        <span class="c-gray en">&gt;</span> 权限列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <form>
            <div class="text-c">
                <input value="{{ request()->get('kw') }}" type="text" class="input-text" style="width:250px" placeholder="输入搜索的账号" name="kw">
                <button type="submit" class="btn btn-success radius" id="" name="">
                    <i class="Hui-iconfont">&#xe665;</i> 搜索一下
                </button>
            </div>
        </form>

        @include('admin.public.msg')

        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                 {!! $addbtn !!}
            </span>
        </div>

        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="100">节点名称</th>
                    <th>路由别名</th>
                    <th>是否菜单</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                {{-- 列表数据 --}}
                @foreach($data as $item)
                    <tr class="text-c">
                        <td>{{ $item['id'] }}</td>
                        <td class="text-l">{{ $item['html'] }}{{ $item['name'] }}</td>
                        <td>{{ $item['route_name'] ?? '无' }}</td>
                        <td>
                            @if($item['is_menu'] == '0')
                                <span class="label label-warning radius">否</span>
                            @else
                                <span class="label label-success radius">是</span>
                            @endif
                        </td>
                        <td class="td-manage">
                            <a href="#" class="label label-secondary radius">修改</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    @endsection

@section('js')
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/laypage/1.2/laypage.js"></script>
    <script>

    </script>
@endsection