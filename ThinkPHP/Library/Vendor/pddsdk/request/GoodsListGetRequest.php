<?php

class GoodsListGetRequest {

    private $apiParas = array();

    public function getApiTypeName(){
        return "pdd.goods.list.get";
    }

    public function getApiParas(){
        return $this->apiParas;
    }

    public function check(){

    }

    private $outerId;

    public function setOuterId($outerId){
        $this->outerId = $outerId;
        $this->apiParas["outer_id"] = $outerId;
    }

    public function getOuterId(){
        return $this->outerId;
    }

    private $isOnsale;

    public function setIsOnsale($isOnsale){
        $this->isOnsale = $isOnsale;
        $this->apiParas["is_onsale"] = $isOnsale;
    }

    public function getIsOnsale(){
        return $this->isOnsale;
    }

    private $goodsName;

    public function setGoodsName($goodsName){
        $this->goodsName = $goodsName;
        $this->apiParas["goods_name"] = $goodsName;
    }

    public function getGoodsName(){
        return $this->goodsName;
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