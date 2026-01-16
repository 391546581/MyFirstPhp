<?php
/**
 * PHP 基础学习 - 第6课：字符串处理
 * 
 * 学习目标：掌握字符串操作、正则表达式基础
 * 运行方式：php practice.php
 */

echo "=== 第6课：字符串处理 ===\n\n";

// 1. 字符串基础
echo "【1. 字符串基础】\n";

$single = 'Hello World';      // 单引号
$double = "Hello World";      // 双引号
$name = "PHP";
$greeting = "Hello, $name!";  // 双引号解析变量

echo "单引号: $single\n";
echo "双引号变量解析: $greeting\n";

// Heredoc 和 Nowdoc
$heredoc = <<<HTML
<div>
    <p>这是 Heredoc 语法，可以解析变量: $name</p>
</div>
HTML;

$nowdoc = <<<'TEXT'
这是 Nowdoc 语法，不解析变量: $name
TEXT;

echo "Heredoc:\n$heredoc\n";
echo "Nowdoc:\n$nowdoc\n";

// 2. 常用字符串函数
echo "\n【2. 常用字符串函数】\n";

$str = "  Hello, PHP World!  ";

echo "strlen: " . strlen($str) . "\n";
echo "trim: '" . trim($str) . "'\n";
echo "strtoupper: " . strtoupper(trim($str)) . "\n";
echo "strtolower: " . strtolower(trim($str)) . "\n";
echo "ucfirst: " . ucfirst("hello") . "\n";
echo "ucwords: " . ucwords("hello world") . "\n";

// 查找和替换
echo "\n查找和替换:\n";
echo "strpos: " . strpos($str, "PHP") . "\n";
echo "str_replace: " . str_replace("PHP", "ThinkPHP", $str) . "\n";
echo "substr: " . substr(trim($str), 0, 5) . "\n";

// 3. 字符串与数组转换
echo "\n【3. 字符串与数组转换】\n";

$csv = "苹果,香蕉,橙子,葡萄";
$fruits = explode(",", $csv);
echo "explode: " . print_r($fruits, true);

$joined = implode(" | ", $fruits);
echo "implode: $joined\n";

// str_split
$chars = str_split("Hello", 2);
echo "str_split: " . implode("-", $chars) . "\n";

// 4. 格式化输出
echo "\n【4. 格式化输出】\n";

$name = "张三";
$score = 85.5;

// printf - 直接输出
printf("学生: %s, 分数: %.1f\n", $name, $score);

// sprintf - 返回字符串
$formatted = sprintf("学生: %s, 分数: %05.1f", $name, $score);
echo "$formatted\n";

// 格式说明符
echo "整数: " . sprintf("%d", 42) . "\n";
echo "浮点: " . sprintf("%.2f", 3.14159) . "\n";
echo "补零: " . sprintf("%05d", 42) . "\n";
echo "左对齐: " . sprintf("%-10s|", "hello") . "\n";

// number_format
$price = 1234567.891;
echo "number_format: " . number_format($price, 2, '.', ',') . "\n";

// 5. 正则表达式
echo "\n【5. 正则表达式基础】\n";

$text = "我的邮箱是 test@example.com，电话是 13812345678";

// preg_match - 匹配
if (preg_match('/\d{11}/', $text, $matches)) {
    echo "找到电话: {$matches[0]}\n";
}

// preg_match_all - 全部匹配
preg_match_all('/\d+/', $text, $allMatches);
echo "所有数字: " . implode(", ", $allMatches[0]) . "\n";

// preg_replace - 替换
$censored = preg_replace('/\d/', '*', $text);
echo "隐藏数字: $censored\n";

// 验证邮箱
$email = "test@example.com";
if (preg_match('/^[\w\.-]+@[\w\.-]+\.\w+$/', $email)) {
    echo "邮箱格式正确: $email\n";
}

// 6. 多字节字符串（中文）
echo "\n【6. 多字节字符串】\n";

$chinese = "你好世界";
echo "strlen: " . strlen($chinese) . " (字节)\n";
echo "mb_strlen: " . mb_strlen($chinese) . " (字符)\n";
echo "mb_substr: " . mb_substr($chinese, 0, 2) . "\n";

// 7. 常见错误
echo "\n【常见错误】\n";
echo "1. 单引号不解析变量和转义符(除了\\和\\')\n";
echo "2. 中文处理要用 mb_ 系列函数\n";
echo "3. strpos 返回 0 时不等于 false，要用 === 判断\n";

$pos = strpos("Hello", "H");
if ($pos !== false) {
    echo "   找到位置: $pos\n";
}

echo "\n第6课完成！下一课：07_oop_basics\n";
