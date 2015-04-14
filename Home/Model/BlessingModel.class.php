<?php
namespace Home\Model;
use Think\Model;

class BlessingModel extends Model {
	protected $trueTableName = 'blessing';
    
	//获取未处理的
	public function getdataA(){
		return $this->where("onShow is null")->order('id desc')->select();
	}
	
	//获取全部的
	public function getdataB(){
		return $this->order('id desc')->select();
	}
	
	//处理
	public function setIsDo($id){
		$data['onShow']=1;
		return $this->where("id=$id")->save($data);
	}
	public function del($id){
		return $this->where('id='.$id)->delete();
	}
   
	//首页显示用的
	public function getShow(){
		return $this->where("onShow is not null")->order('id desc')->limit(0,15)->select();
	}
}
