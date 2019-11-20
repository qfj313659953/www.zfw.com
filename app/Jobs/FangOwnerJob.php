<?php

namespace App\Jobs;

use Illuminate\Mail\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class FangOwnerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    #添加成员属性
    public $userData;
    /**
     * 初始化属性
     */
    public function __construct(array $data)
    {
        $this->userData = $data;
    }

    /**
     * 执行任务
     */
    public function handle()
    {
        $email = $this->userData['email'];
        $name = $this->userData['name'];

        Mail::raw('您的信息添加成功，稍后我们会有工作人员与您联系！',function(Message $message) use($email,$name) {
            //主题
            $message->subject('信息添加通知邮件');
            //发给哪个邮箱和给谁
            $message->to($email,$name);
        });
    }
}
