//滚动插件 
(function($){ 
$.fn.extend({ 
Scroll:function(opt,callback){ 
//参数初始化 
if(!opt) var opt={}; 
var _this=this.eq(0).find("ul:first"); 
var lineH=_this.find("li:first").height(), //获取行高 
line=opt.line?parseInt(opt.line,10):parseInt(this.height()/lineH,10), //每次滚动的行数，默认为一屏，即父容器高度 
speed=opt.speed?parseInt(opt.speed,10):500, //卷动速度，数值越大，速度越慢（毫秒） 
timer=opt.timer?parseInt(opt.timer,10):3000; //滚动的时间间隔（毫秒） 
if(line==0) line=1; 
var upHeight=0-line*lineH; 
//滚动函数 
scrollUp=function(){ 
_this.animate({ 
marginTop:upHeight 
},speed,function(){ 
for(i=1;i<=line;i++){ 
_this.find("li:first").appendTo(_this); 
} 
_this.css({marginTop:0}); 
}); 
} 
//鼠标事件绑定 
_this.hover(function(){ 
clearInterval(timerID); 
},function(){ 
timerID=setInterval("scrollUp()",timer); 
}).mouseout(); 
} 
}) 
})(jQuery); 
$(document).ready(function(){ 
$("#scrollDiv").Scroll({line:6,speed:500,timer:2500}); 
}); 



$(function(){
 
   $('#sb-slider').hover(function(event){
     $('#nav-arrows').fadeIn('slow');
 return false;
   },function(event){
   event.stopPropagation();
	     $('#nav-arrows').fadeOut('slow');
	 return false;
   });
  })
  

			$(function() {
				var Page = (function() {

					var $navArrows = $( '#nav-arrows' ).hide(),
						$shadow = $( '#shadow' ).hide(),
						slicebox = $( '#sb-slider' ).slicebox( {
							onReady : function() {

								//$navArrows.show();
								$shadow.show();

							},
							orientation : 'r',
							cuboidsRandom : true,
							disperseFactor : 30
						} ),
						
						init = function() {

							initEvents();
							
						},
						initEvents = function() {

							// add navigation events
							$navArrows.children( ':first' ).on( 'click', function() {

								slicebox.next();
								return false;

							} );

							$navArrows.children( ':last' ).on( 'click', function() {
								
								slicebox.previous();
								return false;

							} );

						};

						return { init : init };

				})();

				Page.init();

			});