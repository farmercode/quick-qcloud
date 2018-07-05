<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/7/3
 * Time: 上午9:27
 */

namespace FCode\QQCloud\Sign;


use FCode\QQCloud\Modules\QCloudApi;

class HmacSign
{
    const SHA1 = 'sha1';
    
    const SHA256 = 'sha256';
    
    protected $secretKey;
    
    protected $secretId;
    
    protected $signType;
    
    public function __construct($type = self::SHA1)
    {
        $config = QCloudApi::config();
        $this->secretKey = $config['secret_key'];
        $this->secretId = $config['secret_id'];
        $this->signType = $type;
    }
    
    public function sign($srcStr, $secretKey = '')
    {
        if (empty($secretKey)){
            $secretKey = $this->secretKey;
        }
        $retStr = base64_encode(hash_hmac($this->signType, $srcStr, $secretKey, true));
        return $retStr;
    }
    
    public function cosSign($srcStr, $signTime, $algorithm = self::SHA1, $secretKey = '')
    {
        if (empty($secretKey)){
            $secretKey = $this->secretKey;
        }
        
        $signKey = hash_hmac('sha1', $signTime, $secretKey);
        $sha1edString = sha1($srcStr);
        $string2Sign = sprintf("%s\n%s\n%s\n", $algorithm, $signTime, $sha1edString);
        return hash_hmac('sha1', $string2Sign, $signKey);
    }
    
    public function generateSignString($requestUrl, $requestMethod, $params)
    {
        $dataString = '';
        ksort($params);
        foreach ($params as $key => $value) {
            if (strpos($key, '_') !== false) {
                $key = str_replace('_', '.', $key);
            }
            $dataString .=$key.'='.$value.'&';
        }
        $dataString = substr($dataString, 0, -1);
        $plainString = sprintf('%s%s?%s', $requestMethod, $requestUrl, $dataString);
        return $plainString;
    }
    
    public function generateCosSignString($requestUrl, $requestMethod, $host)
    {
        $requestMethod = strtolower($requestMethod);
        $headerString = 'host='.$host;
        
        return sprintf('%s\n%s\n\n%s\n', $requestMethod, $requestUrl, $headerString);
    }
}