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
        'secretId' => 'AKIDvUwddW0DqKgtQtCHjGgw0sa9bsxomlgE',
        'secretKey' => 'cVIetwmFXdgaMvJYg4JQL5c4ubAXijYb',
//        'token' => 'be8683cbd5e92141a5fb989690a935af14ab4bc530001',
    ],
    'timeout' => 3600
];

$qcloudClient = new \Qcloud\Cos\Client($config);
$result = $qcloudClient->listBuckets();
print_r($result);
