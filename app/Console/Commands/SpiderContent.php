<?php

namespace App\Console\Commands;

use App\Model\Article;
use Illuminate\Console\Command;
use QL\QueryList;

class SpiderContent extends Command
{
    //命令
    protected $signature = 'qian:downcnt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collect article contents';

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
        $data = \DB::table('articles')->where('is_down',1)->get(['id','cnt_url'])->toArray();

        QueryList::run('Multi',[
            //待采集链接集合
            'list' => array_column($data,'cnt_url'),
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
            //$cnt是当前页面所有采集到的信息
            'success' => function($cnt){
                //采集规则
                $reg = [
                    //采集文章标题
                    'body' => ['.article-detail','html'],
                ];
                $cnt_url = $cnt['info']['url'];
                $ql = QueryList::Query($cnt['content'],$reg);
                $data = $ql->getData();
                //打印结果，实际操作中这里应该做入数据库操作
                //dump($data);
                //判断是否采集到数据，如果没有数据默认为'',避免报错
                $body = $data[0]['body'] ?? '';
                //采集数据并入库
                \Db::table('articles')->where('cnt_url',$cnt_url)->update(['body'=>$body,'is_down'=>0]);
                echo "ok\n";
        }
        ]);

    }
}
