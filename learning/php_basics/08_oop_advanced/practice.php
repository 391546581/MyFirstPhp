<?php
/**
 * PHP 基础学习 - 第8课：面向对象进阶
 * 
 * 学习目标：掌握继承、接口、抽象类、Trait、命名空间
 * 运行方式：php practice.php
 */

echo "=== 第8课：面向对象进阶 ===\n\n";

// 1. 继承
echo "【1. 继承】\n";

class Animal
{
    public function __construct(
        protected string $name
    ) {
    }

    public function speak(): string
    {
        return "{$this->name}发出声音";
    }
}

class Dog extends Animal
{
    public function speak(): string
    {
        return "{$this->name}: 汪汪汪！";
    }

    public function fetch(): string
    {
        return "{$this->name}在捡球";
    }
}

class Cat extends Animal
{
    public function speak(): string
    {
        return "{$this->name}: 喵喵喵！";
    }
}

$dog = new Dog("旺财");
$cat = new Cat("咪咪");
echo $dog->speak() . "\n";
echo $cat->speak() . "\n";
echo $dog->fetch() . "\n";

// 2. 抽象类
echo "\n【2. 抽象类】\n";

abstract class Shape
{
    abstract public function area(): float;
    abstract public function perimeter(): float;

    // 抽象类可以有具体方法
    public function describe(): string
    {
        return "这是一个图形，面积: " . $this->area();
    }
}

class Rectangle extends Shape
{
    public function __construct(
        private float $width,
        private float $height
    ) {
    }

    public function area(): float
    {
        return $this->width * $this->height;
    }

    public function perimeter(): float
    {
        return 2 * ($this->width + $this->height);
    }
}

$rect = new Rectangle(10, 5);
echo "矩形面积: " . $rect->area() . "\n";
echo "矩形周长: " . $rect->perimeter() . "\n";

// 3. 接口
echo "\n【3. 接口】\n";

interface Printable
{
    public function print(): string;
}

interface Saveable
{
    public function save(): bool;
}

// 类可以实现多个接口
class Document implements Printable, Saveable
{
    public function __construct(
        private string $content
    ) {
    }

    public function print(): string
    {
        return "打印内容: {$this->content}";
    }

    public function save(): bool
    {
        echo "文档已保存\n";
        return true;
    }
}

$doc = new Document("Hello World");
echo $doc->print() . "\n";
$doc->save();

// 4. Trait（代码复用）
echo "\n【4. Trait】\n";

trait Timestampable
{
    private ?string $createdAt = null;
    private ?string $updatedAt = null;

    public function setCreatedAt(): void
    {
        $this->createdAt = date('Y-m-d H:i:s');
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }
}

trait Loggable
{
    public function log(string $message): void
    {
        echo "[LOG] $message\n";
    }
}

class Article
{
    use Timestampable, Loggable;

    public function __construct(
        public string $title
    ) {
        $this->setCreatedAt();
    }
}

$article = new Article("PHP教程");
echo "创建时间: " . $article->getCreatedAt() . "\n";
$article->log("文章已创建");

// 5. 后期静态绑定
echo "\n【5. 后期静态绑定】\n";

class ParentClass
{
    public static function create(): static
    {
        return new static();  // static 而非 self
    }

    public function whoAmI(): string
    {
        return static::class;  // 返回实际类名
    }
}

class ChildClass extends ParentClass
{
}

$parent = ParentClass::create();
$child = ChildClass::create();
echo "Parent: " . $parent->whoAmI() . "\n";
echo "Child: " . $child->whoAmI() . "\n";

// 6. 魔术方法
echo "\n【6. 魔术方法】\n";

class MagicDemo
{
    private array $data = [];

    public function __get(string $name): mixed
    {
        return $this->data[$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->data[$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    public function __call(string $name, array $args): mixed
    {
        echo "调用了不存在的方法: $name\n";
        return null;
    }
}

$magic = new MagicDemo();
$magic->name = "张三";  // 调用 __set
echo "name: {$magic->name}\n";  // 调用 __get
$magic->unknownMethod();  // 调用 __call

// 7. Final 关键字
echo "\n【7. Final 关键字】\n";
echo "final class - 不能被继承\n";
echo "final method - 不能被重写\n";

// 8. 常见错误
echo "\n【常见错误】\n";
echo "1. 接口只能定义方法签名，不能有实现\n";
echo "2. 抽象方法必须在子类中实现\n";
echo "3. Trait 冲突时需要用 insteadof 解决\n";
echo "4. 静态方法中不能使用 \$this\n";

echo "\n=== PHP 基础学习完成！===\n";
echo "接下来学习 ThinkPHP 框架基础\n";
