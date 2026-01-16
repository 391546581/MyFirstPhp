<?php
/**
 * ThinkPHP 8.0 学习 - 第6课：模型
 */

/*
============================================================
模型基础
============================================================

1. 创建模型
------------------------------------------------------------

// 命令行创建
php think make:model User

// 或手动创建 app/model/User.php

2. 基本模型定义
------------------------------------------------------------

namespace app\model;

use think\Model;

class User extends Model
{
    // 表名（不含前缀，自动识别）
    protected $table = 'user';

    // 主键
    protected $pk = 'id';

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    // 时间字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    // 定义数据类型转换
    protected $type = [
        'id' => 'integer',
        'status' => 'integer',
        'birthday' => 'datetime',
        'settings' => 'json',
    ];
}

3. 模型 CRUD 操作
------------------------------------------------------------

use app\model\User;

// 创建
$user = User::create([
    'name' => '张三',
    'email' => 'zhangsan@example.com',
    'age' => 25
]);
echo $user->id;  // 获取自增ID

// 查询
$user = User::find(1);  // 根据主键查询
$user = User::where('email', 'zhangsan@example.com')->find();
$users = User::where('status', 1)->select();
$users = User::all();  // 所有记录

// 更新
$user = User::find(1);
$user->name = '新名字';
$user->save();

// 或
User::where('id', 1)->update(['name' => '新名字']);

// 删除
User::destroy(1);  // 根据主键删除
User::destroy([1, 2, 3]);  // 删除多个
$user->delete();  // 删除模型实例

4. 获取器和修改器
------------------------------------------------------------

class User extends Model
{
    // 获取器：读取时自动处理
    public function getStatusTextAttr($value, $data)
    {
        $status = [0 => '禁用', 1 => '正常', 2 => '待审核'];
        return $status[$data['status']] ?? '未知';
    }

    // 修改器：写入时自动处理
    public function setPasswordAttr($value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }
}

// 使用
$user = User::find(1);
echo $user->status_text;  // 自动调用获取器

$user = new User;
$user->password = '123456';  // 自动调用修改器加密

5. 模型关联
------------------------------------------------------------

// 一对一（用户-个人资料）
class User extends Model
{
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }
}

// 使用
$user = User::find(1);
echo $user->profile->avatar;

// 一对多（用户-订单）
class User extends Model
{
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}

// 使用
$user = User::find(1);
foreach ($user->orders as $order) {
    echo $order->order_no;
}

// 反向关联（订单属于用户）
class Order extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

// 多对多（用户-角色）
class User extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'role_id', 'user_id');
    }
}

6. 预载入（解决 N+1 问题）
------------------------------------------------------------

// 不好：N+1 查询
$users = User::select();
foreach ($users as $user) {
    echo $user->profile->avatar;  // 每次循环都查询
}

// 正确：预载入
$users = User::with('profile')->select();
foreach ($users as $user) {
    echo $user->profile->avatar;  // 已经预先加载
}

// 多个关联
User::with(['profile', 'orders'])->select();

7. 软删除
------------------------------------------------------------

use think\model\concern\SoftDelete;

class User extends Model
{
    use SoftDelete;

    protected $deleteTime = 'delete_time';
}

// 使用
User::destroy(1);  // 软删除
User::withTrashed()->find(1);  // 包含软删除
User::onlyTrashed()->select();  // 只查软删除
$user->restore();  // 恢复
$user->force()->delete();  // 真正删除

8. 模型事件
------------------------------------------------------------

class User extends Model
{
    // 新增前
    public static function onBeforeInsert($user)
    {
        $user->created_ip = request()->ip();
    }

    // 新增后
    public static function onAfterInsert($user)
    {
        // 发送欢迎邮件等
    }

    // 更新前
    public static function onBeforeUpdate($user)
    {
        $user->updated_at = date('Y-m-d H:i:s');
    }

    // 删除前
    public static function onBeforeDelete($user)
    {
        // 检查是否可删除
    }
}

============================================================
常见错误
============================================================

1. 模型找不到对应表
   原因：表名不匹配
   解决：设置 protected $table = 'table_name';

2. 关联查询返回空
   原因：外键名不正确
   解决：检查关联方法的外键参数

3. 时间戳格式不对
   原因：数据库字段类型与配置不匹配
   解决：统一使用 datetime 或 int

============================================================
*/

echo "模型说明文件，请查看 app/model 目录\n";
