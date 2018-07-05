<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/7/3
 * Time: 下午2:59
 */
$loader = require __DIR__.'/../vendor/autoload.php';
$config = require __DIR__.'/../config/config.php';

$camRole = new \FCode\QQCloud\Modules\Cam\Cam($config);

//策略语法参考 https://cloud.tencent.com/document/product/598/10604
//资源描述方式 https://cloud.tencent.com/document/product/598/10606
$roleName = 'cam_test_3';
$camRole->deleteRole(['roleName' => $roleName]);

$policyDocument = [
    "version" => "2.0",
    "statement" => [
        [
            "action" => ["name/sts:AssumeRole"],
            "resource" => "*",
            "effect" => "allow",
            "principal" => [
                "qcs" => [
//                    "qcs::cam::uin/787700316:uin/787700316"
                    "qcs::cam::uin/787700316:root"
                ]
            ]
        ]
    ],
];
//$json = '{ "version": "2.0", "statement": [ { "action": [ "cos:*" ], "resource": "*", "effect": "allow" }, { "effect": "allow", "action": [ "monitor:*", "cam:ListUsersForGroup", "cam:ListGroups", "cam:GetGroup" ], "resource": "*" } ] }';
$roleInfo = [
    'roleName' => $roleName,
    'description' => 'test',
    'policyDocument' => json_encode($policyDocument)
];
echo json_encode($policyDocument);
$result = $camRole->createRole($roleInfo);
print_r($result);
exit();

$policyToRole = [
    'policyName' => 'QcloudCOSFullAccess',
    'roleName' => 'cam_test_3'
];
$result = $camRole->attachRolePolicy($policyToRole);
print_r($result);

$roleListParams = [
    'page' => 1,
    'rp' => 20
];
$result = $camRole->describeRoleList($roleListParams);
print_r($result);

$params = [
    'roleName' => 'cam_test',
    'page' => 1,
    'rp' => 20
];
$roleAllPolicies = $rolePolicies = $camRole->listAttachedRolePolicies($params);
print_r($roleAllPolicies);
