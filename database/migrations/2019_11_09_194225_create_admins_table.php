<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',50)->unique()->comment('用户名');
            $table->string('truename',50)->default('未知')->comment('真实姓名');
            $table->string('password',255)->comment('密码');
            $table->string('email',50)->nullable()->comment('邮箱');
            $table->string('phone',15)->default('')->comment('手机号码');
            $table->enum('sex',['先生','女士'])->default('女士')->comment('性别');
            $table->char('last_ip',15)->default('')->comment('登录ip');
            $table->timestamps();
            //软删除
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
