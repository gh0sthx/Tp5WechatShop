<?php
namespace app\api\controller\v1;

use app\api\model\Auth;
use app\api\model\Product;
use app\api\validate\SampleGet;
use app\lib\exception\MissException;
use think\Controller;
use app\api\service\Sample as SampleService;
use think\Request;

/*
 * Resource Sample
 */

class Sample extends Controller
{

    /**
     * Sample 样例
     * @url     /sample/:key
     * @http    get
     * @param   int $key 键
     * @return  array of values , code 200
     * @throws  MissException
     */
    public function getSample($key)
    {
//        debug('begin');
        $validate = new SampleGet();
        $validate->goCheck();
        $key = (int)$key;
        $result = SampleService::getSampleByKey($key);
        if (empty($result)) {
            throw new MissException([
                'msg' => 'sample not found'
            ]);
        }
//        debug('end');
//        echo debug('begin','end').'s';
        return $result;
//        $data = [
//            'key' => $key,
//        ];
//        $result = $this->validate($data,'BannerGet');
//        if(true !== $result){
//            // 验证失败 输出错误信息
//            dump($result);
//        }
//        $key = (int)$key;
//        $result = BannerService::getBannerByLocation($key);
//        return $result;
    }

    public function test1()
    {
        $users = Auth::with(['hi' => function ($query) {
            $query->where('id', '>', 2);
        }])
            ->find(1);
        return $users;
    }

    public function test2($id=1)
    {
        $n = input('param.');
        Request::instance()->get(['name'=>10]);
        echo input('get.name');

//        $t =session('count');
//        if(!$t)
//        {
//            session('count', 1);
//        }
//        else{
////            session()
//            session('count', $t +1);
//        }
//        echo (string)$t;
    }

    public function test3()
    {
        $n = input('param.');
        $m = input('post.');
    }

    public function test4()
    {
//        Product::
    }
}
