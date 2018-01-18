<?php

class LogisticsOnlineSendRequest {

    private $apiParas = array();

    public function getApiTypeName(){
        return "pdd.logistics.online.send";
    }

    public function getApiParas(){
        return $this->apiParas;
    }

    public function check(){
        $mustParas =['order_sn', 'logistics_id', 'tracking_number'];
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

    private $trackingNumber;

    public function getTrackingNumber()
    {
        return $this->trackingNumber;
    }

    public function setTrackingNumber($trackingNumber)
    {
        $this->trackingNumber = $trackingNumber;
        $this->apiParas["tracking_number"] = $trackingNumber;
    }

    private $logisticsId;


    public function getLogisticsId()
    {
        return $this->logisticsId;
    }

    public function setLogisticsId($logisticsId)
    {
        $this->logisticsId = $logisticsId;
        $this->apiParas["logistics_id"] = $logisticsId;
    }
}