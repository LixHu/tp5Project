<?php
namespace app\index\model;

use think\Model;
class Complaint extends Model
{
    protected function setAddTimeAttr(){
        return time();
    }
}