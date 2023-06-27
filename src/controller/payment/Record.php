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

namespace app\wechat\controller\payment;

use app\wechat\model\WechatFans;
use app\wechat\model\WechatPaymentRecord;
use app\wechat\service\PaymentService;
use think\admin\Controller;
use think\admin\helper\QueryHelper;
use think\exception\HttpResponseException;

/**
 * 微信支付行为管理
 * @class Record
 * @package app\wechat\controller
 */
class Record extends Controller
{
    /**
     * 微信支付行为管理
     * @auth true
     * @menu true
     * @return void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        WechatPaymentRecord::mQuery()->layTable(function () {
            $this->title = '支付行为管理';
        }, function (QueryHelper $query) {
            $db = WechatFans::mQuery()->like('openid|nickname#nickname')->db();
            if ($db->getOptions('where')) $query->whereRaw("openid in {$db->field('openid')->buildSql()}");
            $query->like('order_code|order_name#order')->dateBetween('create_time');
            $query->with(['bindFans'])->equal('payment_status');
        });
    }

    /**
     * 创建退款申请
     * @auth true
     * @return void
     */
    public function refund()
    {
        try {
            $data = $this->_vali(['code.require' => '支付号不能为空！']);
            $recode = WechatPaymentRecord::mk()->where($data)->findOrEmpty();
            if ($recode->isEmpty()) $this->error('支付单不存在！');
            if ($recode->getAttr('payment_status') < 1) $this->error('支付单未完成支付！');
            $desc = "来自订单 {$recode['order_code']} 的退款！";
            [$state, $message] = PaymentService::refund($data['code'], $recode->getAttr('payment_amount'), $desc);
            $state ? $this->success($message) : $this->error($message);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}