<?php
namespace Home\Model;
use Think\Model;

class NavModel extends Model {
	// 定义自动验证
	protected $_validate    =   array(
			array('name','require','导航名称不能为空！'),
			array('link','require','导航名称不能为空！'),
			array('sort','require','排序字段必须填写'),
			array('description','require','描述字段必须填写'),
	);
	// 定义自动完成



	public function getNav(){
		return $this->order('sort asc')->select();
	}


	public function getSortNew(){
		return $this->limit(0,1)->field('sort')->order('sort desc')->select();
	}

	public function delNavById($id){
		return $this->where('id='.$id)->delete();
	}

	public function getNavById($id){
		return $this->where('id='.$id)->select();
	}

	public function getNameById($id){
		$arr=$this->field('name')->where('id='.$id)->select();
		return $arr[0]['name'];
	}

	// 	public function getSortById($id){
	// 		return $this->limit(0,1)->where('navId='.$id)->field('sort')->order('sort desc')->select()[0]['sort'];
	// 	}

	//获取侧边栏标题名
	function getLeftTitle($navId){
		$arr=$this->where('id='.$navId)->field('name,content')->select();
		return $arr[0];
	}
    
	//获取导航条信息
	function getNavForAction($navAction){
		$arr=$this->where("link='$navAction'")->field('id,name,description')->select();
		return $arr[0];
	}
}
