<?php

namespace app\admin\controller;

class Goods extends Index
{

	/*
	* 上传
	*/
	public function upload()
	{
		if($_POST){
			return json_encode($_SESSION['base']);
		}else{
			return $this->fetch();
		}
	}
	public function	re_base()
	{
		if($_POST){
			$_SESSION['base'] = [];
			if(empty($_SESSION['base'])){
				echo 1;
			}else{
				echo 2;
			}
		}
	}
	public function up(){
		if($_FILES){
			dump($_FILES['file']);
			$file = $_FILES['file'];
			$name = $file['name'];
			$type = $file['type'];
			$tmp_name = $file['tmp_name'];
			$size = $file['size'];
			if($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/git') {
				$dir = ROOT_PATH .'public\static'.DS.'uploads\deposit\\';
				echo $dir .'-'.$tmp_name;
				if(!is_dir($dir)) {
					mkdir($dir);
				}
				$res = move_uploaded_file($tmp_name,$dir.$name);
				if($res){
					$base64 = base64EncodeImage($dir.$name);
					unlink($dir.$name);
					if(!empty($_SESSION['base'])) {
						array_push($_SESSION['base'],$base64);
					}else{
						$_SESSION['base'][0] = $base64;
					}
				}else{

				}
			}else{
				$this->error('上传文件格式不正确');
			}
		}

	}
	/*
	* 商品分类
	*/
	public function goods_cat(){
		$cat_list = db('goods_category')->select();
		$this->assign('cat_list',$cat_list);
		return $this->fetch();
	}
	/*
	* 新增修改分类
	*/
	public function addedit_cat(){
		if(!empty($_GET['id'])){
			$id = $_GET['id'];
			$info = db('goods_category')->where('cat_id',$id)->find();
			$this->assign('info',$info);
		}else{
			$id = '';
		}
		if($_POST){
			$data['cat_name'] = $_POST['cat_name'];
			$file = request()->file('image1');
			if($file){
				if($id){
					$list = db('goods_category')->where('cat_id ='.$id)->find();
					@unlink(ROOT_PATH .'public'.$list['img']);
				}
	        	$info = $file->validate(['size'=>2097152,'ext'=>'jpeg,jpg,png,gif'])->move(ROOT_PATH . 'public/static' . DS . 'uploads');
	        	if($info){
		            // 成功上传后 获取上传信息
		            $img_path = $info->getSaveName();
					$data['img'] = '/static/uploads/'.$img_path;
		        }else{
		            // 上传失败获取错误信息
		            echo $file->getError();
		        }
			}
			if($id){
				$ret = db('goods_category')->where('cat_id = '.$id)->update($data);
			}else{
				$ret = db('goods_category')->insert($data);
			}
			if($ret){
				$this->success('成功','/admin/goods/goods_cat');
			}else{
				$this->error('失败');
			}
		}
		return $this->fetch();
	}
	/*
	* 商品列表
	*/
	public function goods_list(){
		$where = '1=1';
		$cat_list = db('goods_category')->select();
		if($_POST){
			$keywords = $_POST['keywords'];
			$cat_id = $_POST['cat_id'];
			if($keywords){
				$this->assign('cat_id',$cat_id);
				$where .= ' and goods_name REGEXP \''.$keywords.'\'';
			}
			if($cat_id){
				$this->assign('keywords',$keywords);
				$where .= ' and cat_id = '.$cat_id;
			}
		}
		$goods_list = db('goods')->where($where)->paginate(10);
		$page = $goods_list->render();
		$this->assign('page',$page);
		$this->assign('cat_list',$cat_list);
		$this->assign('goods_list',$goods_list);
		return $this->fetch();
	}
	/*
	* 添加修改商品
	*/
	public function addedit_goods(){
		$_SESSION['base'] = [];
		$cat_list = db('goods_category')->order('sort asc')->select();
		$attr_list = [];
		$res = '';
		if(!empty($_GET['id'])){
			$id = $_GET['id'];
			$goodsinfo = db('goods')
						->alias('a')
						->join('goods_spec b','a.goods_id = b.goods_id')
						->where('a.goods_id',$id)
						->find();
			$goods_img = db('goods_img')->where('goods_id',$id)->select();
			foreach ($goods_img as $key => $val) {
				$goods_img[$key]['img_url'] = base64EncodeImage(ROOT_PATH.'public/'.$val['img_url']);
			}
			$this->assign('goods_img',$goods_img);
			$this->assign('info',$goodsinfo);
		}else{
			$id = '';
		}
		if($_POST){
			$base = [];
			if(!empty($_POST['base'])) {
				$base = $_POST['base'];
				if(count($base) > 5){
					$this->error('上传图片不能多于五张');
					exit;
				}
			}
		    $file = request()->file('image1');
		    if($file){
		        $info = $file->validate(['size'=>2097152,'ext'=>'jpeg,jpg,png,gif'])->move(ROOT_PATH . 'public/static' . DS . 'uploads/goods');
		        if($info){
					if($id){
						$list = db('goods')->where('goods_id ='.$id)->find();
						@unlink(ROOT_PATH .'public'.$list['goods_img']);
					}
		            $goods_data['goods_img'] = '/static/uploads/goods/'.$info->getSaveName();
		        }
		    }
			$goods_data['goods_name'] = $_POST['goods_name'];
			$goods_data['goods_desc'] = $_POST['goods_desc'];
			$goods_data['porint'] = $_POST['porint'];
			$goods_data['cat_id'] = $_POST['cat_id'];
			$goods_data['add_time'] = time();
			$data['yuan_price'] = $_POST['yuan_price'];
			$data['spec_price'] = $_POST['goods_price'];
			$data['vip_price'] = $_POST['vip_price'];
			if(!empty($_POST['attr_id'])){
				$attr_id = $_POST['attr_id'];
			}else{
				$this->error('请选择属性');
			}
			if(!empty($_POST['attr_value'])){
				$attr_value = $_POST['attr_value'];
			}else{
				$this->error('请添加属性值');
			}
			$str = '';
			//如果存在id 更新商品数据 不存在则添加
			if($id){
				db('goods_img')->where('goods_id ='.$id)->delete();
				$res[] = db('goods')->where('goods_id ='.$id)->update($goods_data);
				$num = $id;
				foreach ($attr_id as $key => $val) {
					$adata['attr_id'] = $val;
					$adata['attr_value'] = $attr_value[$key];
					$adata['goods_id'] = $num;
					$where['attr_id'] = $val;
					$where['goods_id'] = $num;
					$have = db('goods_attrvalue')->where($where)->find();
					if(!empty($have)){
						db('goods_attrvalue')->where('id = '.$have['id'])->update($adata);
					}else{
						$res[] = db('goods_attrvalue')->insert($adata);
					}
					$valid = $have['id']?$have['id']:db('goods_attrvalue')->getLastInsId();
					$str .= trim($val) .":".$valid.',';
				}
				$data['goods_spec'] = substr($str,0,-1);
				db('goods_spec')->where('goods_id = '.$id)->update($data);
			}else{
				$res[] = db('goods')->insert($goods_data);
				$num = $id;
				foreach ($attr_id as $key => $val) {
					$adata['attr_id'] = $val;
					$adata['attr_value'] = $attr_value[$key];
					$adata['goods_id'] = $num;
					$where['attr_id'] = $val;
					$where['goods_id'] = $num;
					$res[] = db('goods_attrvalue')->insert($adata);
					$valid = db('goods_attrvalue')->getLastInsId();
					$str .= trim($val) .":".$valid.',';
				}
				$data['goods_spec'] = substr($str,0,-1);
				$res[] = db('goods_spec')->insert($data);
			}
			$up_dir = ROOT_PATH . 'public/static' . DS . 'uploads/goods';
			foreach($base as $key => $val){
				$re = base_upload($up_dir,$val);
				if($re['code'] == 1) {
					$idata['img_url'] = $re['url'];
					if($id){
						$idata['goods_id'] = $id;
					}else{
						$idata['goods_id'] = $num;
					}
					$res[] = db('goods_img')->insert($idata);
				}
			}
			if($res){
				$this->success('添加/修改成功',url('goods/goods_list'));
			}else{
				$this->error('失败');
			}
		}
		$this->assign('cat_list',$cat_list);
		$this->assign('attr_list',$attr_list);
		return $this->fetch();
	}
	/*
	* 获取商品属性名
	*/
	public function get_attr(){
		$div = '';
		if(!empty($_GET)) {
			$flag = true;
			if (empty($_GET['cat_id'])) {
				$flag = false;
			}
			if ($flag) {
				$cat_id = $_GET['cat_id'];
				$arr = db('goods_attr')->where('cat_id ='.$cat_id)->select();
				if($_GET['goods_id'] != -1) {
					$where['goods_id'] = $_GET['goods_id'];
					foreach($arr as $key => $val){
						$where['attr_id'] = $val['attr_id'];
						$arr[$key]['attr_value'] = db('goods_attrvalue')->where($where)->find()['attr_value'];
					}
				}
				foreach($arr as $key => $val){
					if(!empty($val['attr_value']))
						$attr_value = $val['attr_value'];
					else
						$attr_value = '';
					$div.= '<div style="display:block;margin-top:10px;">'.$val['attr_name'].':<input type="hidden" class="input w50" name="attr_id[]" value="'.$val['attr_id'].'
					"</div><div style="display:inline-block;margin-top:10px;">
						<input type="text" class="input" name="attr_value[]" value="'.$attr_value.'" data-validate="required:请输入"'.$val['attr_name'].'>
					</div>';
				}
			}else{
				$div = '';
			}
			return $div;
		}
	}
	/*
	* 商品属性列表
	*/
	public function goods_attr(){
		$cat_list = db('goods_category')->order('sort asc')->select();
		foreach($cat_list as $key => $val){
			$cat_list[$key]['child'] = db('goods_attr')->where('cat_id = '.$val['cat_id'])->select();
		}
		$this->assign('cat_list',$cat_list);
		return $this->fetch();
	}

