<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::group(['prefix'=>'admin','namespace'=>'Admin'],function (){


//后台登录路由
    Route::get('login','LoginController@login');



//登录验证码
    Route::get('code', "LoginController@code");


//处理后台登录的路由
    Route::post('doLogin','LoginController@doLogin');


//加密算法
    Route::get('jiami','LoginController@jiami');
});





//             命名前缀              命名空间              中间件
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'isLogin'],function (){//前面是条件，后面是背包

    //后台登录路由
    Route::get('index','LoginController@index');


//后台欢迎页
    Route::get('welcome','LoginController@welcome');


//后台退出登录路由
    Route::get('logout','LoginController@logout');


    //后台用户模块路由
    Route::get('user/del','UserController@delAll');
    Route::resource('user','UserController');//资源路由
//    资源路由写法是固定的
//    输入代码 php artisan route:list  可以查看
//        后期根据路由就能找到相关执行的方法









});





