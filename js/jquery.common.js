//适应屏幕显示
var PageSize = {};
PageSize.windowHeight = -1;
PageSize.windowWidth = -1;
PageSize.min_size = -1;

PageSize.oriHeight = 1008;
PageSize.oriWidth = 640;

$.fn.SetSizeFullScreen = function (top,left,width,height) {
	
	if(top == null){
		this.css("display","none");
		return;
	}

	this.top = top / PageSize.oriHeight * PageSize.windowHeight;
	this.left = left / PageSize.oriWidth * PageSize.windowWidth;

	if(height != null){
		this.width = width / PageSize.oriWidth * PageSize.windowWidth;
		this.height = height / PageSize.oriHeight * PageSize.windowHeight;
	}
	if(height == null && width !=null){
		this.width = width / PageSize.oriWidth * min_size;
		this.height = width / PageSize.oriWidth * min_size;
	}
		
	this.css("top" , top * PageSize.windowHeight / PageSize.oriHeight);
	this.css("left" , left * PageSize.windowWidth / PageSize.oriWidth);
	this.css("width" , width * PageSize.windowWidth / PageSize.oriWidth);
	this.css("height" , height * PageSize.windowHeight / PageSize.oriHeight);
};

$.fn.SetSizeZoom = function (top,left,width,height) {
	if(top == null){
		this.css("display","none");
		return;
	}

	this.top = top / PageSize.oriHeight * PageSize.windowHeight;
	this.left = left / PageSize.oriWidth * PageSize.windowWidth;
	
	if(height != null){
		this.width = width / PageSize.oriWidth * PageSize.windowWidth;
		this.height = height / PageSize.oriHeight * PageSize.windowHeight;
	}
	if(height == null && width !=null){
		this.width = width / PageSize.oriWidth * min_size;
		this.height = width / PageSize.oriWidth * min_size;
	}
		
	this.css("top" , top * PageSize.windowWidth / PageSize.oriWidth);
	this.css("left" , left * PageSize.windowWidth / PageSize.oriWidth);
	this.css("width" , width * PageSize.windowWidth / PageSize.oriWidth);
	this.css("height" , height * PageSize.windowWidth / PageSize.oriWidth);
};

$.fn.OffsetFullScreen = function( name, value ) {
	if ( arguments.length === 2 && value === undefined ) {		//arguments.length 属性代表实参的个数
		return this;
	}
	if (typeof (name)=="object"){
		if(name.top!==undefined){this.css("top" ,name.top * PageSize.windowHeight / PageSize.oriHeight);}
		if(name.left!==undefined){this.css("left" ,name.left * PageSize.windowWidth / PageSize.oriWidth);}
		if(name.width!==undefined){this.css("width" ,name.width * PageSize.windowWidth / PageSize.oriWidth);}
		if(name.height!==undefined){this.css("height" ,name.height * PageSize.windowWidth / PageSize.oriHeight);}
	}
	switch(name){
		case "top":
			this.css("top" ,value * PageSize.windowHeight / PageSize.oriHeight);
			break;
		case "left":
			this.css("left" ,value * PageSize.windowWidth / PageSize.oriWidth);
			break;
		case "width":
			this.css("width" ,value * PageSize.windowWidth / PageSize.oriWidth);
			break;
		case "height":
			this.css("height" ,value * PageSize.windowWidth / PageSize.oriHeight);
			break;
		default:
			break;
	}
};

$.fn.OffsetZoom = function( name, value ) {
	if ( arguments.length === 2 && value === undefined ) {		//arguments.length 属性代表实参的个数
		return this;
	}
	if (typeof (name)=="object"){
		if(name.top!==undefined){this.css("top" ,name.top * PageSize.windowWidth / PageSize.oriWidth);}
		if(name.left!==undefined){this.css("left" ,name.left * PageSize.windowWidth / PageSize.oriWidth);}
		if(name.width!==undefined){this.css("width" ,name.width * PageSize.windowWidth / PageSize.oriWidth);}
		if(name.height!==undefined){this.css("height" ,name.height * PageSize.windowWidth / PageSize.oriWidth);}
	}
	switch(name){
		case "top":
			this.css("top" ,value * PageSize.windowWidth / PageSize.oriWidth);
			break;
		case "left":
			this.css("left" ,value * PageSize.windowWidth / PageSize.oriWidth);
			break;
		case "width":
			this.css("width" ,value * PageSize.windowWidth / PageSize.oriWidth);
			break;
		case "height":
			this.css("height" ,value * PageSize.windowWidth / PageSize.oriWidth);
			break;
		default:
			break;
	}
};

