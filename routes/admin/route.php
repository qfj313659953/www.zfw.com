<?php
Route::group(['namespace'=>'Admin','prefix'=>'admin','as'=>'admin.'],function(){
    //登录显示
    Route::get('login','LoginController@index')->name('login');
    //登录功能
    Route::post('login','LoginController@login')->name('login');
});
