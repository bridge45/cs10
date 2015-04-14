<?php
namespace Home\Controller;
use Think\Controller;
class Al extends Controller {
	public $Config;//全局变量
	public $Nav;//导航条对象
	public function __construct(){
		parent::__construct();
		$this->assign('RootJ',getRootUrl());//Root for jump
		$this->assign('RootUrl',getRootUrl().'Home/View/Index/');
		
		//准备导航条数据
		$this->Nav   =   D('Nav');
		$this->assign('Nav',$this->Nav->getNav());
		
		
		
		
		$this->Config=array(
			'title'=>'湖北工业大学计算机学院10周年校庆',
			'pre_title'=>'湖北工业大学计算机学院',
			'after_title'=>'10周年校庆',
			'theme'=>'主题网站',
		);
		
		$this->assign('Config',$this->Config);
	}

	
	
}