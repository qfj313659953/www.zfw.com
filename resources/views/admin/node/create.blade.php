@extends ('admin.public.public')

@section ('content')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 管理员管理
        <span class="c-gray en">&gt;</span> 权限添加
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
            <i class="Hui-iconfont">&#xe68f;</i>
        </a>
    </nav>
    <article class="page-container">
        <form action="{{ route('admin.node.store') }}" method="post" class="form form-horizontal" id="form-admin-role-add">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">上级菜单：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="pid" class="select">
                    @foreach($data as $id=>$name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
				</select>
				</span></div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ old('name') }}" placeholder="" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">路由别名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{ old('route_name') }}" placeholder="" name="route_name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">菜单显示：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <label><input name="is_menu" type="radio" value="0" checked>
                            否</label>
                    </div>
                    <div class="radio-box">
                        <label><input type="radio" name="is_menu" value="1">
                            是</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input type="submit" value="添加权限" class="btn btn-success radius">
                        <i class="icon-ok"></i>
                    </input>
                </div>
            </div>
        </form>
    </article>

    @endsection

