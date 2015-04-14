<?php
namespace Home\Controller;
use Think\Controller;
class AdminAlController extends Admin{

	public function index(){
	
		$this->display();
	}
	
	//显示
	public function showAl(){
		//获取navID 和 navname
		$NavObj=D('Nav');
		$Nav['navId']=I('get.navId')==''?1:I('get.navId');
		$Nav['name']=$NavObj->getNameById($Nav['navId']);
		$Al=D('Al')->getListByNavId($Nav['navId']);

		$this->assign('Nav',$Nav);
		$this->assign('AlList',$Al);

		$this->display();
	}
	
	//添加栏目
	public function addAl(){
		$NavObj=D('Nav');
		$Nav['navId']=I('get.navId')==''?1:I('get.navId');
		$Nav['name']=$NavObj->getNameById($Nav['navId']);
		$Nav['sort']=D('Al')->getSortById($Nav['navId'])+1;
		
		$this->assign('Nav',$Nav);
				
		$this->display();
	}
	
	//保存添加的栏目
	public function saveAl(){
		$Al['navId']=I('post.navId');
		$Al['title']=I('post.title');
		$Al['content']=I('post.content');
		$Al['sort']=I('post.sort');
		$Al['addtime']=time();
		$AlObj=D('Al');
		if($AlObj->data($Al)->add())
			$this->success($Al['navId'].'操作成功！','?c=AdminAl&a=showAl&navId='.$Al['navId']);
		else
			$this->error('写入错误！');
	}
	//删除添加的栏目
	public function delAl(){
		$Al=d('Al');
		if($Al->delAlById(I('get.id'))){
			$this->success('删除Id为'. I('get.id').'!成功','?c=AdminAl&a=showAl&navId='.I('get.NavId'));
		}else
		{
			$this->error('删除Id为 '.I('get.id').'失败！');
		}
		
		
	}
	//修改添加的栏目
    public function editAl(){
    	//获取navID 和 navname
    	$NavObj=D('Nav');
    	$Nav['navId']=I('get.NavId')==''?1:I('get.NavId');
    	$Nav['name']=$NavObj->getNameById($Nav['navId']);
    	
    	$Al=D('Al')->getListById(I('get.id'));
    	$this->assign('Al',$Al);
    	
    	$this->assign('Nav',$Nav);
    	
    	$this->display();
    }
    
    //更新  保存修改
    public function updateAl(){
    	$Al['id']=I('post.id');
    	$Al['navId']=I('post.navId');
    	$Al['title']=I('post.title');
    	$Al['content']=I('post.content');
    	$Al['sort']=I('post.sort');
    	$Al['addtime']=time();
    	$AlObj=D('Al');
    	if($AlObj->data($Al)->save())
    		$this->success($Al['navId'].'更新操作成功！','?c=AdminAl&a=showAl&navId='.$Al['navId']);
    	else
    		$this->error('写入错误！');
    }

    
    
    //退出系统
    public function loginOut(){
    	session(null);
    	$this->success('退出成功!','?a=adminLogin');
    }
    
    //显示修改密码
    public function showAlterAccount(){
    	$this->assign('alAdmin',session('alAdmin'));
    	$this->display('alterAccount');
    }
    
    
    
    //修改密码
    public function alterAccount(){
    	$newUserName=AlFilter(I('post.username'),'DW');
    	$newPassWord=AlFilter(I('post.password'),'A');
    	
    	if(empty($newUserName)) $this->error('用户名只能为数字字母,且不能为空!');
    	
    	if(empty($newPassWord)) $this->error('密码不能为空,或者包括非法字符!');
    	
    	if(!($alValue=D('AlConfig')->updateValueByKey(session('alAdmin'),$newUserName,$newPassWord))){
    		$this->error('密码修改不成功!');
    	}else{
    		$this->success('密码修改成功,请记住你的新帐号:<font color="red">'.$newUserName.'</font>新密码:<font color="red">'.$newPassWord.'</font>','',10);
    	}
    	
    	
    }
    

}