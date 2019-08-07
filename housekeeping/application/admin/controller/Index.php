<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Session;
use think\Loader;
use think\Paginator;
use think\Cache;
class Index extends Controller
{
	public function __construct(){
		parent::__construct();
		$this->valida();
	}

	function valida(){
		$val = Session('admin');
		if(empty($val)){
			$method = request()->action();
			if($method != 'login' && $method != 'doimg'){
				$this->redirect('Users/login');
			}
		}
	}

	function clearcache(){
		if(Cache::clear()){
			$this->success('清除成功',url('admin/index'));
		}else{
			$this->error('失败');
		}
	}
}
