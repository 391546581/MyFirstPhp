# PHP & ThinkPHP 学习计划

## 📅 学习阶段安排

### 第一阶段：PHP 基础（建议2周）

| 天数 | 主题 | 学习文件 | 预计时间 |
|-----|------|---------|---------|
| 1-2 | 变量与数据类型 | `php_basics/01_variables_and_types/` | 2-3小时 |
| 3-4 | 运算符 | `php_basics/02_operators/` | 2-3小时 |
| 5-6 | 流程控制 | `php_basics/03_control_flow/` | 2-3小时 |
| 7-8 | 函数 | `php_basics/04_functions/` | 3-4小时 |
| 9 | 数组 | `php_basics/05_arrays/` | 2-3小时 |
| 10 | 字符串处理 | `php_basics/06_strings/` | 2-3小时 |
| 11-12 | 面向对象基础 | `php_basics/07_oop_basics/` | 3-4小时 |
| 13-14 | 面向对象进阶 | `php_basics/08_oop_advanced/` | 4-5小时 |

### 第二阶段：ThinkPHP 基础（建议3周）

| 天数 | 主题 | 学习文件 | 预计时间 |
|-----|------|---------|---------|
| 15 | 目录结构 | `thinkphp_basics/01_directory_structure/` | 1-2小时 |
| 16-17 | 路由 | `thinkphp_basics/02_routing/` | 2-3小时 |
| 18-20 | 控制器 | `thinkphp_basics/03_controller/` | 4-5小时 |
| 21-22 | 请求与响应 | `thinkphp_basics/04_request_response/` | 2-3小时 |
| 23-26 | 数据库操作 | `thinkphp_basics/05_database/` | 6-8小时 |
| 27-30 | 模型 | `thinkphp_basics/06_model/` | 6-8小时 |
| 31-32 | 视图 | `thinkphp_basics/07_view/` | 3-4小时 |
| 33-35 | 验证器 | `thinkphp_basics/08_validate/` | 3-4小时 |

### 第三阶段：ThinkPHP 进阶（建议2周）

| 天数 | 主题 | 学习文件 | 预计时间 |
|-----|------|---------|---------|
| 36-37 | 中间件 | `thinkphp_advanced/01_middleware/` | 3-4小时 |
| 38-39 | Session与Cookie | `thinkphp_advanced/02_session_cookie/` | 2-3小时 |
| 40-41 | 缓存 | `thinkphp_advanced/03_cache/` | 2-3小时 |
| 42-43 | 事件 | 自行探索 | 2-3小时 |
| 44-45 | 服务与容器 | 自行探索 | 3-4小时 |
| 46-49 | 项目实战 | 综合练习 | 8-10小时 |

---

## 🎯 学习方法

### 1. 阅读代码注释
每个练习文件都包含详细的中文注释，包括：
- 语法说明
- 常见错误和解决方案
- 最佳实践建议

### 2. 运行示例代码
```bash
# PHP 基础练习
cd learning/php_basics/01_variables_and_types
php practice.php

# ThinkPHP 练习
php think run
# 访问 http://localhost:8000/learning
```

### 3. 完成练习题
每个模块末尾都有练习题，请：
1. 先自己尝试完成
2. 遇到问题查阅资料
3. 对比参考答案

### 4. 做项目实战
学完基础后，尝试做一个简单项目：
- 用户注册/登录系统
- 博客文章管理
- 简单的 API 接口

---

## 📚 推荐资源

### 官方文档
- [PHP 官方文档](https://www.php.net/manual/zh/)
- [ThinkPHP 8.0 文档](https://doc.thinkphp.cn/)

### 视频教程
- B站搜索 "PHP 入门教程"
- B站搜索 "ThinkPHP8 教程"

### 工具
- [PHPStorm](https://www.jetbrains.com/phpstorm/) - 最强 PHP IDE
- [VS Code](https://code.visualstudio.com/) + PHP 插件
- [phpMyAdmin](https://www.phpmyadmin.net/) - MySQL 管理
- [Postman](https://www.postman.com/) - API 测试

---

## ⚠️ 常见陷阱清单

### PHP 常见错误
1. **变量名大小写敏感** - `$Name` 和 `$name` 是不同变量
2. **== 和 === 混淆** - 推荐使用 `===` 严格比较
3. **数组索引从0开始** - 不是从1开始
4. **字符串单引号不解析变量** - 用双引号或字符串连接
5. **函数不能直接访问外部变量** - 需要 `global` 或 `use`
6. **浮点数精度问题** - 不要直接比较浮点数

### ThinkPHP 常见错误
1. **表名前缀** - 使用 `Db::name()` 自动加前缀
2. **模型类名与表名对应** - `User` 模型对应 `user` 表
3. **视图路径** - 默认在 `view/控制器/方法.html`
4. **验证器场景** - 记得指定正确的验证场景
5. **路由未定义** - 检查 `route/app.php`
6. **环境配置** - 敏感信息放 `.env` 文件

---

## ✅ 学习检查清单

### PHP 基础
- [ ] 能够声明和使用各种数据类型的变量
- [ ] 理解 == 和 === 的区别
- [ ] 熟练使用 if/switch/match 条件语句
- [ ] 熟练使用 for/foreach/while 循环
- [ ] 能够定义和调用函数
- [ ] 理解值传递和引用传递
- [ ] 能够使用匿名函数和箭头函数
- [ ] 熟练操作数组（增删改查、遍历）
- [ ] 掌握常用字符串函数
- [ ] 理解类、对象、属性、方法
- [ ] 理解继承、接口、抽象类、Trait

### ThinkPHP 基础
- [ ] 理解框架目录结构
- [ ] 能够定义路由
- [ ] 能够创建控制器和方法
- [ ] 能够获取请求参数
- [ ] 能够返回 JSON 和视图
- [ ] 能够使用 Db 类进行 CRUD
- [ ] 能够创建和使用模型
- [ ] 能够使用模型关联
- [ ] 能够渲染视图模板
- [ ] 能够创建和使用验证器

### ThinkPHP 进阶
- [ ] 能够创建和使用中间件
- [ ] 能够使用 Session 和 Cookie
- [ ] 能够使用缓存
- [ ] 理解事件机制
- [ ] 理解服务容器

---

**祝你学习愉快！** 🚀
