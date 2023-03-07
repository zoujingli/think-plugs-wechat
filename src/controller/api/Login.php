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

namespace app\wechat\controller\api;

use app\wechat\service\LoginService;
use think\admin\Controller;

/**
 * 微信扫码登录
 * Class Login
 * @package app\wechat\controller\api
 */
class Login extends Controller
{
    /**
     * 扫描显示二维码
     * @return void
     */
    public function qrc()
    {
        $code = LoginService::gcode();
        $mode = intval(input('mode', '0'));
        $image = LoginService::qrcode($code, $mode)->getDataUri();
        $this->success('生成登录二维码', ['code' => $code, 'image' => $image]);
    }

    /**
     * 微信授权结果处理
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function oauth()
    {
        $data = $this->_vali(['code.default' => '', 'mode.default' => '0']);
        if (LoginService::oauth($data['code'], intval($data['mode']))) {
            $this->fetch('success', ['message' => '授权成功']);
        } else {
            $this->fetch('failed', ['message' => '授权失败']);
        }
    }

    /**
     * 获取授权信息
     * 用定时器请求这个接口
     * @throws \think\exception\HttpResponseException
     */
    public function query()
    {
        $code = input('code', '');
        if ($fans = LoginService::query($code)) {
            $this->success('获取授权信息', (object)$fans);
        } else {
            $this->error("授权CODE不能为空！");
        }
    }
}