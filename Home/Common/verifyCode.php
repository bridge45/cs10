<?php
/*****************************/
/*
 * 
 * ***爱乐*2013-05-05 22:30
 * 
 */
/****************************/
$num=4;//验证码个数
$height=40;//验证码图像高度
$width=160;//验证码图像宽度
$move_x=15;//验证码向右偏移量
$move_y=35;//验证码向下偏移量
$font_size=28;//字体大小
$count = 160;//干扰像素的数量
function getAuthImage($text,$im_x,$im_y,$move_x,$move_y,$font_size,$count) {

	$im = imagecreatetruecolor($im_x,$im_y);
	$text_c = ImageColorAllocate($im, mt_rand(0,100),mt_rand(0,100),mt_rand(0,100));
	$tmpC0=mt_rand(100,255);
	$tmpC1=mt_rand(100,255);
	$tmpC2=mt_rand(100,255);
	$buttum_c = ImageColorAllocate($im,$tmpC0,$tmpC1,$tmpC2);
	imagefill($im, 16, 13, $buttum_c);

	$font = dirname(__FILE__).'/t1.ttf';

	for ($i=0;$i<strlen($text);$i++)
	{
		$tmp =substr($text,$i,1);
		$array = array(-1,1);
		$p = array_rand($array);
		$an = $array[$p]*mt_rand(1,10);//角度
		$size =$font_size;
		imagettftext($im, $size, $an, $i*$size+$move_x,$move_y, $text_c, $font, $tmp);
	}


	$distortion_im = imagecreatetruecolor ($im_x, $im_y);

	imagefill($distortion_im, 16, 13, $buttum_c);
	for ( $i=0; $i<$im_x; $i++) {
		for ( $j=0; $j<$im_y; $j++) {
			$rgb = imagecolorat($im, $i , $j);
			if( (int)($i+20+sin($j/$im_y*2*M_PI)*10) <= imagesx($distortion_im)&& (int)($i+20+sin($j/$im_y*2*M_PI)*10) >=0 ) {
				imagesetpixel ($distortion_im, (int)($i+10+sin($j/$im_y*2*M_PI-M_PI*0.1)*4) , $j , $rgb);
			}
		}
	}
	//加入干扰象素;
	for($i=0; $i<$count; $i++){
		$randcolor = ImageColorallocate($distortion_im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
		imagesetpixel($distortion_im, mt_rand()%$im_x , mt_rand()%$im_y , $randcolor);
	}

	$rand = mt_rand(5,30);
	$rand1 = mt_rand(15,25);
	$rand2 = mt_rand(5,10);
	for ($yy=$rand; $yy<=+$rand+2; $yy++){
		for ($px=-80;$px<=80;$px=$px+0.1)
		{
			$x=$px/$rand1;
			if ($x!=0)
			{
				$y=sin($x);
			}
			$py=$y*$rand2;

			imagesetpixel($distortion_im, $px+80, $py+$yy, $text_c);
		}
	}

	//设置文件头;
	Header("Content-type: image/JPEG");

	//以PNG格式将图像输出到浏览器或文件;
	ImagePNG($distortion_im);

	//销毁一图像,释放与image关联的内存;
	ImageDestroy($distortion_im);
	ImageDestroy($im);
}

function make_rand($length="32"){//验证码文字生成函数
	$str="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$result="";
	for($i=0;$i<$length;$i++){
		$num[$i]=rand(0,35);
		$result.=$str[$num[$i]];
	}
	return $result;
}


//输出调用
$checkcode = make_rand($num);
session_start();//将随机数存入session中
$_SESSION['alverify']=strtolower($checkcode);
getAuthImage($checkcode,$width,$height,$move_x,$move_y,$font_size,$count);
?>
