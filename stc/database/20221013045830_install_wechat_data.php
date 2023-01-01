<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon<zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免费声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

use think\admin\extend\PhinxExtend;
use think\migration\Migrator;

/**
 * 微信初始化
 */
class InstallWechatData extends Migrator
{
    /**
     * 初始化数据
     * @return void
     */
    public function change()
    {
        set_time_limit(0);
        @ini_set('memory_limit', -1);

        $this->insertMenu();
    }

    /**
     * 初始化菜单
     */
    private function insertMenu()
    {
        // 写入微信菜单
        PhinxExtend::write2menu([
            [
                'name' => '微信管理',
                'sort' => '200',
                'subs' => [
                    [
                        'name' => '微信管理',
                        'subs' => [
                            ['name' => '微信接口配置', 'icon' => 'layui-icon layui-icon-set', 'node' => 'plugin-wechat/config/options'],
                            ['name' => '微信支付配置', 'icon' => 'layui-icon layui-icon-rmb', 'node' => 'plugin-wechat/config/payment'],
                        ],
                    ],
                    [
                        'name' => '微信定制',
                        'subs' => [
                            ['name' => '微信粉丝管理', 'icon' => 'layui-icon layui-icon-username', 'node' => 'plugin-wechat/fans/index'],
                            ['name' => '微信图文管理', 'icon' => 'layui-icon layui-icon-template-1', 'node' => 'plugin-wechat/news/index'],
                            ['name' => '微信菜单配置', 'icon' => 'layui-icon layui-icon-cellphone', 'node' => 'plugin-wechat/menu/index'],
                            ['name' => '回复规则管理', 'icon' => 'layui-icon layui-icon-engine', 'node' => 'plugin-wechat/keys/index'],
                            ['name' => '关注自动回复', 'icon' => 'layui-icon layui-icon-release', 'node' => 'plugin-wechat/auto/index'],
                        ],
                    ],
                ],
            ],
        ], ['node' => 'plugin-wechat/config/options']);
    }
}
