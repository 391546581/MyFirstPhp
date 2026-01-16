<?php

namespace app\controller;

use app\BaseController;  // 添加这一行
use app\model\User as UserModel;
use think\facade\Request;
use think\facade\View;

class User extends BaseController
{
    // 列表页面
    public function index()
    {
        $users = UserModel::paginate(10);
        View::assign('users', $users);
        return View::fetch();
    }

    // 创建用户页面
    public function create()
    {
        return View::fetch();
    }

    // 保存用户
    public function save()
    {
        $data = Request::post();
        
        $validate = validate([
            'name' => 'require|max:100',
            'email' => 'require|email|unique:users',
            'phone' => 'max:20',
            'age' => 'number|between:0,150',
        ]);
        
        if (!$validate->check($data)) {
            return json(['code' => 0, 'msg' => $validate->getError()]);
        }
        
        try {
            UserModel::create($data);
            return json(['code' => 1, 'msg' => '用户创建成功']);
        } catch (\Exception $e) {
            return json(['code' => 0, 'msg' => '创建失败：' . $e->getMessage()]);
        }
    }

    // 编辑用户页面
    public function edit($id)
    {
        $user = UserModel::find($id);
        if (!$user) {
            return '用户不存在';
        }
        
        View::assign('user', $user);
        return View::fetch();
    }

    // 更新用户
    public function update($id)
    {
        $user = UserModel::find($id);
        if (!$user) {
            return json(['code' => 0, 'msg' => '用户不存在']);
        }
        
        $data = Request::post();
        
        $validate = validate([
            'name' => 'require|max:100',
            'email' => 'require|email|unique:users,email,' . $id,
            'phone' => 'max:20',
            'age' => 'number|between:0,150',
        ]);
        
        if (!$validate->check($data)) {
            return json(['code' => 0, 'msg' => $validate->getError()]);
        }
        
        try {
            $user->save($data);
            return json(['code' => 1, 'msg' => '用户更新成功']);
        } catch (\Exception $e) {
            return json(['code' => 0, 'msg' => '更新失败：' . $e->getMessage()]);
        }
    }

    // 删除用户
    public function delete($id)
    {
        $user = UserModel::find($id);
        if (!$user) {
            return json(['code' => 0, 'msg' => '用户不存在']);
        }
        
        try {
            $user->delete();
            return json(['code' => 1, 'msg' => '用户删除成功']);
        } catch (\Exception $e) {
            return json(['code' => 0, 'msg' => '删除失败：' . $e->getMessage()]);
        }
    }
}