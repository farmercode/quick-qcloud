<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/7/2
 * Time: 下午5:30
 */
$loader = require __DIR__.'/../vendor/autoload.php';
$config = require __DIR__.'/../config/config.php';
var_dump(class_exists(\FCode\QQCloud\Modules\Vod::class));
$vodHandler = new \FCode\QQCloud\Modules\Vod($config);
$params = [
    'videoType' => 'mp4'
];
$result = $vodHandler->applyUpload($params);
var_dump($result);