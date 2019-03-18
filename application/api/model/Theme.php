<?php

namespace app\api\model;


use app\lib\exception\ProductException;
use app\lib\exception\ThemeException;
use think\Model;

class Theme extends BaseModel
{
    protected $hidden = ['delete_time','update_time', 'topic_img_id', 'head_img_id'];

    /**
     * 关联Image
     * 要注意belongsTo和hasOne的区别
     * 带外键的表一般定义belongsTo，另外一方定义hasOne
     */
    public function topicImg()
    {
//        一对一 hasone(和belongsto反向，当没有外键时使用)
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public function headImg()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    /**
     * 关联product，多对多关系
     */
    public function products()
    {
        return $this->belongsToMany(
            'Product', 'theme_product', 'product_id', 'theme_id');
    }

    public function getThemes()
    {

    }
    
    public static function getThemeWithProducts($id)
    {
        $themes = self::with('products,topicImg,headImg')
            ->select($id);
        return $themes;
    }

    /**
     * 获取主题列表
     * @param $ids array
     * @return array
     */
    public static function getThemeList($ids)
    {
        if (empty($ids))
        {
            return [];
        }
        // 讲解with的用法和如何预加载关联属性的关联属性
        // 不要在这里就toArray或者toJSON
        $themes = self::with('products,img')
//            ->with('products.imgs')
            ->select($ids);
        return $themes;
        //        foreach ($themes as $theme) {
        //            foreach($theme->products as $product){
        //                $url = $product->img;
        //            }
        //        }
        // 讲解collection的用法，可以在Model中配置默认返回数据集，而非数组
        //        $themes = User::with(['orders'=>function($query){
        //            $query->where('order_no', '=', 7);
        //        }])->select();
        //        return collection($themes)->toArray();
    }

    public static function addThemeProduct($themeID, $productID)
    {
        $models = self::checkRelationExist($themeID, $productID);

        // 写入中间表，这里要注意，即使中间表已存在相同themeID和itemID的
        // 数据，写入不成功，但TP并不会报错
        // 最好是在插入前先做一边查询检查

        $models['theme']->products()
            ->attach($productID);
        return true;
    }

    public static function deleteThemeProduct($themeID, $productID)
    {
        $models = self::checkRelationExist($themeID, $productID);
        $models['theme']->products()
            ->detach($productID);
        return true;
    }

    private static function checkRelationExist($themeID, $productID)
    {
        $theme = self::get($themeID);
        if (!$theme)
        {
          throw new ThemeException(); 
        }
        $product = Product::get($productID);
        if (!$product)
        {
            throw new ProductException(); 
        }
        return [
            'theme' => $theme,
            'product' => $product
        ];

    }
}