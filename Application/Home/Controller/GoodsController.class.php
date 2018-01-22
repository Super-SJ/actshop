<?php
namespace Home\Controller;

class GoodsController extends BaseController
{
    public function detail(){
        $model = M('Goods');
        $detail = $model->join('LEFT JOIN l_goods_picture on l_goods.id = l_goods_picture.goods_id')->where('l_goods.id=' . I('get.id'))->field('l_goods.*,l_goods_picture.type,l_goods_picture.url')->select();
        foreach ($detail as $v){
            if($v['type']== 0){
                $picture_0[] = $v['url'];
            }elseif ($v['type'] == 1){
                $picture_1[] =$v['url'];
            }
        }
        $detail = array_merge($detail[0],array('picture_0'=>$picture_0),array('picture_1'=>$picture_1));
        $this->assign('detail',$detail);
        $this->display();
    }

    public function submit(){
        $model = M('Goods');
        $detail = $model->join('LEFT JOIN l_goods_picture on l_goods.id = l_goods_picture.goods_id')->where(array('l_goods.id'=>I('get.id')))->group('l_goods.id')->field('l_goods.*,l_goods_picture.url')->order(array('l_goods.order'))->find();
        $arr_spe = M('GoodsSpe')->where('goods_id='.I('get.id'))->select();
        foreach ($arr_spe as $v){
            if($v['type'] == 0){
                $spe_value_1[] = $v['value'];
            }else{
                $spe_value_2[] = $v['value'];
            }
        }
        $detail = array_merge($detail,array_merge(array('spe_value_1'=>$spe_value_1,'spe_value_2'=>$spe_value_2)));
        $this->assign('detail',$detail);
        $this->display();
    }
}