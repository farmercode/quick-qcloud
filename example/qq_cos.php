<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/7/5
 * Time: 上午10:28
 */
$loader = require __DIR__.'/../vendor/autoload.php';
$config = [
    'region' => 'sh',
    'credentials' => [
//        'appId' => '',
        'secretId' => 'xxxxxx',
        'secretKey' => 'xxxxx',
//        'token' => 'xxxx',
    ],
    'timeout' => 3600
];

$qcloudClient = new \Qcloud\Cos\Client($config);
$result = $qcloudClient->listBuckets();
print_r($result);
