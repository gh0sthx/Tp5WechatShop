<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\service\Pay as PayService;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePositiveInt;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];
    
    public function getPreOrder($id='')
    {
        (new IDMustBePositiveInt()) -> goCheck();
        $pay= new PayService($id);
        return $pay->pay();
    }

    public function redirectNotify()
    {
        $notify = new WxNotify();
        $notify->handle();
    }

    public function notifyConcurrency()
    {
        $notify = new WxNotify();
        $notify->handle();
    }

    /**
     * 支付回调
     */
    public function receiveNotify()
    {


//        获取微信返回的xml数据
//         $xmlData = file_get_contents('php://input');
//         Log::error($xmlData);
//      	 error_log($xmlData,'fuck.log');
//	     error_log($_REQUEST,'test.log');
        //检测库存量，超卖，更新status
        $notify = new WxNotify();
        $notify->handle();
    //    做一次转发，然后就可以进行断点调试了
//        $xmlData = file_get_contents('php://input');
//        $result = curl_post_raw('http:/zerg.cn/api/v1/pay/re_notify?XDEBUG_SESSION_START=13133',
//            $xmlData);
//        return $result;
//        Log::error($xmlData);
    }
}
