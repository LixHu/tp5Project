<?php
namespace app\admin\model;
use think\Db;
use think\Model;

/**
 *  products
 */
class Product extends Model
{
    public function select()
    {
        $list = db('product')
                ->alias('a')
                ->field('a.p_id,a.p_title,a.p_img,a.p_desc,a.is_groom,a.is_ab_us,b.cid,b.cname')
                ->join('category b','a.cid = b.cid')
                ->paginate(10);
        return $list;
    }
}
