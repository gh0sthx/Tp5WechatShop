<?php
/**
 * Created by PhpStorm.
 * User: bliss
 * Date: 2017/2/13
 * Time: 16:14
 */
namespace app\api\service;

use app\api\model\Sample as SampleModel;

/**
 *Sample服务类 
 */
class Sample
{
    /**
     * @param $key int banner所在位置
     * @return false|static[]
     */
    static public function getSampleByKey($key)
    {
//        $banner = new BannerModel();
//        $banners = $banner->where('key', $key)->find();
        $banners = SampleModel::all(['key' => $key]);
        return $banners;
    }
}