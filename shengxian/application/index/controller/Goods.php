<?php
namespace app\index\controller;

class Goods extends Index
{
	/*
	* 获取主页信息
	*/
	public function get_indexinfo(){
			$pt = file_get_contents("php://input");
			$arr=json_decode($pt,true);
			$res['code'] = 1;
			$id = $arr['user_id'];
			$vip = db('users')->field('vip_lv')->where('user_id',$id)->find();
			if($vip){
				$field = "b.vip_price as price";
			}else{
				$field = "b.spec_price as price";
			}
			$recommend = db('goods')
								->alias('a')
								->field('a.goods_id,a.goods_name,a.goods_img,a.goods_desc,b.spec_price,'.$field)
								->join('goods_spec b','a.goods_id = b.goods_id')
								->where('is_recommend = 1 and is_on_sale = 1')
								->select();
			if(!empty($recommend)){
				$res['tj'] = $recommend;
			}else{
				$res['tjmsg']  = '无数据';
			}

			$type_list = db('goods_category')->field('cat_id,cat_name,img')->where('is_show = 1')->order('sort asc')->select();
			if(!empty($type_list)){
				$res['cat'] = $type_list;
			}else{
				$res['code'] = 2;
				$res['cat_msg']  = '无数据';
			}

			$banner_list = db('banner')->field('img_url,id,pos')->where('is_show = 1')->select();
			if(!empty($banner_list)){
				$res['banner'] = $banner_list;
			}else{
				$res['code'] = 2;
				$res['msg']  = '无数据';
			}
		return json_encode($res);
	}
	/*
	* 获取商品信息
	*/
	public function goods_info(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if(!empty($arr)){
			$user_id = $arr['user_id'];
			$goods_id = $arr['goods_id'];
			$vip = db('users')->field('vip_lv')->where('user_id',$user_id)->find();
			if($vip){
				$field = "b.vip_price as price";
			}else{
				$field = "b.spec_price as price";
			}
			if($goods_id){
				$goodsinfo = db('goods')
							->alias('a')
							->field('a.goods_id,a.goods_name,a.porint,a.goods_desc,b.yuan_price,b.spec_price,b.dis_price,b.vip_price,b.goods_spec')
							->join('goods_spec b','a.goods_id = b.goods_id')
							->where('a.goods_id = '.$goods_id)
							->find();
					$attr = $goodsinfo['goods_spec'];
					if($attr){
						$arr = explode(',',$attr);
						foreach($arr as $key => $val){
							$attr_list = explode(':',$val);
							$attr_info[$key]['attr_id'] = $attr_list[0];
							$attr_info[$key]['attr_value'] = db('goods_attrvalue')->where('id ='.$attr_list[1])->find()['attr_value'];
						}
						foreach($attr_info as $key => $val){
								$attr_info[$key]['attr_name'] = db('goods_attr')->field('attr_name')->where('attr_id',$val['attr_id'])->find()['attr_name'];
								unset($attr_info[$key]['attr_id']);
						}
						$goodsinfo['attr'] = $attr_info;
					}
					unset($goodsinfo['goods_spec']);
			}
			if(!empty($goodsinfo)){
				//每次获取到当前商品 给商品的点击量+1
				db('goods')->where('goods_id',$goodsinfo['goods_id'])->setInc('click_count',1);
				$cart_num = db('cart')->where('user_id ='.$arr['user_id'])->count();
				// 获取收藏状态
				if(db('collect')->where('user_id ='.$user_id .' and goods_id = '.$goods_id)->find()){
					$res['collect'] = 1;
				}else{
					$res['collect'] = 2;
				}
				$res['code'] = 1;
				$res['goods'] = $goodsinfo;
				$res['cart'] = $cart_num;
			}else{
				$res = array('code' => 2,'msg' => '商品不存在');
			}
		}else{
			$res = array('code' => 1,'msg' => '商品编号为空');
		}
		return json_encode($res);
	}

