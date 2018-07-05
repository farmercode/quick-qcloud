<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/6/29
 * Time: 下午5:20
 */

namespace FCode\QQCloud\Utils;

use FCode\QQCloud\Modules\QCloudApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class RequestClient
{
    /**
     * 请求默认超时时间
     */
    const REQUEST_DEFAULT_TIMEOUT = 5.0;
    
    const POST_REQUEST = 'POST';
    
    const GET_REQUEST = 'GET';
    
    const PUT_REQUEST = 'PUT';
    
    const HEAD_REQUEST = 'HEAD';
    
    const DELETE_REQUEST = 'DELETE';
    
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;
    
    public function __construct($config = [])
    {
        if (!isset($config['timeout'])) {
            $config['timeout'] = self::REQUEST_DEFAULT_TIMEOUT;
        }
        $this->client = new Client($config);
    }
    
    public function send($url, $type=self::GET_REQUEST, $params = [], $headers =[])
    {
        $result = null;
        switch ($type) {
            case self::GET_REQUEST:
                $result = $this->get($url, $params, $headers);
                break;
            case self::HEAD_REQUEST:
                $result = $this->head($url, $params, $headers);
                break;
            case self::DELETE_REQUEST:
                $result = $this->delete($url, $params, $headers);
                break;
            case self::POST_REQUEST:
                $result = $this->post($url, $params, $headers);
                break;
            case self::PUT_REQUEST:
                $result = $this->put($url, $params, $headers);
                break;
            default:
                break;
        }
        return $result;
    }
    
    /**
     * GET请求
     * @param string $url
     * @param array $params
     * @param array $headers
     * @param array $options
     *
     * @return string
     */
    public function get($url, $params = [], $headers = [], $options = [])
    {
        if (!empty($params)) {
            $url .= strpos($url, '?') === false? '?' : '';
            $url .= http_build_query($params);
        }
        
        $request = new Request(self::GET_REQUEST, $url, $headers);
        return $this->sendRequest($request, $options);
    }
    
    /**
     * @param string $url
     * @param array|string $params
     * @param array  $headers
     * @param array $options
     *
     * @return string
     */
    public function post($url, $params = [], $headers = [], $options =  [])
    {
        $body = null;
        if (is_array($params)) {
            $headers['Content-Type']= 'application/x-www-form-urlencoded';
            $body = http_build_query($params);
        }else if(empty($params)){
            $body = null;
        }else {
            $body = $params;
        }
        $request = new Request(self::POST_REQUEST, $url, $headers, $body);
        return $this->sendRequest($request, $options);
    }
    
    public function put($url, $params = [], $headers = [], $options =  [])
    {
        if (is_array($params) && !empty($params)) {
            $headers['Content-Type']= 'application/x-www-form-urlencoded';
            $body = http_build_query($params);
        }else if(empty($params)) {
            $body = null;
        }else {
            $body = $params;
        }
        $request = new Request(self::PUT_REQUEST, $url, $headers, $body);
        return $this->sendRequest($request, $options);
    }
    
    public function head($url, $params = [], $headers = [], $options = [])
    {
        if (!empty($params)) {
            $url .= strpos($url, '?') === false? '?' : '';
            $url .= http_build_query($params);
        }
        $request = new Request(self::HEAD_REQUEST, $url, $headers);
        return $this->sendRequest($request, $options);
    }
    
    public function delete($url, $params = [], $headers = [], $options = [])
    {
        if (!empty($params)) {
            $url .= strpos($url, '?') === false? '?' : '';
            $url .= http_build_query($params);
        }
        $request = new Request(self::DELETE_REQUEST, $url, $headers);
        return $this->sendRequest($request, $options);
    }
    
    /**
     * @param Request $request
     * @param array $options
     *
     * @return mixed
     */
    public function sendRequest($request, $options = [])
    {
        if (QCloudApi::debug()) {
            $options['debug'] = true;
        }
        $response = $this->client->send($request, $options);
        $data = $response->getBody()->getContents();
    
        QCloudApi::logger()->debug('response content :' . $data);
        return json_decode($data, true);
    }
}