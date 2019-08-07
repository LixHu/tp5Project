<?php
namespace app\boquan\controller;
use think\Loader;
use app\boquan\model\Files;
use app\boquan\model\Filescate;
use think\Controller;
use think\File;
use think\Request;
use think\Db;

/**
 * File 文件管理
 */
class Fileall extends Index
{

    /**
     * 文件库
     */
    public function file_case()
    {
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        // 接收文件分类id
        
        
        $cateid = input('get.cateid');
        isset($cateid) ? $cateid : '';
        if (empty($cateid)) {
            

            // 获取分类
            $fc = new Filescate();
            $filecate = $fc->getfilecate();
            // 获取文件信息
            $fc = new Files();
            $fileall = $fc->getfileall();
            
            $page = $fileall->render();
            $res = $fileall->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('fileall', $fileall);
            $this->assign('filecate', $filecate);
            $this->assign('cateid',$cateid);

        }else{
            // 获取分类
            $fc = new Filescate();
            $filecate = $fc->getfilecate();

            // 获取文件信息
            $fileall = Db::name('file')->where(['gid'=>$gid,'cateid'=>$cateid])->paginate(10,false,['query' => request()->param(), ]);
            $page = $fileall->render();
            $res = $fileall->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('fileall', $fileall);
            $this->assign('filecate', $filecate);
            $this->assign('cateid',$cateid);
        }
		$this->assign('cateid',$cateid);
        return view();
    }

    /*
     * 返回base64 格式图片
     */
    function base64EncodeImage($image_file)
    {
        $base_img = '';
        $image_info = getimagesize($image_file);
        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }

    /**
     * 上传文件返会base64格式 多张用 ' - '分开
     * 
     * @return string
     */
    public function UploadBase()
    {
        $files = request()->file('file');
        $base64 = [];
        foreach ($files as $file) {
            $info = $file->move(ROOT_PATH . 'public/static' . DS . 'upload/file');
            if ($info) {
                $path = ROOT_PATH . 'public/static' . DS . 'upload/file/' . $info->getSaveName();
                $base64[] = base64EncodeImage($path);
                @unlink($path);
            } else {
                return $file->getError();
            }
        }
        $str = implode(' - ', $base64);
        return $str;
    }

    /**
     * 新增文件
     */
    public function file_ad()
    {
        
        
        if ($_POST) {
            
            // 接收传递过来的文件内容值
            $addfile = input('post.');
            $addfile['ad_time'] = time();
            $addfile['gid'] = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
            // $arr = [];
            // if(!empty($addfile['upload'])){
            //         $arr = explode(' - ',$addfile['upload']);      // 拿到base64 格式字符串，根据 - 进行切割
            //     }
            // $up_dir = ROOT_PATH . 'public/static' . DS .'upload/file/';
            // $str = '';
            // foreach ($arr as $key => $val){
            //     $res = base_upload($up_dir,$val);
            //     if($res['code'] == 1){
            //         $str .= ','.$res['url'];
            //     }
            // }
            // $addfile['upload'] = $str;
            $file = request()->file('upload');
            // 移动到指定目录下
            if ($file) {

                $info = $file->move(ROOT_PATH . 'public/static' . DS . 'upload');
                if ($info) {
                    
                $adfileall['upload'] = $info->getSaveName();
                }
            }
            //获取文件的全路径
            // 实例化模型
            $fl = new Files();
            $adfileall = $fl->adfile($addfile);
            if ($adfileall) {
                $this->redirect('Fileall/file_case');
            } else {
                $this->error('操作失败');
            }
        }
        
        
    }

    /**
     * 文件分类
     */
    public function file_upload()
    {
        // 实例化模型
        $fs = new Filescate();
        $filecate = $fs->getfilecate();
        $this->assign('filecate', $filecate);
        return view();
    }

    /**
     * 文件类别添加
     */
    public function add_filecate()
    {
        $adfilecate = input('post.');
        $adfilecate['gid'] = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        // 实例化模型
        $fl = new Filescate();
        // 调用模型里的方法
        $filecate = $fl->addfilecate($adfilecate);
        if ($filecate) {
            $this->redirect('Fileall/file_upload');
        } else {
            $this->error('操作失败');
        }
        return $this->fetch('file_upload');
    }

    /**
     * 文件搜索
     */
    public function filesee()
    {
        $cateid = input('get.cateid');
        // 接收所搜的关键字
        $keywords = input('param.keyWord');
        if ($keywords) {
            $map['title'] = [ 'like', '%' . $keywords . '%' ]; // 关键字模糊查询
            $map['gid'] = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
            $fileall = Db::name('file')->where($map)->order('id desc')->paginate(10,false,['query' => request()->param(), ]);
            // 获取分类
            $fc = new Filescate();
            $filecate = $fc->getfilecate();
            $page = $fileall->render();
            $res = $fileall->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('fileall', $fileall);
            $this->assign('filecate', $filecate);
        } else {
            $this->error('暂无相关文件');
        }
        $this->assign('cateid', $cateid);
        return $this->fetch('file_case');
    }



    /**
     * 删除文件分类
     */
    public function del_cate(){
        $id = input('param.id');
        if ($id) {
            $res = db('filecate')->where('id',$id)->delete();
            if ($res) {
                return 1;
            }else{
                return 0;
            }
        }
    }


   /**
     * 批量删除文件库文件
     */
    public function del()
    {
        $data = input('param.id/a');
        $param = implode(",",$data);

        $am = new Files;
        $res = $am->del($param);
            if ($res) {
                echo "1";
            } else {
                echo "0";
            }
    }


    /**
     * 编辑
     */
    public function edit_cate()
    {
        
        // 判断是否有数据传递过来
        if ($_POST) {
            // 接收数据
            $param = input('post.');
            
            // 实例化模型
            $se = new Filescate();
            $ep = $se->edit_cate($param);
            if (! empty($ep)) {
                $this->redirect('Fileall/file_upload');
            } else {
                $this->error('编辑失败');
            }
        }
        
        $id = input('param.id');
        
        // 实例化模型
        $ep = new Filescate();
        $this->assign('se', $ep->getOneAd($id));

        return view();
    }
}
