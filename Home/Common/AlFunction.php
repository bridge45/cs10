<?php
//过滤函数
function strreplaces($str)
{
	$farr = array(
			"/\s+/",           //过滤多余的空白
			"/<(\/?)(script|i?frame|object|html|body|title|link|meta|div|\?|\%)([^>]*?)>/isU",  //过滤tag
			"/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU", //过滤javascript的on事件
			"/[\'\+\*\/\<\>\"\?\#\‘\“\\？\￥\×;\%\#\&\^\&\$\|\(\)]/",     //过滤常规的很多特殊字符 []是正则表示里面任何一个匹配上 ,
			//在里面我们可以写很多想要过滤的特殊字符 比如要过滤 单引号‘，就加入\',\的作用是转义，其他的诸于此类，都如此过滤
	);
	$tarr = array(
			"",
			"",           //＜\\1\\2\\3＞如果要直接清除不安全的标签，这里可以留空
			"\\1\\2",
			"",
	);
	//上下数组是一一对应替换的
	$str = preg_replace( $farr,$tarr,$str);
	return $str;
}
//echo strreplaces($_GET['id']);

//白名单过滤模式开始
function AlFilter($str=NULL,$operate,$ext=NULL){
    $str = trim(str_replace(PHP_EOL, '', $str));//去换行机制
	if(!$str) return 0;
	//匹配模式 $pattern
	$Ap="\x{4e00}-\x{9fff}".'0-9a-zA-Z\@\#\$\%\^\&\*\(\)\!\,\.\?\-\+\=';
	$Cp="\x{4e00}-\x{9fff}";
	$Dp='0-9';
	$Wp='a-zA-Z';
	$Tp='@#$%^&*()-+=';
	$_p='_';
	
	$pattern="/^[";
	$OArr=str_split(strtolower($operate));//拆分操作符
	if (in_array('a', $OArr)) $pattern.=$Ap;
	if (in_array('c', $OArr)) $pattern.=$Cp;
	if (in_array('d', $OArr)) $pattern.=$Dp;
	if (in_array('w', $OArr)) $pattern.=$Wp;
	if (in_array('t', $OArr)) $pattern.=$Tp;
	if (in_array('_', $OArr)) $pattern.=$_p;
	if($ext) $pattern.=$ext;
	$pattern.="]+$/u";
	if(!preg_match($pattern,$str))
		return 0;
	else 
		return $str;
		
}

//白名单过滤模式结束

function encodeC($value){
	$text = $value;
	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, 'lb123', $text, MCRYPT_MODE_ECB, $iv);
	return base64_encode($crypttext);
}
//解密函数
function decodeC($value){
	$crypttext = base64_decode($value);
	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, 'lb123', $crypttext, MCRYPT_MODE_ECB, $iv);
	return trim($decrypttext);
}


//URL 处理
function getRootUrl(){
	$url='http://'.$_SERVER['HTTP_HOST'];
	$urlArr=explode('/',$_SERVER['PHP_SELF']);
	array_pop($urlArr);
	//print_r($urlArr);
	foreach ($urlArr as $value){
		if($value)
			$url.='/'.$value;
	}
	return $url.'/';
}


function getColor($colorI){
	$A=$colorI%4;
	switch($A){
		case 0: return 'red';
		case 1: return 'green';
		case 2: return 'orange';
		case 3: return 'blue';
		default:return 'red';
	}
}

function check_str($str,$len){
	if(strlen($str)>$len*2)
		return '...';
	else 
		return;
}

//获取首页图片(文章中的第一张图片)
function getImg($str){
	$preg = "/<img src=\"(.+?)\".*?>/";
	preg_match($preg,$str,$match);
	if(isset($match[1]))
		return $match[1];
	else{
		$str=htmlspecialchars_decode($str);
		preg_match($preg,$str,$match);
		if(isset($match[1]))
			return $match[1];
		return ROOT.'/Home/View/Index/images/black.jpg';
	}
}