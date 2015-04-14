<?php
namespace Home\Controller;
class BlessingController extends Al {
	public function __construct(){
		parent::__construct();
	    $this->assign('RootJ',getRootUrl());//Root for jump
		$this->assign('RootUrl',getRootUrl().'Home/View/Index/');
		
		//准备导航条数据
		$this->Nav   =   D('Nav');
		$this->assign('Nav',$this->Nav->getNav());
	}

    public function index(){
    	$this->assign('title',$this->Al['after_title'].'_校庆祝福');//设置页面标题
    	
    	//获取祝福栏目
    	$blessing=D('Blessing')->getShow();
    	$this->assign('blessing',$blessing);
    	
    	$this->display('Index/blessing');
    }
    
    public function show($id=NULL){
    	$Data =D('Blessing'); // 实例化Data数据对象
    	if($id)
    		$count = $Data->where("onShow is not null and id=$id")->count();// 查询满足要求的总记录数 $map表示查询条件
    	else 
    	    $count = $Data->where("onShow is not null")->count();// 查询满足要求的总记录数 $map表示查询条件
    	$Page =D('Page');// 实例化分页类 传入总记录数
    	$Page->setPage($count,10);
    	$show       = $Page->show();// 分页显示输出
    	// 进行分页数据查询
    	if($id)
    		$list = $Data->where("onShow is not null and id=$id")->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
    	else
    	    $list = $Data->where("onShow is not null")->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
    	 
    	$this->assign('doFlag',1);
    	$this->assign('page',$show);
    	$this->assign('XYDJ',$list);// 赋值分页输出
    	$this->display('Index/showBlessing');
    }
    
    public function showById(){
    	$id=AlFilter(I('get.id'),'D')?I('get.id'):'非法访问！';
    	$this->show($id);
    	
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
   	
   	$content=I('post.content');
  
   	
   	$connects=AlFilter(I('post.connects'),'A');
   	if(empty($connects)) $this->error('输入'.I('post.connects').'必须为数字!');
   	
   	$Form   =   D('Blessing');
   	$data['name']  =   	$name;
   	$data['content']  =    $content;
   	$data['connects']  =   	$connects;
   	$data['addtime']=time();
   	if($Form->add($data)){
   		$this->assign('waitSecond','10');
   		$this->success('您好，你的祝福已经提交成功，我们将在后台审核后显示出来，谢谢您的参与！');
   	}else {
   		$this->success('操作失败!');
   	}
   }

}