OffsetTopFullScreen = function(top){
	return top * PageSize.windowHeight / PageSize.oriHeight;
}
OffsetLeftFullScreen = function(left){
	return left * PageSize.windowWidth / PageSize.oriWidth;
}
OffsetwidthFullScreen = function(width){
	return width * PageSize.windowWidth / PageSize.oriWidth;
}
OffsetheightFullScreen = function(height){
	return height * PageSize.windowWidth / PageSize.oriHeight;
}

//全屏显示--fullScreen
$(document).ready(function(){
	$(".fullScreen").each(function(){
		$("#"+$(this).attr("id")).SetSizeFullScreen(0,0,PageSize.oriWidth,PageSize.oriHeight);
	});
});
$(window).resize(function() {
	$(".fullScreen").each(function(){
		$("#"+$(this).attr("id")).SetSizeFullScreen(0,0,PageSize.oriWidth,PageSize.oriHeight);
	});
	if(typeof window.InitSize == 'function') {
		InitSize();
	};
});


//ShowText动画
$.fn.ShowText = function (direction , timecount , percent) {
	textid=this[0].id;
	container=textid+"container"
	conHtml  = "<div id='"+container+"' class='float hidden'  style='overflow:hidden;'></div>";
	$("#"+textid).after(conHtml);
	$("#"+container).append($("#"+textid));

	$("#"+container).removeClass("hidden");
	
	if(timecount == null)
		timecount = 1500;
	if(direction == null)
		direction = "toptobottom";	
	if(percent == null)
		percent = 1;
		

	textTop = parseInt(this.css("top"));
	textLeft = parseInt(this.css("left"));
	textWidth = parseInt(this.css("width"));
	textHeight = parseInt(this.css("height"));	
	
	$("#"+container).css({top:textTop,left:textLeft,width:textWidth,height:textHeight});

	if(this.data("width")){
		textTop=parseInt(this.data("top"));
		textLeft=parseInt(this.data("left"));
		textWidth=parseInt(this.data("width"));
		textHeight=parseInt(this.data("height"));
		
		conLeft=parseInt($("#"+container).data("left"));
		conTop=parseInt($("#"+container).data("top"));
	} else {
		parseInt(this.data("top",textTop));
		parseInt(this.data("left",textLeft));
		parseInt(this.data("width",textWidth));
		parseInt(this.data("height",textHeight));

		parseInt($("#"+container).data("left",parseInt($("#"+container).css("left"))));
		parseInt($("#"+container).data("top",parseInt($("#"+container).css("top"))));
		
		// return;
		
		textTop=parseInt(this.data("top"));
		textLeft=parseInt(this.data("left"));
		textWidth=parseInt(this.data("width"));
		textHeight=parseInt(this.data("height"));
		
		conLeft=parseInt($("#"+container).data("left"));
		conTop=parseInt($("#"+container).data("top"));
	}
	
	
	switch(direction){
		case "toptobottom":
			$("#"+container).css("width" , textWidth);
			$("#"+container).css("height" , 0);

			this.css("top" , 0);
			this.css("left" , 0);
			this.removeClass("hidden");
			$("#"+container).animate({height : textHeight*percent} , timecount);
			break;
		case "bottomtotop":
			$("#"+container).css("width" , textWidth);
			$("#"+container).css("height" , 0);
			$("#"+container).css("top" , conTop + textHeight);

			this.css("top" , textHeight*-1 );
			this.css("left" , 0);
			this.removeClass("hidden");
			$("#"+container).animate({height : textHeight*percent,top:conTop+textHeight*(1-percent)} , timecount);
			this.animate({top : textHeight * -1 * (1-percent)} , timecount);
			break;
		case "lefttoright":
			$("#"+container).css("width" , 0);
			$("#"+container).css("height" , textHeight);

			this.css("top" , 0);
			this.css("left" , 0);
			this.removeClass("hidden");
			$("#"+container).animate({width : textWidth*percent} , timecount);
			break;
		case "righttoleft":
			$("#"+container).css("width" , 0);
			$("#"+container).css("height" , textHeight);
			$("#"+container).css("left" , conLeft + textWidth);

			this.css("top" , 0);
			this.css("left" , textWidth * -1);
			this.removeClass("hidden");
			$("#"+container).animate({width : textWidth*percent , left:conLeft+textWidth*(1-percent)} , timecount);
			this.animate({left : textWidth * -1 * (1-percent)} , timecount);
	}
};

