<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/7/5
 * Time: 上午11:02
 */

namespace FCode\QQCloud\Modules\Cos;


use FCode\QQCloud\Utils\RequestClient;

class Bucket extends CosAPI
{
//    protected $responseType = self::RESPONSE_JSON;
    
    protected $serverUri = '/';
    
    public function createBucket($name)
    {
        $this->serverHost = $this->getBucketHost($name);
        $params = [];
        $this->requestMethod = RequestClient::PUT_REQUEST;
        $result = $this->sendCosRequest($params);
        return $result;
    }
}