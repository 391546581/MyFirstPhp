<?php
declare(strict_types=1);

namespace app\model;

use think\Model;

/**
 * 学习示例模型 - 用户模型
 * 
 * 对应数据表：user（会自动加上配置的表前缀）
 * 
 * 创建表SQL：
 * CREATE TABLE `user` (
 *   `id` int NOT NULL AUTO_INCREMENT,
 *   `name` varchar(50) NOT NULL COMMENT '用户名',
 *   `email` varchar(100) NOT NULL COMMENT '邮箱',
 *   `password` varchar(255) NOT NULL COMMENT '密码',
 *   `phone` varchar(20) DEFAULT NULL COMMENT '手机号',
 *   `avatar` varchar(255) DEFAULT NULL COMMENT '头像',
 *   `status` tinyint NOT NULL DEFAULT '1' COMMENT '状态 0禁用 1正常',
 *   `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
 *   `settings` json DEFAULT NULL COMMENT '设置',
 *   `last_login_at` datetime DEFAULT NULL COMMENT '最后登录时间',
 *   `create_time` datetime NOT NULL COMMENT '创建时间',
 *   `update_time` datetime DEFAULT NULL COMMENT '更新时间',
 *   `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
 *   PRIMARY KEY (`id`),
 *   UNIQUE KEY `email` (`email`),
 *   KEY `status` (`status`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表';
 */
class UserExample extends Model
{
    /**
     * 数据表名（不含前缀）
     * 如果类名与表名一致，可以不设置
     */
    protected $table = 'user';

    /**
     * 主键名
     * 默认为 id，如果不同需要设置
     */
    protected $pk = 'id';

    /**
     * 自动写入时间戳
     * 可以是 true/false 或 'datetime'/'timestamp'/'int'
     */
    protected $autoWriteTimestamp = 'datetime';

    /**
     * 创建时间字段名
     */
    protected $createTime = 'create_time';

    /**
     * 更新时间字段名
     */
    protected $updateTime = 'update_time';

    /**
     * 数据类型转换
     * 读取时自动转换，写入时自动反转
     */
    protected $type = [
        'id' => 'integer',
        'status' => 'integer',
        'balance' => 'float',
        'settings' => 'json',
        'last_login_at' => 'datetime',
    ];

    /**
     * 只读字段（创建后不能修改）
     */
    protected $readonly = ['email'];

    /**
     * 允许写入的字段
     * 防止恶意批量赋值
     */
    protected $field = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'status',
        'balance',
        'settings',
        'last_login_at'
    ];

    // ================================================================
    // 获取器 - 读取时自动处理
    // ================================================================

    /**
     * 获取状态文本
     * 
     * 使用：$user->status_text
     */
    public function getStatusTextAttr($value, $data): string
    {
        $status = [
            0 => '禁用',
            1 => '正常',
            2 => '待审核',
        ];
        return $status[$data['status']] ?? '未知';
    }

    /**
     * 获取头像（默认值处理）
     */
    public function getAvatarAttr($value): string
    {
        return $value ?: '/static/images/default-avatar.png';
    }

    /**
     * 格式化余额
     */
    public function getBalanceTextAttr($value, $data): string
    {
        return '¥' . number_format($data['balance'], 2);
    }

    // ================================================================
    // 修改器 - 写入时自动处理
    // ================================================================

    /**
     * 密码加密
     * 
     * 使用：$user->password = '123456'; // 自动加密
     */
    public function setPasswordAttr($value): string
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }

    /**
     * 处理手机号
     */
    public function setPhoneAttr($value): string
    {
        // 去除空格
        return preg_replace('/\s+/', '', $value);
    }

    // ================================================================
    // 搜索器 - 简化查询
    // ================================================================

    /**
     * 状态搜索器
     * 
     * 使用：User::withSearch(['status'], ['status' => 1])->select();
     */
    public function searchStatusAttr($query, $value)
    {
        if ($value !== '') {
            $query->where('status', $value);
        }
    }

    /**
     * 关键词搜索器
     */
    public function searchKeywordAttr($query, $value)
    {
        if ($value !== '') {
            $query->where('name|email|phone', 'like', "%{$value}%");
        }
    }

    /**
     * 时间范围搜索器
     */
    public function searchCreateTimeAttr($query, $value)
    {
        if (!empty($value[0]) && !empty($value[1])) {
            $query->whereBetweenTime('create_time', $value[0], $value[1]);
        }
    }

    // ================================================================
    // 模型关联
    // ================================================================

    /**
     * 一对一：用户资料
     */
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    /**
     * 一对多：用户订单
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * 多对多：用户角色
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'role_id', 'user_id');
    }

    // ================================================================
    // 模型事件
    // ================================================================

    /**
     * 新增前
     */
    public static function onBeforeInsert($user)
    {
        // 设置默认头像
        if (empty($user->avatar)) {
            $user->avatar = '/static/images/default-avatar.png';
        }
    }

    /**
     * 新增后
     */
    public static function onAfterInsert($user)
    {
        // 创建用户资料
        // Profile::create(['user_id' => $user->id]);

        // 记录日志
        // Log::info('新用户注册', ['user_id' => $user->id]);
    }

    // ================================================================
    // 自定义方法
    // ================================================================

    /**
     * 验证密码
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    /**
     * 更新最后登录时间
     */
    public function updateLastLogin(): bool
    {
        $this->last_login_at = date('Y-m-d H:i:s');
        return $this->save();
    }

    /**
     * 修改余额
     */
    public function changeBalance(float $amount, string $reason = ''): bool
    {
        if ($this->balance + $amount < 0) {
            return false;
        }

        $this->balance = $this->balance + $amount;
        return $this->save();
    }

    // ================================================================
    // 静态查询方法
    // ================================================================

    /**
     * 查询正常用户
     */
    public static function normal()
    {
        return static::where('status', 1);
    }

    /**
     * 根据邮箱查找用户
     */
    public static function findByEmail(string $email): ?static
    {
        return static::where('email', $email)->find();
    }
}

/*
============================================================
使用示例
============================================================

// 创建用户
$user = UserExample::create([
    'name' => '张三',
    'email' => 'zhangsan@example.com',
    'password' => '123456',  // 自动加密
]);

// 查询用户
$user = UserExample::find(1);
echo $user->status_text;  // 自动调用获取器

// 使用搜索器
$users = UserExample::withSearch(['status', 'keyword'], [
    'status' => 1,
    'keyword' => '张三',
])->select();

// 关联查询
$user = UserExample::with(['profile', 'orders'])->find(1);

// 静态方法
$users = UserExample::normal()->limit(10)->select();

============================================================
*/