//下降箭头动画
$.fn.DropLogo = function(time) {
	this.css({opacity : 1});
	
	if(time == null)
		time = 500;

	objTop = parseInt(this.css("top"));
	objLeft = parseInt(this.css("left"));
	objWidth = parseInt(this.css("width"));
	objHeight = parseInt(this.css("height"));//获取位置，宽高信息

	this.css("top" , objTop - objHeight * 1);
	this.css("left" , objLeft - objWidth * 1);
	this.css("width" , objWidth * 3);
	this.css("height" , objHeight * 3);

	this.animate({
		opacity : 1 , 
		top : objTop , 
		left : objLeft , 
		width : objWidth , 
		height : objHeight
	} , time);
};

//加载进度显示
var num=0;
function setsize(){
	if($(window).width() < PageSize.windowHeight)
	{
		if(PageSize.windowHeight == -1)
			{
				windowHeight = $(window).height();
				windowWidth = $(window).width();
			}
	}
	PageSize.oriHeight =1008;
	PageSize.oriWidth = 640;
	PageSize.windowHeight = $(window).height();
	PageSize.windowWidth = $(window).width();
	PageSize.SetSizeFullScreen($("#isloading"),459,275,93,93);
	PageSize.SetSizeFullScreen($("#word"),489,275,93,93);
}
(function($){
	//部分加载
	$.fn.prePartLoadImg=function(bgcolor,callback) {
		var imgNum = 0;
		var images = [];
		var index=0;
		var imgs=$(this).children("img");
		var newid="bar"+(++num);
		var str='<div id= "'+newid+'" style="color:black; position:absolute; font-size:150%;z-index:140;background-color: '+bgcolor+' ;">'
				+'<div id="word"  style="z-index:200; text-align:center; position:absolute;"></div>'
				+'<img id="isloading" style="z-index:150; position:absolute;"  src="image/load.GIF" />'
			   +'</div>';

		$(this).prepend(str);
		setsize();
		PageSize.SetSizeFullScreen($("#"+newid),0,0,PageSize.oriWidth,PageSize.oriHeight);
		for (var i = 0; i < imgs.length; i++) {
			images.push(imgs[i].src);
		}

		$.each(images,function(i,url){
			var img = new Image();
			img.src=url;
			$(img).bind("load",function(e){
				if(e.type!='error'){
					var v = (parseFloat(++imgNum) / images.length).toFixed(2);
					$("#word").html(Math.round(v * 100) + "%");
				}
				index++;
				if(index== images.length){
					$("#word").html("100%");
					$("#"+newid).addClass("hidden"); 
					callback();
				}
				$(this).unbind('load');
			})
			
		});
	
	}

	//全部加载
	$.preAllLoadImg=function(bgcolor,callback){
		var imgNum = 0;
		var images = [];
		var index=0;
		var imgs = document.images;
		var str='<div id="bar" style="color:black;position:absolute;font-size:150%;z-index:100;background-color:'+bgcolor+';">'
				+'<div id="word" style="position:absolute;z-index:100; text-align:center;font-size:70%;"></div>'
				+'<img id="isloading" style="position:absolute;z-index:50"  src="img/load.GIF" />'
				+'</div>';
		$("body").prepend(str);
		setsize();
		PageSize.SetSizeFullScreen($("#bar"),0,0,PageSize.oriWidth,PageSize.oriHeight);
		for (var i = 0; i < imgs.length; i++) {
			images.push(imgs[i].src);
		}
		
		$.each(images,function(i,url){
			var img = new Image();
			img.src=url;
			$(img).bind("load",function(e){
				if(e.type!='error'){
					var v = (parseFloat(++imgNum) / images.length).toFixed(2);
					$("#word").html(Math.round(v * 100) + "%");
					//PageSize.SetSizeFullScreen($("#progress"),548,221,198*v,6);
				}
				index++;
				//$("#word").html($("#word").html() + index + "/" + images.length);
				if(index== images.length - 1){
					$("#word").html("100%");
					$("#bar").addClass("hidden");   
					callback();
				}
			})
		})	
	}

})(jQuery);

