@extends ('admin.public.public')

@section ('content')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 管理员管理
        <span class="c-gray en">&gt;</span> 角色修改
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>
    <article class="page-container">
        <form action="{{ route('admin.role.update',$role) }}" method="post" class="form form-horizontal" id="form-admin-role-add">
            @csrf
            @method('PUT')
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $role->name }}" placeholder="" id="roleName" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">备注：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ $role->desc }}" placeholder="" id="" name="desc">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">权限分配：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    @foreach($nodeData as $item)
                        <dl class="permission-list">
                            <dt>
                                <label>
                                    <input type="checkbox" value="{{ $item['id'] }}" name="node_ids[]"
                                    @if(in_array($item['id'],$role_node)) checked @endif
                                    >
                                    {{ $item['name'] }}</label>
                            </dt>
                            @foreach($item['son'] as $val)
                                <dd  class="cl permission-list2">
                                    <label class="">
                                        <input type="checkbox" value="{{ $val['id'] }}" name="node_ids[]"
                                               @if(in_array($val['id'],$role_node)) checked @endif
                                        >
                                        {{ $val['name'] }}
                                    </label>

                                </dd>
                            @endforeach
                        </dl>
                    @endforeach
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <button type="submit" class="btn btn-success radius">
                        <i class="icon-ok"></i> 角色修改
                    </button>
                </div>
            </div>
        </form>
    </article>

    @endsection
@section ('js')
    <script>
        $('.user-Character-1').change(function(){
            if($(this).is(":checked")){
                $(".user-Character-1-0").prop("checked",true);
            }else{
                $(".user-Character-1-0").prop("checked",false);
            }
        })

        $(".user-Character-1-0").change(function(){
            if($(".user-Character-1-0:checked").length==$(".user-Character-1-0").length){
                $('.user-Character-1').prop("checked",true);
            }else{
                $('.user-Character-1').prop("checked",false);
            }
        })
    </script>
@endsection
