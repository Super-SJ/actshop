<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;


class IndexController extends BaseController
{
    public function index()
    {
        $this->display();
    }

    public function test(){
        $model = M('GoodsPicture');
        $list = $model->select();
        foreach ($list as $v){
            $result = getimagesize('./Public/images/' . $v['url']);
            $width = ($result[0]/2);
            $height = ($result[1]/2);
            Img('./Public/images/' . $v['url'], $width, $height, 1);
        }
    }
}