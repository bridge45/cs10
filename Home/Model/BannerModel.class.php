<?php
namespace Home\Model;
use Think\Model;

class BannerModel extends Model {

	public function getBanner(){
		$Banner=$this->order('id asc')->select();
		foreach ($Banner as &$val){//获取文章第一张图片
			$val['content']=getImg($val['content']);
		}
		return $Banner;
		
	}

	public function del($id){
		return $this->where('id='.$id)->delete();
	}

	
}
