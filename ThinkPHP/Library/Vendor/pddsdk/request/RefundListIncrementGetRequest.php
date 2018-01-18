<?php

class RefundListIncrementGetRequest {

    private $apiParas = array();

    public function getApiTypeName(){
        return "pdd.refund.list.increment.get";
    }

    public function getApiParas(){
        return $this->apiParas;
    }

    public function check(){
        $mustParas =['after_sales_type', 'after_sales_status', 'start_updated_at', 'end_updated_at'];
        foreach ($mustParas as $p) {
            if (!isset($this->apiParas[$p])) {
                $errMsg = 'not exists param : '.$p;
                throw new Exception($errMsg,0);
            }
        }
    }

    private $afterSalesType;

    public function setAfterSalesType($afterSalesType){
        $this->afterSalesType = $afterSalesType;
        $this->apiParas["after_sales_type"] = $afterSalesType;
    }

    public function getAfterSalesType(){
        return $this->afterSalesType;
    }

    private $afterSalesStatus;

    public function setAfterSalesStatus($afterSalesStatus){
        $this->afterSalesStatus = $afterSalesStatus;
        $this->apiParas["after_sales_status"] = $afterSalesStatus;
    }

    public function getAfterSalesStatus(){
        return $this->afterSalesStatus;
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