<?php

class OrderNumberListGetRequest {

    private $apiParas = array();

    public function getApiTypeName(){
        return "pdd.order.number.list.get";
    }

    public function getApiParas(){
        return $this->apiParas;
    }

    public function check(){
        $mustParas =['order_status'];
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