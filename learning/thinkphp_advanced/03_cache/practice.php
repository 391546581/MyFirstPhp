<?php
/**
 * ThinkPHP 8.0 进阶 - 第3课：缓存
 */

/*
============================================================
缓存配置 (config/cache.php)
============================================================

return [
    // 默认驱动
    'default' => 'file',

    // 缓存存储配置
    'stores' => [
        // 文件缓存
        'file' => [
            'type' => 'file',
            'path' => runtime_path('cache'),
            'prefix' => '',
            'expire' => 0,  // 永不过期
        ],

        // Redis缓存
        'redis' => [
            'type' => 'redis',
            'host' => '127.0.0.1',
            'port' => 6379,
            'password' => '',
            'select' => 0,
            'prefix' => 'cache:',
        ],
    ],
];

============================================================
缓存操作
============================================================

use think\facade\Cache;

1. 基本操作
------------------------------------------------------------

// 设置缓存
Cache::set('name', '张三');

// 设置带过期时间（秒）
Cache::set('name', '张三', 3600);

// 获取缓存
$value = Cache::get('name');
$value = Cache::get('name', '默认值');

// 删除缓存
Cache::delete('name');

// 清空缓存
Cache::clear();

// 检查是否存在
if (Cache::has('name')) {
    // ...
}

// 自增
Cache::inc('count');
Cache::inc('count', 5);

// 自减
Cache::dec('count');
Cache::dec('count', 3);

2. 获取并存储（常用）
------------------------------------------------------------

// 如果缓存不存在，则执行闭包并缓存结果
$users = Cache::remember('user_list', function () {
    return User::where('status', 1)->select();
}, 3600);

3. 标签缓存
------------------------------------------------------------

// 设置标签缓存
Cache::tag('user')->set('user_1', $user1);
Cache::tag('user')->set('user_2', $user2);
Cache::tag(['user', 'admin'])->set('admin_list', $admins);

// 清除标签下所有缓存
Cache::tag('user')->clear();

4. 切换缓存驱动
------------------------------------------------------------

// 使用Redis
Cache::store('redis')->set('name', '张三');

// 获取
$value = Cache::store('redis')->get('name');

5. 助手函数
------------------------------------------------------------

cache('name');                      // 获取
cache('name', '张三');              // 设置
cache('name', '张三', 3600);        // 带过期时间
cache('name', null);                // 删除

============================================================
缓存应用示例
============================================================

1. 缓存数据库查询
------------------------------------------------------------

class UserService
{
    public function getUserById($id)
    {
        $cacheKey = 'user:' . $id;

        return Cache::remember($cacheKey, function () use ($id) {
            return User::find($id);
        }, 3600);
    }

    public function updateUser($id, $data)
    {
        $user = User::find($id);
        $user->save($data);

        // 更新后清除缓存
        Cache::delete('user:' . $id);

        return $user;
    }
}

2. 缓存分页列表
------------------------------------------------------------

public function userList($page = 1, $pageSize = 10)
{
    $cacheKey = "user_list:{$page}:{$pageSize}";

    return Cache::remember($cacheKey, function () use ($page, $pageSize) {
        return User::where('status', 1)
            ->page($page, $pageSize)
            ->select();
    }, 300);  // 缓存5分钟
}

3. 缓存配置数据
------------------------------------------------------------

public function getConfig($key)
{
    return Cache::remember('config:' . $key, function () use ($key) {
        return Config::where('key', $key)->value('value');
    }, 86400);  // 缓存1天
}

4. 计数器（限流）
------------------------------------------------------------

public function rateLimit($ip, $limit = 60)
{
    $key = 'rate_limit:' . $ip;
    $count = Cache::get($key, 0);

    if ($count >= $limit) {
        return false;  // 超过限制
    }

    if ($count === 0) {
        Cache::set($key, 1, 60);  // 1分钟过期
    } else {
        Cache::inc($key);
    }

    return true;
}

5. 缓存锁（防止并发）
------------------------------------------------------------

public function processOrder($orderId)
{
    $lockKey = 'lock:order:' . $orderId;

    // 尝试获取锁
    if (Cache::has($lockKey)) {
        throw new \Exception('订单正在处理中');
    }

    try {
        // 设置锁，30秒自动过期
        Cache::set($lockKey, 1, 30);

        // 处理业务...

    } finally {
        // 释放锁
        Cache::delete($lockKey);
    }
}

============================================================
缓存策略建议
============================================================

1. 合理设置过期时间
   - 热点数据：较短时间（5-15分钟）
   - 配置数据：较长时间（1天）
   - 统计数据：根据更新频率决定

2. 缓存键命名规范
   - 使用冒号分隔：user:1:profile
   - 包含版本号：v1:user:1

3. 避免缓存击穿
   - 使用 remember 方法
   - 热点数据永不过期 + 异步更新

4. 避免缓存雪崩
   - 过期时间加随机值
   - 多级缓存

============================================================
*/

echo "缓存说明文件\n";
