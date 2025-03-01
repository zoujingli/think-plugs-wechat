<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2025 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// | github 代码仓库：https://github.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace app\wechat\model;

use think\admin\Model;

/**
 * 微信媒体文件模型
 *
 * @property int $id
 * @property string $appid 公众号ID
 * @property string $create_at 创建时间
 * @property string $local_url 本地文件链接
 * @property string $md5 文件哈希
 * @property string $media_id 永久素材MediaID
 * @property string $media_url 远程图片链接
 * @property string $type 媒体类型
 * @class WechatMedia
 * @package app\wechat\model
 */
class WechatMedia extends Model
{
}