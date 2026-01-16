<?php
/**
 * ThinkPHP 8.0 学习 - 第7课：视图渲染
 */

/*
============================================================
视图基础
============================================================

1. 视图配置 (config/view.php)
------------------------------------------------------------

return [
    // 模板引擎类型
    'type' => 'Think',
    
    // 模板目录
    'view_path' => app()->getBasePath() . 'view' . DIRECTORY_SEPARATOR,
    
    // 模板后缀
    'view_suffix' => 'html',
    
    // 模板缓存
    'tpl_cache' => true,
];

2. 视图目录结构
------------------------------------------------------------

view/
├── index/              # 对应 Index 控制器
│   ├── index.html      # 对应 index 方法
│   └── list.html       # 对应 list 方法
├── user/               # 对应 User 控制器
│   ├── login.html
│   └── register.html
└── public/             # 公共模板
    ├── header.html
    └── footer.html

3. 渲染视图
------------------------------------------------------------

use think\facade\View;

// 渲染当前控制器/方法对应的视图
return View::fetch();

// 渲染指定模板
return View::fetch('index/list');

// 完整路径渲染
return View::fetch('/absolute/path/template');

// 使用助手函数
return view('index/list');

4. 变量分配
------------------------------------------------------------

// 方式1：assign 方法
View::assign('name', '张三');
View::assign('age', 25);
return View::fetch();

// 方式2：assign 数组
View::assign([
    'name' => '张三',
    'age' => 25,
    'items' => ['苹果', '香蕉', '橙子']
]);
return View::fetch();

// 方式3：fetch 时传递
return View::fetch('index', [
    'name' => '张三',
    'age' => 25
]);

// 方式4：view 助手函数
return view('index', ['name' => '张三']);

============================================================
模板语法
============================================================

1. 变量输出
------------------------------------------------------------

{$name}
{$user.name}
{$user['name']}
{$items[0]}
{$user.profile.avatar}

2. 系统变量
------------------------------------------------------------

{$Request.get.id}      // $_GET['id']
{$Request.post.name}   // $_POST['name']
{$Request.param.id}    // 获取参数
{$Request.server.HTTP_HOST}
{$Request.session.user}
{$Request.cookie.token}

// ThinkPHP 内置
{$Think.now}           // 当前时间戳
{$Think.const.APP_PATH} // 常量

3. 函数调用
------------------------------------------------------------

// 单个函数
{$name|md5}
{$email|strtolower}

// 多个函数（链式）
{$name|trim|strtoupper}

// 带参数的函数
{$birthday|date='Y-m-d'}
{$content|substr=0,100}

// 默认值
{$name|default='匿名'}

4. 条件判断
------------------------------------------------------------

{if $status == 1}
    <span class="success">正常</span>
{elseif $status == 0}
    <span class="danger">禁用</span>
{else}
    <span class="warning">未知</span>
{/if}

// 三元运算
{$status ? '启用' : '禁用'}
{$name ?? '匿名'}

// empty 判断
{empty name='$user'}
    用户不存在
{/empty}

// present 判断（非空）
{present name='$user'}
    欢迎，{$user.name}
{/present}

5. 循环
------------------------------------------------------------

// foreach 遍历
{foreach $users as $user}
    <div>{$user.name}</div>
{/foreach}

// 带键名
{foreach $users as $key => $user}
    <div>[{$key}] {$user.name}</div>
{/foreach}

// volist（更多控制）
{volist name='users' id='user'}
    <div>{$user.name}</div>
{/volist}

// 带偏移和数量限制
{volist name='users' id='user' offset='2' length='5'}

// 循环索引
{volist name='users' id='user' key='k'}
    <div>{$k}. {$user.name}</div>
{/volist}

// 空数据处理
{volist name='users' id='user' empty='暂无数据'}

// for 循环
{for start='1' end='10'}
    <div>{$i}</div>
{/for}

6. 模板包含
------------------------------------------------------------

// 包含公共模板
{include file='public/header'}
{include file='public/footer'}

// 带变量传递
{include file='public/sidebar' menu='$menuList'}

7. 模板继承
------------------------------------------------------------

// 基础模板 view/layout/base.html
<!DOCTYPE html>
<html>
<head>
    <title>{block name='title'}默认标题{/block}</title>
</head>
<body>
    {block name='header'}
        <header>默认头部</header>
    {/block}
    
    <main>
        {block name='content'}{/block}
    </main>
    
    {block name='footer'}
        <footer>默认底部</footer>
    {/block}
</body>
</html>

// 子模板 view/index/index.html
{extend name='layout/base'}

{block name='title'}首页 - 我的网站{/block}

{block name='content'}
    <h1>欢迎来到首页</h1>
    <p>{$content}</p>
{/block}

8. 原生PHP代码
------------------------------------------------------------

{php}
    $now = date('Y-m-d H:i:s');
    echo "当前时间：$now";
{/php}

9. 注释
------------------------------------------------------------

{/* 这是模板注释，不会输出 */}

{// 单行注释 //}

============================================================
常见错误
============================================================

1. 模板不存在
   原因：视图文件路径错误
   解决：检查 view/ 目录结构

2. 变量未定义
   原因：未分配变量
   解决：使用 View::assign() 分配变量

3. 模板语法错误
   原因：标签不匹配
   解决：检查 {if} {/if} 等是否配对

4. 转义问题
   原因：默认会HTML转义
   解决：使用 {$content|raw} 输出原始HTML

============================================================
*/

echo "视图说明文件，请查看 view/ 目录\n";
