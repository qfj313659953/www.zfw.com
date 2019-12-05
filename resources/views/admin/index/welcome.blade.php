@extends('admin.public.public')

@section('content')
    <div class="page-container">
        <p class="f-20 text-success">欢迎使用H-ui.admin <span class="f-14">v3.1</span>后台模版！</p>
        <p>登录次数：18 </p>
        <p>上次登录IP：222.35.131.79.1  上次登录时间：2014-6-14 11:19:55</p>
        <div class="chart">
            <div id="main" style="width: 600px;height:400px;"></div>
        </div>
    </div>
{{--        <table class="table table-border table-bordered table-bg mt-20">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th colspan="2" scope="col">服务器信息</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            <tr>--}}
{{--                <th width="30%">服务器计算机名</th>--}}
{{--                <td><span id="lbServerName">http://127.0.0.1/</span></td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>服务器IP地址</td>--}}
{{--                <td>192.168.1.1</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>服务器域名</td>--}}
{{--                <td>www.h-ui.net</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>服务器端口 </td>--}}
{{--                <td>80</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>服务器IIS版本 </td>--}}
{{--                <td>Microsoft-IIS/6.0</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>本文件所在文件夹 </td>--}}
{{--                <td>D:\WebSite\HanXiPuTai.com\XinYiCMS.Web\</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>服务器操作系统 </td>--}}
{{--                <td>Microsoft Windows NT 5.2.3790 Service Pack 2</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>系统所在文件夹 </td>--}}
{{--                <td>C:\WINDOWS\system32</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>服务器脚本超时时间 </td>--}}
{{--                <td>30000秒</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>服务器的语言种类 </td>--}}
{{--                <td>Chinese (People's Republic of China)</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>.NET Framework 版本 </td>--}}
{{--                <td>2.050727.3655</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>服务器当前时间 </td>--}}
{{--                <td>2014-6-14 12:06:23</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>服务器IE版本 </td>--}}
{{--                <td>6.0000</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>服务器上次启动到现在已运行 </td>--}}
{{--                <td>7210分钟</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>逻辑驱动器 </td>--}}
{{--                <td>C:\D:\</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>CPU 总数 </td>--}}
{{--                <td>4</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>CPU 类型 </td>--}}
{{--                <td>x86 Family 6 Model 42 Stepping 1, GenuineIntel</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>虚拟内存 </td>--}}
{{--                <td>52480M</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>当前程序占用内存 </td>--}}
{{--                <td>3.29M</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>Asp.net所占内存 </td>--}}
{{--                <td>51.46M</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>当前Session数量 </td>--}}
{{--                <td>8</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>当前SessionID </td>--}}
{{--                <td>gznhpwmp34004345jz2q3l45</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td>当前系统用户名 </td>--}}
{{--                <td>NETWORK SERVICE</td>--}}
{{--            </tr>--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--    </div>--}}
{{--    <footer class="footer mt-20">--}}
{{--        <div class="container">--}}
{{--            <p>感谢jQuery、layer、laypage、Validform、UEditor、My97DatePicker、iconfont、Datatables、WebUploaded、icheck、highcharts、bootstrap-Switch<br>--}}
{{--                Copyright &copy;2015-2017 H-ui.admin v3.1 All Rights Reserved.<br>--}}
{{--                本后台系统由<a href="http://www.h-ui.net/" target="_blank" title="H-ui前端框架">H-ui前端框架</a>提供前端技术支持</p>--}}
{{--        </div>--}}
{{--    </footer>--}}

@endsection

@section('js')
    <script src="/js/echarts.min.js"></script>
    <script>
        let myChart = echarts.init(document.getElementById('main'));

        var option = {
            title : {
                text: '已租和待租的比例',
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                type: 'scroll',
                orient: 'vertical',
                right: 10,
                top: 20,
                bottom: 20,
                data: [{!! $legend !!}],

            },
            series : [
                {
                    name: '租房比例',
                    type: 'pie',
                    radius : '55%',
                    center: ['40%', '50%'],
                    data: {!! $data !!},
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>

@endsection