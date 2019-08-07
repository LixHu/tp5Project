<?php
namespace app\index\controller;

use think\Db;
use think\Loader;
use think\Validate;
use think\Controller;
class Index extends Controller
{
    function __construct(){
        parent::__construct();
        $this->arr = $this->receive();
    }
    public function receive(){
        $pt = file_get_contents("php://input");
        $arr = json_decode($pt,true);
        return $arr;
    }
}
