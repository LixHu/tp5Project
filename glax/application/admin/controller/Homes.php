<?php
namespace  app\admin\controller;
/**
 *  家居
 */
use app\admin\model\Home;
class Homes extends Index
{

    public function test()
    {
        $home = Home::get(1);
        dump($home->status);
    }
}
