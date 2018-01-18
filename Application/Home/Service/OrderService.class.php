<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/9
 * Time: 20:19
 */
namespace Home\Service;
Vendor('pddsdk.PddTest');

Class OrderService{
    private $pddTest;
    function __construct($params)
    {
        $this->pddTest = new \PddTest($params);
    }

    public function OrderList(){
        return $this->pddTest->orderNumberListGetTest();
    }

    public function OrderInfo($order_id){
        return $this->pddTest->orderInformationGetTest($order_id);
    }


}