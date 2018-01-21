<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;


class IndexController extends BaseController
{
    public function index()
    {
        $model = M('Goods');
        $list = $model->join('LEFT JOIN l_goods_picture on l_goods.id = l_goods_picture.goods_id')->where(array('l_goods.status'=>array('eq',0),'l_goods_picture.type'=>0))->group('l_goods.id')->field('l_goods.*,l_goods_picture.url')->order(array('l_goods.order'))->select();
        $this->assign('list',$list);
        $Admodel = M('AdPicture');
        $Adlist = $Admodel->where(array('type'=>0))->order(array('order'))->select();
        $this->assign('adlist',$Adlist);
        $this->display();
    }

}