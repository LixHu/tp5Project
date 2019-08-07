<?php
namespace app\admin\model;
use think\Model;
class Home extends Model
{
    public function getStatusAttr($value) {
        $status = ['1' => '显示' , '2' => '禁用'];
        return $status[$value];
    }
}
