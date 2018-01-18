<?php

class OrderInformationGetRequest {

    private $apiParas = array();

    public function getApiTypeName(){
        return "pdd.order.information.get";
    }

    public function getApiParas(){
        return $this->apiParas;
    }

    public function check(){
        $mustParas =['order_sn'];
        foreach ($mustParas as $p) {
            if (!isset($this->apiParas[$p])) {
                $errMsg = 'not exists param : '.$p;
                throw new Exception($errMsg,0);
            }
        }
    }

    private $orderSn;

    public function setOrderSn($orderSn){
        $this->orderSn = $orderSn;
        $this->apiParas["order_sn"] = $orderSn;
    }

    public function getOrderSn(){
        return $this->orderSn;
    }
}