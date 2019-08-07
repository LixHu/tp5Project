<?php

namespace app\admin\controller;

class Application extends Index
{
	public function website_conf(){
		$conf = db('website_conf')->find();
		if($_POST){
			$file = request()->file('image1');
			if($file){
	        	$info = $file->move(ROOT_PATH . 'public/static' . DS . 'uploads');
	        	if($info){
		            // 成功上传后 获取上传信息
		            $img_path = $info->getSaveName();
					if(!empty($conf)){
						unlink(ROOT_PATH . 'public'.$conf['logo_img']);
					}
					$data['logo_img'] = '/static/uploads/'.$img_path;  #logo
		        }else{
		            // 上传失败获取错误信息
		            echo $file->getError();
		        }
		    }
			$data['title'] = input('title');				#网站标题
			$data['website'] = input('website');			#官方网站
			$data['micro_blog'] = input('micro_blog');		#官方微博
			$data['qq'] = input('qq');						#qq
			$data['wechat'] = input('wechat'); 				#微信号
			$data['mobile'] = input('mobile');				#手机号
			$data['tel'] = input('tel');					#电话
			$data['address'] = input('address');			#地址
			$data['email'] = input('email');				#邮箱
															#添加字段。。。
			$resault = db('website_conf')->where('id = 1')->update($data);
			if($resault){
				$this->success('成功');
			}else{
				$this->error('失败');
			}
		}
		$this->assign('conf',$conf);
		return $this->fetch();
	}
}
