<?php
/*
 * 导航条后端增删改查
 * 爱乐:2014-05-01
 * QQ:852208555
 * */
namespace Home\Controller;
use Think\Controller;
class AdminBannerController extends Admin{
	
	//显示
	public function showNav(){
		$this->assign('Banner',D('Banner')->getBanner());
		$this->display('AdminAl/showBanner');
	}

	
	//添加
	public function addNav(){
		$Nav   =   D('Banner');

	    $this->display('AdminAl/addBanner');
	}
	
	//保存
	public function saveNav(){
		$Form   =   D('Banner');
	   	$data['text']  =   	I('post.text');
	   	$data['content']  =  I('post.content');
	   	
	   	if($Form->add($data)){
	   		$this->success('操作成功!');
	   	}else {
	   		$this->success('操作失败!');
	   	}
	}
	
	
	
	//删除
	public function delBanner(){
		$id=I('get.id');
		if(D('Banner')->del($id)){
			$this->success('操作成功!');
		}else {
			$this->success('操作失败!');
		}
		
	}
	
	
}