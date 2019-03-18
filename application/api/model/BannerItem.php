<?php

namespace app\api\model;

use think\Model;

class BannerItem extends BaseModel
{
    protected $hidden = [ 'img_id', 'banner_id', 'delete_time'];

    public function img()
    {
//        定义关联关系 图片模型，外键，主键
        return $this->belongsTo('Image', 'img_id', 'id');
    }
    //
}
