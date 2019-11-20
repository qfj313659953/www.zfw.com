<?php


namespace App\Model\Services;

use Illuminate\Http\Request;
use App\Model\Article;
use App\Model\Cate;

class ArticleService
{

    //用户列表搜索业务
    public function getList(Request $request,int $pagesize = 10)
    {

            //偏移量
            $offset = $request->get('start',0);
            //每页记录数
            $limit = $request->get('length',$pagesize);

            //排序
            $order = $request->get('order')[0];
            //排序类型
            $orderType = $order['dir'];
            //获取默认排序的字段下标
            $index = $order['column'];
            //获取字段名
            $field = $request->get('columns')[$index]['data'];
            #关联关系字段映射
            $field = $field != 'cates.cname' ? $field : 'cid';
            #搜索
            $kw = $request->get('kw');
            $st = $request->get('st');
            $et = $request->get('et');

            //查询条件
            $builder = Article::when($kw,function($query) use ($kw) {
                $query->where('title','like',"%$kw%");
            })->when($st,function($query) use ($st,$et) {
                $st = date('Y-m-d 00:00:00',strtotime($st));
                $et = date('Y-m-d 00:00:00',strtotime($et));
                $query->whereBetween('created_at',[$st,$et]);
            });

            //总记录数
            $count = $builder->count();

            //查询数据
            $data = $builder->with('cates')->orderBy($field,$orderType)->offset($offset)->limit($limit)->get();

            //按datatables的要求返回数据
            return [
                'draw' => $request->get('draw'),
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $data
            ];

        }





}
