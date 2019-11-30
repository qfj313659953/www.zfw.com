<?php

namespace App\Console\Commands;

use App\Model\Article;
use Illuminate\Console\Command;
use QL\QueryList;

class Spider extends Command
{
    //自定义命令
    protected $signature = 'qian:spider';

    //命令的注释
    protected $description = '抓取网页数据';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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
                    'pic' => ['.item a.img img','data-original'],
                    'cnt_url' => ['.item .text a.tit','href']
                ];

                $ql = QueryList::Query($a['content'],$reg);
                $data = $ql->getData();
                //打印结果，实际操作中这里应该做入数据库操作
               foreach($data as $item){
                   $item['cid'] = 2;
                   $item['author'] = 'admin';
                   $item['is_down'] = 1;
                   $item['body'] = '';
                   Article::create($item);
               }
            }
        ]);
    }
}
