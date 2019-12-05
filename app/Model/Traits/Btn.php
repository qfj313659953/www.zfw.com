<?php
/**
 * 后台按钮组件
 */

namespace App\Model\Traits;


trait Btn
{
    //判断是否拥有权限
    static private function checkAuth(string $routename)
    {
        //在中间件中得到当前角色持有的权限列表
        $auths = request()->auths ?? [];
        if(!in_array($routename,$auths) && request()->username != 'admin'){
            return false;
        }
        return true;
    }

    #添加按钮组件
    static public function addBtn(string $routename,string $btnname)
    {
        if(self::checkAuth($routename)){
            return '<a href="' .route($routename) .'" class="btn btn-primary radius">
                    <i class="Hui-iconfont">&#xe600;</i> 添加'. $btnname .'
                </a>';
        }
        return '';

    }


    //修改按钮组件
    public function editBtn(string $routename)
    {
        if(self::checkAuth($routename)){
            $arr['start'] = request()->get('start');
            $arr['field'] = request()->get('order')[0]['column'];
            $arr['order'] = request()->get('order')[0]['dir'];
            $params = http_build_query($arr);
            #生成url地址
            $url = route($routename,$this);
            if(stristr($url,'?')){
                $url = $url .'&' . $params;
            }else{
                $url = $url . '?' . $params;
            }
            return ' <a href="'. $url .'" class="label label-secondary radius">修改</a>';
        }
        return '';
    }

    //删除按钮组件
    public function delBtn(string $routename)
    {
        if(self::checkAuth($routename)){
            return '<a href="'.route($routename,$this) .'" class="label label-danger radius deluser">删除</a>';
        }
        return '';
    }

    //查看按钮组件
    public function showBtn(string $routename)
    {
        if(self::checkAuth($routename)){
            return '<a href="'.route($routename,$this) .'" class="label label-success radius showbtn">查看</a>';
        }
        return '';
    }

}
