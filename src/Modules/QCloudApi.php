<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/7/2
 * Time: 下午1:58
 */

namespace FCode\QQCloud\Modules;

use FCode\QQCloud\Exception\QQException;
use FCode\QQCloud\Factory\SignFactory;
use FCode\QQCloud\Sign\HmacSign;
use FCode\QQCloud\Utils\QQLog;
use FCode\QQCloud\Utils\RequestClient;

class QCloudApi
{
    const SDK_VERSION = 'quick_qclound_1.0';
    
    public static $logger;
    
    /**
     * @var RequestClient
     */
    protected $httpClient;
    
    protected static $config;
    
    protected $serverHost = '';
    
    protected $serverUri  = '/v2/index.php';
    
    protected $requestMethod = 'POST';
    
    protected $secretId;
    
    protected $secretKey;
    
    protected $region;
    
    protected $allowActions = [];
    
    protected $signType = HmacSign::SHA1;
    
    public function __construct($config)
    {
        self::$config = $config;
        $this->init();
    }
    
    protected function init()
    {
        self::$logger = new QQLog(self::$config['log']);
        $this->httpClient = new RequestClient();
        if (!isset(self::$config['secret_id']) || empty(self::$config['secret_id'])) {
            throw new QQException('quick qclound must config secret id');
        }
        $this->secretId = self::$config['secret_id'];
        if (!isset(self::$config['secret_key']) || empty(self::$config['secret_key'])) {
            throw new QQException('quick qclound must config secret key');
        }
        $this->secretKey = self::$config['secret_key'];
        if (!isset(self::$config['region']) || empty(self::$config['region'])) {
            throw new QQException('quick qclound must config region');
        }
        $this->region = self::$config['region'];
    }
    
    public static function config()
    {
        return self::$config;
    }
    
    public static function debug($model = null)
    {
        if ($model === null) {
            return isset(self::$config['debug'])? self::$config['debug'] : false;
        }else {
            self::$config['debug'] = $model;
        }
        return true;
    }
    
    /**
     * @return QQLog
     */
    public static function logger()
    {
        return self::$logger;
    }
    
    protected function sendRequest($params)
    {
        $params['SecretId'] = isset($params['SecretId'])? $params['SecretId'] : $this->secretId;
        $params['Timestamp'] = isset($params['Timestamp'])? $params['Timestamp'] : time();
        $params['Nonce'] = isset($params['Nonce'])? $params['Nonce'] : rand(1, 65535);
        $params['RequestClient'] = self::SDK_VERSION;
        $params['Region'] = $this->region;
        
        if (isset($params['SignatureMethod'])) {
            $this->signType = $params['SignatureMethod'];
        }else {
            $params['SignatureMethod'] = $this->signType;
        }
        self::logger()->debug('before sign params,', $params);
        
        $apiUrl = $this->getFullApi();
        
        //签名
        $signer = new HmacSign($this->signType);
        $signString = $signer->generateSignString($this->serverHost.$this->serverUri, $this->requestMethod, $params);
        self::logger()->debug('sign string :'.$signString);
        
        $params['Signature'] = $signer->sign($signString);
        self::logger()->debug('after sign params,', $params);
        
        if ($this->requestMethod == 'POST') {
            $result = $this->httpClient->post($apiUrl, $params);
        }else {
            $result = $this->httpClient->get($apiUrl, $params);
        }
        return $result;
    }
    
    protected function getFullApi()
    {
        return sprintf("https://%s%s", $this->serverHost, $this->serverUri);
    }
    
    public function __call($name, $arguments)
    {
        $params = current($arguments);
        $params['Action'] = ucfirst($name);
        $result = $this->sendRequest($params);
        return $result;
    }
}