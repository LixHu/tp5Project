<?php
namespace app\admin\controller;

class Banner extends Index
{
    /*
    *   banner列表
    */
    public function banner_list()
    {
        $where = '1=1';
        $banner = db('banner')->where($where)->select();
        $this->assign('banner',$banner);
        return $this->fetch();
    }
    /*
    *   添加修改banner
    */
    public function addedit_banner()
    {
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $info = db('banner')->where('id ='.$id)->find();
            if(!empty($info)){
                $this->assign('info',$info);
            }
        }else{
            $id = '';
        }
        if ($_POST) {
            $file = request()->file('image1');
            $data['img_url'] = '';
            if($file){
                $info = $file->move(ROOT_PATH . 'public/static' . DS .'uploads/banner');
                if($info){
                    if($id){
                        $list = db('banner')->where('id ='.$id)->find();
                        @unlink(ROOT_PATH .'public'.$list['img_url']);
                    }
                    $data['img_url'] = '/static/uploads/banner/'.$info->getSaveName();
                }else{
                    $this->error($file->getError());
                }
            }
            $data['pos'] = $_POST['pos'];
            $data['is_show'] = 1;
            if($id){
                $res = db('banner')->where('id = '.$id)->update($data);
            }else{
                $res = db('banner')->insert($data);
            }
            if($res){
                $this->success('添加修改成功',url('banner/banner_list'));
            }else{
                $this->error('失败');
            }
        }
        return $this->fetch();
    }
    /*
    *   删除banner
    */
    public function del_img()
    {
        $idarr = input()['id'];
		$res = array('code' => '-1','msg' => '');
		if(!empty($idarr)){
			if(is_array($idarr)){
				foreach ($idarr as $key => $value) {
					$resault = db('banner')->where('id',$value)->delete();
				}
			}else{
				$resault = db('banner')->where('id',$idarr)->delete();
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
}
