<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFangOwnersTable extends Migration
{
    /**
     *房东表
     */
    public function up()
    {
        Schema::create('fang_owners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->comment('房东姓名');
            $table->enum('sex',['先生','女士'])->default('先生')->comment('性别');
            $table->unsignedInteger('age')->default(18)->comment('年龄');
            $table->char('phone',15)->comment('手机号码');
            $table->string('card',20)->comment('身份证号码');
            $table->string('address',100)->comment('家庭住址');
            $table->string('pic',500)->comment('身份证照片');
            $table->string('email',50)->default('')->comment('邮箱');
            $table->timestamps();
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
        Schema::dropIfExists('fang_owners');
    }
}