//微信接口
function BuildShareData(){
	if(!WXSettings)
		return;
	if(!visitid)
		visitid = -1;
	if(!openid)
		 openid = "";

	shareDataMessage = {
		title: WXSettings.defaulttitle,
		desc: WXSettings.defaultdesc,
		link: WXSettings.link,
		imgUrl: WXSettings.defaultimgUrl
	};
	shareDataTimeline = {
		title: WXSettings.defaulttimeline,
		desc: WXSettings.defaulttimeline,
		link: WXSettings.link,
		imgUrl: WXSettings.defaultimgUrl
	};
	wx.onMenuShareAppMessage({
		title: WXSettings.defaulttitle,
		desc: WXSettings.defaultdesc,
		link: WXSettings.link,
		imgUrl: WXSettings.defaultimgUrl,
		success: function () { 
			$.post("ajax.php?mode=Action&action=ShareAppMessage&page=Index&memo=Share&visitid=" + visitid + "&openid=" + openid +"&token="+token);
		},
		cancel: function () { 
			$.post("ajax.php?mode=Action&action=ShareAppMessage&page=Index&memo=Cancel&visitid=" + visitid + "&openid=" + openid +"&token="+token);
		}
	});
	wx.onMenuShareTimeline({
		title: WXSettings.defaulttimeline,
		desc: WXSettings.defaulttimeline,
		link: WXSettings.link,
		imgUrl: WXSettings.defaultimgUrl,
		success: function () { 
			$.post("ajax.php?mode=Action&action=ShareTimeline&page=Index&memo=Share&visitid=" + visitid + "&openid=" + openid +"&token="+token);
		},
		cancel: function () { 
			$.post("ajax.php?mode=Action&action=ShareTimeline&page=Index&memo=Cancel&visitid=" + visitid + "&openid=" + openid +"&token="+token);
		}
	});
	wx.onMenuShareQQ({
		title: WXSettings.defaulttitle,
		desc: WXSettings.defaultdesc,
		link: WXSettings.link,
		imgUrl: WXSettings.defaultimgUrl,
		success: function () { 
			$.post("ajax.php?mode=Action&action=ShareQQ&page=Index&memo=Share&visitid=" + visitid + "&openid=" + openid +"&token="+token);
		},
		cancel: function () { 
			$.post("ajax.php?mode=Action&action=ShareQQ&page=Index&memo=Cancel&visitid=" + visitid + "&openid=" + openid +"&token="+token);
		}
	});
}

//hide show 方法
$.fn.hide = function() {
	this.addClass("hidden");
};
$.fn.show = function() {
	this.removeClass("hidden");
};

