<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Session;
use think\Loader;
use think\Paginator;
use think\Cache;
use think\Cookie;
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
		Cache::clear();
	}
}
