<?php
/**
 * ThinkPHP 8.0 学习 - 第8课：数据验证
 */

/*
============================================================
验证器基础
============================================================

1. 创建验证器
------------------------------------------------------------

// 命令行创建
php think make:validate User

// 生成文件 app/validate/User.php

2. 验证器定义
------------------------------------------------------------

namespace app\validate;

use think\Validate;

class User extends Validate
{
    // 验证规则
    protected $rule = [
        'name'  => 'require|max:25',
        'email' => 'require|email|unique:user',
        'age'   => 'require|number|between:1,120',
        'phone' => 'require|mobile',
    ];

    // 错误消息
    protected $message = [
        'name.require' => '姓名不能为空',
        'name.max'     => '姓名最多25个字符',
        'email.require' => '邮箱不能为空',
        'email.email'   => '邮箱格式不正确',
        'email.unique'  => '邮箱已存在',
        'age.require'   => '年龄不能为空',
        'age.number'    => '年龄必须是数字',
        'age.between'   => '年龄必须在1-120之间',
        'phone.require' => '手机号不能为空',
        'phone.mobile'  => '手机号格式不正确',
    ];

    // 验证场景
    protected $scene = [
        'add'  => ['name', 'email', 'age', 'phone'],
        'edit' => ['name', 'age'],
        'login' => ['email', 'password'],
    ];
}

3. 使用验证器
------------------------------------------------------------

use app\validate\User as UserValidate;

// 方式1：使用 validate 实例
$validate = new UserValidate();
if (!$validate->check($data)) {
    return json(['code' => 1, 'msg' => $validate->getError()]);
}

// 方式2：使用场景验证
$validate = new UserValidate();
if (!$validate->scene('add')->check($data)) {
    return json(['code' => 1, 'msg' => $validate->getError()]);
}

// 方式3：控制器中使用（推荐）
try {
    $this->validate($data, UserValidate::class);
} catch (\think\exception\ValidateException $e) {
    return json(['code' => 1, 'msg' => $e->getMessage()]);
}

// 方式4：使用场景
try {
    $this->validate($data, UserValidate::class . '.add');
} catch (\think\exception\ValidateException $e) {
    return json(['code' => 1, 'msg' => $e->getMessage()]);
}

============================================================
常用验证规则
============================================================

1. 必填与格式
------------------------------------------------------------

'require'          // 必填
'number'          // 纯数字
'integer'         // 整数
'float'           // 浮点数
'alpha'           // 纯字母
'alphaNum'        // 字母和数字
'alphaDash'       // 字母、数字、下划线、破折号

2. 长度验证
------------------------------------------------------------

'max:25'          // 最大长度25
'min:6'           // 最小长度6
'length:4,25'     // 长度4-25
'length:6'        // 固定长度6

3. 范围验证
------------------------------------------------------------

'in:1,2,3'        // 在给定值列表中
'notIn:0,1'       // 不在给定值列表中
'between:1,100'   // 在范围内
'notBetween:1,10' // 不在范围内

4. 比较验证
------------------------------------------------------------

'eq:100'          // 等于100
'gt:0'            // 大于0
'gte:0'           // 大于等于0
'lt:100'          // 小于100
'lte:100'         // 小于等于100
'confirm:password' // 与另一字段相同

5. 格式验证
------------------------------------------------------------

'email'           // 邮箱格式
'mobile'          // 手机号格式
'url'             // URL格式
'ip'              // IP地址
'date'            // 日期格式
'dateFormat:Y-m-d' // 指定日期格式

6. 正则验证
------------------------------------------------------------

'regex:/^[a-zA-Z]+$/'  // 自定义正则

7. 数据库验证
------------------------------------------------------------

'unique:user'          // user表中唯一
'unique:user,email'    // 指定字段唯一
'unique:user,email,1'  // 排除ID=1的记录

'exists:user,id'       // 必须存在于user表

8. 文件验证
------------------------------------------------------------

'file'                 // 必须是文件
'image'               // 必须是图片
'image:jpg,png'       // 指定图片格式
'fileExt:jpg,png'     // 文件扩展名
'fileMime:image/jpeg' // 文件MIME类型
'fileSize:2048'       // 文件大小（KB）

9. 条件验证
------------------------------------------------------------

'requireIf:field,value'    // 当field=value时必填
'requireWith:field'        // 当field有值时必填
'requireWithout:field'     // 当field没值时必填

============================================================
独立验证（不创建验证器类）
============================================================

$validate = \think\facade\Validate::rule([
    'name'  => 'require|max:25',
    'email' => 'require|email',
])->message([
    'name.require' => '姓名不能为空',
    'email.require' => '邮箱不能为空',
]);

if (!$validate->check($data)) {
    return $validate->getError();
}

============================================================
批量验证
============================================================

// 默认只返回第一个错误
// 开启批量验证返回所有错误

$validate = new UserValidate();
$validate->batch(true);
if (!$validate->check($data)) {
    $errors = $validate->getError();  // 数组
}

// 或在验证器类中设置
class User extends Validate
{
    protected $batch = true;
}

============================================================
自定义验证规则
============================================================

class User extends Validate
{
    protected $rule = [
        'password' => 'require|checkPassword',
    ];

    // 自定义验证规则
    protected function checkPassword($value, $rule, $data = [])
    {
        // 返回 true 表示验证通过
        // 返回字符串表示验证失败（返回值作为错误消息）

        if (strlen($value) < 6) {
            return '密码长度不能小于6位';
        }

        if (!preg_match('/[A-Z]/', $value)) {
            return '密码必须包含大写字母';
        }

        return true;
    }
}

============================================================
常见错误
============================================================

1. 验证器类不存在
   原因：类名或命名空间错误
   解决：检查 app/validate/ 目录

2. 规则不生效
   原因：规则名拼写错误
   解决：参考官方文档确认规则名

3. 场景不生效
   原因：场景名错误或字段不在场景中
   解决：检查 $scene 定义

============================================================
*/

echo "数据验证说明文件\n";
