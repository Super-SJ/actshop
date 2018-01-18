<?php

class OrderNumberListIncrGetRequest {

    private $apiParas = array();

    public function getApiTypeName(){
        return "pdd.order.number.list.increment.get";
    }

    public function getApiParas(){
        return $this->apiParas;
    }

    public function check(){
        $mustParas =['order_status', 'refund_status', 'start_updated_at', 'end_updated_at', 'is_lucky_flag'];
        foreach ($mustParas as $p) {
            if (!isset($this->apiParas[$p])) {
                $errMsg = 'not exists param : '.$p;
                throw new Exception($errMsg,0);
            }
        }
    }

    private $orderStatus;

    public function setOrderStatus($orderStatus){
        $this->orderStatus = $orderStatus;
        $this->apiParas["order_status"] = $orderStatus;
    }

    public function getOrderStatus(){
        return $this->orderStatus;
    }

    private $refundStatus;

    public function setRefundStatus($refundStatus){
        $this->refundStatus = $refundStatus;
        $this->apiParas["refund_status"] = $refundStatus;
    }

    public function getRefundStatus(){
        return $this->$refundStatus;
    }

    private $startUpdatedAt;

    public function setStartUpdatedAt($startUpdatedAt){
        $this->startUpdatedAt = $startUpdatedAt;
        $this->apiParas["start_updated_at"] = $startUpdatedAt;
    }

    public function getStartUpdatedAt(){
        return $this->startUpdatedAt;
    }

    private $endUpdatedAt;

    public function setEndUpdatedAt($endUpdatedAt){
        $this->endUpdatedAt = $endUpdatedAt;
        $this->apiParas["end_updated_at"] = $endUpdatedAt;
    }

    public function getEndUpdatedAt(){
        return $this->endUpdatedAt;
    }

    private $isLuckyFlag;

    public function getIsLuckyFlag()
    {
        return $this->isLuckyFlag;
    }

    public function setIsLuckyFlag($isLuckyFlag)
    {
        $this->isLuckyFlag = $isLuckyFlag;
        $this->apiParas["is_lucky_flag"] = $isLuckyFlag;
    }



    private $page;

    public function setPage($page){
        $this->page = $page;
        $this->apiParas["page"] = $page;
    }

    public function getPage(){
        return $this->page;
    }

    private $pageSize;

    public function setPageSize($pageSize){
        $this->pageSize = $pageSize;
        $this->apiParas["page_size"] = $pageSize;
    }

    public function getPageSize(){
        return $this->pageSize;
    }
}