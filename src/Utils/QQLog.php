<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/6/29
 * Time: 下午5:40
 */

namespace FCode\QQCloud\Utils;


use FCode\QQCloud\Exception\QQException;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

/**
 * Class QQLog
 * @package Fcode\QQCloud\Utils
 * @method void info($message, array $context = [])
 * @method void error($message, array $context = [])
 * @method void log($message, array $context = [])
 * @method void debug($message, array $context = [])
 * @method void notice($message, array $context = [])
 * @method void critical($message, array $context = [])
 * @method void alert($message, array $context = [])
 * @method void emergency($message, array $context = [])
 * @method void warn($message, array $context = [])
 */
class QQLog
{
    const DEFAULT_LOGGER_NAME = 'qqc';
    
    const MAX_FILES = 50;
    
    protected $config;
    
    protected $logger;
    
    public function __construct($config)
    {
        $this->config = $config;
        $this->init();
    }
    
    protected function init()
    {
        if (!isset($this->config['name'])) {
            $this->config['name'] = self::DEFAULT_LOGGER_NAME;
        }
        if (!isset($this->config['max'])) {
            $this->config['max'] = self::MAX_FILES;
        }
        $this->logger = new Logger($this->config['name']);
        $pushHandler = new RotatingFileHandler($this->getLogPath(), $this->config['max']);
        $this->logger->pushHandler($pushHandler);
    }
    
    protected function getLogPath()
    {
        return sprintf('%s/%s.log', $this->config['path'], $this->config['name']);
    }
    
    public function __call($name, $arguments)
    {
        switch ($name) {
            case 'info':
            case 'error':
            case 'log':
            case 'debug':
            case 'notice':
            case 'critical':
            case 'alert':
            case 'emergency':
                $result = call_user_func_array([$this->logger, $name], $arguments);
                break;
            case 'warn':
                $result = call_user_func_array([$this->logger, 'warn'], $arguments);
                break;
            default :
                throw new QQException('do not support this log method :'.$name);
                break;
        }
        return $result;
    }
}