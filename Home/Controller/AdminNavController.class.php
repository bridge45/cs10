<?php
/*
 * 导航条后端增删改查
 * 爱乐:2014-05-01
 * QQ:852208555
 * */
namespace Home\Controller;
use Think\Controller;
class AdminNavController extends Admin{
	
	//显示
	public function showNav(){
		$Nav   =   D('Nav');
		$this->assign('Nav',$Nav->getNav());
		$this->display('AdminAl/showNav');
	}
	
	//左边导航条设置栏目 显示
	public function showNavForLeft(){
		$Nav   =   D('Nav');
		$this->assign('Nav',$Nav->getNav());
		$this->display('AdminAl/left');
	}
	
	//添加
	public function addNav(){
		$Nav   =   D('Nav');
		$newSort=$Nav->getSortNew();
		$newSort=$newSort[0]['sort']+1;
		$this->assign('newSort',$newSort);
	    $this->display('AdminAl/addNav');
	}
	
	//保存
	public function saveNav(){
		//print_r($_POST);
// 		$name=I('post.name');
// 		$sort=I('post.sort');
// 		$description=I('post.description');
		$Nav   =   D('Nav');
		if($Nav ->create()) {
			$result =   $Nav->add();
			if($result) {
				$this->success('操作成功！','?c=AdminNav&a=showNav');
			}else{
				$this->error('写入错误！');
			}
		}else{
			$this->error($Nav->getError());
		}

	}
	
	//删除
	public function delNav(){
		$Nav=D('Nav');
		$Al=D('Al');
		if($Nav->delNavById(I('get.id'))){
			$flag=$Al->delAlByNavId(I('get.id'));
			$this->success('删除Id为'. I('get.id').'的导航成功,其子目录删除：'.$flag,'?c=AdminNav&a=showNav');
		}else
		{
			$this->error('删除Id为 '.I('get.id').'的NAV失败！');
		}
	}
	
	//修改
	public function editNav(){
		$editNav=d('Nav')->getNavById(I('get.id'));
		$editNav=$editNav[0];
		$this->assign('editNav',$editNav);
		$this->display('AdminAl/editNav');
	}
	
	//保存修改
	public function saveEditNav(){
		$Nav['id']=I('post.id');
		$Nav['name']=I('post.name');
		$Nav['showflag']=I('post.showflag');
		$Nav['link']=I('post.link');
		$Nav['content']=str_replace('\&quot;',"",I('post.content'));
		
		$Nav['sort']=I('post.sort');
		$Nav['description']=I('description');
		$NavObj  =   D('Nav');
		if($NavObj->data($Nav)->save())
			$this->success('更新操作成功！','?c=AdminNav&a=showNav');
		else
			$this->error('写入错误！');
	}
	
}