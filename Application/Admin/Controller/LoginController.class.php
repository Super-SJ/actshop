<?php

namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
    public function index()
    {
        // 清空session数据
        session(null);
        $this->display();
    }

    public function login()
    {
        // 登录
        if (IS_POST && check_verify(I('post.verify_code'))) {
            $user_key = I('post.user');
            $tmp = cookie($user_key);
            if ($tmp > 5) {
                $this->ajaxReturn(array(
                    'ret' => -1,
                    'msg' => '账号已被限制登录，请24小时后重试'
                ));
            }
            $parameter = array(
                'user' => I('post.user'),
                'password' => md5(I('post.password')),
            );
            $User = M('AdminUser');
            if (!empty($parameter)) {
                $data = $User->where($parameter)->find();
                if (!empty($data)) {
                    // 写入session
                    session('user', $data['user'], 12 * 3600);
                    cookie($user_key, 0, 24 * 3600);
                    $this->ajaxReturn(array(
                        'ret' => 0
                    ));
                } else {
                    if ($tmp) {
                        cookie($user_key, $tmp + 1, 24 * 3600);
                    } else {
                        cookie($user_key, 1, 24 * 3600);
                    }
                    $this->ajaxReturn(array(
                        'ret' => -1,
                        'msg' => '用户名或密码错误，您还有' . (4 - $tmp) . '次机会'
                    ));
                }
            }
        } else {
            $this->ajaxReturn(array(
                'ret' => -1,
                'msg' => '验证码错误'
            ));
        }
    }

    public function logout()
    {
        //清空session数据
        session(null);
        $this->redirect("Login/index");
    }

    public function verify_c()
    {
        $Verify = new \Think\Verify();
        $Verify->fontSize = 70;
        $Verify->length = 4;
        $Verify->codeSet = '0123456789';
        $Verify->useCurve = false;
        $Verify->entry();
    }
}