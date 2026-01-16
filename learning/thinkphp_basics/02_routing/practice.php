<?php
/**
 * ThinkPHP 8.0 学习 - 第2课：路由
 * 
 * 本文件用于说明路由配置方式
 * 实际路由定义在 route/app.php 中
 */

/*
============================================================
ThinkPHP 8.0 路由系统
============================================================

1. 路由定义位置
   - route/app.php（主路由文件）
   - route/xxx.php（可创建多个路由文件）

2. 基础路由规则
------------------------------------------------------------

// GET 请求
Route::get('hello/:name', 'index/hello');

// POST 请求
Route::post('user/add', 'user/add');

// 任意请求方式
Route::any('test', 'index/test');

// 指定多个请求方式
Route::rule('search', 'index/search', 'GET|POST');

3. 路由参数
------------------------------------------------------------

// 必选参数
Route::get('user/:id', 'user/read');

// 可选参数
Route::get('blog/:year/[:month]', 'blog/archive');

// 参数约束（正则）
Route::get('user/:id', 'user/read')->pattern(['id' => '\d+']);

// 全局参数规则（在 route.php 配置）

4. 路由分组
------------------------------------------------------------

Route::group('api', function () {
    Route::get('users', 'api.User/index');
    Route::get('users/:id', 'api.User/read');
    Route::post('users', 'api.User/save');
})->prefix('api/');

5. 资源路由（RESTful API）
------------------------------------------------------------

Route::resource('articles', 'ArticleController');

// 自动生成以下路由：
// GET    /articles          -> index  列表
// GET    /articles/create   -> create 创建页面
// POST   /articles          -> save   保存
// GET    /articles/:id      -> read   读取
// GET    /articles/:id/edit -> edit   编辑页面
// PUT    /articles/:id      -> update 更新
// DELETE /articles/:id      -> delete 删除

6. 路由中间件
------------------------------------------------------------

Route::get('admin/:action', 'admin/:action')
    ->middleware('auth');

Route::group('api', function () {
    // 路由定义
})->middleware(['auth', 'log']);

7. 路由别名
------------------------------------------------------------

Route::get('user/:id', 'user/read')->name('user.read');

// 在代码中生成URL
url('user.read', ['id' => 1]);  // 返回 /user/1

8. 常见错误
------------------------------------------------------------

错误 1：路由未定义
原因：route/app.php 中没有定义对应路由
解决：添加路由规则，或关闭强制路由

错误 2：控制器不存在
原因：路由指向的控制器类不存在
解决：检查控制器文件名和类名

错误 3：方法不存在
原因：控制器中没有对应的方法
解决：在控制器中添加对应方法

9. 配置说明（config/route.php）
------------------------------------------------------------

return [
    // 是否强制使用路由（false 表示可以用路径访问控制器）
    'url_route_must' => false,

    // URL后缀（如 .html）
    'url_html_suffix' => 'html',

    // 路由参数默认规则
    'default_route_pattern' => '[\w\.]+',
];

============================================================
*/

echo "本文件为路由学习说明，请查看 route/app.php 实际使用\n";
echo "运行 php think route:list 可查看所有路由\n";
