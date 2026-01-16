<?php
/**
 * ThinkPHP 8.0 进阶 - 第1课：中间件
 */

/*
============================================================
中间件基础
============================================================

1. 创建中间件
------------------------------------------------------------

// 命令行创建
php think make:middleware Auth

// 生成文件 app/middleware/Auth.php

2. 中间件示例
------------------------------------------------------------

namespace app\middleware;

class Auth
{
    public function handle($request, \Closure $next)
    {
        // 前置操作：请求处理之前
        if (!session('user_id')) {
            return redirect('/login');
        }

        // 继续执行下一个中间件/控制器
        $response = $next($request);

        // 后置操作：响应返回之后
        // 可在这里修改响应

        return $response;
    }
}

3. 注册中间件
------------------------------------------------------------

// 全局中间件 app/middleware.php
return [
    \app\middleware\Auth::class,
    \app\middleware\Log::class,
];

// 应用中间件 config/middleware.php
return [
    'alias' => [
        'auth' => \app\middleware\Auth::class,
        'log'  => \app\middleware\Log::class,
    ],
];

4. 使用中间件
------------------------------------------------------------

// 路由中使用
Route::get('admin/:action', 'admin/:action')->middleware('auth');

Route::group('api', function () {
    // 路由定义
})->middleware(['auth', 'log']);

// 控制器中使用
class Admin extends BaseController
{
    protected $middleware = [
        'auth',
        'log' => ['only' => ['index', 'save']],
        'check' => ['except' => ['login']],
    ];
}

5. 传递参数
------------------------------------------------------------

// 定义时接收参数
public function handle($request, \Closure $next, $role = 'user')
{
    // 使用 $role 参数
}

// 使用时传递参数
->middleware('auth:admin')
->middleware('auth', 'admin')

============================================================
常用中间件示例
============================================================

1. 登录验证中间件
------------------------------------------------------------

class Auth
{
    public function handle($request, \Closure $next)
    {
        $userId = session('user_id');
        if (!$userId) {
            if ($request->isAjax()) {
                return json(['code' => 401, 'msg' => '请先登录']);
            }
            return redirect('/login');
        }

        // 将用户信息注入到请求中
        $request->user_id = $userId;

        return $next($request);
    }
}

2. 跨域中间件
------------------------------------------------------------

class Cors
{
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        $response->header([
            'Access-Control-Allow-Origin'  => '*',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
        ]);

        return $response;
    }
}

3. 日志中间件
------------------------------------------------------------

class Log
{
    public function handle($request, \Closure $next)
    {
        $startTime = microtime(true);

        $response = $next($request);

        $endTime = microtime(true);
        $duration = round(($endTime - $startTime) * 1000, 2);

        \think\facade\Log::info('Request', [
            'url' => $request->url(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'duration' => $duration . 'ms',
        ]);

        return $response;
    }
}

4. 权限验证中间件
------------------------------------------------------------

class Permission
{
    public function handle($request, \Closure $next, $permission)
    {
        $userId = session('user_id');
        $hasPermission = $this->checkPermission($userId, $permission);

        if (!$hasPermission) {
            return json(['code' => 403, 'msg' => '没有权限']);
        }

        return $next($request);
    }

    private function checkPermission($userId, $permission)
    {
        // 实际的权限检查逻辑
        return true;
    }
}

// 使用
Route::get('admin/users', 'admin/users')->middleware('permission:user.list');

============================================================
*/

echo "中间件说明文件\n";
