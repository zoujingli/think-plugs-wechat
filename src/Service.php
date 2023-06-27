<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// | github 代码仓库：https://github.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

namespace app\wechat;

use app\wechat\command\Auto;
use app\wechat\command\Fans;
use app\wechat\service\AutoService;
use app\wechat\service\PaymentService;
use think\admin\extend\CodeExtend;
use think\admin\Plugin;
use think\Request;

/**
 * 组件注册服务
 * @class Service
 * @package app\wechat
 */
class Service extends Plugin
{
    /**
     * 定义插件名称
     * @var string
     */
    protected $appName = '微信管理';

    /**
     * 定义安装包名
     * @var string
     */
    protected $package = 'zoujingli/think-plugs-wechat';

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

        // 注册支付通知路由
        $this->app->route->any('/plugin-wxpay-notify/:vars', function (Request $request) {
            try {
                $data = json_decode(CodeExtend::deSafe64($request->param('vars')), true);
                return PaymentService::notify($data);
            } catch (\Exception|\Error $exception) {
                return 'Error: ' . $exception->getMessage();
            }
        });
    }

    /**
     * 增加微信配置
     * @return array[]
     */
    public static function menu(): array
    {
        // 设置插件菜单
        return [
            [
                'name' => '微信管理',
                'subs' => [
                    ['name' => '微信接口配置', 'icon' => 'layui-icon layui-icon-set', 'node' => "wechat/config/options"],
                    ['name' => '微信支付配置', 'icon' => 'layui-icon layui-icon-rmb', 'node' => "wechat/config/payment"],
                ],
            ],
            [
                'name' => '微信定制',
                'subs' => [
                    ['name' => '微信粉丝管理', 'icon' => 'layui-icon layui-icon-username', 'node' => "wechat/fans/index"],
                    ['name' => '微信图文管理', 'icon' => 'layui-icon layui-icon-template-1', 'node' => "wechat/news/index"],
                    ['name' => '微信菜单配置', 'icon' => 'layui-icon layui-icon-cellphone', 'node' => "wechat/menu/index"],
                    ['name' => '回复规则管理', 'icon' => 'layui-icon layui-icon-engine', 'node' => "wechat/keys/index"],
                    ['name' => '关注自动回复', 'icon' => 'layui-icon layui-icon-release', 'node' => "wechat/auto/index"],
                ],
            ],
            [
                'name' => '微信支付',
                'subs' => [
                    ['name' => '微信支付行为', 'icon' => 'layui-icon layui-icon-username', 'node' => "wechat/payment.record/index"],
                    ['name' => '微信退款管理', 'icon' => 'layui-icon layui-icon-template-1', 'node' => "wechat/payment.refund/index"],
                ]
            ]
        ];
    }
}