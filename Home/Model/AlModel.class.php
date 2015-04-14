<?php
namespace Home\Model;
use Think\Model;

class AlModel extends Model {
	// 定义自动验证
	protected $_validate    =   array(
			array('NavId','require','NavId不能为空！'),
			array('title','require','title不能为空！'),
			array('content','require','content不能为空！'),
			array('sort','require','Nsort不能为空！'),
	);
	// 定义自动完成

	
	public function getListByNavId($NavId){
		return $this->where('navId='.$NavId)->order('sort asc')->select();
	}
	
	
	public function getListById($Id){
		$arr=$this->where('id='.$Id)->order('sort asc')->select();
		return $arr[0];
	}
	
	
	public function delAlById($id){
		return $this->where('id='.$id)->delete();
	}
	
	public function delAlByNavId($id){
		return $this->where('navId='.$id)->delete();
	}

	public function getSortById($id){
		$arr=$this->limit(0,1)->where('navId='.$id)->field('sort')->order('sort desc')->select();
		return $arr[0]['sort'];
	}
	
	
	
	//获取所有
	public function getAll(){
		$Arr=array();
		$Res=$this->field('navId,title,sort')->select();
		foreach ($Res as $value){
			$Arr[$value['navId']][$value['sort']]=$value['title'];
		}
		foreach ($Arr as $key=>$value){
			ksort($value);
			$ArrB[$key]=$value;
		}
		return $ArrB;
	}
	
	//获取显示栏目的首页模块展示
	public function showIndexBlock(){
		$Res=$this->field('navId,title,sort')->select();
		
		$model=new Model();
		$members=$model->table('nav')
		->where('nav.showflag=1')
		->field('id,name,content,link,description')
		->order('sort asc')
		->select();

		$colorI=1;
		foreach ($members as &$value){
		$value['content']=htmlspecialchars_decode($value['content']);
		$membersm=$model->table('al')
		->where('al.navId='.$value['id'])
		->field('title,id,addtime')
		->limit(0,6)
		->order('sort asc')
		->select();
		$value['more']=$membersm;
		$value['color']=getColor($colorI++);
		}
		
		foreach ($members as &$val){//获取文章第一张图片
			$val['content']=getImg($val['content']);
		}
		
       return $members;
		
	}
	
	
	
	//获取指定
	public function getAlByTypeId($type,$id){
		$Arr=$this->where("navId='$type' and id='$id'")->select();
		$Arr=$Arr[0];
		$Arr['content']=htmlspecialchars_decode($Arr['content']);
		$Arr['addtime']=date("Y-m-d H:i:s",$Arr['addtime']);
        return 	$Arr;
	}
	
	//获取侧边栏
	public function getLeftByType($type){
		$ArrB=array();
		$Arr=$this->where("navId='$type'")->field('navId,sort,id,title')->select();
		foreach ($Arr as $value){
			$ArrB[$value['sort']]['navId']=$value['navId'];
			$ArrB[$value['sort']]['title']=$value['title'];
			$ArrB[$value['sort']]['id']=$value['id'];
			$ArrB[$value['sort']]['sort']=$value['sort'];
		}
		ksort($ArrB);

		return $ArrB;
	}
	

}
