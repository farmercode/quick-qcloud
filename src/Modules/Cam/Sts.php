<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/7/3
 * Time: 下午2:26
 */

namespace FCode\QQCloud\Modules\Cam;

use FCode\QQCloud\Modules\QCloudApi;

/**
 * Class Sts
 * @package FCode\QQCloud\Modules\Cam
 * @method array assumeRole($params)
 * @method array getFederationToken($params)
 * @see https://cloud.tencent.com/document/product/598/13876
 */
class Sts extends QCloudApi
{
    protected $serverHost = 'sts.api.qcloud.com';
    
    /**
     * 用于获取角色的临时访问凭证
     * @param string $roleArn 角色的资源描述
     * @param string $roleSessionName 临时会话名称
     * @param integer $durationSeconds 指定临时证书的有效期，单位：秒，默认 1800 秒，最长可设定有效期为 7200 秒
     * @see https://cloud.tencent.com/document/product/598/13895
     *
     * @return array
     */
    public function assumeRoleAPI($roleArn, $roleSessionName, $durationSeconds = 1800)
    {
        $params = [
            'Action' => 'AssumeRole',
            'roleArn' => $roleArn,
            'roleSessionName' => $roleSessionName,
            'durationSeconds' => $durationSeconds
        ];
        $result = $this->sendRequest($params);
        return $result;
    }
    
    /**
     * 获取联合身份临时访问凭证
     * @param string $name 联合身份用户昵称
     * @param string $policy 策略描述。注意：1、不能包含空格和换行；2、策略语法参照 CAM策略语法；3、策略中不能包含 principal 元素
     * @param int $durationSeconds 指定临时证书的有效期，单位：秒
     *
     * @return string
     * @see https://cloud.tencent.com/document/product/598/13896
     */
    public function getFederationTokenAPI($name, $policy, $durationSeconds = 1800)
    {
        $params = [
            'Action' => 'GetFederationToken',
            'name' => $name,
            'policy' => $policy,
            'durationSeconds' => $durationSeconds
        ];
        return $this->sendRequest($params);
    }
}