<?php

include 'PddClient.php';

include 'request/RefundListIncrementGetRequest.php';
include 'request/GoodsListGetRequest.php';
include 'request/OrderNumberListIncrGetRequest.php';
include 'request/LogisticsCompaniesGetRequest.php';
include 'request/OrderInformationGetRequest.php';
include 'request/RefundStatusCheckRequest.php';
include 'request/LogisticsOnlineSendRequest.php';
include 'request/OrderNumberListGetRequest.php';
include 'request/OrderStatusGetRequest.php';
include 'request/GoodsSkuStockGetRequest.php';
include 'request/GoodsSkuStockUpdateRequest.php';
include 'request/GoodsSkuStockIncrUpdateRequest.php';
include 'request/GoodsInfoGetRequest.php';


class PddTest {

    public $pddClient;

    function __construct($params)
    {
        $pddClient = new PddClient();
        $pddClient->mallId = $params['mallId'];
        $pddClient->serverUrl = 'http://open.yangkeduo.com/api/router';
        $pddClient->clientSecret = $params['clientSecret'];
        $pddClient->dataType = 'JSON';
        $this->pddClient = $pddClient;
    }

    public  function refundListIncrementGetTest ()
    {
        $refundListIncrementGetRequest = new RefundListIncrementGetRequest();
        $refundListIncrementGetRequest->setAfterSalesType(1);
        $refundListIncrementGetRequest->setAfterSalesStatus(1);
        $refundListIncrementGetRequest->setStartUpdatedAt(1469980800);
        $refundListIncrementGetRequest->setEndUpdatedAt(1472659200);
        return $this->pddClient->execute($refundListIncrementGetRequest);
    }

    public  function goodsListGetTest ()
    {
        $goodListGetRequest = new GoodsListGetRequest();
        $goodListGetRequest->setGoodsName('乐事薯片');
        $goodListGetRequest->setOuterId(111111);
        $goodListGetRequest->setIsOnsale(0);
        return $this->pddClient->execute($goodListGetRequest);
    }

    public function orderNumberListIncrGetTest ()
    {
        $request = new OrderNumberListIncrGetRequest();
        $request->setOrderStatus(5);
        $request->setRefundStatus(5);
        $request->setIsLuckyFlag(1);
        $request->setStartUpdatedAt(1507219200);
        $request->setEndUpdatedAt(1507554206);
        return $this->pddClient->execute($request);
    }

    public function logisticsCompaniesGetTest()
    {
        $request = new LogisticsCompaniesGetRequest();
        return $this->pddClient->execute($request);
    }

    public function orderInformationGetTest ($order_id)
    {
        $request = new OrderInformationGetRequest();
        $request->setOrderSn($order_id);
        return $this->pddClient->execute($request);
    }

    public  function refundStatusCheckTest ()
    {
        $request = new RefundStatusCheckRequest();
        $request->setOrderSns('20150909-452750051,20150909-452750134');
        return $this->pddClient->execute($request);
    }

    public function logisticsOnlineSendTest ($logistics_id,$order_sn,$track_number)
    {
        $request = new LogisticsOnlineSendRequest();
        $request->setLogisticsId($logistics_id);
        $request->setOrderSn($order_sn);
        $request->setTrackingNumber($track_number);
        return $this->pddClient->execute($request);
    }

    public function orderNumberListGetTest ()
    {
        $request = new OrderNumberListGetRequest();
        $request->setOrderStatus(1);
        return $this->pddClient->execute($request);
    }

    public function orderStatusGetTest ()
    {
        $request = new OrderStatusGetRequest();
        $request->setOrderSns('20150909-452750051,20150909-452750134');
        return $this->pddClient->execute($request);
    }

    public function goodsSkuStockGetTest ()
    {
        $request = new GoodsSkuStockGetRequest();
        $request->setSkuIds('879512');
        return $this->pddClient->execute($request);
    }

    public  function goodsSkuStockUpdateTest ()
    {
        $request = new GoodsSkuStockUpdateRequest();
        $request->setSkuId('879512');
        $request->setQuantity('12');
        return $this->pddClient->execute($request);
    }

    public function goodsSkuStockIncrUpdateTest ()
    {
        $request = new GoodsSkuStockIncrUpdateRequest();
        $request->setSkuId('879512');
        $request->setIncrementQuantity('12');
        return $this->pddClient->execute($request);
    }
	 public function goodsInfoGetTest ()
    {
        $request = new GoodsInfoGetRequest();
        $request->getGoodsId('879512');
        return $this->pddClient->execute($request);
    }
}