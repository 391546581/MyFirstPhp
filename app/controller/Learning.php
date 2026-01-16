<?php
declare(strict_types=1);

namespace app\controller;

/**
 * ============================================================
 * ThinkPHP 8.0 学习 - 第3课：控制器
 * ============================================================
 * 
 * 这是一个示例控制器，用于学习控制器的基本用法
 * 
 * 访问方式：
 *   http://localhost:8000/learning
 *   http://localhost:8000/learning/hello/张三
 *   http://localhost:8000/learning/json
 * 
 * ============================================================
 */

use app\BaseController;
use think\Request;
use think\Response;
use think\facade\View;

class Learning extends BaseController
{
    /**
     * 1. 基础方法
     * 
     * 访问：GET /learning 或 /learning/index
     */
    public function index(): string
    {
        return 'Welcome to ThinkPHP Learning!';
    }

    /**
     * 2. 带参数的方法
     * 
     * 访问：GET /learning/hello/张三
     * 
     * 参数可以通过以下方式获取：
     * - 方法参数（URL参数自动注入）
     * - $this->request->param('name')
     * - input('name')
     */
    public function hello(string $name = 'World'): string
    {
        return "Hello, {$name}!";
    }

    /**
     * 3. 返回JSON数据
     * 
     * 访问：GET /learning/json
     * 
     * 💡 API开发中最常用
     */
    public function json(): \think\response\Json
    {
        $data = [
            'code' => 0,
            'msg' => 'success',
            'data' => [
                'name' => '张三',
                'age' => 25,
                'skills' => ['PHP', 'ThinkPHP', 'MySQL']
            ]
        ];

        return json($data);
    }

    /**
     * 4. 获取请求参数
     * 
     * 访问：GET /learning/params?name=张三&age=25
     *       POST /learning/params （带请求体）
     */
    public function params(): \think\response\Json
    {
        // 获取单个参数
        $name = $this->request->param('name', '默认值');

        // 获取所有参数
        $all = $this->request->param();

        // 获取GET参数
        $get = $this->request->get();

        // 获取POST参数
        $post = $this->request->post();

        // 使用助手函数
        $inputName = input('name');
        $inputAge = input('age/d', 0);  // /d 转为整数

        return json([
            'name' => $name,
            'input_age' => $inputAge,
            'all_params' => $all,
            'request_method' => $this->request->method(),
        ]);
    }

    /**
     * 5. 请求验证
     * 
     * 数据验证的基础用法
     */
    public function validateDemo(): \think\response\Json
    {
        $data = [
            'name' => '张三',
            'email' => 'invalid-email',  // 故意写错
            'age' => 15,
        ];

        // 定义验证规则
        $rules = [
            'name' => 'require|max:20',
            'email' => 'require|email',
            'age' => 'require|number|between:18,60',
        ];

        // 定义错误消息
        $messages = [
            'name.require' => '姓名不能为空',
            'email.require' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
            'age.between' => '年龄必须在18-60之间',
        ];

        try {
            $this->validate($data, $rules, $messages);
            return json(['code' => 0, 'msg' => '验证通过']);
        } catch (\think\exception\ValidateException $e) {
            return json(['code' => 1, 'msg' => $e->getError()]);
        }
    }

    /**
     * 6. 渲染视图
     * 
     * 返回HTML页面
     */
    public function view(): string
    {
        // 分配变量到视图
        View::assign([
            'title' => 'ThinkPHP 学习',
            'user' => ['name' => '张三', 'age' => 25],
            'items' => ['PHP', 'ThinkPHP', 'MySQL'],
        ]);

        // 渲染视图文件 view/learning/view.html
        return View::fetch('learning/view');
    }

    /**
     * 7. 重定向
     */
    public function redirect(): \think\response\Redirect
    {
        // 重定向到另一个方法
        return redirect('/learning/index');

        // 或者使用 url 助手函数
        // return redirect(url('learning/hello', ['name' => '张三']));
    }

    /**
     * 8. 请求信息获取
     */
    public function requestInfo(): \think\response\Json
    {
        return json([
            'method' => $this->request->method(),
            'ip' => $this->request->ip(),
            'url' => $this->request->url(),
            'baseUrl' => $this->request->baseUrl(),
            'host' => $this->request->host(),
            'header' => $this->request->header(),
            'isAjax' => $this->request->isAjax(),
            'isPost' => $this->request->isPost(),
            'isGet' => $this->request->isGet(),
        ]);
    }
}

/*
============================================================
常见错误
============================================================

1. 控制器找不到
   原因：类名与文件名不一致，或命名空间错误
   解决：确保文件名大写（如 Learning.php），类名也大写

2. 方法不存在
   原因：方法名拼写错误，或访问控制为 private
   解决：方法必须是 public

3. 参数类型错误
   原因：URL参数与方法参数类型不匹配
   解决：添加默认值，或用 ? 允许 null

4. 视图文件不存在
   原因：视图路径错误
   解决：检查 view/ 目录下的文件位置

============================================================
练习
============================================================

1. 创建一个新控制器 ArticleController
2. 实现 index、read、save 三个方法
3. index 返回文章列表（JSON）
4. read 根据 id 参数返回文章详情
5. save 接收 POST 数据并验证

============================================================
*/
