<?php
/**
 * ThinkPHP 8.0 学习 - 第4课：请求与响应
 */

/*
============================================================
请求处理 (Request)
============================================================

1. 获取请求对象
------------------------------------------------------------

// 在控制器中
$this->request

// 依赖注入
public function index(Request $request) { }

// 使用门面
use think\facade\Request;
Request::param('name');

// 使用助手函数
request()

2. 获取请求参数
------------------------------------------------------------

// 获取所有参数（GET+POST+路由参数）
$this->request->param();

// 获取指定参数
$this->request->param('name');
$this->request->param('name', '默认值');

// 强制类型转换
$this->request->param('id/d');     // 整数
$this->request->param('price/f');  // 浮点
$this->request->param('name/s');   // 字符串
$this->request->param('tags/a');   // 数组

// 只获取GET参数
$this->request->get('name');

// 只获取POST参数
$this->request->post('name');

// 助手函数 input()
input('name');              // 自动判断GET/POST
input('get.name');          // GET参数
input('post.name');         // POST参数
input('?name');             // 检查参数是否存在
input('name', '', 'trim');  // 使用过滤器

3. 获取请求信息
------------------------------------------------------------

$this->request->method();      // 请求方法 GET/POST
$this->request->ip();          // 客户端IP
$this->request->url();         // 当前URL
$this->request->baseUrl();     // 不含查询字符串的URL
$this->request->host();        // 主机名
$this->request->scheme();      // 协议 http/https
$this->request->port();        // 端口号
$this->request->path();        // URL路径
$this->request->controller();  // 当前控制器
$this->request->action();      // 当前操作

4. 请求类型判断
------------------------------------------------------------

$this->request->isGet();       // 是否GET请求
$this->request->isPost();      // 是否POST请求
$this->request->isPut();       // 是否PUT请求
$this->request->isDelete();    // 是否DELETE请求
$this->request->isAjax();      // 是否Ajax请求
$this->request->isJson();      // 是否JSON请求
$this->request->isMobile();    // 是否手机访问

5. 获取请求头
------------------------------------------------------------

$this->request->header();              // 所有请求头
$this->request->header('content-type');// 指定请求头
$this->request->contentType();         // Content-Type

============================================================
响应处理 (Response)
============================================================

1. 返回字符串
------------------------------------------------------------

return 'Hello World';

2. 返回JSON
------------------------------------------------------------

return json(['code' => 0, 'msg' => 'success', 'data' => $data]);

// 或使用Response类
return Response::create($data, 'json');

3. 返回视图
------------------------------------------------------------

return view('template', ['name' => $name]);

// 或
return View::fetch('template');

4. 设置响应头
------------------------------------------------------------

return json($data)->header([
    'Access-Control-Allow-Origin' => '*',
    'X-Custom-Header' => 'value'
]);

5. 设置状态码
------------------------------------------------------------

return json($data)->code(201);

6. 重定向
------------------------------------------------------------

return redirect('/user/list');
return redirect(url('user/read', ['id' => 1]));

7. 文件下载
------------------------------------------------------------

return download($filePath, '下载文件名.zip');

8. 响应格式统一化（推荐）
------------------------------------------------------------

// 在 BaseController 中定义
protected function success($data = null, string $msg = 'success') {
    return json([
        'code' => 0,
        'msg' => $msg,
        'data' => $data
    ]);
}

protected function error(string $msg = 'error', int $code = 1) {
    return json([
        'code' => $code,
        'msg' => $msg,
        'data' => null
    ]);
}

============================================================
常见错误
============================================================

1. 获取不到POST参数
   原因：Content-Type不正确
   解决：前端设置正确的Content-Type

2. input()返回null
   原因：参数名错误或参数不存在
   解决：使用第二个参数设置默认值

3. JSON响应乱码
   原因：字符编码问题
   解决：确保数据库和PHP使用UTF-8

============================================================
*/

echo "请求与响应说明文件，请在控制器中实践\n";
