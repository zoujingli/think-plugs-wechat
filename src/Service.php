<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2022 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免费声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\wechat;

use app\wechat\command\Auto;
use app\wechat\command\Fans;
use app\wechat\service\AutoService;

/**
 * 组件注册服务
 * Class Service
 * @package app\wechat
 */
class Service extends \think\Service
{
    /**
     * 指定版本号
     * @var string
     */
    const VERSION = '0.0.1';

    /**
     * 配置组件服务
     * @return void
     */
    public function boot(): void
    {
        $attr = explode('\\', __NAMESPACE__);
        $addons = $this->app->config->get('app.addons', []);
        $addons[array_pop($attr)] = __DIR__ . DIRECTORY_SEPARATOR . '@' . join('\\', $attr);
        $this->app->config->set(['addons' => $addons], 'app');
    }

    /**
     * 注册组件服务
     * @return void
     */
    public function register(): void
    {
        // 注册模块指令
        $this->commands([Fans::class, Auto::class]);

        // 注册粉丝关注事件
        $this->app->event->listen('WechatFansSubscribe', function ($openid) {
            AutoService::register($openid);
        });
    }
}