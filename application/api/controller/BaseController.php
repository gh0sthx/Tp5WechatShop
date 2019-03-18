<?php


namespace app\api\controller;


use app\api\service\Token;
use think\Controller;

class BaseController extends Controller
{
//    只能用户
    protected function checkExclusiveScope()
    {
        Token::needExclusiveScope();
    }
//    超级管理员或者是用户
    protected function checkPrimaryScope()
    {
        Token::needPrimaryScope();
    }
//    只能超级管理员
    protected function checkSuperScope()
    {
        Token::needSuperScope();
    }
}