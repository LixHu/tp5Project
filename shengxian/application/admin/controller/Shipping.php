<?php

namespace app\admin\controller;

class Shipping extends Index
{
    /*
    *   配送方式列表
    */
    public function shipping_list ()
    {
        $shipping_list = db('shipping')->select();
        $this->assign('shipping_list',$shipping_list);
        return $this->fetch();
    }
    /*
    *   添加编辑配送方式
    */
    public function addedit_info()
    {
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $info = db('shipping')->where('shipping_id ='.$id)->find();
            $this->assign('info',$info);
        }else{
            $id = '';
        }
        if ($_POST) {
            $data['name'] = $_POST['name'];
            $data['desc'] = $_POST['desc'];
            $data['code'] = $_POST['code'];
            if ($id) {
                $res = db('shipping')->where('shipping_id',$id)->update($data);
            }else{
                $res = db('shipping')->insert($data);
            }
            if($res){
                $this->success('添加/修改成功',url('shipping/shipping_list'));
            }else{
                $this->error('失败');
            }
        }
        return $this->fetch();
    }

    /*
    *   删除配送方式
    */
    public function del_shipping()
    {
        $idarr = input()['id'];
		$res = array('code' => '-1','msg' => '');
		if(!empty($idarr)){
			if(is_array($idarr)){
				foreach ($idarr as $key => $value) {
					$resault = db('shipping')->where('shipping_id',$value)->delete();
				}
			}else{
				$resault = db('shipping')->where('shipping_id',$idarr)->delete();
			}
			if($resault){
				$res = array('code' => 1,'msg' => '删除成功');
			}else{
				$res = array('code' => 2,'msg' => '失败');
			}
		}else{
			$res = array('code' => '-1','msg' => '请选择要删除的内容');
		}
		return $res;
    }
    /*
    *   配送范围
    */
    public function shipping_area()
    {
        $list = db('china')->select();
        $province = db('china')->where('pid = 0')->select();
        $this->assign('province',$province);
        return $this->fetch();
    }
    /*
    * 地区列表
    */
    public function area_list (){
        if($_GET){
            $id = $_GET['id'];
            $city = db('china')->where('pid = '.$id)->select();
            foreach($city as $key => $val){
                $city[$key]['town'] = db('china')->where('pid = '.$val['id'])->select();
            }
            $area = db('shipping_area')->where('area_id ='.$id)->find();
            $list = explode(',',$area['area']);
            $this->assign('list',$list);
            $this->assign('area',$city);
        }
        if($_POST){
            $area = $_POST['area'];
            $str = '';
            foreach($area as $key => $val){
                $str .= $val.',';
            }
            $str = substr($str,0,-1);
            $data['area'] = $str;
            $data['area_id'] = $_POST['area_id'];
            if($data){
                $hav = db('shipping_area')->where('area_id = '.$data['area_id'])->find();
                if($hav){
                    db('shipping_area')->where('area_id = '.$data['area_id'])->update($data);
                }else {
                    $res = db('shipping_area')->insert($data);
                }
            }
        }
        return $this->fetch();
    }

}
