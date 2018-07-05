<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/7/3
 * Time: 下午4:34
 */

$loader = require __DIR__.'/../vendor/autoload.php';
$config = require __DIR__.'/../config/config.php';

$sts = new \FCode\QQCloud\Modules\Cam\Sts($config);
$params = [
    //qcs::cam::uin/12345678:role/4611686018427397919
    //qcs::cam::uin/12345678:roleName/testRoleName
//    qcs::cam::uin/12345678:role/4611686018427397919
    'roleArn' => 'qcs::cam::uin/787700316:role/4611686018427418046',
    'roleSessionName' => 'abc',
];

//$result = $sts->assumeRoleAPI($params['roleArn'], $params['roleSessionName']);
//print_r($result);

//获得
$policy = [
    "statement" => [
        [
            "action" => ["name/vod:*"],
            "effect" => "allow",
            "resource" => "*"
        ]
    ],
    "version"=>"2.0"
];
$result = $sts->getFederationTokenAPI('test', json_encode($policy));
print_r($result);
