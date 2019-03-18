<?php
/**
 * Created by PhpStorm.
 * User: 含笑
 * Date: 2018-06-26
 * Time: 9:36
 */

namespace app\api\service;


use app\api\model\Order as OrderModel;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use think\Lorder;


Lorder::import('WxPay.Wxpay',EXTEND_PATH,'.Api.php');

class Refund
{
    private $orderNO;
    private $orderID;

    function __construct($orderID)
    {
        if (!$orderID){
            throw new Exception('订单不允许为空');
        }
        $this->orderID = $orderID;
    }

    /**
     * 退款申请
     * @return array
     * @throws Exception
     */
    public function refund()
    {
        return $this->requestRefund();

    }

    /**
     * 发送退款请求
     */
    private function requestRefund($totalPrice){
        $openid = Token::getCurrentTokenVar('openid');

        if(!$openid){
            throw new TokenException();
        }
        $wxRefundData = new \WxPayRefund();
        $wxRefundData->SetOut_trade_no($this->orderNO);
        $wxRefundData->SetTotal_fee($totalPrice);
        $wxRefundData->SetRefund_fee($totalPrice);
        $wxRefundData->SetOp_user_id(config('wx.mch_id'));

        return $this->get($wxRefundData);
    }

    /**
     * 签名
     * @param $wxOrder
     * @return array
     */
    private function sign($wxOrder)
    {
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());
        $rand = md5(time() . mt_rand(0, 1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id=' . $wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');
        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;
        //        appid返回客户端并没有实际作用
        unset($rawValues['appId']);
        return $rawValues;
    }

    /**
     * 检查订单有效性
     * @return bool
     * @throws Exception
     * @throws OrderException
     * @throws TokenException
     * @throws \app\lib\exception\ParameterException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function checkOrderVaild(){
        $order = OrderModel::where('id','=',$this->orderID)
            ->find();
        if(!$order){
            throw new OrderException();
        }
        if(!Token::isValidOperate($order->user_id)) {
            throw new TokenException(
                [
                  'msg' => '订单与用户不匹配',
                  'errorCode' => 10004
                ]);
        }
        if($order->status != OrderStatusEnum::PAID){
            throw new OrderException(
                [
                    'msg' => '订单还没有支付',
                    'errorCode' => 80002,
                    'code' => 400
                ]);
        }

        $this->orderID = $order->order_no;
        return true;
    }

}