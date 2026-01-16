<?php
/**
 * PHP 基础学习 - 第4课：函数
 * 
 * 学习目标：掌握函数定义、参数传递、闭包和箭头函数
 * 运行方式：php practice.php
 */

echo "=== 第4课：函数 ===\n\n";

// 1. 函数基础
echo "【1. 函数基础】\n";

function greet(string $name): string
{
    return "你好，{$name}！";
}

echo greet("张三") . "\n";

// 2. 参数传递
echo "\n【2. 参数传递】\n";

// 值传递（默认）
function incrementValue(int $num): void
{
    $num++;
    echo "函数内：$num\n";
}

// 引用传递
function incrementRef(int &$num): void
{
    $num++;
}

$val = 5;
incrementValue($val);
echo "值传递后：$val\n";  // 仍然是5

incrementRef($val);
echo "引用传递后：$val\n";  // 变成6

// 3. 默认参数
echo "\n【3. 默认参数】\n";

function createUser(string $name, int $age = 18, string $role = 'user'): string
{
    return "$name, $age岁, 角色: $role";
}

echo createUser("张三") . "\n";
echo createUser("李四", 25, "admin") . "\n";

// 4. 命名参数（PHP 8+）
echo "\n【4. 命名参数】\n";

echo createUser(name: "王五", role: "editor") . "\n";

// 5. 可变参数
echo "\n【5. 可变参数】\n";

function sum(...$numbers): int|float
{
    return array_sum($numbers);
}

echo "sum(1,2,3,4,5) = " . sum(1, 2, 3, 4, 5) . "\n";

// 6. 匿名函数
echo "\n【6. 匿名函数】\n";

$multiply = function ($a, $b) {
    return $a * $b;
};

echo "3 * 4 = " . $multiply(3, 4) . "\n";

// 使用 use 捕获外部变量
$prefix = "Hello";
$greetFn = function ($name) use ($prefix) {
    return "$prefix, $name!";
};
echo $greetFn("World") . "\n";

// 7. 箭头函数（PHP 7.4+）
echo "\n【7. 箭头函数】\n";

$double = fn($n) => $n * 2;
echo "double(5) = " . $double(5) . "\n";

$numbers = [1, 2, 3, 4, 5];
$squared = array_map(fn($n) => $n ** 2, $numbers);
echo "平方：" . implode(", ", $squared) . "\n";

// 8. 常见错误
echo "\n【常见错误】\n";
echo "1. 默认参数必须放在必须参数后面\n";
echo "2. 函数不能直接访问外部变量（需用global或use）\n";
echo "3. 引用传递时记得加 & 符号\n";

// 9. 练习题
echo "\n【练习题】\n";
echo "1. 编写阶乘函数 factorial(n)\n";
echo "2. 用箭头函数过滤数组中的偶数\n";
echo "3. 创建返回闭包的计数器函数\n";

echo "\n第4课完成！下一课：05_arrays\n";
