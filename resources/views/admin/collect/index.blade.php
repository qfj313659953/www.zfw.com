@extends('admin.public.public')

@section('content')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 看房管理
        <span class="c-gray en">&gt;</span> 看房列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container">
        <div class="text-c"> 日期范围：
            <input value="{{ request()->get('st') }}" type="text" onfocus="WdatePicker({})" name="st" class="input-text Wdate" style="width:120px;">
            -
            <input value="{{ request()->get('et') }}" type="text" onfocus="WdatePicker({})" name="et" class="input-text Wdate" style="width:120px;">
            <button type="button" class="btn btn-success radius" onclick="searchBtn()">
                <i class="Hui-iconfont">&#xe665;</i> 搜索一下
            </button>
        </div>

        @include('admin.public.msg')

        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="100">业主</th>
                    <th width="100">业主电话</th>
                    <th width="100">租客</th>
                    <th width="120">租客电话</th>
                    <th>确认房源名称</th>
                    <th>房源小区名称</th>
                    <th>房源地址</th>
                    <th width="50">预约状态</th>
                    <th width="120">操作</th>
                </tr>
                </thead>
                @foreach($data as $item)
                    <tr class="text-c">
                        <td>{{$item->id}}</td>
                        <td>{{ $item->fangowner->name }}</td>
                        <td>{{ $item->fangowner->phone }}</td>
                        <td>{{ $item->renting->truename }}</td>
                        <td>{{ $item->renting->phone }}</td>
                        <td>{{ $item->fang->fang_name }}</td>
                        <td>{{ $item->fang->fang_xiaoqu }}</td>
                        <td>{{ $item->fang->fang_addr }}</td>
                        <td>{{ $item->is_notice == 0 ? '未约' : '已约' }}</td>
                        <td>
                            {!! $item->delBtn('admin.notice.destroy') !!}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        {{ $data->appends(request()->except('page'))->links() }}
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/My97DatePicker/4.8/WdatePicker.js"></script>

@endsection

