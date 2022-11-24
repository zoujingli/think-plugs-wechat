<?php

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
        $addons = $this->app->config->get('app.addons', []);
        $addons['wechat'] = __DIR__ . DIRECTORY_SEPARATOR;
        $this->app->config->set(['addons' => $addons], 'app');
    }

    /**
     * 注册组件服务
     * @return void
     */
    public function register(): void
    {
        // 注册模块指令
        $this->app->console->addCommands([Fans::class, Auto::class]);

        // 注册粉丝关注事件
        $this->app->event->listen('WechatFansSubscribe', function ($openid) {
            AutoService::register($openid);
        });
    }
}