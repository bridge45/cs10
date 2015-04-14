<?php
namespace Home\Model;
use Think\Model;

class XydjModel extends Model {
	protected $trueTableName = 'xydj';
    
	//获取未处理的
	public function getdataA(){
		return $this->where("isDo is null")->order('id desc')->select();
	}
	
	//获取全部的
	public function getdataB(){
		return $this->order('id desc')->select();
	}
	
	//处理
	public function setIsDo($id){
		$data['isDo']=1;
		return $this->where("id=$id")->save($data);
	}
	public function del($id){
		return $this->where('id='.$id)->delete();
	}

}
