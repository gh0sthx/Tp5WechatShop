<?php

namespace app\api\model;

use think\Model;

class Auth extends Model
{
    public function hi()
    {
        return $this->belongsToMany('User','user_auth','auth_id', 'user_id');
    }
}
