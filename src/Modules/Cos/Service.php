<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/7/4
 * Time: 下午2:30
 */

namespace FCode\QQCloud\Modules\Cos;


use FCode\QQCloud\Utils\RequestClient;

class Service extends CosAPI
{
    protected $serverHost = 'service.cos.myqcloud.com';
    
    protected $serverUri = '/';
    
    public function getServices()
    {
        $this->requestMethod = RequestClient::GET_REQUEST;
        $this->serverUri = '/';
        $params = [];
        $result = $this->sendCosRequest($params);
        return $result;
    }
}