<?php

namespace Admin\Controller;

use Think\Controller;


class BaseController extends Controller
{
    //基类预留
    public function __construct()
    {
        parent::__construct();
        $user = session('user');
        if (empty($user)) {
            $this->error("无权限，请先登录", U('Login/index') . "?ReturnUrl=" . __SELF__);
        }
    }
}