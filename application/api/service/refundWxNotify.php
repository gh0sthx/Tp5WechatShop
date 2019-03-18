<?php
/**
 * Created by PhpStorm.
 * User: 含笑
 * Date: 2018-06-26
 * Time: 13:56
 */

namespace app\api\service;

use app\api\model\Order;
use app\api\model\Product;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;
use think\Db;
use think\Exception;
use think\Loader;
use think\Log;


Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');


class refund extends \WxPayNotify
{
//<xml>
//<appid>wx2421b1c4370ec43b</appid>
//<mch_id>10000100</mch_id>
//<nonce_str>6cefdb308e1e2e8aabd48cf79e546a02</nonce_str>
//<out_refund_no>1415701182</out_refund_no>
//<out_trade_no>1415757673</out_trade_no>
//<refund_fee>1</refund_fee>
//<total_fee>1</total_fee>
//<transaction_id></transaction_id>
//<sign>FE56DD4AA85C0EECA82C35595A69E153</sign>
//</xml>

//    判断退款是否在规定的时间内
//    判断是否
}