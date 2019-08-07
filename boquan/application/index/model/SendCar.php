<?php
/**
 * 派车申请
 */

namespace app\index\model;

use think\Model;
class SendCar extends Model
{
    protected $insert = ['add_time'];
    protected function setAddTimeAttr(){
        return time();
    }
}