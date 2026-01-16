<?php
declare(strict_types=1);

namespace app\validate;

use think\Validate;

/**
 * 用户验证器示例
 * 
 * 演示 ThinkPHP 验证器的各种用法
 */
class UserValidate extends Validate
{
    /**
     * 验证规则
     * 
     * 格式：'字段名' => '规则1|规则2:参数1,参数2'
     */
    protected $rule = [
        'name' => 'require|length:2,20|chsDash',
        'email' => 'require|email|unique:user',
        'password' => 'require|length:6,20|checkPassword',
        'confirm_password' => 'require|confirm:password',
        'phone' => 'mobile',
        'age' => 'number|between:1,120',
        'status' => 'in:0,1,2',
        'avatar' => 'image:jpg,png,gif|fileSize:2048',
        'captcha' => 'require|checkCaptcha',
    ];

    /**
     * 自定义错误消息
     * 
     * 格式：'字段名.规则' => '错误消息'
     */
    protected $message = [
        'name.require' => '用户名不能为空',
        'name.length' => '用户名长度必须是2-20个字符',
        'name.chsDash' => '用户名只能是汉字、字母、数字、下划线和破折号',

        'email.require' => '邮箱不能为空',
        'email.email' => '邮箱格式不正确',
        'email.unique' => '该邮箱已被注册',

        'password.require' => '密码不能为空',
        'password.length' => '密码长度必须是6-20个字符',
        'password.checkPassword' => '密码必须包含字母和数字',

        'confirm_password.require' => '请确认密码',
        'confirm_password.confirm' => '两次密码输入不一致',

        'phone.mobile' => '手机号格式不正确',

        'age.number' => '年龄必须是数字',
        'age.between' => '年龄必须在1-120之间',

        'status.in' => '状态值不正确',

        'avatar.image' => '头像必须是jpg、png或gif格式的图片',
        'avatar.fileSize' => '头像文件不能超过2MB',

        'captcha.require' => '验证码不能为空',
        'captcha.checkCaptcha' => '验证码错误',
    ];

    /**
     * 验证场景
     * 
     * 定义不同场景下需要验证的字段
     */
    protected $scene = [
        // 注册场景
        'register' => ['name', 'email', 'password', 'confirm_password', 'captcha'],

        // 登录场景
        'login' => ['email', 'password', 'captcha'],

        // 编辑个人信息场景
        'edit' => ['name', 'phone', 'age'],

        // 修改密码场景
        'password' => ['password', 'confirm_password'],

        // 管理员添加用户
        'admin_add' => ['name', 'email', 'password', 'status'],
    ];

    /**
     * 动态场景定义
     * 
     * 可以在场景方法中动态修改规则
     */
    public function sceneEdit()
    {
        return $this->only(['name', 'phone', 'age'])
            ->remove('name', 'require')  // 编辑时名称非必填
            ->append('phone', 'require'); // 编辑时手机必填
    }

    /**
     * 更新用户场景（排除唯一性验证自身）
     */
    public function sceneUpdate()
    {
        return $this->only(['name', 'email', 'phone', 'age', 'status'])
            ->remove('email', 'unique');  // 更新时不验证唯一性
    }

    // ================================================================
    // 自定义验证规则
    // ================================================================

    /**
     * 检查密码强度
     * 
     * 自定义规则方法，必须是 protected 或 public
     * 
     * @param mixed $value  字段值
     * @param mixed $rule   规则参数
     * @param array $data   所有数据
     * @return bool|string  true表示验证通过，字符串表示错误消息
     */
    protected function checkPassword($value, $rule, $data = [])
    {
        // 必须包含字母
        if (!preg_match('/[a-zA-Z]/', $value)) {
            return '密码必须包含字母';
        }

        // 必须包含数字
        if (!preg_match('/[0-9]/', $value)) {
            return '密码必须包含数字';
        }

        // 不能是纯数字或纯字母
        if (preg_match('/^[a-zA-Z]+$/', $value) || preg_match('/^\d+$/', $value)) {
            return '密码不能是纯字母或纯数字';
        }

        // 不能包含空格
        if (preg_match('/\s/', $value)) {
            return '密码不能包含空格';
        }

        return true;
    }

    /**
     * 检查验证码
     */
    protected function checkCaptcha($value, $rule, $data = [])
    {
        // 这里模拟验证码校验
        // 实际应该从 session 或 Redis 中获取验证码比对

        // $storedCaptcha = session('captcha');
        // if (strtolower($value) !== strtolower($storedCaptcha)) {
        //     return '验证码错误';
        // }

        return true;
    }

    /**
     * 检查用户名是否包含敏感词
     */
    protected function checkSensitiveWord($value, $rule, $data = [])
    {
        $sensitiveWords = ['admin', 'root', 'system', '管理员'];

        foreach ($sensitiveWords as $word) {
            if (stripos($value, $word) !== false) {
                return '用户名包含敏感词';
            }
        }

        return true;
    }
}

/*
============================================================
使用示例
============================================================

// 1. 在控制器中使用验证器类
use app\validate\UserValidate;

// 方式一：实例化使用
$validate = new UserValidate();
if (!$validate->scene('register')->check($data)) {
    return json(['code' => 1, 'msg' => $validate->getError()]);
}

// 方式二：控制器内置方法
try {
    $this->validate($data, UserValidate::class . '.register');
} catch (\think\exception\ValidateException $e) {
    return json(['code' => 1, 'msg' => $e->getMessage()]);
}

// 方式三：静态调用
$result = UserValidate::check($data);

// 2. 批量验证（返回所有错误）
$validate = new UserValidate();
$validate->batch(true);
if (!$validate->check($data)) {
    $errors = $validate->getError();  // 数组
    return json(['code' => 1, 'msg' => '验证失败', 'errors' => $errors]);
}

// 3. 动态添加规则
$validate = new UserValidate();
$validate->rule([
    'invite_code' => 'require|length:6',
])->message([
    'invite_code.require' => '邀请码不能为空',
]);

============================================================
*/
