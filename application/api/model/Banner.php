<?php
/**
 * Created by PhpStorm.
 * User: 含笑
 * Date: 2017/12/20
 * Time: 8:46
 */

namespace app\api\model;

use think\Model;

class Banner extends BaseModel
{
    public function items()
    {
//        关于TP5 orm 优化的建议，tp5在执行如下语句时，会首先查询一次全表，也就是 SHOW COLUMNS FROM `user`
//        我们可以执行php think optimize:schema 生成数据库缓存
//        类似的还有路由缓存 php think optimize:route
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }
    //

    /**
     * @param $id int banner所在位置
     * @return Banner
     */
    public static function getBannerById($id)
    {
        //TODO: 根据Banner ID号 获取Banner信息（关联items和img）
        $banner = self::with(['items','items.img'])
            ->find($id);

//                 $banner = BannerModel::relation('items,items.img')
//                     ->find($id);
        return $banner;
    }
}
