<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //生成后台用户数据
       // $this->call(AdminSeeder::class);
        //$this->call(CateSeeder::class);
        $this->call(ArticleSeeder::class);
    }
}
