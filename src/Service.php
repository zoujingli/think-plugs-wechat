<?php

// +----------------------------------------------------------------------
// | Wechat for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2022 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免费声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

namespace plugin\wechat;

use plugin\wechat\command\Auto;
use plugin\wechat\command\Fans;
use plugin\wechat\service\AutoService;
use think\admin\Plugin;

/**
 * 组件注册服务
 * Class Service
 * @package plugin\wechat
 */
class Service extends Plugin
{
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

    /**
     * 增加微信配置
     * @return array[]
     */
    public static function menu(): array
    {
        return [
            [
                'name' => '微信管理',
                'subs' => [
                    ['name' => '微信接口配置', 'icon' => 'layui-icon layui-icon-set', 'node' => 'wechat/config/options'],
                    ['name' => '微信支付配置', 'icon' => 'layui-icon layui-icon-set', 'node' => 'wechat/config/options'],
                ]
            ],
            [
                'name' => '微信定制',
                'subs' => [
                    ['name' => '微信粉丝管理', 'icon' => 'layui-icon layui-icon-username', 'node' => 'wechat/fans/index'],
                    ['name' => '微信图文管理', 'icon' => 'layui-icon layui-icon-template-1', 'node' => 'wechat/news/index'],
                    ['name' => '微信菜单配置', 'icon' => 'layui-icon layui-icon-cellphone', 'node' => 'wechat/menu/index'],
                    ['name' => '回复规则管理', 'icon' => 'layui-icon layui-icon-engine', 'node' => 'wechat/keys/index'],
                    ['name' => '关注自动回复', 'icon' => 'layui-icon layui-icon-release', 'node' => 'wechat/auto/index'],
                ]
            ]
        ];
    }
}