//按钮闪光设置 
// $.fn.FlashButton = function (startTime,intervalTime,angle) {
function FlashButton(btnlight,startTime,intervalTime,angle){
	if(startTime == null)
		startTime = 1000;
	if(intervalTime == null)
		intervalTime = 1500;	
	if(angle == null)
		angle = 0;
	
	var flashContainer=btnlight+"FlashContainer"
	var flash=btnlight+"Flash"
		
	if(!$("#"+flashContainer).length>0){
		FlashButtonDiv(btnlight,flashContainer,flash,angle);
	}
	setTimeout(function(){
		var objleftintro = parseInt($("#"+flash).css("left"));
		var objwidthintro = parseInt($("#"+flash).css("width"));
		$("#"+flash).animate({left : objwidthintro * 2} , 1500 , function(){$("#"+flash).css("left" , objwidthintro * -1.5);});
	} , startTime);
	setTimeout(function(){
		FlashButton(btnlight,startTime,intervalTime,angle);
	},intervalTime);
}
function FlashButtonDiv(btnlight,flashContainer,flash,angle){
	// btnlight=this[0].id;
	conHtml  = "<div id='"+flashContainer+"' class='float' style='overflow:hidden;border-radius:"+angle+"px;-moz-border-radius:"+angle+"px;-webkit-border-radius:"+angle+"px;'>";
	conHtml += "<div id='"+flash+"' class='float buttonlight'></div>";
	conHtml += "</div>";

	// $("#"+btnlight).after(conHtml);
	$("#"+btnlight).before(conHtml);
	
	var textTop = parseInt($("#"+btnlight).css("top"));
	var textLeft = parseInt($("#"+btnlight).css("left"));
	var textWidth = parseInt($("#"+btnlight).css("width"));
	var textHeight = parseInt($("#"+btnlight).css("height"));	
	
	$("#"+flashContainer).css({top:textTop,left:textLeft,width:textWidth,height:textHeight});
	$("#"+flash).css({top:0,left:-2*textLeft,width:textWidth,height:textHeight});
}

//左右翻页--下一页
function ShowNextPage(currentPage , nextPage){
	Settings.CurrentPage = nextPage;
	$("#"+nextPage).css({left:PageSize.windowWidth}).removeClass("hidden").animate({left:0},200,"linear");
	$("#"+currentPage).animate({left:PageSize.windowWidth*-1},200,"linear");
	setTimeout(function(){
		$("#"+currentPage).addClass("hidden");
	},500);
}

//左右翻页--上一页
function ShowLastPage(currentPage , lastPage){
	Settings.CurrentPage = lastPage;
	$("#"+lastPage).css({left:-PageSize.windowWidth}).removeClass("hidden").animate({left:0},200,"linear");
	$("#"+currentPage).animate({left:PageSize.windowWidth},200,"linear");
	setTimeout(function(){
		$("#"+currentPage).addClass("hidden");
	},500);
} 
//上下翻页--下一页
function ShowDownPage(currentPage , nextPage){
	Settings.CurrentPage = nextPage;
	$("#"+nextPage).css({top:PageSize.windowHeight}).removeClass("hidden").animate({top:0},500,"linear");
	$("#"+currentPage).animate({top:PageSize.windowHeight*-1},500,"linear");
	setTimeout(function(){
		$("#"+currentPage).addClass("hidden");
	},700);
}	
//上下翻页--上一页
function ShowUpPage(currentPage , lastPage){
	Settings.CurrentPage = lastPage;
	$("#"+lastPage).css({top:-PageSize.windowHeight}).removeClass("hidden").animate({top:0},500,"linear");
	$("#"+currentPage).animate({top:PageSize.windowHeight},500,"linear");
	setTimeout(function(){
		$("#"+currentPage).addClass("hidden");
	},700);
}

//AjaxPost 需不需等待
function Wait(){
	CheckWaitContainer();
	$("#divWait").removeClass("hidden");
}
function WaitFinish(){
	$("#divWait").addClass("hidden");
}
function CheckWaitContainer(){
	if($("#divWait").length != 0)
		return;
	
	strHtml  = '		<div id="divWait" class="hidden float" style="z-index:200;background:rgba(0,0,0,0.8)">' + "\n";
	strHtml += '			<img id="imgWait" class="float" src="image/load.gif">' + "\n";
	strHtml += '		</div>' + "\n";
	
	$(document.body).append(strHtml);
	
	$("#divWait").SetSizeFullScreen(0,0,PageSize.oriWidth,PageSize.oriHeight);
	$("#imgWait").SetSizeFullScreen(450,280,64,64);
}
$(document).ajaxStart(function(){
	Wait();
});
$(document).ajaxComplete(function(){
	WaitFinish();
});

// AjaxPostNoWait 不触发wait、无需处理返回结果
function AjaxPostNoWait(url,para,callback){ 
	WaitFinish();
	// para.extends({ajaxComplete:WaitFinish();});
	$.post(url,para,callback);
}
// AjaxPostWait 触发wait、处理返回结果
function AjaxPostWait(url,para,callback){ 
	Wait();
	// para.extends({ajaxComplete:Wait();});
	$.post(url,para,callback);
}

