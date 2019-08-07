<?php
namespace app\admin\controller;

/**
 *
 */
class Role extends Index
{

    /*
    * 角色列表
    */
    public function role_list()
    {
        $role_list = db('role')->where('is_show = 1')->paginate(10);
        $page = $role_list->render();
        $this->assign('page',$page);
        $this->assign('role_list',$role_list);
        return $this->fetch();
    }
    /*
    * 权限管理
    */
    public function edit_role(){
        $role = db('role')->select();
        $left_list = db('admin_menu')->where('pid = 0 and is_show = 1')->select();
        foreach($left_list as $key => $val){
            $children = db('admin_menu')->where('is_show = 1 and pid = '.$val['menu_id'])->select();
            if(!empty($children)){
                $left_list[$key]['children'] =	$children;
            }
        }
        if(!empty($_GET)){
            //根据id找到权限显示出来
            $role_name = db('admin_menu')
                ->alias('a')
                ->field('a.menu_id')
                ->join('role_menu b','b.menu_id = a.menu_id')
                ->join("role c",'b.role_id = c.role_id')
                ->where('a.is_show = 1 and c.role_id = '.$_GET['id'])
                ->select();
            $role_id = db('role')->find($_GET['id']);
            $this->assign('role_id',$role_id);
            $this->assign('role_name',$role_name);
        }
        // 提交表单
        if($_POST){
            $data['role_id'] = $_POST['role_id'];
            db('role')->where('role_id =' .$data['role_id'])->update(['role_desc' => $_POST['desc'] ]);
            if(!empty($_POST['id'])){
                $id = $_POST['id'];
                db('role_menu')->where($data)->delete();
                foreach($id as $k => $v){
                    $data['menu_id'] = $v;
                    $have = '';
                    if(empty($have) && $data['role_id'] != 0){
                        $resault = db('role_menu')->insert($data);
                    }
                }
            }else{
                $resault = '';
            }

            if($resault){
                $this->success('修改成功',url('role/role_list'));
            }
        }
        $this->assign('menu',$left_list);
        $this->assign('role',$role);
        return $this->fetch();
    }

    /*
    * 删除角色及权限
    */
    public function del_role(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('role')->where('role_id ='.$val)->delete();
                    db('role_menu')->where('role_id ='.$val)->delete();
                }
            }else{
                $res = db('role')->where('role_id ='.$id)->delete();
                db('role_menu')->where('role_id ='.$id)->delete();
            }
            if($res){
                $res = array('code' => 1, 'msg' => '删除成功');
            }else{
                $res = array('code' => 2, 'msg' => '失败');
            }
            return jsonReturn($res);
        }
    }

}
