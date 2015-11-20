<?php
namespace Home\Model;
Class UserModel extends \Think\Model {
    // 表单白名单
    protected $insertFields = array(
        'username',
        'password',
        'rpassword',
        'email',
        'salt',
        'authcode'
    );

    /**
     * 注册
     */

    //添加数据验证，
    protected $_validate=array(
        array("username",'require','用户名称不能为空'),
         // callback指定要使用当前模型里面里面的一个方法，验证规则中要指定使用的方法名称。
        array("username",'checkname','用户名称中包含非法字符',1,'callback'),
            //验证用户名称是否唯一
        array("username",'','用户名称已经存在',1,'unique'),
            //验证密码的长度要在6到12位之间(包含6和12)
        // array("password",'6,12','密码要在6到12位之间',1,'length'),
            //验证确认密码是否和输入的密码一致。
        array("rpassword",'password','两次密码输入不一致',1,'confirm'),
            //验证邮箱格式是否正确
        array('email','email','邮箱格式不正确')
    );
    //验证用户名称包含非法字符的方法
    protected function checkname(){
            //要接收提交的用户名称
            $username  = I('post.username');
            //要判断用户名称中是否包含非法字符，@ # .
            if(strpos($username,'@')!==false || strpos($username,'#')!==false || strpos($username,'.')!==false){
                        //已经包含非法字符了。
                        return false;
            }
            return true;
    }

    /**
     * 登录
     */

    // 动态方式验证规则
    public $_validate_login = array(
        array('username','require','用户名不能为空'),
        array('password','require','密码不能为空'),
        array('authcode','require','验证码不能为空'),
        // 验证验证码是否输入正确
        array('authcode','check_verify','验证码输入错误',1,'callback'),
    );

    // 验证码检测方法
    protected function check_verify($code, $id = '')
    {
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

    // 验证输入的用户名与密码是否正确
    public function login()
    {
        $username = I('post.username');
        $password = I('post.password');

        // 取出数据
        $where['username'] = array('eq',$username);
        $info = $this->field('id,password,salt')->where($where)->find();
        if ($info) {
            // 验证用户密码
            if (md5(md5($password).$info['salt']) == $info['password']) {
                $_SESSION['user_id'] = $info['id'];
                $_SESSION['username'] = $username;
                return true;
            }
        }else{
            $this->error('用户名或密码错误');
            return false;
        }
    }
}
 ?>
