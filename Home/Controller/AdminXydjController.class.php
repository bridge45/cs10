<?php
/*
 * 校友登记
 * 爱乐:2014-05-01
 * QQ:852208555
 * */
namespace Home\Controller;
use Think\Controller;
class AdminXydjController extends Admin{
	public $Obj;
	function __construct(){
		parent::__construct();
		$this->Obj=D('Xydj');
	
	}
	
	
	//显示未处理
	public function showXydjA(){
		$Data = $this->Obj; // 实例化Data数据对象	
		$count      = $Data->where("isDo is null")->count();// 查询满足要求的总记录数 $map表示查询条件
		$Page =D('Page');// 实例化分页类 传入总记录数
		$Page->setPage($count);
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询
		$list = $Data->where("isDo is null")->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		$this->assign('page',$show);
    	$this->assign('XYDJ',$list);// 赋值分页输出
  		$this->display('AdminAl/showXydj');
	}
	//显示全部
	public function showXydjB(){
		$Data = $this->Obj; // 实例化Data数据对象
		$count      = $Data->count();// 查询满足要求的总记录数 $map表示查询条件
		$Page =D('Page');// 实例化分页类 传入总记录数
		$Page->setPage($count);
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询
		$list = $Data->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		$this->assign('page',$show);
		$this->assign('XYDJ',$list);// 赋值分页输出
		$this->display('AdminAl/showXydj');
	}
	
	
	
	
	
	
	
	//处理
	public function setIsdo(){
		$id=AlFilter(I('get.id'),'D');
		if(empty($id)) $this->error('输入参数'.I('get.id').'非法');
		if($this->Obj->setIsDo($id))
			$this->success('操作成功!');
		else
			$this->error('操作失败!');
	}
	//删除无用信息
	public function del(){
		$id=AlFilter(I('get.id'),'D');
		if(empty($id)) $this->error('输入参数'.I('get.id').'非法');
		if($this->Obj->del($id))
			$this->success('操作成功!');
		else
			$this->error('操作失败!');
	}
	
}