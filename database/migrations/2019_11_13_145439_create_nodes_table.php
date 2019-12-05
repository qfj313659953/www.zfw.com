<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->comment('权限名称');
            $table->string('route_name',100)->nullable()->default('')->comment('路由名称');
            $table->unsignedInteger('pid')->default(0)->comment('上级ID');
            $table->enum('is_menu',['0','1'])->default('0')->comment('是否为菜单显示');
            $table->timestamps();
            //软删除
            $table->softDeletes();
        });

        Schema::create('role_node',function (Blueprint $table) {
            $table->unsignedInteger('role_id')->default(0)->comment('角色ID');
            $table->unsignedInteger('node_id')->default(0)->comment('权限ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nodes');
        Schema::dropIfExists('role_node');
    }
}
