<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Http\Resources\FangAttrResourceCollection;
use App\Http\Resources\FangDetailResource;
use App\Http\Resources\FangResourceCollection;
use App\Model\Fang;
use App\Model\FangAttr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use function foo\func;

class FangController extends BaseController
{
    //推荐房源
    public function recommend()
    {
        $data = Fang::where('is_recommend','1')->select(['id','fang_name','fang_pic'])->orderBy('updated_at','desc')->limit(5)->get();
        return ['status' => 0,'msg'=>'推荐房源获取成功','data'=>$data];
    }


    //获取租赁方式
    public function fangattr()
    {
        $data = FangAttr::select(['id','name','icon','pid','field_name'])->get()->toArray();
        $data = subtree2($data);
        $attr = array_slice($data['fang_rent_class']['son'],0,2);
        $attr2 = array_slice($data['fang_rent_type']['son'],0,2);
        $rent = array_merge($attr,$attr2);

        return ['status' => 0,'msg'=>'租期方式和租赁方式返回成功','data'=>$rent];

    }
    //租房小组
    public function group()
    {
        $where['field_name'] = 'fang_group';
        $pid = FangAttr::where($where)->value('id');
        $group = FangAttr::where('pid',$pid)->orderBy('updated_at','desc')->limit(4)->get(['id','name','icon']);

        return ['status' => 0,'msg'=>'获取小组成功','data'=>new FangAttrResourceCollection($group)];


    }

    //房源列表
    public function list(Request $request)
    {
        if(!empty($request->get('kw'))){
            $this->search($request);
        }

        $data = Fang::orderBy('id','asc')->paginate($this->pagesize);
        return ['status'=>0,'msg'=>'ok','data'=>new FangResourceCollection($data)];
    }

    //获取房源详情
    public function detail(Request $request)
    {
        try{
            $data = $this->validate($request,[
               'id' => 'required|numeric'
            ]);
        }catch (\Exception $e){
            throw new MyValidateException('数据异常',3);
        }

        $data = Fang::where('id',$data['id'])->first();
        $fang_config = explode(',',$data->fang_config);
        $configs = FangAttr::whereIn('id',$fang_config)->get(['name','icon']);
        $data->configs = $configs;

        return ['status' => 0,'msg'=> '房源详情获取成功','data'=>new FangDetailResource($data)];
    }

    //房源属性列表
    public function fangAttrs(Request $request)
    {
        $data = FangAttr::select(['id','name','icon','pid','field_name'])->get()->toArray();
        $data = subtree2($data);

        return ['status' => 0,'msg'=>'房源属性获取成功','data' => $data];

    }

    //根据搜索条件搜索房源
    public function search(Request $request)
    {
        try{
            $data = $this->validate($request,[
                'page' => 'required|numeric',
                'fang_area' => 'numeric',
                'fang_rent_class' => 'numeric',
                'fang_rent_range' => 'numeric',
                'fang_rent_type' => 'numeric'
            ]);
        }catch (\Exception $e){
            throw new MyValidateException('数据异常',3);
        }
        $fang_area = $request->get('fang_area') ;
        $fang_rent_class = $request->get('fang_rent_class');
        $fang_rent_range =$request->get('fang_rent_range');
        $fang_rent_type = $request->get('fang_rent_type');

        $res = Fang::when($fang_area,function($query) use ($fang_area) {
            $query-> where('fang_area',$fang_area);
        })->when($fang_rent_class,function($query) use($fang_rent_class) {
            $query-> where('fang_rent_class',$fang_rent_class);
        })->when($fang_rent_range,function($query) use ($fang_rent_range){
            $query-> where('fang_rent_range',$fang_rent_range);
    })->when($fang_rent_type,function($query) use ($fang_rent_type){
            $query-> where('fang_rent_type',$fang_rent_type);
        })->orderBy('created_at','desc')->paginate($this->pagesize);

        return ['status' => 0,'msg' => '搜索成功','data'=>new FangResourceCollection($res)];



    }

    public function searchkw(Request $request)
    {
        $kw = $request->get('kw');
        if(empty($kw)){
            $data = Fang::orderBy('id','asc')->paginate($this->pagesize);
            return ['status'=>0,'msg'=>'ok','data'=>new FangResourceCollection($data)];
        }
        // 表示kw有数据
        $client = \Elasticsearch\ClientBuilder::create()->setHosts(config('es.hosts'))->build();
        $params = [
            # 索引名称
            'index' => 'fangs',
            # 查询条件
            'body' => [
                'query' => [
                    'match' => [
                        'desn' => [
                            'query' => $kw
                        ]
                    ]
                ]
            ]
        ];
        $ret = $client->search($params);

        #获取查询记录数
        $total = $ret['hits']['total']['value'];
        if($total == 0){
            return ['status' => 6,'msg'=>'没有查询到数据','data'=>[]];
        }
        //获取数组中某列的值
        $ids = array_column($ret['hits']['hits'],'_id');
        $data = Fang::whereIn('id',$ids)->orderBy('id','asc')->paginate($this->pagesize);
        return ['status'=>0,'msg'=>'ok','data'=>new FangResourceCollection($data)];





    }





}
