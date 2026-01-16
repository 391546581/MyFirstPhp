<?php
/**
 * ThinkPHP 8.0 学习 - 第5课：数据库操作
 */

/*
============================================================
数据库配置 (config/database.php)
============================================================

1. 基本配置
------------------------------------------------------------

return [
    'default' => 'mysql',
    'connections' => [
        'mysql' => [
            'type'     => 'mysql',
            'hostname' => '127.0.0.1',
            'database' => 'test',
            'username' => 'root',
            'password' => '',
            'hostport' => '3306',
            'charset'  => 'utf8mb4',
            'prefix'   => 'tp_',
        ],
    ],
];

2. 使用 .env 环境变量（推荐）
------------------------------------------------------------

// .env 文件
DATABASE_TYPE=mysql
DATABASE_HOSTNAME=127.0.0.1
DATABASE_DATABASE=test
DATABASE_USERNAME=root
DATABASE_PASSWORD=
DATABASE_HOSTPORT=3306
DATABASE_PREFIX=tp_

============================================================
Db 查询构建器
============================================================

use think\facade\Db;

1. 插入数据
------------------------------------------------------------

// 单条插入
Db::table('tp_user')->insert([
    'name' => '张三',
    'email' => 'zhangsan@example.com',
    'age' => 25
]);

// 获取自增ID
$id = Db::table('tp_user')->insertGetId([
    'name' => '李四',
    'email' => 'lisi@example.com'
]);

// 批量插入
Db::table('tp_user')->insertAll([
    ['name' => '用户1', 'email' => 'user1@example.com'],
    ['name' => '用户2', 'email' => 'user2@example.com'],
]);

2. 查询数据
------------------------------------------------------------

// 查询所有
$users = Db::table('tp_user')->select();

// 带条件查询
$users = Db::table('tp_user')
    ->where('status', 1)
    ->where('age', '>=', 18)
    ->order('id', 'desc')
    ->limit(10)
    ->select();

// 查询单条
$user = Db::table('tp_user')->where('id', 1)->find();

// 查询指定字段
$users = Db::table('tp_user')
    ->field('id, name, email')
    ->select();

// 使用 name 方法（自动加表前缀）
$users = Db::name('user')->select();  // 等于 Db::table('tp_user')

3. 条件查询
------------------------------------------------------------

// 等于
->where('status', 1)

// 比较
->where('age', '>', 18)
->where('age', '>=', 18)
->where('age', '<>', 0)

// LIKE
->where('name', 'like', '%张%')

// IN
->where('id', 'in', [1, 2, 3])
->whereIn('id', [1, 2, 3])

// BETWEEN
->where('age', 'between', [18, 60])
->whereBetween('age', [18, 60])

// NULL
->whereNull('deleted_at')
->whereNotNull('email')

// 多条件（AND）
->where('status', 1)->where('age', '>', 18)

// 多条件（OR）
->where('status', 1)->whereOr('age', '>', 50)

// 数组条件
->where([
    ['status', '=', 1],
    ['age', '>=', 18],
])

// 原生表达式
->whereRaw('age > :age', ['age' => 18])

4. 更新数据
------------------------------------------------------------

// 更新
Db::name('user')
    ->where('id', 1)
    ->update(['name' => '新名字', 'age' => 26]);

// 自增
Db::name('user')->where('id', 1)->inc('score', 10);

// 自减
Db::name('user')->where('id', 1)->dec('score', 5);

5. 删除数据
------------------------------------------------------------

// 删除
Db::name('user')->where('id', 1)->delete();

// 清空表（谨慎！）
// Db::name('user')->delete(true);

6. 聚合查询
------------------------------------------------------------

Db::name('user')->count();           // 统计数量
Db::name('user')->max('age');        // 最大值
Db::name('user')->min('age');        // 最小值
Db::name('user')->avg('age');        // 平均值
Db::name('user')->sum('score');      // 求和

7. 分组与排序
------------------------------------------------------------

// 排序
->order('id', 'desc')
->order(['create_time' => 'desc', 'id' => 'asc'])

// 分组
->group('status')
->having('count(id) > 10')

// 分页
->page(1, 10)  // 第1页，每页10条
->paginate(10) // 返回分页器对象

8. 关联查询（JOIN）
------------------------------------------------------------

Db::name('user')
    ->alias('u')
    ->join('order o', 'u.id = o.user_id')
    ->field('u.name, o.order_no, o.amount')
    ->select();

// LEFT JOIN
->leftJoin('order o', 'u.id = o.user_id')

// RIGHT JOIN
->rightJoin('order o', 'u.id = o.user_id')

9. 事务处理
------------------------------------------------------------

// 自动事务
Db::transaction(function () {
    Db::name('user')->where('id', 1)->update(['balance' => Db::raw('balance - 100')]);
    Db::name('order')->insert(['user_id' => 1, 'amount' => 100]);
});

// 手动事务
Db::startTrans();
try {
    Db::name('user')->where('id', 1)->update(['balance' => Db::raw('balance - 100')]);
    Db::name('order')->insert(['user_id' => 1, 'amount' => 100]);
    Db::commit();
} catch (\Exception $e) {
    Db::rollback();
    throw $e;
}

============================================================
常见错误
============================================================

1. SQLSTATE[HY000]: No such database
   原因：数据库不存在
   解决：创建数据库或检查配置

2. Access denied
   原因：数据库用户名或密码错误
   解决：检查 .env 配置

3. table not found
   原因：表名错误或表前缀配置有误
   解决：检查表名和 prefix 配置

4. 中文乱码
   原因：字符集不统一
   解决：使用 utf8mb4 字符集

============================================================
*/

echo "数据库操作说明文件\n";
echo "请先配置 config/database.php 或 .env\n";