	/*
	* 添加修改属性
	*/
	public function addedit_attr(){
		$cat_list = db('goods_category')->select();
		if(!empty($_GET['id'])){
			$id = $_GET['id'];
			$info = db('goods_attr')->where("attr_id",$id)->find();
			$this->assign('info',$info);
		}else{
			$id = '';
		}
		if ($_POST) {
			$data['cat_id'] = $_POST['cat_id'];
			$data['attr_name'] = $_POST['attr_name'];
			$data['pid'] = 0;
			$data['input_type'] = 0;
			$data['is_required'] = 0;
			$data['is_show'] = 1;
			if($id){
				$res = db('goods_attr')->where('attr_id',$id)->update($data);
			}else{
				$res = db('goods_attr')->insert($data);
			}
			if($res){
				$this->success('修改成功',url('goods/goods_attr'));
			}else{
				$this->error('修改失败');
			}
		}
		$this->assign('cat_list',$cat_list);
		return $this->fetch();
	}
	/*
	* 删除商品
	*/
	public function del_goods(){
		$idarr = input()['id'];
		$res = array('code' => -1,'msg' => '');
		if(!empty($idarr)){
			if(is_array($idarr)){
				foreach ($idarr as $key => $value) {
							db('goods_img')->where('goods_id',$value)->delete();
							db('goods_spec')->where('goods_id',$value)->delete();
							db('goods_attrvalue')->where('goods_id',$value)->delete();
					$resault = db('goods')->where('goods_id',$value)->delete();
				}
			}else{
				db('goods_img')->where('goods_id',$idarr)->delete();
				db('goods_spec')->where('goods_id',$idarr)->delete();
				db('goods_attrvalue')->where('goods_id',$idarr)->delete();
				$resault = db('goods')->where('goods_id',$idarr)->delete();
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
	/*
	* 删除商品类型
	*/
	public function del_cat(){
		$idarr = input()['id'];
		$res = array('code' => -1,'msg' => '');
		if(!empty($idarr)){
			if(is_array($idarr)){
				foreach ($idarr as $key => $value) {
					$resault = db('goods_category')->where('cat_id',$value)->delete();
				}
			}else{
				$resault = db('goods_category')->where('cat_id',$idarr)->delete();
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
	/*
	* 商品规格
	*/
	public function update_status()
	{
		if($_POST){
			$type = $_POST['type'];
			$status = $_POST['status'];
			$goods_id = $_POST['goodsid'];
			if($type == 'is_group' || $type == 'is_recommend'){
				$count = db('goods')->where($type .' = 1')->count();
				if($type == 'is_recommend' && $status == 1 && $count+1 > 4){
					$res = array('code' => 2 ,'msg' => '推荐商品不能多于4个');
					return $res;
				}
			}
			$res = db('goods')->where('goods_id = '.$goods_id)->update(array($type => $status));
			if($res){
				$res = array('code' => 1);
			}else{
				$res = array('code' => 2 ,'msg' => '失败');
			}
		}
		return $res;
	}

	/*
	*   删除相册图片
	*/
	public function del_goods_img()
	{
		if($_POST){
			$id = $_POST['id'];
			$url = db('goods_img')->where('img_id',$id)->find();
			unlink(ROOT_PATH .'public'.$url['img_url']);
			$res = db('goods_img')->where('img_id',$id)->delete();
			if($res){
				$msg['code'] = 1;
			}else{
				$msg['code'] = 2;
			}
			return $msg;
		}
	}
}
