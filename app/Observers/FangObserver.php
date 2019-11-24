<?php

namespace App\Observers;

use App\Model\Fang;
use GuzzleHttp\Client;

class FangObserver
{
    //添加数据之前转化地址为经纬度
    public function creating(Fang $fang)
    {
        $location = $this->geo();
        $fang->longitude = $location[0];
        $fang->latitude = $location[1];

        $fang->fang_config = implode(',',request()->get('fang_config'));

    }
    //添加数据之后
    public function created(Fang $fang)
    {
        //添加文档
        $hosts = config('es.hosts');
        $client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
        // 写文档
        $params = [
            'index' => 'fangs',
            //es6以下还有一个类型,es7已取消
            //'type' => '_doc',
            'id' => $fang->id,
            'body' => [
                'xiaoqu' => $fang->fang_xiaoqu,
                'desn' => $fang->fang_desn,
            ],
        ];

        $response = $client->index($params);
    }

    //修改数据前
    public function updating(Fang $fang)
    {
        //判断详细地址是否被修改
        if(request()->get('fang_addr2') != request()->get('fang_addr')){
            //如果修改，那么请求更新经纬度,否则不请求
            $location = $this->geo();
            $fang->longitude = $location[0];
            $fang->latitude = $location[1];
        }

        $fang->fang_config = implode(',',request()->get('fang_config'));
    }

    //封闭经纬度转化
    private function geo(){
        //获取第三方接口地址
        $url = sprintf(config('geo.url'),request()->get('fang_addr'));
        //引入Guzzle类发起Get请求
        $client = new Client(['timeout' => 5,'verify'=> false]);
        $response = $client->get($url);
        //获取请求的主体
        $data = $response->getBody();
        $arr = json_decode($data,true)['geocodes'];

        //初始化经度和纬度
        $longitude = $latitude = 0;
        if(count($arr) > 0){
            $location = $arr[0]['location'];
            //解构赋值
            [$longitude,$latitude] = explode(',',$location);
        }
        return [$longitude,$latitude];
    }



}
