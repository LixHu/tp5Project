<?php
namespace app\index\model;
use think\Model;
/**
 * product model
 */
class Product extends Model
{
    public function getCatSelect($cid)
    {
        $list = [];
        if (!empty($cid)) {
            $list = db('product')->where('cid ='.$cid)->select();
        }
        return $list;
    }
}
