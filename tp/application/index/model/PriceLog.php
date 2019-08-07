<?php
/**
 * 用户交易日志
 */

namespace app\index\model;


use think\Model;

class PriceLog extends Model
{
    protected function getTranTimeAttr($val){
        return date("Y-m-d H:i:s",$val);
    }
}