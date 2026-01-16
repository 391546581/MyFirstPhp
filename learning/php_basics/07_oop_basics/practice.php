<?php
/**
 * PHP 基础学习 - 第7课：面向对象基础
 * 
 * 学习目标：掌握类、对象、属性、方法、构造函数
 * 运行方式：php practice.php
 */

echo "=== 第7课：面向对象基础 ===\n\n";

// 1. 类的定义
echo "【1. 类的定义】\n";

class User
{
    // 属性（PHP 8+ 支持类型声明）
    public string $name;
    public int $age;
    private string $password;
    protected string $email;

    // 构造函数
    public function __construct(string $name, int $age, string $password = '')
    {
        $this->name = $name;
        $this->age = $age;
        $this->password = $password;
    }

    // 公有方法
    public function greet(): string
    {
        return "你好，我是{$this->name}，今年{$this->age}岁。";
    }

    // 私有方法
    private function hashPassword(): string
    {
        return md5($this->password);
    }

    // Getter
    public function getEmail(): string
    {
        return $this->email ?? '';
    }

    // Setter
    public function setEmail(string $email): void
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        }
    }
}

$user = new User("张三", 25);
echo $user->greet() . "\n";
echo "访问属性: {$user->name}\n";

// 2. 构造函数属性提升（PHP 8+）
echo "\n【2. 构造函数属性提升】\n";

class Product
{
    // PHP 8 新特性：直接在构造函数参数中声明属性
    public function __construct(
        public string $name,
        public float $price,
        public int $stock = 0
    ) {
    }

    public function getInfo(): string
    {
        return "{$this->name}: ¥{$this->price} (库存: {$this->stock})";
    }
}

$product = new Product("iPhone", 5999.00, 100);
echo $product->getInfo() . "\n";

// 3. 静态成员
echo "\n【3. 静态成员】\n";

class Counter
{
    private static int $count = 0;

    public static function increment(): void
    {
        self::$count++;
    }

    public static function getCount(): int
    {
        return self::$count;
    }
}

Counter::increment();
Counter::increment();
Counter::increment();
echo "计数器: " . Counter::getCount() . "\n";

// 4. 常量
echo "\n【4. 类常量】\n";

class Config
{
    public const VERSION = '1.0.0';
    public const MAX_USERS = 100;

    public static function getVersion(): string
    {
        return self::VERSION;
    }
}

echo "版本: " . Config::VERSION . "\n";
echo "最大用户数: " . Config::MAX_USERS . "\n";

// 5. 访问控制
echo "\n【5. 访问控制】\n";
echo "public    - 任何地方都可以访问\n";
echo "protected - 类内部和子类可以访问\n";
echo "private   - 只有类内部可以访问\n";

// 6. $this vs self vs static
echo "\n【6. \$this vs self vs static】\n";
echo "\$this   - 指向当前对象实例\n";
echo "self    - 指向当前类（编译时确定）\n";
echo "static  - 指向调用的类（运行时确定，后期静态绑定）\n";

// 7. 常见错误
echo "\n【常见错误】\n";
echo "1. 忘记使用 \$this-> 访问对象属性\n";
echo "2. 混淆 self:: 和 \$this->\n";
echo "3. 新手容易忘记 new 关键字\n";
echo "4. PHP 8 要求声明属性类型时必须初始化\n";

echo "\n第7课完成！下一课：08_oop_advanced\n";
