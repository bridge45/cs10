<?php
namespace Home\Controller;
class IndexController extends Al {
   public function index(){
      	$this->assign('title',$this->Config['after_title'].'_首页');//设置页面标题
    	$this->assign('Al',D('Al')->showIndexBlock());//准备各栏目数据
    	//获取首页横幅图片
    	$this->assign('Banner',D('Banner')->getBanner());
    	
    	//获取祝福栏目
    	$blessing=D('Blessing')->getShow();
    	$this->assign('blessing',$blessing);
    	
    	$this->display();
    }
  
    public function al(){
    	$type=AlFilter($_GET['type'],'D')?$_GET['type']:die('非法参数!');
    	$id=AlFilter($_GET['id'],'D')?$_GET['id']:die('非法参数!');
    	$AlObj=D('Al');
    	
    	//准备各栏目数据
    	$Al=$AlObj->getAll();
    	$this->assign('Al',$Al);
    	$this->assign('Content',$AlObj->getAlByTypeId($type,$id));
    	
    	//获取侧边栏标题
    	$NavArr=$this->Nav->getLeftTitle($type);
    	$this->assign('LeftName',$NavArr['name']);
    	$this->assign('Topimg',getImg($NavArr['content']));
    	$this->assign('FirstContent',$NavArr['content']);
    	//获取侧边栏
    	
    	$this->assign('CurrentId',$_GET['id']);//当前页标识
    	$this->assign('LeftAl',$AlObj->getLeftByType($type));
    	
    	
    	$this->display();
    }
    
    public function navaction(){
    	$navAction=AlFilter($_GET['navA'],'WD')?$_GET['navA']:die('非法参数!');
    	$Nav   =   D('Nav');
    	$AlObj=D('Al');
    	
    	
    	$NavMsg=$Nav->getNavForAction($navAction);
    	$this->assign('NavMsg',$NavMsg);
    	
    	//获取侧边栏标题
    	$NavArr=$this->Nav->getLeftTitle($NavMsg['id']);
    	$this->assign('LeftName',$NavArr['name']);
    	$this->assign('Topimg',getImg($NavArr['content']));
    	$this->assign('FirstContent',$NavArr['content']);
    	 
    	//获取侧边栏
    	$this->assign('LeftAl',$AlObj->getLeftByType($NavMsg['id']));
    	$this->display();
    	
    }
    
    
    //后台登录
    public function adminLogin(){
    	if(session('loginFlag')) header('Location: ?c=AdminAl');
    	$this->assign('RootUrlForLogin',ROOT.'Home/View/AdminAl/');
    	$this->display('AdminAl/login');
    }
    //登录验证
    public function checkLogin(){
    	$userName=AlFilter(I('post.username'),'DW');
    	$passWord=AlFilter(I('post.password'),'A');
    	$verifyCode=AlFilter(I('post.verifycode'),'WD');
    	
    	if(session('alverify')!=$verifyCode||$verifyCode=''||empty($verifyCode)){
    		$this->error('验证码输入错误 ');
    	}
    	if(empty($userName)) $this->error('用户名只能为数字字母,且不能为空!');
    	
    	if(!($alValue=D('AlConfig')->getValue($userName))){
    		$this->error('用户名不存在!');
    	}
    	
    	if($alValue!=md5($passWord)){
    		$this->error('密码不正确!');
    	}
    	session('loginFlag',true);
    	session('alAdmin',$userName);
    	$this->success('登录成功！','?c=AdminAl');
    }
    
}