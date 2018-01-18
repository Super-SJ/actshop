<?php
require 'JSON.php';
require 'PddError.php';

/**
 * Class PddClient
 */
class PddClient {
    /**
     * @var string
     */
    public $serverUrl = "http://open.yangkeduo.com/api/router";

    /**
     * @var
     */
    public $accessToken = '';

    /**
     * @var
     */
    public $clientId = '';

    /**
     * 商家自主接入为拼多多后台设置的secret
     * 服务商接入的为服务商的client_secret
     * @var
     */
    public $clientSecret = '';

    /**
     * @var
     */
    public $mallId = 0;

    /**
     * @var int
     */
    public $connectTimeout = 30;

    /**
     * @var int
     */
    public $readTimeout = 30;

    /**
     * @var string
     */
    public $version = "V1";

    /**
     * @var string
     */
    public $dataType = "JSON";

    /**
     * @var string
     * 是否打开入参check
     **/
    public $checkRequest = true;


    /**
     * @param $params
     * @return string
     */
    protected function generateSign($params)
    {
        ksort($params);
        $stringToBeSigned = $this->clientSecret;
        foreach ($params as $k => $v)
        {
            if("@" != substr($v, 0, 1))
            {
                $stringToBeSigned .= "$k$v";
            }
        }
        unset($k, $v);
        $stringToBeSigned .= $this->clientSecret;
        return strtoupper(md5($stringToBeSigned));
    }

    /**
     * @param $url
     * @param null $postFields
     * @param bool $setCT
     * @return mixed
     * @throws Exception
     */
    protected function curl($url, $postFields = null, $setCT = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        if ($setCT) {
            curl_setopt($ch,CURLOPT_HTTPHEADER,["content-type: application/x-www-form-urlencoded; charset=UTF-8"]);
        }

        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($this->readTimeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->readTimeout);
        }
        if ($this->connectTimeout) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        }
        //https 请求
        if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        if (is_array($postFields) && 0 < count($postFields))
        {
            $postBodyString = "";
            $postMultipart = false;
            foreach ($postFields as $k => $v)
            {
                if("@" != substr($v, 0, 1) || !is_file(substr($v,1)))//判断是不是文件上传
                {
                    $postBodyString .= "$k=" . urlencode($v) . "&";
                }
                else//文件上传用multipart/form-data，否则用www-form-urlencoded
                {
                    $postMultipart = true;
                }
            }
            unset($k, $v);
            curl_setopt($ch, CURLOPT_POST, true);
            if ($postMultipart)
            {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            }
            else
            {
                curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
            }
        }
        $reponse = curl_exec($ch);

        if (curl_errno($ch))
        {
            throw new Exception(curl_error($ch),0);
        }
        else
        {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 !== $httpStatusCode)
            {
                throw new Exception($reponse,$httpStatusCode);
            }
        }
        curl_close($ch);
        return $reponse;
    }

    /**
     * @param $request
     * @return mixed|SimpleXMLElement
     */
    public function execute($request)
    {
        $result = new PddError ();
        if($this->checkRequest) {
            try {
                $request->check();
            } catch (Exception $e) {
                $result->error_code = $e->getCode();
                $result->error_msg = $e->getMessage();
                return $result;
            }
        }
        //获取业务参数
        $params = $request->getApiParas();
        //组装系统参数
        if ('' !== $this->clientId) {
            $params["client_id"] = $this->clientId;
        }

        if ('' !== $this->accessToken)
        {
            $params["access_token"] = $this->accessToken;
        }

        if (0 !== $this->mallId)
        {
            $params["mall_id"] = $this->mallId;
        }

        $params["version"] = $this->version;
        $params["type"] = $request->getApiTypeName();
        $params["data_type"] = $this->dataType;
        $params["timestamp"] = time();

        //签名
        $params["sign"] = $this->generateSign($params);
        //发起HTTP请求
        //发起HTTP请求
        try
        {
            $resp = $this->curl($this->serverUrl, $params);
        }
        catch (Exception $e)
        {
            $result->error_code = $e->getCode();
            $result->error_msg = $e->getMessage();
            return $result;
        }

        //解析接口返回结果
        $respWellFormed = false;
        if ("JSON" == $this->dataType)
        {
            $jsonService = new Services_JSON(SERVICES_JSON_IN_OBJ);
            $respObject = $jsonService->decode($resp);
            if (null !== $respObject)
            {
                $respWellFormed = true;
                foreach ($respObject as $propKey => $propValue)
                {
                    $respObject = $propValue;
                }
            }
        }
        else if("XML" == $this->dataType)
        {
            $respObject = @simplexml_load_string($resp);
            if (false !== $respObject)
            {
                $respWellFormed = true;
            }
        }

        //返回的HTTP文本不是标准JSON或者XML
        if (false === $respWellFormed)
        {
            $result->error_code = 0;
            $result->error_msg = "HTTP_RESPONSE_NOT_WELL_FORMED:".$resp;
            return $result;
        }
        return $respObject;
    }
}