<?php
namespace app\test\controller;
use app\test\model\Category as CategoryModel;
use Firebase\JWT\JWT;

class Index
{
    public function index($id=1)
    {
        $category = new CategoryModel();
        $cats = CategoryModel::all();
        if($cats){
            $cats = collection($cats)->toArray();
        }
        return json($cats);
    }
    
    public function db()
    {
        $test = new CategoryModel();
        $test1 = new \CategoryModel();
    }

    public function test()
    {
       $key = 'example';
        $token = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
//            "exp" => "1356999524",
            "uid" => 7,
//            "iat" => 1356999524,
//            "nbf" => 1357000000
        );
        $jwt = JWT::encode($token, $key);
        $decoded = JWT::decode($jwt, $key, array('HS256'));

        print_r($decoded);
    }
}
