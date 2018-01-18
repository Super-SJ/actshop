<?php

class GoodsSkuStockGetRequest {

    private $apiParas = array();

    public function getApiTypeName(){
        return "pdd.goods.sku.stock.get";
    }

    public function getApiParas(){
        return $this->apiParas;
    }

    public function check(){
        if (!isset($this->apiParas['sku_ids']) && !isset($this->apiParas['outer_ids'])) {
            $errMsg = 'not exists param : sku_ids and outer_ids';
            throw new Exception($errMsg,0);
        }

    }

    private $outerIds;

    public function setOuterIds($outerIds){
        $this->outerIds = $outerIds;
        $this->apiParas["outer_ids"] = $outerIds;
    }

    public function getOuterIds(){
        return $this->outerIds;
    }

    private $skuIds;

    public function setSkuIds($skuIds){
        $this->skuIds = $skuIds;
        $this->apiParas["sku_ids"] = $skuIds;
    }

    public function getSkuIds(){
        return $this->skuIds;
    }

}