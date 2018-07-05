<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/7/3
 * Time: 下午2:55
 */

namespace FCode\QQCloud\Modules\Cam;


use FCode\QQCloud\Modules\QCloudApi;

/**
 * CAM角色相关模块
 * @package FCode\QQCloud\Modules\Cam
 * @method array createRole($params) 创建角色
 * @method array getRole($params) 获取角色信息
 * @method array describeRoleList($params) 获取角色列表
 * @method array attachRolePolicy($params) 绑定策略到角色
 * @method array detachRolePolicy($params) 解绑角色的策略
 * @method array updateRoleDescription($params) 修改角色描述
 * @method array updateAssumeRolePolicy($params) 修改角色信任策略
 * @method array deleteRole($params) 删除角色
 * @method array listAttachedRolePolicies($params) 获取角色绑定的策略列表
 * @see https://cloud.tencent.com/document/product/598/13876
 */
class Cam extends QCloudApi
{
    protected $serverHost = 'cam.api.qcloud.com';
}