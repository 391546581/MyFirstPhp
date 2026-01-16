<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP8!';
});

Route::get('hello/:name', 'index/hello');


// 用户管理路由
Route::resource('user', 'User');

// ============================================================
// 学习模块路由
// ============================================================
Route::group('learning', function () {
    Route::get('/', 'Learning/index');
    Route::get('hello/:name', 'Learning/hello');
    Route::get('json', 'Learning/json');
    Route::any('params', 'Learning/params');
    Route::get('validate', 'Learning/validateDemo');
    Route::get('view', 'Learning/view');
    Route::get('request', 'Learning/requestInfo');
});
