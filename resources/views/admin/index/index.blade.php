@extends('admin.public.public')
@section('title','首页')

@section('content')
    <header class="navbar-wrapper">
        <div class="navbar navbar-fixed-top">
            <div class="container-fluid cl"><a class="logo navbar-logo f-l mr-10 hidden-xs" href="/aboutHui.shtml">H-ui.admin</a>
                <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="/aboutHui.shtml">H-ui</a>
                <span class="logo navbar-slogan f-l mr-10 hidden-xs">v3.1</span>
                <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
                <nav class="nav navbar-nav">
                    <ul class="cl">
                        <li class="dropDown dropDown_hover"><a href="javascript:;" class="dropDown_A"><i
                                    class="Hui-iconfont">&#xe600;</i> 新增 <i class="Hui-iconfont">&#xe6d5;</i></a>
                            <ul class="dropDown-menu menu radius box-shadow">
                                <li><a href="javascript:;" onclick="article_add('添加资讯','article-add.html')"><i
                                            class="Hui-iconfont">&#xe616;</i> 资讯</a></li>
                                <li><a href="javascript:;" onclick="picture_add('添加资讯','picture-add.html')"><i
                                            class="Hui-iconfont">&#xe613;</i> 图片</a></li>
                                <li><a href="javascript:;" onclick="product_add('添加资讯','product-add.html')"><i
                                            class="Hui-iconfont">&#xe620;</i> 产品</a></li>
                                <li><a href="javascript:;" onclick="member_add('添加用户','member-add.html','','510')"><i
                                            class="Hui-iconfont">&#xe60d;</i> 用户</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                    <ul class="cl">
                        <li>{{ auth()->user()->truename }}</li>
                        <li class="dropDown dropDown_hover">
                            <a href="#" class="dropDown_A">{{ auth()->user()->username }} <i class="Hui-iconfont">&#xe6d5;</i></a>
                            <ul class="dropDown-menu menu radius box-shadow">
                                <li><a onClick="myselfinfo('{{ route('admin.admin.person') }}')">个人信息</a></li>
                                <li><a href="#">切换账户</a></li>
                                <li><a href="{{ route('admin.logout') }}">退出</a></li>
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <aside class="Hui-aside">
        <div class="menu_dropdown bk_2">
            @foreach($menuData as $item)
            <dl id="menu-admin">
                <dt><i class="Hui-iconfont">&#xe62d;</i> {{ $item['name'] }}<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
                </dt>
                <dd>
                    <ul>
                        @foreach($item['son'] as $val)
                        <li><a data-href="{{ route($val['route_name']) }}" data-title="{{ $val['name'] }}" href="javascript:void(0)">{{ $val['name'] }}</a></li>
                        @endforeach
                    </ul>
                </dd>
            </dl>
            @endforeach
        </div>
    </aside>
    <div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a>
    </div>
    <section class="Hui-article-box">
        <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
            <div class="Hui-tabNav-wp">
                <ul id="min_title_list" class="acrossTab cl">
                    <li class="active">
                        <span title="我的桌面" data-href="welcome.html">我的桌面</span>
                        <em></em></li>
                </ul>
            </div>
            <div class="Hui-tabNav-more btn-group">
                <a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;">
                    <i class="Hui-iconfont">&#xe6d4;</i>
                </a>
                <a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;">
                    <i class="Hui-iconfont">&#xe6d7;</i>
                </a>
            </div>
        </div>
        <div id="iframe_box" class="Hui-article">
            <div class="show_iframe">
                <div style="display:none" class="loading"></div>
                <iframe scrolling="yes" frameborder="0" src="{{route('admin.welcome')}}"></iframe>
            </div>
        </div>
    </section>

    <div class="contextMenu" id="Huiadminmenu">
        <ul>
            <li id="closethis">关闭当前</li>
            <li id="closeall">关闭全部</li>
        </ul>
    </div>
@endsection

@section('js')
    <!--请在下方写此页面业务相关的脚本-->
    <script type="text/javascript" src="{{ staticAdminPath() }}lib/jquery.contextmenu/jquery.contextmenu.r2.js"></script>
    <script type="text/javascript">
        /*个人信息*/
        function myselfinfo(url) {
            layer_show('个人信息修改', url, 800, 600);

        }

        /*资讯-添加*/
        function article_add(title, url) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*图片-添加*/
        function picture_add(title, url) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*产品-添加*/
        function product_add(title, url) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*用户-添加*/
        function member_add(title, url, w, h) {
            layer_show(title, url, w, h);
        }


    </script>
@endsection

