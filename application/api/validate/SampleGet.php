<?php

namespace app\api\validate;

/**
 * Class BannerGet
 * 对获取Banner的接口做验证
 */
class SampleGet extends BaseValidate
{
    protected $rule = [
        'key' => 'number'
    ];

    protected $message = [
//        'location' => 'location 输入'
    ];
}