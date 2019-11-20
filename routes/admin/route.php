<?php
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    //登录显示
    Route::get('login', 'LoginController@index')->name('login');
    //登录功能
    Route::post('login', 'LoginController@login')->name('login');

    //中间件绑定（检查是否已登录）
    Route::group(['middleware' => 'checklogin'], function () {
        //---后台首页---------------------------
        Route::get('index', 'IndexController@index')->name('index');
        //欢迎页
        Route::get('welcome', 'IndexController@welcome')->name('welcome');
        //退出登录
        Route::get('logout', 'IndexController@logout')->name('logout');
        //文件上传
        Route::post('base/upfile','BaseController@upfile')->name('base.upfile');
        //点击删除图片
        Route::get('base/delpic','BaseController@delpic')->name('base.delpic');

        //---用户管理---------------------------
        //个人信息展示
        Route::get('admin/person', 'AdminController@person')->name('admin.person');
        //个人信息修改
        Route::put('admin/personedit', 'AdminController@personedit')->name('admin.personedit');
        //用户列表
        Route::get('admin/index', 'AdminController@index')->name('admin.index');

        // 添加用户显示
        Route::get('user/create', 'AdminController@create')->name('user.create');
        // 添加用户处理
        Route::post('user/create', 'AdminController@store')->name('user.store');
        // 修改用户显示
        Route::get('user/edit/{id}', 'AdminController@edit')->name('user.edit');
        // 修改用户处理
        Route::put('user/edit/{id}', 'AdminController@update')->name('user.update');
        //删除用户软删除到回收站
        Route::delete('user/del/{id}','AdminController@del')->name('user.del');
        //回收站
        Route::get('user/restore', 'AdminController@restore')->name('user.restore');
        //恢复用户
        Route::get('user/renew','AdminController@renew')->name('user.renew');
        //批量删除
        Route::delete('user/delAll','AdminController@delAll')->name('user.delAll');

        //-角色管理--------------------------------------
        Route::get('role/search','RoleController@search')->name('role.search');
        Route::resource('role','RoleController');
        //-权限管理--------------------------------------
        Route::resource('node','NodeController');
        //-文章管理--------------------------------------


        Route::resource('article','ArticleController');
        //-房源管理--------------------------------------
        //房源属性
        Route::resource('fangAttr','FangAttrController');
        //房东属性
        Route::resource('fangOwner','fangOwnerController');




    });


});
