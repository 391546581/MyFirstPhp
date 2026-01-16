<?php
/**
 * PHP 基础学习 - 第5课：数组
 * 
 * 学习目标：掌握索引数组、关联数组、多维数组和常用数组函数
 * 运行方式：php practice.php
 */

echo "=== 第5课：数组 ===\n\n";

// 1. 索引数组
echo "【1. 索引数组】\n";

$fruits = ['苹果', '香蕉', '橙子'];  // 简写语法（推荐）
$numbers = array(1, 2, 3, 4, 5);     // 传统语法

echo "fruits[0] = {$fruits[0]}\n";
echo "count = " . count($fruits) . "\n";

// 添加元素
$fruits[] = '葡萄';  // 追加
array_push($fruits, '西瓜');
echo "添加后：" . implode(", ", $fruits) . "\n";

// 2. 关联数组
echo "\n【2. 关联数组】\n";

$user = [
    'name' => '张三',
    'age' => 25,
    'email' => 'zhangsan@example.com'
];

echo "name = {$user['name']}\n";
echo "age = {$user['age']}\n";

// 遍历
foreach ($user as $key => $value) {
    echo "  $key: $value\n";
}

// 3. 多维数组
echo "\n【3. 多维数组】\n";

$users = [
    ['name' => '张三', 'age' => 25],
    ['name' => '李四', 'age' => 30],
    ['name' => '王五', 'age' => 28],
];

foreach ($users as $index => $u) {
    echo "  [$index] {$u['name']}, {$u['age']}岁\n";
}

// 4. 常用数组函数
echo "\n【4. 常用数组函数】\n";

$nums = [3, 1, 4, 1, 5, 9, 2, 6];

echo "count: " . count($nums) . "\n";
echo "sum: " . array_sum($nums) . "\n";
echo "max: " . max($nums) . "\n";
echo "min: " . min($nums) . "\n";
echo "in_array(5): " . (in_array(5, $nums) ? 'true' : 'false') . "\n";

sort($nums);
echo "sort: " . implode(", ", $nums) . "\n";

$nums = [3, 1, 4, 1, 5, 9, 2, 6];
rsort($nums);
echo "rsort: " . implode(", ", $nums) . "\n";

// array_map
$doubled = array_map(fn($n) => $n * 2, [1, 2, 3]);
echo "array_map: " . implode(", ", $doubled) . "\n";

// array_filter
$even = array_filter([1, 2, 3, 4, 5], fn($n) => $n % 2 === 0);
echo "array_filter(偶数): " . implode(", ", $even) . "\n";

// array_reduce
$sum = array_reduce([1, 2, 3, 4, 5], fn($carry, $n) => $carry + $n, 0);
echo "array_reduce(求和): $sum\n";

// 5. 数组合并与切片
echo "\n【5. 数组合并与切片】\n";

$arr1 = [1, 2, 3];
$arr2 = [4, 5, 6];

// 合并
$merged = array_merge($arr1, $arr2);
echo "array_merge: " . implode(", ", $merged) . "\n";

// ... 展开运算符
$merged2 = [...$arr1, ...$arr2];
echo "展开运算符: " . implode(", ", $merged2) . "\n";

// 切片
$slice = array_slice([1, 2, 3, 4, 5], 1, 3);
echo "array_slice(1,3): " . implode(", ", $slice) . "\n";

// 6. 数组解构
echo "\n【6. 数组解构】\n";

$data = ['张三', 25, '北京'];
[$name, $age, $city] = $data;
echo "$name, $age岁, 来自$city\n";

// 跳过元素
[, $second,] = [1, 2, 3];
echo "第二个元素: $second\n";

// 7. 常见错误
echo "\n【常见错误】\n";
echo "1. 访问不存在的索引会报 Undefined 警告\n";
echo "2. 关联数组的键使用字符串时要加引号\n";
echo "3. foreach 使用引用后要 unset\n";

// 正确做法：检查键是否存在
if (isset($user['phone'])) {
    echo $user['phone'];
} else {
    echo "phone 不存在\n";
}

// 使用空合并运算符
$phone = $user['phone'] ?? '未设置';
echo "phone: $phone\n";

// 8. 练习题
echo "\n【练习题】\n";
echo "1. 创建学生成绩数组，计算平均分\n";
echo "2. 使用 array_filter 过滤及格的成绩(>=60)\n";
echo "3. 使用 array_map 将成绩转换为等级\n";

echo "\n第5课完成！下一课：06_strings\n";
