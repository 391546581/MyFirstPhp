<?php
/**
 * ThinkPHP 8.0 进阶 - 第2课：Session与Cookie
 */

/*
============================================================
Session 会话
============================================================

1. 配置 (config/session.php)
------------------------------------------------------------

return [
    // 驱动方式
    'type' => 'file',

    // Session 存储路径
    'path' => runtime_path('session'),

    // Session 有效期（秒）
    'expire' => 1440,

    // Session 名称
    'name' => 'PHPSESSID',

    // Session 前缀
    'prefix' => '',

    // 是否自动开启
    'auto_start' => true,
];

2. Session 操作
------------------------------------------------------------

use think\facade\Session;

// 设置Session
Session::set('name', '张三');
Session::set('user', ['id' => 1, 'name' => '张三']);

// 获取Session
$name = Session::get('name');
$name = Session::get('name', '默认值');

// 获取所有
$all = Session::all();

// 删除Session
Session::delete('name');

// 清空Session
Session::clear();

// 检查是否存在
if (Session::has('name')) {
    // ...
}

// 一次性数据（获取后自动删除）
Session::flash('message', '操作成功');
$message = Session::pull('message');

// 助手函数
session('name');                    // 获取
session('name', '张三');            // 设置
session('name', null);              // 删除
session(['name' => '张三']);        // 批量设置
session(null);                      // 清空

3. Session 二级数组
------------------------------------------------------------

Session::set('user.name', '张三');
Session::set('user.age', 25);

$userName = Session::get('user.name');

4. 登录示例
------------------------------------------------------------

// 登录
public function login()
{
    $user = User::where('email', $email)->find();
    if ($user && password_verify($password, $user->password)) {
        Session::set('user_id', $user->id);
        Session::set('user_name', $user->name);
        return json(['code' => 0, 'msg' => '登录成功']);
    }
    return json(['code' => 1, 'msg' => '账号或密码错误']);
}

// 登出
public function logout()
{
    Session::clear();
    return redirect('/login');
}

// 获取当前用户
public function getCurrentUser()
{
    $userId = Session::get('user_id');
    return User::find($userId);
}

============================================================
Cookie
============================================================

1. 配置 (config/cookie.php)
------------------------------------------------------------

return [
    // 有效期（秒），0表示浏览器关闭时过期
    'expire' => 0,

    // 路径
    'path' => '/',

    // 域名
    'domain' => '',

    // 仅HTTPS
    'secure' => false,

    // 仅HTTP访问（JavaScript不可访问）
    'httponly' => true,

    // SameSite属性
    'samesite' => 'Lax',
];

2. Cookie 操作
------------------------------------------------------------

use think\facade\Cookie;

// 设置Cookie
Cookie::set('name', '张三');

// 设置带过期时间（秒）
Cookie::set('name', '张三', 3600);

// 设置带选项
Cookie::set('token', 'xxx', [
    'expire' => 3600,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
]);

// 获取Cookie
$name = Cookie::get('name');
$name = Cookie::get('name', '默认值');

// 删除Cookie
Cookie::delete('name');

// 检查是否存在
if (Cookie::has('name')) {
    // ...
}

// 助手函数
cookie('name');              // 获取
cookie('name', '张三');      // 设置
cookie('name', null);        // 删除
cookie('name', '张三', 3600);// 带过期时间

3. Remember Me 示例
------------------------------------------------------------

// 登录时
public function login()
{
    // 验证用户...

    if ($rememberMe) {
        $token = bin2hex(random_bytes(32));
        Cookie::set('remember_token', $token, 86400 * 30); // 30天

        // 存储token到数据库
        User::where('id', $userId)->update(['remember_token' => $token]);
    }

    Session::set('user_id', $userId);
}

// 自动登录中间件
public function handle($request, \Closure $next)
{
    if (!Session::has('user_id')) {
        $token = Cookie::get('remember_token');
        if ($token) {
            $user = User::where('remember_token', $token)->find();
            if ($user) {
                Session::set('user_id', $user->id);
            }
        }
    }

    return $next($request);
}

============================================================
安全注意事项
============================================================

1. Session 安全
   - 登录后重新生成Session ID
   - 设置合理的过期时间
   - 不要在Session中存储敏感信息

2. Cookie 安全
   - 设置 httponly = true 防止XSS
   - 敏感数据使用 secure = true
   - 不要在Cookie中存储密码

============================================================
*/

echo "Session与Cookie说明文件\n";
