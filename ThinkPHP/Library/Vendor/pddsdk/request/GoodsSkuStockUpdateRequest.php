<?php

class GoodsSkuStockUpdateRequest {

    private $apiParas = array();

    public function getApiTypeName(){
        return "pdd.goods.sku.stock.update";
    }

    public function getApiParas(){
        return $this->apiParas;
    }

    public function check(){
        if (!isset($this->apiParas['sku_id']) && !isset($this->apiParas['outer_id'])) {
            $errMsg = 'not exists params : sku_id and outer_id';
            throw new Exception($errMsg,0);
        }

        if (!isset ($this->apiParas['quantity'])) {
            $errMsg = 'not exists param : quantity';
            throw new Exception($errMsg,0);
        }

    }

    private $outerId;

    public function setOuterId($outerId){
        $this->outerId = $outerId;
        $this->apiParas["outer_id"] = $outerId;
    }

    public function getOuterId(){
        return $this->outerId;
    }

    private $skuId;

    public function setSkuId($skuId){
        $this->skuId = $skuId;
        $this->apiParas["sku_id"] = $skuId;
    }

    public function getSkuId(){
        return $this->skuId;
    }

    public $quantity;

    public function getQuantity()
    {
        return $this->quantity;
    }


    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->apiParas["quantity"] = $quantity;
    }
}