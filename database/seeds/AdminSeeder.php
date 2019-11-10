<?php

use Illuminate\Database\Seeder;
use App\Model\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //清空原有数据
        Admin::truncate();
        //调用factory数据工厂，生成数据
        factory(Admin::class,20)->create();
        //修改某行记录的用户名为admin
        Admin::where('id',8)->update(['username'=>'admin']);
    }
}
