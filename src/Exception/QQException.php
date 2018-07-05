<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/6/29
 * Time: 下午6:00
 */

namespace FCode\QQCloud\Exception;


class QQException extends \Exception
{
    public function __construct($message = "", $code = 0)
    {
        parent::__construct($message, $code, null);
    }
}