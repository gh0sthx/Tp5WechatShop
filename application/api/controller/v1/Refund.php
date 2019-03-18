<?php
/**
 * Created by PhpStorm.
 * User: 含笑
 * Date: 2018-06-26
 * Time: 9:35
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\Refund as RefundService;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePositiveInt;


class Refund extends  BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    public function getPreRefund($id=''){
        (new IDMustBePositiveInt())->goCheck();
        $refund = new RefundService($id);
        return $refund->refund();
    }

//    回调一会写
}