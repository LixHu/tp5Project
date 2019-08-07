<?php
/**
 *
 */

namespace app\index\model;

use think\Model;

class StayApply extends Model
{
    protected $insert = ['add_time'];
    protected function setAddTimeAttr(){
        return time();
    }
}