	/*
	* 获取商品列表
	*/
	public function goods_list (){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		$goods_list = [];
		// $field = 'b.spec_price';
		// if(!empty($arr['user_id'])){
			// $vip = db('users')->field('vip_lv')->where('user_id',$arr['user_id'])->find();
			// if($vip > 0 ){
				// $field = 'b.vip_price as price';
			// }
		// }
		if(!empty($arr['cat_id'])){
			$cat_id = $arr['cat_id'];
			$where = 'cat_id = '.$cat_id;
		}else{
			$where = 'cat_id = 1';
		}
		if(!empty($arr['group'])){
			$where = 'is_group = '.$arr['group'];
		}
		if(!empty($arr['tejia'])){
			$where = ' is_tejia = '.$arr['tejia'];
		}
		$goods_list = db('goods')
					->alias('a')
					->field('a.goods_id,a.goods_name,a.goods_img,a.sale_count,a.porint,a.goods_desc,b.spec_price,b.yuan_price')
					->join('goods_spec b','a.goods_id = b.goods_id')
					->where($where)
					->select();
		if(!empty($goods_list)){
			$res = array('code' => 1 ,'data' => $goods_list );
		}else{
			$res = array('code' => 2 ,'msg' => '无数据');
		}
		return json_encode($res);
	}
	/*
	* 商品分类列表
	*/
	public function goods_cat(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		$cat_list = db('goods_category')->field('cat_id,cat_name')->where('is_show = 1')->select();
		if(!empty($cat_list)){
			$res = array('code' => '1' ,'data' => $cat_list);
		}else{
			$res = array('code' => '2', 'msg' => '暂无');
		}
		return json_encode($res);
	}
	/*
	* 收藏/取消收藏商品
	*/
	public function collect_goods(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		$res = [];
		if(!empty($arr)){
			if (!empty($arr['user_id'])) {
				$data['user_id'] = $arr['user_id'];
				$data['goods_id'] = $arr['goods_id'];
				// 判断商品是否存在 不存在则退出
				$goods = db('goods')->where('goods_id ='.$arr['goods_id'])->find();
				if(!empty($goods)){
					// 判断信息是否存在，存在则删除，取消收藏
					$have = db('collect')->where($data)->find();
					if($have){
						$msg = '取消收藏成功';
						// sleep(2);
						$ret = db('collect')->where('collect_id ='.$have['collect_id'])->delete();
					}else{
						$msg = '收藏成功';
						// sleep(2);
						$ret = db('collect')->insert($data);
					}
					if($ret){
						$res = array('code' => 1 , 'msg' => $msg);
					}else{
						$res = array('code' => 2 , 'msg' => '失败');
					}
				}else{
					$res = array('code' => -1 ,'msg' => '商品不存在');
				}
			}else{
				$res = array('code' => -1 ,'msg' => '用户编号有误');
			}
		}else{
			$res = array('code' => -1 , 'msg' => '请选择商品');
		}
		return json_encode($res);
	}

	/*
	* 关键字搜索
	*/
	public function search_goods()
	{
		$pt = file_get_contents("php://input");
		$arr = json_decode($pt,true);
		$where = '1=1';
		if(!empty($arr['keywords'])){
			$keywords = $arr['keywords'];
			$where .= ' and (a.goods_name REGEXP \''.$keywords.'\' or a.goods_desc REGEXP \''.$keywords.'\') and is_on_sale = 1';
		}
		$goods_list = db('goods')
					->alias('a')
					->field('a.goods_id,a.goods_name,a.goods_desc,a.goods_img,a.sale_count,a.is_tejia,a.is_group,b.spec_price,b.yuan_price')
					->join('goods_spec b','a.goods_id = b.goods_id')
					->where($where)
					->select();
		$res = array('code' => 1, 'data' => $goods_list);
		return json_encode($res);
	}
}
