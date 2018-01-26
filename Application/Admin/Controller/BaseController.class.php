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

    public function photo_upload($type = 1)
    {
        //type = 1 商品 type =2 广告
        $file_name = md5(time().mt_rand(1000000,9999999)) . "." . substr(strrchr($_FILES['file']['name'], '.'), 1);
        copy($_FILES["file"]["tmp_name"], './Public/temp/' . $file_name);
        $result = getimagesize('./Public/temp/' . $file_name);
        $width = ($result[0]/2);
        $height = ($result[1]/2);
        if($type ==1){
            Img('./Public/temp/' . $file_name, $width, $height, 1);
        }else{
            Img('./Public/temp/' . $file_name, $width, $height, 1);
        }
        $this->ajaxReturn(array('src'=>$file_name));
    }
}