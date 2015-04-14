<?php
namespace Home\Controller;
use Think\Controller;
class Admin extends Controller {
	public function __construct(){
		parent::__construct();

		if(!session('loginFlag')){
			$this->error('请先登录!','?a=adminLogin');
		}

		$this->assign('RootUeditor',ROOT.'ThinkPHP/Public/');
		$this->assign('RootUrl',ROOT.'Home/View/AdminAl/');
	}

	
	
}