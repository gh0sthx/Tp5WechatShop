<?php
/**
 * Created by PhpStorm.
 * User: 含笑
 * Date: 2017/12/19
 * Time: 22:39
 */

namespace app\api\validate;

class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];
}
