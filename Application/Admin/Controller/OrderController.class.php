<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;

class OrderController extends BaseController
{
    private $status = array(
        '0' =>'待发货',
        '1' =>'已发货',
        '2' =>'已签收',
        '3' =>'已作废'
    );
    public function index()
    {
        $model = M('Order');
        $list = $model->join('LEFT JOIN l_goods ON l_order.goods_id = l_goods.id')->field('l_order.*,l_goods.name')->select();
        foreach ($list as &$v){
            $v['status'] = $this->status[$v['status']];
            $v['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
        }
        $this->assign('list',$list);
        $this->display();
    }

    public function update_status(){
        $model = M('Order');
        $paramas = array(
            'id'=>I('get.id'),
            'status'=>I('get.status')
        );
        $result = $model->save($paramas);
        if($result !== false){
            $this->success('操作成功');
        }else{
            $this->success('操作失败');
        }
    }
}