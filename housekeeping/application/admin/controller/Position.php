<?php

namespace app\admin\controller;


class Position extends Index
{
	//展示列表
	public function position_list(){
		$pos = '';
		$keywords = '';
		$where = "1 = 1 ";
		if(!empty(input())){
			$pos = input('pos');
			$keywords = input('keywords');
			if(!empty($pos)){
				$where .= ' and a.position = '.$pos;
			}
			if(!empty($keywords)){
				$where .= 'and (a.name REGEXP \''.$keywords.'\' or b.position_name REGEXP \''.$keywords.'\')';
			}
		}
		$this->assign('pos',$pos);
		$this->assign('keywords',$keywords);
		$list = db('position_info')
				->alias('a')
				->field(' a.name,a.id,a.top_image,a.type,a.experience,a.workprice,a.ability,a.specialty,a.address,a.introduce,a.origin_address,a.nation,a.marriage,a.age,a.status,a.position,a.add_time,a.update_time,b.position_name')
				->join('position_name b',' a.position = b.id')
				->where($where)
				->paginate(10);

		$page = $list->render();
		$this->assign('page',$page);
		$position = db('position_name')->select();
		$this->assign('position',$position);
		$this->assign('list',$list);
		return $this->fetch();
	}
	//添加修改人员信息
	public function addedit_pos(){
		if(!empty($_GET['id'])){
			$id = $_GET['id'];
			$info = db('position_info')
				->alias('a')
				->field(' a.name,a.id,a.price_type,a.top_image,a.education,a.type,a.experience,a.workprice,a.position,a.ability,a.specialty,a.address,a.introduce,a.origin_address,a.nation,a.marriage,a.age,a.status,a.make_status,a.position,a.rest_time,a.add_time,a.update_time,b.position_name')
				->join('position_name b',' a.position = b.id')
				->where('a.id',$id)
				->find();
		}else{
			$info = [];
		}
		$this->assign('info',$info);
		if(!empty($_POST)){
			$data['top_image'] = '/static/img/head.png';
			$file = request()->file('image1');
			if($file){
	        	$info = $file->move(ROOT_PATH . 'public/static' . DS . 'uploads');
	        	if($info){
					// if($id){
					// 	$url = db('position_info')->field('top_image')->where('id='.$id)->find();
					// 	unlink(ROOT_PATH.'public'.$url['top_image']);
					// }
		            $img_path = $info->getSaveName();
					$data['top_image'] = '/static/uploads/'.$img_path;
		        }else{
		            // 上传失败获取错误信息
		            echo $file->getError();
		        }
		    }
			$data['name'] = input('name');
			$data['workprice'] = input('workprice');
			$data['experience'] = input('experience');
			$data['price_type'] = input('price_type');
			$data['ability'] = input('ability');
			$data['specialty'] = input('specialty');
			$data['address'] = input('address');
			$data['introduce'] = input('introduce');
			$data['origin_address'] = input('origin_address');
			$data['nation'] = input('nation');
			$data['marriage'] = input('marriage');
			$data['age'] = input('age');
			$data['rest_time'] = input('rest_time');
			$data['education'] = input('education');
			$data['status'] = input('status');
			$data['make_status'] = input('make_status');
			$data['position'] = input('position');
			// $data['type'] = input('type');
			$data['update_time'] = time();
			if(!empty($id)){
				$data['add_time'] = time();
				$res = db('position_info')->where('id',$id)->update($data);
			}else{

				$res = db('position_info')->insert($data);
			}
			if($res){
				$this->success('成功','Position/position_list');
			}else{
				$this->error('失败');
			}
		}
		$position = db('position_name')->select();
		$this->assign('position',$position);
		return $this->fetch();
	}
	//删除员工
	public function del_pos(){
		$idarr = input()['id'];

		$res = array('code' => -1,'msg' => '');
		if(!empty($idarr)){
			if(is_array($idarr)){
				foreach ($idarr as $key => $value) {
					$resault = db('position_info')->where('id',$value)->delete();
				}
			}else{
				$resault = db('position_info')->where('id',$idarr)->delete();
			}
			if($resault){
				$res = array('code' => 1,'msg' => '删除成功');
			}else{
				$res = array('code' => 2,'msg' => '失败');
			}
		}else{
			$res = array('code' => 3,'msg' => '请选择要删除的内容');
		}
		return $res;
	}

	/*显示类型*/
	public function position_type (){
		$type_list = db('position_name')->select();
		$this->assign('type_list',$type_list);
		return $this->fetch();
	}
	public function addedit_type(){
		$info = [];
		$id = '';
		if($_GET){
			$id = $_GET['id'];
			$info =  db("position_name")->where('id',$id)->find();
		}
		$this->assign('info',$info);
		if(!empty($_POST)){
			$data['position_name'] = input('type_name');
			$data['is_show'] = input('is_show');
			if($id){
				$resault = db('position_name')->where('id = '.$id)->update($data);
			}else{
				$resault = db('position_name')->insert($data);
			}
			if($resault){
				$this->success('成功');
			}else{
				$this->error('失败');
			}
		}
		return $this->fetch();
	}
	/*删除类型*/
	public function del_type(){
		$idarr = input()['id'];

		$res = array('code' => -1,'msg' => '');
		if(!empty($idarr)){
			if(is_array($idarr)){
				foreach ($idarr as $key => $value) {
					$resault = db('position_name')->where('id',$value)->delete();
				}
			}else{
				$resault = db('position_name')->where('id',$idarr)->delete();
			}
			if($resault){
				$res = array('code' => 1,'msg' => '删除成功');
			}else{
				$res = array('code' => 2,'msg' => '失败');
			}
		}else{
			$res = array('code' => 3,'msg' => '请选择要删除的内容');
		}
		return $res;
	}
}
