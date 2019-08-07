<?php
namespace app\jielv\controller;

use app\jielv\model\Users;
/**
*  User
*/
class User extends Index
{
    public function login()
    {
        if ($_POST) {
            $data = $_POST;
            $user = new Users;
            // if ($this->check_code($data['capt'])) {
                unset($data['capt']);
                $data['password'] = sysmd5($data['password']);
                $info = $user->getInfo($data);
                if ($info) {
                    Session('user',$info);
                    $this->redirect(url('index/index'));
                }else {
                    $msg = '用户名或密码错误';
                }
            // }else {
                // $msg = '验证码有误';
            // }
            echo '<script>alert("'.$msg.'")</script>';
        }
        return view();
    }
}
