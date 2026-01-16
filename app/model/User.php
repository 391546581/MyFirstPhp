<?php

namespace app\model;

use think\Model;

class User extends Model
{
    protected $name = 'users';
    
    protected $autoWriteTimestamp = true;
    
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    
    protected $schema = [
        'id' => 'int',
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'age' => 'int',
        'status' => 'int',
        'create_time' => 'datetime',
        'update_time' => 'datetime',
    ];
}