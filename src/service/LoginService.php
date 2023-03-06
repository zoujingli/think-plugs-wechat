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
use think\admin\Service;

/**
 * 微信授权登录
 * @class LoginService
 * @package app\wechat\service
 */
class LoginService extends Service
{
    private $expire = 3600;
    private $prefix = 'wxlogin';

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
    public function oauth(string $code, int $mode = 0): bool
    {
        if (stripos($code, $this->prefix) === 0) {
            $fans = WechatService::getWebOauthInfo($this->app->request->url(true), $mode);
            if (isset($fans['openid'])) {
                $fans['token'] = md5(uniqid('t', true) . rand(10000, 99999));
                $this->app->cache->set("wxlogin{$code}", $fans, $this->expire);
                $this->app->cache->set($fans['openid'], $fans['token'], $this->expire);
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
    public function query(string $code)
    {
        if (stripos($code, $this->prefix) === 0) {
            return $this->app->cache->get("wxlogin{$code}", []);
        } else {
            return false;
        }
    }
}