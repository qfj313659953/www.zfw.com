<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cid')->default(0)->comment('分类ID');
            $table->string('title',200)->comment('文章标题');
            $table->string('author',50)->comment('文章作者');
            $table->string('desn',255)->default('')->comment('文章摘要');
            $table->string('pic',100)->default('')->comment('缩略图');
            $table->text('body')->comment('文章详情');
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
        Schema::dropIfExists('articles');
    }
}
