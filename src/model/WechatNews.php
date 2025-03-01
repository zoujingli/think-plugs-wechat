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
 * 微信图文主模型
 *
 * @property int $create_by 创建人
 * @property int $id
 * @property int $is_deleted 删除状态(0未删除,1已删除)
 * @property string $article_id 关联图文ID(用英文逗号做分割)
 * @property string $create_at 创建时间
 * @property string $local_url 永久素材外网URL
 * @property string $media_id 永久素材MediaID
 * @class WechatNews
 * @package app\wechat\model
 */
class WechatNews extends Model
{
}