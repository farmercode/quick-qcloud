<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/7/4
 * Time: 下午5:47
 */

$loader = require __DIR__.'/../vendor/autoload.php';
$config = require __DIR__.'/../config/config.php';

$cosService = new \FCode\QQCloud\Modules\Cos\Service($config);
//$list = $cosService->getServices();
//print_r($list);

$bucket = new \FCode\QQCloud\Modules\Cos\Bucket($config);
$result = $bucket->createBucket('king2');
print_r($result);