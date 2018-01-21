<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;

class OrderController extends BaseController
{
    private function form_check(){
        if(intval(I('post.number')) <= 0){
            $this->ajaxReturn(array(
                'ret'=>-1,
                'msg'=>'购买的数量不能小于0'
            ));
        }
        if(empty(I('post.customer_name'))){
            $this->ajaxReturn(array(
                'ret'=>-1,
                'msg'=>'请输入收货人名字',
            ));
        }
        $result = phone_check(I('post.customer_phone'));
        if(is_array($result)){
            if(count($result)==0){
                $this->ajaxReturn(array(
                    'ret'=>-1,
                    'msg'=>'输入的电话号码段不存在'
                ));
            }
        }else{
            $this->ajaxReturn(array(
                'ret'=>-1,
                'msg'=>'输入的电话号码'.$result
            ));
        }

        if(empty(I('post.customer_address_pre')) || empty(I('post.customer_address_last'))){
            $this->ajaxReturn(array(
                'ret'=>-1,
                'msg'=>'请补全地址',
            ));
        }
    }
    public function create(){
        $this->form_check();
        $params = array(
            'order_sn' => time().mt_rand(1000000,9999999),
            'goods_id' => I('post.id'),
            'number' => intval(I('post.number')),
            'customer_name' => I('post.customer_name'),
            'customer_phone' => I('post.customer_phone'),
            'customer_address' => str_replace(' ','',I('post.customer_address_pre')).I('post.customer_address_last'),
            'create_time' => time(),
        );
        $model = M('Order');
        //表单令牌
        if (!$model->autoCheckToken($_POST)){
            $this->ajaxReturn(array(
                'ret'=>-1,
                'msg'=>'下单失败，请稍后尝试'
            ));
        }
        $result = $model->add($params);
        if($result){
            $this->ajaxReturn(array(
                'ret'=>0,
            ));
        }else{
            $this->ajaxReturn(array(
                'ret'=>-1,
                'msg'=>'下单失败，请稍后尝试'
            ));
        }
    }
}