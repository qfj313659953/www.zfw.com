@extends ('admin.public.public')

@section ('content')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 管理员管理
        <span class="c-gray en">&gt;</span> 角色管理
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>
    <div class="page-container">
        <form>
            <div class="text-c">
                <input value="{{ request()->get('kw') }}" type="text" class="input-text" id="kw" style="width:250px" placeholder="输入搜索的账号" name="kw">
                <button type="submit" class="btn btn-success radius" id="" name="">
                    <i class="Hui-iconfont">&#xe665;</i> 搜索一下
                </button>
                <div id="search" style="display: none">
                    <ul id="ul1">

                    </ul>
                </div>
            </div>
        </form>

        @include ('admin.public.msg')
        <div class="cl pd-5 bg-1 bk-gray">
            <span class="l">
                {{--<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius">
                    <i class="Hui-iconfont">&#xe6e2;</i> 批量删除
                </a>--}}
                {!! $addbtn !!}
            </span>
        </div>
        <table class="table table-border table-bordered table-hover table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="6">角色管理</th>
            </tr>
            <tr class="text-c">
                <th width="25">
                    <input type="checkbox" value="" name=""></th>
                <th width="40">ID</th>
                <th width="200">角色名</th>
                <th>用户列表</th>
                <th width="300">描述</th>
                <th width="70">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
            <tr class="text-c">
                <td><input type="checkbox" value="{{ $item['id'] }}" name="ids[]"></td>
                <td>{{ $item['id'] }}</td>
                <td>{{ $item['name'] }}</td>
                <td><a href="#"></a></td>
                <td>{{ $item['desc'] }}</td>
                <td class="f-14">
                    <a href="{{ route('admin.role.edit',$item) }}" class="label label-secondary radius">修改</a>
                    {{--<a data-href="{{ route('admin.role.destroy',$item) }}" class="label label-danger radius deluser">删除</a>--}}
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    </div>
    @endsection

@section ('js')
    <script>
        $('#kw').on('input',function(){
            clearTimeout(timer);
            let kw = $(this).val();
           var timer =  setTimeout(()=>{
               $.ajax({
                   url:"{{ route('admin.role.search') }}",
                   data: {kw},
               }).then(ret=>{
                   let {status,data} = ret;
                   let ul = $('#ul1');
                   let ularray = [];
                   if(status == 0){
                       $(ul).empty();
                       $.each(data,function(index,item){

                           var li = $("<li></li>").html(item.name);
                           ularray.push(item.name);
                          /* $.each(item,function(name,val){
                               console.log(val);
                               var span = $("<span></span>").html(val);
                               li.append(span);
                               ularray.push(val.name);
                           })*/
                           ul.append(li);
                       })
                       ularray.sort();
                       $('#search').css('display','block');
                   }
               })
           },1000)
        });

    </script>
    @endsection

