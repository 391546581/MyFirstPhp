# ThinkPHP 8.0 目录结构详解

## 📁 项目根目录结构

```
tp/
├── app/                    # 应用目录（核心代码）
├── config/                 # 配置目录
├── extend/                 # 扩展类库目录
├── public/                 # 公共访问目录（Web入口）
├── route/                  # 路由定义目录
├── runtime/                # 运行时目录（缓存、日志）
├── vendor/                 # Composer依赖包
├── view/                   # 视图目录
├── .env                    # 环境配置文件
├── composer.json           # Composer配置
└── think                   # 命令行入口
```

## 📁 app/ 应用目录详解

```
app/
├── controller/             # 控制器目录
│   ├── Index.php           # 默认控制器
│   └── User.php            # 用户控制器
├── model/                  # 模型目录
│   └── User.php            # 用户模型
├── validate/               # 验证器目录（可选）
├── middleware/             # 中间件目录（可选）
├── service/                # 服务类目录（可选）
├── BaseController.php      # 基础控制器类
├── common.php              # 公共函数文件
├── event.php               # 事件定义文件
├── middleware.php          # 中间件定义文件
├── provider.php            # 容器服务定义
├── Request.php             # 请求类扩展
└── ExceptionHandle.php     # 异常处理类
```

## 📁 config/ 配置目录详解

```
config/
├── app.php                 # 应用配置
├── cache.php               # 缓存配置
├── console.php             # 控制台配置
├── cookie.php              # Cookie配置
├── database.php            # 数据库配置
├── filesystem.php          # 文件系统配置
├── lang.php                # 语言配置
├── log.php                 # 日志配置
├── middleware.php          # 中间件配置
├── route.php               # 路由配置
├── session.php             # Session配置
├── trace.php               # 调试跟踪配置
└── view.php                # 视图配置
```

## 📁 public/ 公共目录

```
public/
├── index.php               # 入口文件（⭐重要）
├── .htaccess               # Apache重写规则
├── static/                 # 静态资源目录
│   ├── css/
│   ├── js/
│   └── images/
└── uploads/                # 上传文件目录
```

## 🔑 关键文件说明

### 1. public/index.php - 入口文件
```php
<?php
// 绑定根目录
define('APP_PATH', __DIR__ . '/../app/');

// 加载框架引导文件
require __DIR__ . '/../vendor/autoload.php';

// 执行应用并响应
$http = (new think\App())->http;
$response = $http->run();
$response->send();
$http->end($response);
```

### 2. app/BaseController.php - 基础控制器
所有控制器都应该继承这个类，它提供：
- 请求对象 `$this->request`
- 应用对象 `$this->app`
- 数据验证方法 `$this->validate()`

### 3. config/database.php - 数据库配置
```php
return [
    'default' => env('database.driver', 'mysql'),
    'connections' => [
        'mysql' => [
            'type' => 'mysql',
            'hostname' => env('database.hostname', '127.0.0.1'),
            'database' => env('database.database', ''),
            'username' => env('database.username', 'root'),
            'password' => env('database.password', ''),
            'hostport' => env('database.hostport', '3306'),
            'charset' => 'utf8mb4',
            'prefix' => env('database.prefix', ''),
        ],
    ],
];
```

## 💡 最佳实践

1. **控制器命名**：使用大驼峰命名，如 `UserController.php`
2. **模型命名**：与数据表对应，如 `User.php` 对应 `user` 表
3. **不要修改 vendor 目录**：这是 Composer 管理的依赖
4. **敏感信息放 .env**：数据库密码、API密钥等
5. **runtime 目录要有写权限**：用于缓存和日志

## 📝 练习

1. 浏览项目目录，熟悉各文件位置
2. 查看 `config/database.php` 配置
3. 查看 `app/BaseController.php` 理解基础控制器

## ⏭️ 下一课

02_routing（路由配置）
