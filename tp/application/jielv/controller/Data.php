<?php
/**
 * 数据分析
 */

namespace app\jielv\controller;

use think\Db;
use think\Session;

class Data extends Index
{
    /**
     * 运营统计
     */
    public function data_statistics()
    {

        return view();
    }
    /**
     * 工单统计
     */
    public function data_workorder()
    {

        return view();
    }
    /**
     * 人员统计
     */
    public function data_person()
    {

        return view();
    }
    /**
     * 后台数据显示
     */
    public function data_adm()
    {

        return view();
    }
    public function database()
    {
        $sql = 'select TABLE_NAME as tb from INFORMATION_SCHEMA.TABLES where TABLE_NAME like \'bq%\'';
        $table = Db::query($sql);
        $this->assign('tab',$table);
        return view();
    }
    public function tabledata()
    {
        if(!empty($_GET['tb'])){
            Session('tb',$_GET['tb']);
        }
        if(!empty(Session('tb'))){
            $tb = Session('tb');
            $sql = "desc " .$tb;
            $sqlpri = "SELECT
                      t.TABLE_NAME,
                      t.CONSTRAINT_TYPE,
                      c.COLUMN_NAME,
                      c.ORDINAL_POSITION
                    FROM
                      INFORMATION_SCHEMA.TABLE_CONSTRAINTS AS t,
                      INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS c
                    WHERE
                      t.TABLE_NAME = c.TABLE_NAME
                      AND t.TABLE_SCHEMA = 'bott'
                      AND t.CONSTRAINT_TYPE = 'PRIMARY KEY' 
                      AND t.TABLE_NAME = '".$tb."'";
            $data['primary'] = Db::query($sqlpri);
            if(!empty($data['primary'])){
                $data['primary'] = $data['primary'][0]['COLUMN_NAME'];
            }
            $data['col'] = Db::query($sql);    //所有字段名
            $tb = str_replace('bq_','',$tb);
            $data['list'] = db($tb)->paginate(10);  // 所有数据
        }
        $this->assign('data',$data);
        $this->assign('page',$data['list']->render());
        return view();
    }
    /**
     * 删除表信息
     */
    public function delData()
    {
        $res = array('code' => 2,'msg' => '失败');
        if($_POST){
            if(!empty($_POST['id'])){
                $str = '';
                foreach ($_POST['id'] as $key => $val){
                    $str .= ','.$val;
                }
                $str = substr($str,1);
                $tb = Session('tb');
                $sqlpri = "SELECT
                      t.TABLE_NAME,
                      t.CONSTRAINT_TYPE,
                      c.COLUMN_NAME,
                      c.ORDINAL_POSITION
                    FROM
                      INFORMATION_SCHEMA.TABLE_CONSTRAINTS AS t,
                      INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS c
                    WHERE
                      t.TABLE_NAME = c.TABLE_NAME
                      AND t.TABLE_SCHEMA = 'bott'
                      AND t.CONSTRAINT_TYPE = 'PRIMARY KEY' 
                      AND t.TABLE_NAME = '".$tb."'";
                $primary = Db::query($sqlpri);
                $key =  $primary[0]['COLUMN_NAME'];
                $tb = str_replace('bq_','',$tb);
                if(db($tb)->where($key .' in ('.$str.')')->delete()){
                    $res = array('code' => 1,'msg' => '删除成功');
                }
            }
        }
        return $res;
    }
}