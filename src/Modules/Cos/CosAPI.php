<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/7/4
 * Time: 下午2:11
 */

namespace FCode\QQCloud\Modules\Cos;

use FCode\QQCloud\Exception\QQException;
use FCode\QQCloud\Modules\QCloudApi;
use FCode\QQCloud\Sign\HmacSign;

class CosAPI extends QCloudApi
{
    const RESPONSE_XML = 'xml';
    const RESPONSE_JSON = 'json';
    
    protected $serverHost = '';
    
    protected $appId;
    
    protected $responseType = self::RESPONSE_XML;
    
    protected $buckets = [];
    
    protected $regionMap = [
        'sh' => 'ap-shanghai',
    ];
    
    protected function init()
    {
        parent::init();
        if (!isset(self::$config['cos'])) {
            throw new QQException("Cos must config cos module");
        }
//        $this->buckets = self::$config['cos']['bucket_domain'];
        $this->appId = self::$config['app_id'];
    }
    
    protected function sendCosRequest($params)
    {
        $now = time();
        $signTime = ($now-60).';'.($now+3600);
        $headers = [
            'Host' => $this->serverHost
        ];
        $signAlgorithm = HmacSign::SHA1;
        $signer = new HmacSign($signAlgorithm);
        $tmpString = $signer->generateCosSignString($this->serverUri,$this->requestMethod, $params, $headers);
        $signature = $signer->cosSign($tmpString, $signTime, $signAlgorithm);
        $authParams = [
            'q-sign-algorithm' => $signAlgorithm,
            'q-ak' => $this->secretId,
            'q-sign-time' => $signTime,
            'q-key-time' => $signTime,
            'q-header-list' => 'host',
            'q-url-param-list' => '',
            'q-signature' => $signature
        ];
        $authorization = '';
        foreach ($authParams as $k => $v) {
            $authorization .=$k.'='.$v.'&';
        }
        $headers['Authorization'] = substr($authorization, 0 ,-1);
        $url = $this->getFullApi();
        $response = $this->httpClient->send($url, $this->requestMethod, $params, $headers);
        return $response;
    }
    
    protected function getParamsList($params)
    {
        if (empty($params)) {
            return '';
        }
        $lowerKeys = [];
        foreach ($params as $key=>$value) {
            $lowerKeys[] = strtolower($key);
        }
        return implode(';', $lowerKeys);
    }
    
    protected function getBucketHost($bucket)
    {
        $region = $this->region;
        if ($this->responseType == self::RESPONSE_JSON) {
            $hostFormat = '%s-%s.cos%s.myqcloud.com';
        }else {
            $hostFormat = '%s-%s.cos.%s.myqcloud.com';
            $region = isset($this->regionMap[$region]) ? $this->regionMap[$region] : $region;
        }
        return sprintf($hostFormat, $bucket, $this->appId, $region);
    }
}