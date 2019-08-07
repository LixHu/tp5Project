<?php

namespace app\index\controller;

use think\Controller;
use think\Db;

class Position extends Controller
{
	public function screen_con(){
		$price = screen('price');
		$experience = screen('experience');
		$age = screen('age');
		$condition = array('price' => $price , 'experience' => $experience,'age' => $age);
		return json_encode($condition);
	}
	/*展示职位信息*/
	public function info()
	{
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if(!empty($arr)){
			$id = $arr['id'];
			$position = db('position_info')
						->alias('a')
						->field('a.id,d.id,a.name,a.top_image,a.experience,a.price_type,a.workprice,a.ability,a.status,a.make_status,a.specialty,a.address,a.introduce,a.marriage,a.origin_address,a.top_image,a.nation,a.age,a.rest_time,a.education,a.update_time,d.position_name')
						->join('position_name d','a.position = d.id')
						->where('a.id',$id)
						->find();
			if(!empty($position)){
				$position['education'] = get_education($position['education'])['education'];
				$type = getprice_type($position['price_type']);
				$position['workprice'] = $position['workprice'] . $type['price_type'];
				$position['update_time'] = date('Y-m-d H:i:s');
				unset($position['price_type']);
				unset($position['id']);
				if(!empty($position['status']) && !empty($position['make_status'])){
					$position['status'] = getstatus($position['status']);
					$position['make_status'] = getmakestatus($position['make_status'])['pos'];
				}
				if(!empty($val['education'])){
					$position['education'] = get_education($position['education'])['education'];
				}
			}
			return json_encode($position);
		}
	}
	//列表
	public function position_list()
	{
		$pt = file_get_contents("php://input");
		$arr = json_decode($pt,true);
		$where = ' 1 = 1';
		$pagesize = 10;
		$page = 1;
		if (!empty($arr['position'])) {
			$where .= ' and position = '.$arr['position'];
		}
		if (!empty($arr['origin_address'])) {
			$where .= ' and origin_address = \''.$arr['origin_address'].'\'';
		}
		if(!empty($arr['price'])){
			$price = screen('price',$arr['price']);
			if($arr['price'] == 1){
				$where .= ' and workprice < 3000';
			}else if($arr['price'] == 19){
				$where .= ' and workprice > 20000';
			}else{
				$esxplain = explode('~',$price['esxplain']);
				$where .= ' and workprice between ' .$esxplain[0].' and '.mb_substr($esxplain[1],0,-1,'utf-8');
			}
		}
		if(!empty($arr['experience'])){
			$experience = screen('experience',$arr['experience']);
			if($arr['experience'] == 1){
				$where .= ' and experience < 1';
			}else if($arr['experience'] == 4){
				$where .= ' and experience > 5';
			}else{
				$esxplain = explode('~',$experience['esxplain']);
				$where .= ' and experience between ' .$esxplain[0].' and '.mb_substr($esxplain[1],0,-1,'utf-8');
			}
		}
		if(!empty($arr['age'])){
			$age = screen('age',$arr['age']);
			if($arr['age'] == 1){
				$where .= ' and age < 20';
			}else if($arr['age'] == 5){
				$where .= ' and age > 50';
			}else{
				$esxplain = explode('~',$age['esxplain']);
				$where .= ' and age between ' .$esxplain[0].' and '.mb_substr($esxplain[1],0,-1,'utf-8');
			}
		}
		if (!empty($arr['home'])) {
			$where .= ' and is_home ='.$arr['home'];
		}
		if(!empty($arr['page'])){
			$page = $arr['page'];
		}
		if(!empty($arr['keyword'])){
			$keyword = $arr['keyword'];
			$where .= ' and (name REGEXP "'.$keyword .'" or id = "'.$keyword.'")';
		}
		$position_list = db('position_info')
					->field('id,name,top_image,position,experience,workprice,origin_address,age,price_type')
					->where($where)
					->limit($pagesize*($page-1).','.$pagesize)
					->select();
		foreach($position_list as $key => $val){
			$ptype = getprice_type($val['price_type']);
			$position_list[$key]['workprice'] = $position_list[$key]['workprice'].$ptype['price_type'];
			unset($position_list[$key]['price_type']);
		}
		if(!empty($position_list)){
			$position_list = $position_list;
		}else{
			$position_list['message'] =  '无符合条件';
		}
		return json_encode($position_list);
	}
}
