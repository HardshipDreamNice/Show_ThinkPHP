<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller
{
    public function register()
    {
        // 跨模块取出导航
        $cateModel = D('Admin/Category');
        $navdata = $cateModel->getNav();
        $this->assign('navdata',$navdata);

        if (IS_POST) {
            $userModel = D('User');
            // 过滤post数据
            if ($userModel->create(I('post.'),1)) {
                // 加盐
                $salt = substr(uniqid(),-6);
                // 获取密码
                $pwd = I('post.password');
                // ORM模型 给数据对象赋值
                $userModel->password = md5(md5($pwd).$salt);
                $userModel->salt = $salt;
                if ($userModel->add()) {
                    $this->success("注册成功", U('Home/Index'));
                    exit;
                }else{
                    $this->error('注册失败，请联系管理员');
                }
            }else{
                $this->error($userModel->getError());
            }
        }

        $this->display();
    }

    // 登录
    public function login()
    {
        if (IS_POST) {
            // 完成登录操作
            $userModel = D('User');
            // 连贯操作 1.动态验证 2.过滤post数据
            if ($userModel->validate($userModel->_validate_login)->create(I('post.'))) {
                // 在Model中验证登录
                if ($userModel->login()) {
                    $this->success('登录成功', U('Home/index'));exit;
                }else{
                    $this->error($userModel->getError());
                }
            }else{
                $this->error($userModel->getError());
            }
        }

        // 跨模块取出导航
        $cateModel = D('Admin/Category');
        $navdata = $cateModel->getNav();
        $this->assign('navdata',$navdata);

        $this->display();
    }

    // 生成验证码
    public function authcode()
    {
        // 生成验证码
        $Verify =     new \Think\Verify();
        $Verify->fontSize = 15;
        $Verify->length   = 4;
        $Verify->useNoise = false;
        $Verify->entry();
    }

    // 退出
    public function logont(){
        // 用户退出 清空session
        $_SESSION['user_id'] = null;
        $_SESSION['username'] = null;
        $this->success('成功退出', U('Home/Index'));exit;
    }
}
 ?>
