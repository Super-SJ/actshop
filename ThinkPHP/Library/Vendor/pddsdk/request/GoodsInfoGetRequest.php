<?php

class GoodsInfoGetRequest {

    private $apiParas = array();

    public function getApiTypeName(){
        return "pdd.goods.information.get";
    }

    public function getApiParas(){
        return $this->apiParas;
    }

    public function check(){
		if (!isset($this->apiParas['goodsId'])) {
            $errMsg = 'not exists param : goodsId';
            throw new Exception($errMsg,0);
        }
    }

    private $goodsId;

    public function setGoodsId($goodsId){
        $this->goodsId = $goodsId;
        $this->apiParas["goodsId"] = $goodsId;
    }

    public function getGoodsId(){
        return $this->goodsId;
    }

}