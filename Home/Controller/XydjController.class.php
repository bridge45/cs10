<?php
namespace Home\Controller;
class XydjController extends Al {
	public function __construct(){
		parent::__construct();
	    $this->assign('RootJ',getRootUrl());//Root for jump
		$this->assign('RootUrl',getRootUrl().'Home/View/Index/');
		
		//准备导航条数据
		$this->Nav   =   D('Nav');
		$this->assign('Nav',$this->Nav->getNav());
	}

    public function index(){
    	$this->assign('title',$this->Al['after_title'].'_校友登记');//设置页面标题
    	
    	$this->display('Index/xydj');
    }
   public function save(){
   	$verifyCode=AlFilter(I('post.verifycode'),'WD');
   	 
   	if(session('alverify')!=$verifyCode||$verifyCode=''||empty($verifyCode)){
   		$this->error('验证码输入错误 ');
   	}else {
   		session('alverify',null);
   	}
   	
   	$name=AlFilter(I('post.name'),'C');
   	if(empty($name)) $this->error('输入'.I('post.name').'必须为汉字!');
   	
   	$aclass=AlFilter(I('post.aclass'),'CWD');
   	if(empty($aclass)) $this->error('输入'.I('post.aclass').'必须为汉字数字字母!');
   	
   	$telphone=AlFilter(I('post.telphone'),'D');
   	if(empty($telphone)) $this->error('输入'.I('post.telphone').'必须为数字!');
   	
   	$Form   =   D('Xydj');
   	$data['name']  =   	$name;
   	$data['aclass']  =    $aclass;
   	$data['telphone']  =   	$telphone;
   	$data['addtime']=time();
   	if($Form->add($data)){
   		$this->assign('waitSecond','10');
   		$this->success('您好，你的信息已经登记成功，我们将在后台审核后显示出来，谢谢您的参与！',10);
   	}else {
   		$this->success('操作失败!');
   	}
   }

}