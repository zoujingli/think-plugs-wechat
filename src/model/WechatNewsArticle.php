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
 * 微信图文详细模型
 *
 * @property int $id
 * @property int $read_num 阅读数量
 * @property int $show_cover_pic 显示封面(0不显示,1显示)
 * @property string $author 文章作者
 * @property string $content 图文内容
 * @property string $content_source_url 原文地址
 * @property string $create_at 创建时间
 * @property string $digest 摘要内容
 * @property string $local_url 永久素材URL
 * @property string $title 素材标题
 * @class WechatNewsArticle
 * @package app\wechat\model
 */
class WechatNewsArticle extends Model
{
}