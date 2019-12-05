<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Model\Notice;
use App\Model\Renting;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use QL\QueryList;
use App\Http\Controllers\Controller;

class NoticeController extends BaseController
{
    private $i = 1;
    //看房通知列表
    public function index(Request $request)
    {
        try{
            $data = $this->validate($request,[
               'openid' => 'required'
            ]);
        }catch(\Exception $e){
            throw new MyValidateException('数据异常',3);
        }
        //获取租客id
        $id = Renting::where('openid',$data['openid'])->value('id');

        $res = Notice::where('renting_id',$id)->with('fangowner:id,name,phone,address,sex')->orderBy('updated_at','desc')->paginate($this->pagesize);

        return ['status' => 0,'msg' => '看房通知列表','data'=>$res];
    }

    //spider
    public function sipder()
    {
        /*// 待采集的页面地址
        $url = 'https://news.ke.com/bj/baike/0675578.html';

        // 采集规则
        $rules = [
            // 文章标题
            'title' => ['.hd h1.title','text'],
            // 发布日期
            'date' => ['.time','text'],
            // 文章内容
            'content' => ['.bd','html']
        ];

        $data = QueryList::Query($url,$rules)->data;*/
        QueryList::run('Multi',[
            //待采集链接集合
            'list' => [
                'https://news.ke.com/bj/baike/0777/',
                'https://news.ke.com/bj/baike/0777/pg2/',
                'https://news.ke.com/bj/baike/0777/pg3/',
                'https://news.ke.com/bj/baike/0777/pg4/',
                'https://news.ke.com/bj/baike/0777/pg5/',
            ],
            'curl' => [
                'opt' => array(
                    //这里根据自身需求设置curl参数
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_AUTOREFERER => true,
                    //........
                ),
                //设置线程数
                'maxThread' => 100,
                //设置最大尝试数
                'maxTry' => 3
            ],
            'success' => function($a){
                //采集规则
                $reg = [
                    //采集文章标题
                    'title' => ['.item .tit','text'],
                    'desn' => ['.summary','text'],
                    'pic' => ['.item a.img img','data-original']

                ];

                $ql = QueryList::Query($a['content'],$reg);
                $data = $ql->getData();
                //打印结果，实际操作中这里应该做入数据库操作
                //dump($data);
            }
        ]);
            /*$data = QueryList::Query('http://desk.zol.com.cn/dongman/',[
                'pic' => ['.photo-list-padding a.pic img','src','',function($item){
                    //获取图片的后缀名
                    $exten = pathinfo($item)['extension'];
                    $filename = $this->i .'.'.$exten;
                    $this->i = ++$this->i;
                    //dump($filename);
                    //保存到本地路径和文件名称
                    $filepath = public_path('img/'.$filename);
                    $client = new Client(['timeout'=>5,'verify'=>false]);
                    $response = $client->get($item);
                    //写入本地
                    file_put_contents($filepath,$response->getBody());
                    return '/img/'.$filename;
                }]
            ])->data;


        dump($data);*/
        //多线程扩展

    }






}
