<?php

class RefundStatusCheckRequest {

    private $apiParas = array();

    public function getApiTypeName(){
        return "pdd.refund.status.check";
    }

    public function getApiParas(){
        return $this->apiParas;
    }

    public function check(){
        $mustParas =['order_sns'];
        foreach ($mustParas as $p) {
            if (!isset($this->apiParas[$p])) {
                $errMsg = 'not exists param : '.$p;
                throw new Exception($errMsg,0);
            }
        }
    }

    private $orderSns;

    public function setOrderSns($orderSns){
        $this->orderSns = $orderSns;
        $this->apiParas["order_sns"] = $orderSns;
    }

    public function getOrderSns(){
        return $this->orderSns;
    }
}