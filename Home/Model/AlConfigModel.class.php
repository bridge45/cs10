<?php
namespace Home\Model;
use Think\Model;

class AlConfigModel extends Model {
	protected $trueTableName = 'alconfig';
	
	public function getValue($key){
		$res=$this->where("alkey='$key'")->field('alvalue')->select();
		return $res[0]['alvalue'];
	}
	
	
	public function updateValueByKey($oldKey,$newKey,$newValue){
		$data['alkey']=$newKey;
		$data['alvalue']=md5($newValue);
		return $this->where("alkey='$oldKey'")->save($data);
	}
	
}