<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 2018/7/2
 * Time: 下午3:26
 */

namespace FCode\QQCloud\Modules;

/**
 * 视频云模块
 * 支持视频所有API接口，具体请查看官方文档
 *
 * Class Vod
 * @package Fcode\QQCloud\Modules
 * @method string applyUpload($params = []) 发起视频文件的上传
 * @method string commitUpload($params = []) 确认视频文件
 * @method string multiPullVodFile($params = []) 通过用户传递的 URL
 * @link https://cloud.tencent.com/document/product/266/7788
 */
class Vod extends QCloudApi
{
    protected $serverHost = 'vod.api.qcloud.com';
    
}