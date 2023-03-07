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

namespace app\wechat\service;

use Endroid\QrCode\Writer\Result\ResultInterface;
use think\admin\Library;

/**
 * 微信授权登录
 * @class LoginService
 * @package app\wechat\service
 */
class LoginService
{
    private const expire = 3600;
    private const prefix = 'wxlogin';

    /**
     * 生成登录编码
     * @param string $code
     * @return string
     */
    public static function gcode(string $code = ''): string
    {
        return self::prefix . ($code ?: md5(uniqid(strval(rand(0, 10000)), true)));
    }

    /**
     * 获取授权二维码对象
     * @param string $code 请求编号
     * @param integer $mode 授权模式
     * @return \Endroid\QrCode\Writer\Result\ResultInterface
     */
    public static function qrcode(string $code, int $mode = 0): ResultInterface
    {
        $data = ['code' => $code, 'mode' => $mode];
        $text = url('wechat/api.login/oauth', $data, false, true);
        return MediaService::getQrcode($text);
    }

    /**
     * 发起网页授权处理
     * @param string $code 请求编号
     * @param integer $mode 授权模式
     * @return bool
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function oauth(string $code, int $mode = 0): bool
    {
        if (stripos($code, self::prefix) === 0) {
            $fans = WechatService::getWebOauthInfo(Library::$sapp->request->url(true), $mode);
            if (isset($fans['openid'])) {
                $fans['token'] = md5(uniqid(strval(rand(0, 10000)), true));
                Library::$sapp->cache->set("wxlogin{$code}", $fans, self::expire);
                Library::$sapp->cache->set($fans['openid'], $fans['token'], self::expire);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 检查微信是否已授权
     * @param string $code 请求编号
     * @return false|mixed
     */
    public static function query(string $code)
    {
        if (stripos($code, self::prefix) === 0) {
            return Library::$sapp->cache->get("wxlogin{$code}", []);
        } else {
            return false;
        }
    }
}