<?php
	include "paras.php";
	$openid = Get("wang");
	$publisher = Get("publish");
	$ua = $_SERVER['HTTP_USER_AGENT'];
	$userInfo=null;
	$inviter=Get("inviter");
	if($inviter==''){
		$inviter=0;
	}
	if($openid == ""){
		$arrInfo = InitCustInfoV3();
		$openid = $arrInfo["openid"];
		$nickname=$arrInfo["nickname"];
		$headimgurl=$arrInfo["headimgurl"];
	} else {
		$userInfo = DBGetDataRowByField("custinfo" , "openid" , $openid);
		$nickname = $userInfo["nickname"];
		$headimgurl = $userInfo["imgurl"];
	}
	$_SESSION["stropenid"]=$openid;
	if($userInfo==null){//没有进行查找
		$userInfo = DBGetDataRowByField("custinfo" , "openid" , $openid);
	}
	if($userInfo==null){//没有找到数据
		$userId = DBInsertTableField("custinfo",array("openid","nickname","imgurl","inviter"), array($openid,$nickname,$headimgurl,$inviter));
		$mobile="";
		$isgiftused=0;
		$giftlevel=0;
	}else{
		$userId=$userInfo["id"];
		$mobile=$userInfo["mobile"];
		$isgiftused=$userInfo["isgiftused"];
		$giftlevel=$userInfo["giftlevel"];
	}

	if($mobile != ""){//是否已经登记过电话信息
		$isjoin = 1;
	}else{
		$isjoin = 0;
	}
	
//微信身份判定是否已经领取过优惠券
	//$visitid = InitVisitidV3();
	$visitid = -1;
	$visitid = VisitHistoryV4($openid,$visitid,"index.php",$inviter,$ua,$publisher);//在visithistory表中插入访问数据

	$stropenid = substr($openid, 0, 10);
	$token = md5($stropenid.$userId); 
	
	$stropenid = substr($openid, 0, 10);
	$strdate = date("YmdHi", time());
	$BarCodePara = md5($userId.$stropenid.$strdate);//二维码参数
	$BarCodePara = substr($BarCodePara, 0, 10);
	
	
	$imgPath = "http://wcloud.wsestar.com/gome201604/img/";
	$imgPath = "img/";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<title>格力动真格</title>
		<link rel="stylesheet" href="style/style.common.css" charset="utf8" />
		<link rel="stylesheet" href="style/style.css" charset="utf8" />
		<style>
			body{margin:0;padding:0;}
			input{position:absolute;z-index:1000}
			canvas{position:absolute;top:0;left:0;}
		</style>
	</head>
	<body>
		<audio loop  id="MusicBg" src="bgmusic.mp3"></audio>
		<audio  id="Music1" src="pull.mp3"></audio>
		<audio  id="Music2" src="move.mp3"></audio>
		<audio  id="Music3" src="coin.mp3"></audio>
		<div id="maincontainer" class="float hidden fullScreen" style="overflow:hidden;">
			<img src="<?=$imgPath?>guideCoupon20.png" class="float hidden">
			<img src="<?=$imgPath?>guideCoupon50.png" class="float hidden">
			<img src="<?=$imgPath?>guideCoupon100.png" class="float hidden">
			<img src="<?=$imgPath?>guideCoupon500.png" class="float hidden">
			<img src="<?=$imgPath?>guideCoupon1000.png" class="float hidden">
			
			<img src="<?=$imgPath?>useCoupon20.png" class="float hidden">
			<img src="<?=$imgPath?>useCoupon50.png" class="float hidden">
			<img src="<?=$imgPath?>useCoupon100.png" class="float hidden">
			<img src="<?=$imgPath?>useCoupon500.png" class="float hidden">
			<img src="<?=$imgPath?>useCoupon1000.png" class="float hidden">
			
			<img id="AllBg" src="<?=$imgPath?>startBg.jpg" class="float fullScreen">
			<div  class="float fullScreen hidden" id="pageStart">
				<img id="startBg" src="<?=$imgPath?>startBg.jpg" class="float fullScreen">
				<img id="startLogo" src="<?=$imgPath?>startLogo.png" class="float">
				<img id="startRibbon" src="<?=$imgPath?>startRibbon.png" class="float hidden">
				<img id="startTitle" src="<?=$imgPath?>startTitle.png" class="float hidden">
				<img id="startTitlelight" src="<?=$imgPath?>startTitlelight.jpg" class="float fullScreen" style="opacity:0;">
				<?php
					for ($l=1; $l<=13; $l++){
				?>
						<img id="startLight<?=$l?>" src="<?=$imgPath?>startLight<?=$l?>.png" class="float startLight hidden">
				<?php
					}
				?>
				<img id="startMachinewhole" src="<?=$imgPath?>startMachinewhole.png" class="float hidden">
				<img id="startMachine" src="<?=$imgPath?>startMachine.png" class="float hidden">
				<img id="startUp" src="<?=$imgPath?>startUp.png" class="float hidden">
				<img id="startDown" src="<?=$imgPath?>startDown.png" class="float hidden">
				<?php
					for ($p=1; $p<=24; $p++){
				?>
						<img id="startLamp<?=$p?>" src="<?=$imgPath?>startLampdark.png" class="float startLamp hidden">
				<?php
					}
					for($i=1; $i<=4; $i++){
				?>
						<div id="machine<?=$i?>" class="float slotMachine hidden">
							<?php
								for($a=0; $a<=9; $a++){
							?>
									<img class="slot" src="<?=$imgPath?><?=$a?>.png" style="display: block;">
							<?php
								}
							?>
						</div>
				<?php
					}
				?>
				<img id="startMoney" src="<?=$imgPath?>startMoney.png" class="float hidden">
				
				<?php
					// for ($m=1; $m<=60; $m++){
				?>
						<!--<img id="startMoney<?//=$m?>" src="<?//=$imgPath?>startMoney.png" class="float" style="opacity:0;">-->
				<?php
					// }
				?>
				<img id="startBtn" src="<?=$imgPath?>startBtn.png" class="float hidden">
			</div>
			<div  class="float fullScreen hidden" id="pageGuide">
				<img id="guideBg" src="<?=$imgPath?>startBg.jpg" class="float fullScreen">
				<img id="guideLogo" src="<?=$imgPath?>startLogo.png" class="float">
				<img id="guideRibbon" src="<?=$imgPath?>startRibbon.png" class="float hidden">
				<img id="guideCoupon" src="<?=$imgPath?>guideCoupon20.png" class="float hidden">
				<img id="guideTitle" src="<?=$imgPath?>guideTitle.png" class="float">	
				<img id="guideInfo" src="<?=$imgPath?>guideInfo.png" class="float hidden">
				<input id="guideName" type="text" style="outline:none;background-color:transparent" class="float guideInput">
				<input id="guidePhone" type="number" style="outline:none;background-color:transparent"class="float guideInput">
				<img id="guideSubmit" src="<?=$imgPath?>guideSubmit.png" class="float guideSubmit hidden">
				<img id="guideRule" src="<?=$imgPath?>guideRule.png" class="float" style="opacity:0;">
			</div>
			<div  class="float fullScreen hidden" id="pageUse">
				<img id="useBg" src="<?=$imgPath?>startBg.jpg" class="float fullScreen">
				<img id="useRibbon" src="<?=$imgPath?>startRibbon.png" class="float">
				<img id="useLogo" src="<?=$imgPath?>startLogo.png" class="float">
				<img id="useCoupon" src="<?=$imgPath?>useCoupon20.png" class="float">
				<img id="useSeal" src="<?=$imgPath?>useSeal.png" class="float hidden">
				<img id="useTitle" src="<?=$imgPath?>useTitle.png" class="float">
				<img id="useText" src="<?=$imgPath?>useText.png" class="float">
				<div id="useCode"  class="float"></div>
				<img id="useRule" src="<?=$imgPath?>guideRule.png" class="float">
				<img id="useShare" src="<?=$imgPath?>useShare.png" class="float useShare">
			</div>
			<div  class="float fullScreen hidden" id="pageRule">
				<img id="ruleBg" src="<?=$imgPath?>startBg.jpg" class="float fullScreen">
				<img id="ruleRibbon" src="<?=$imgPath?>startRibbon.png" class="float">
				<img id="ruleLogo" src="<?=$imgPath?>startLogo.png" class="float">
				<img id="ruleContent" src="<?=$imgPath?>ruleContent.png" class="float">
				<img id="ruleTitle" src="<?=$imgPath?>ruleTitle.png" class="float">
				<div id="ruleText" class="float" style="overflow:auto;color:white;-webkit-overflow-scrolling:touch;">
				<p>1、每位用户限得一张优惠券。</p>
				<p>2、所中电子优惠券以二维码形式保存于活动页面；</p>
				<p>3、已购机用户付款时出示活动页面的电子优惠券二维码，待格力专卖店销售员扫码核销无误即可减现；</p>
				<p>4、电子优惠券不可兑换现金，仅限于购买格力家用空调（不含5P及以上机型）、格力家用中央空调、晶弘冰箱、净水机、净化器时使用，其余产品不参与；</p>
				<p>5、每台机型限用一张，同张电子优惠券不可重复使用；</p>
				<p>6、电子优惠券仅限在活动时间内使用，逾期作废。</p>
				<p>7、本次活动中优惠券仅限从活动页面参加活动的用户获得。一旦发现有使用技术手段刷券的行为，将取消优惠券使用资格。</p>
				<p align="center">【技术支持：西安传睿】</p>
				</div>
				<img id="ruleBack" src="<?=$imgPath?>ruleBack.png" class="float">
			</div>
			<div  class="float fullScreen hidden" id="pageShare" >
				<div id="shareBg" class="float fullScreen" style="background:#000;opacity:0.7;"></div>
				<img id="shareContent" src="<?=$imgPath?>shareContent.png" class="float">
				<img id="shareArrow" src="<?=$imgPath?>shareArrow.png" class="float">
			</div>
		</div>
	</body>
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.common.js" ></script>
	<script  type="text/javascript" src="http://weixin.wsestar.com/common/script.js" ></script>
	<script type="text/javascript" src="http://cdn.staticfile.org/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
	<script src="js/jquery.slotmachine.js" charset="utf-8"></script>
	<script type="text/javascript">
		var Settings = {};
		Settings.InfoSubmit = false;
		Settings.LampNo = 0;
		Settings.HaveDraw = false;
		// Settings.Moneysettime = 500;
		Settings.Continueloop = true;
		Settings.MachineReturn1 = 0;
		Settings.MachineReturn2 = 0;
		Settings.MachineReturn3 = 0;
		Settings.StartResult = "0";
		Settings.LampStartno = 3;
		Settings.LampEndno = 1;
		
		var SHAKE_THRESHOLD = 400;
        var last_update = 0;
		var index=0;
        var x = y = z = last_x = last_y = last_z = 0;
		var w_curTime=0;
		var MusicBg=document.getElementById("MusicBg");
		var Music_1=document.getElementById("Music1");
		var Music_2=document.getElementById("Music2");
		var Music_3=document.getElementById("Music3");
		
		var WXSettings = {};
		WXSettings.defaulttitle="格力动真格";
		WXSettings.defaultdesc="格力自带省钱属性的摇奖游戏，再不玩你就out了！";
		WXSettings.link='<?php echo URL_BASE; ?>index-go.php?inviter=<?=$userId?>';
		WXSettings.defaultimgUrl='<?php echo URL_BASE; ?><?=$imgPath?>startLogo.jpg';
		WXSettings.defaulttimeline="格力自带省钱属性的摇奖游戏，再不玩你就out了！";
	
		PageSize.oriHeight = 1008;
		PageSize.oriWidth = 640;
		PageSize.windowHeight = $(window).height();
		PageSize.windowWidth = $(window).width();
		
		var openid = "<?=$openid?>";
		var visitid = "<?=$visitid?>";
		var isjoin = "<?=$isjoin?>";
		var token = "<?=$token?>";
		var userId = "<?=$userId?>";
		var isgiftused = "<?=$isgiftused?>";//0-未使用；1-已使用；
		var giftlevel = "<?=$giftlevel?>";//0-未抽中；1-已抽中；
		// var openid = "a";
		// var visitid = "1";
		// var isgiftused = "0";
		// var isjoin = "0";
		// var giftlevel = "0";
		
		
		var touchEvents = {
			touchstart: "touchstart",
			touchmove: "touchmove",
			touchend: "touchend",
			/**
			 * @desc:判断是否pc设备，若是pc，需要更改touch事件为鼠标事件，否则默认触摸事件
			 */
			initTouchEvents: function () {
				if (isPC()) {
					this.touchstart = "mousedown";
					this.touchmove = "mousemove";
					this.touchend = "mouseup";
				}
			}
		};
		
		
		$(document).ready(function(){
			MusicBg.play();
			MusicBg.pause();
			$("#AllBg").show();
			SetSizes();
			$.preAllLoadImg("transparent",function(){
				$("#loading").addClass("hidden");
				OnLoad();
			});
		});
		
		// window.onload = OnLoad;
		
		function OnLoad(){
			// SetSizes();	
			BindEvents();
			machine1 = $("#machine1").slotMachine({
				active	: 0,
				delay	: 80,
				direction: 'down',
				randomize:function(){return Settings.MachineReturn1;}
			});
			machine2 = $("#machine2").slotMachine({
				active	: 9,
				delay	: 80,
				direction: 'down',
				randomize:function(){return Settings.MachineReturn2;}
			});
			machine3 = $("#machine3").slotMachine({
				active	: 2,
				delay	:80,
				direction: 'down',
				randomize:function(){return Settings.MachineReturn3;}
			});
			machine4 = $("#machine4").slotMachine({
				active	: 8,
				delay	: 80,
				direction: 'down',
				randomize:function(){return 0;}
			});
			if(isjoin!="0"){
				Settings.InfoSubmit = true;
				Settings.StartResult = giftlevel;
				$("#guideCoupon").attr("src","<?=$imgPath?>guideCoupon"+Settings.StartResult+".png");
				$("#useCoupon").attr("src","<?=$imgPath?>useCoupon"+Settings.StartResult+".png");
				$("#pageUse").show();
				var barcode = "http://www.wsestar.com/test/gree201609/checkout.php?id=<?php echo $userId; ?>&p=<?php echo $BarCodePara; ?>";
				$("#useCode").qrcode({ 
					render: "canvas", //方式 
					width: OffsetLeftFullScreen(318), //宽度 
					height:OffsetLeftFullScreen(315), //高度 
					text: barcode //二维码识别参数 
				});
			}else{
				if(giftlevel=="0"){
					ShowPageStart();
					StartGetResult();
				}else{
					Settings.StartResult = giftlevel;
					$("#guideCoupon").attr("src","<?=$imgPath?>guideCoupon"+Settings.StartResult+".png");
					$("#useCoupon").attr("src","<?=$imgPath?>useCoupon"+Settings.StartResult+".png");
					$("#pageGuide").show();
					ShowPageGuide();
				}
			}
			
			if(isgiftused=="0"){
				$("#useSeal").hide();
			}else{
				$("#useSeal").show();
			}
		}
		function ShowPageStart(){
			MusicBg.play();
			$("#pageStart").show();
			ShowLightstart();
			Settings.LightstartInterval = setInterval(ShowLightstart,1000);	
			$("#startTitle").addClass("startTitleIn").show();
			setTimeout(function(){
				$("#startRibbon").addClass("startRibbonIn").show();
				$("#startMachinewhole").addClass("startMachineIn").show();
			},500)
			setTimeout(function(){
				$("#startMoney").addClass("startRibbonIn").show();
			},700)
			setTimeout(function(){
				$("#startTitlelight").animate({"opacity":1},600,"linear");
				$("#startMachinewhole").hide();
				$("#startMachine,.startLamp,#startUp,#startBtn,.slotMachine").show();
				ShowLampstart();
				Settings.LampstartInterval = setInterval(ShowLampstart,300);
			},700+200)
		}
		function ShowPageGuide(){
			setTimeout(function(){
				$("#guideRibbon").addClass("startRibbonIn").show();
				$("#guideCoupon").addClass("guideCouponIn").show();
			},200)
			setTimeout(function(){
				$("#guideInfo").ShowText("lefttoright",600);
				$("#guideRule").animate({"opacity":1},600,"linear");
			},600)
			setTimeout(function(){
				$("#guideSubmit").ShowText("lefttoright",500);
				$("#guideCoupon").removeClass("guideCouponIn");
			},1100)
		}
		function StartGetResult(){
			url = "ajax.php?mode=GetGift&userid="+userId+"&token="+token;
			$.get(url ,function(data){
				console.log(data);
				// data = "1000";
				Settings.StartResult = data;
				switch(data){
					case "20":
						Settings.MachineReturn3=2;
						break;
					case "50":
						Settings.MachineReturn3=5;
						break;
					case "100":
						Settings.MachineReturn2=1;
						break;
					case "500":
						Settings.MachineReturn2=5;
						break;
					case "1000":
						Settings.MachineReturn1=1;
						break;
				}
				RollInfinite();
			});
		}
		function BindEvents(){
			var oldTop = OffsetTopFullScreen(39);
			var oldWidth = OffsetLeftFullScreen(267);
			var oldHeight = OffsetTopFullScreen(161);
			var newTop = OffsetTopFullScreen(39+10);
			var newWidth = OffsetLeftFullScreen(267-10);
			var newHeight = OffsetTopFullScreen(161-10);
			setInterval(function(){
				$("#shareArrow").animate({top:newTop,width:newWidth,height:newHeight},500,"linear").animate({top:oldTop,width:oldWidth,height:oldHeight},500,"linear");
			},1000)
			
			 $("#startBtn,#startUp").bind(touchEvents.touchend, function (event) {
				StartClickDraw();
			});
			// $("#startBtn,#startUp").click(function(){
				// StartClickDraw();
			// });			
			$("#guideRule").click(function(){
				Settings.InfoSubmit = false;
				ShowNextPage("pageGuide","pageRule");
			});
			$("#useRule").click(function(){
				ShowNextPage("pageUse","pageRule");
				$("#pageGuide").removeClass("GuideOut");
				$("#pageUse").removeClass("UseIn");
			});
			$("#useShare").click(function(){
				$("#pageShare").show();
			});
			$("#ruleBack").click(function(){
				if(Settings.InfoSubmit){
					ShowLastPage("pageRule","pageUse");
				}else
					ShowLastPage("pageRule","pageGuide");
			}); 
			$("#pageShare").click(function(){
				$("#pageShare").hide();
			});
			$("#guideSubmit").click(function(){
				GetUserInfo();
			}); 
		}
		
		function StartClickDraw(){
			MusicBg.pause();
			Music_1.play();
			if(Settings.HaveDraw)return;
			Settings.HaveDraw = true;
			Settings.Continueloop = false;
			machine1.settings.delay = 800;
			machine2.settings.delay = 800;
			machine3.settings.delay = 800;
			machine4.settings.delay = 800;
			
			$("#startUp").hide();
			$("#startDown").show();
			setTimeout(function(){
				$("#startUp").show();
				$("#startDown").hide();
			},100)
			setTimeout(function(){
				Music_2.play();
			},450)
			RollNumbers();
			setTimeout(function(){
				clearInterval(Settings.LightstartInterval);
				clearInterval(Settings.LampstartInterval);
			},1500)
			setTimeout(function(){
				ShowLampend();
				Settings.LampendInterval = setInterval(ShowLampend,100);
			},1500+300)
			setTimeout(function(){
				// Settings.Moneysettime = 100;
				$("#startMoney").animate({"opacity":0},600,"linear");
				$(".startLamp").attr("src","<?=$imgPath?>startLampdark.png");
				ShowLightend();
				Settings.LightendInterval = setInterval(ShowLightend,1000);
			},1500+1000)
			setTimeout(function(){
				var coin=new Coin();
			},1500+2500)
		}
		function ShowLightstart(){
			for(i=13;i>=3;i--){
				(function(i){
					setTimeout(function(){
						$("#startLight"+i).removeClass("hidden").css("opacity",0).animate({opacity:1},300).animate({opacity:0},300);
					},100*(14-i))
				})(i)
			}
		}
		function ShowLightend(){
			for(i=3;i<=13;i++){
				(function(i){
					setTimeout(function(){
						$("#startLight"+i).removeClass("hidden").css("opacity",0).animate({opacity:1},300).animate({opacity:0},300);
					},100*(i-2))
				})(i)
			}
		}
		function ShowLampstart(){
			Settings.LampStartno--;
			if(Settings.LampStartno == 0)	Settings.LampStartno=3;
			for(i=Settings.LampStartno;i<=24;i+=3){
				(function(i){
					$("#startLamp"+i).attr("src","<?=$imgPath?>startLamplight.png");
					setTimeout(function(){
						$("#startLamp"+i).attr("src","<?=$imgPath?>startLampdark.png");
					},300)
				})(i)
			}
		}
		function ShowLampend(){
			Settings.LampEndno++;
			if(Settings.LampEndno == 4)	Settings.LampEndno=1;
			for(i=Settings.LampEndno;i<=24;i+=3){
				(function(i){
					$("#startLamp"+i).attr("src","<?=$imgPath?>startLamplight.png");
					setTimeout(function(){
						$("#startLamp"+i).attr("src","<?=$imgPath?>startLampdark.png");
					},100)
				})(i)
			}
		}
		function RollInfinite(){
			if(!Settings.Continueloop)
				return;
			machine1.prev();
			machine2.next();
			machine3.prev();
			machine4.next();
			
			setTimeout(RollInfinite,500);
		}
		function RollNumbers(){
			machine1.shuffle(2);
			machine2.shuffle(3);
			machine3.shuffle(4);
			//machine4.shuffle(5,DisplayResults);
			machine4.shuffle(5);
			DisplayResults();
		}
		function DisplayResults(){								//定时撒金币、判断机器是否停止
			console.log("start",machine4.isRunning);
			setTimeout(function(){
				Settings.GetMachine4Set = setInterval(function(){
					console.log("set",machine4.isRunning);
					if(!machine4.isRunning){
						console.log("next",machine4.isRunning);
						DisplayNextPage();
					}
				},200)
			},1000)
		}
		function DisplayNextPage(){		
			clearInterval(Settings.GetMachine4Set);
			if(Settings.StartResult!="-1" && Settings.StartResult!="-4" && Settings.StartResult!="0"){
				$("#guideCoupon").attr("src","<?=$imgPath?>guideCoupon"+Settings.StartResult+".png");
				$("#useCoupon").attr("src","<?=$imgPath?>useCoupon"+Settings.StartResult+".png");
				setTimeout(function(){
					clearInterval(Settings.LightendInterval);
					clearInterval(Settings.LampendInterval);
					clearInterval(Settings.MoneyLeftInterval);
					clearInterval(Settings.MoneyRightInterval);
					MusicBg.play();
					ShowNextPage("pageStart","pageGuide");
					ShowPageGuide();
				},800)
			}else{
				Message("服务器忙，请稍候再试。");
			}
		}
		function GetUserInfo(){
			var name= $("#guideName").val();
			var phone= $("#guidePhone").val();
			if(name == ""){
				Message("请填写姓名。");
				return;
			}
			if(phone == ""){
				Message("请填写电话。");
				return;
			}
			if(!(/^1[3|4|5|7|8]\d{9}$/.test(phone))){  
				Message("电话号码格式有误。");
				return;
			}
			
			url = "ajax.php?mode=SubmitInfo";
			$.post(url , {
				userid : userId ,
				token : token ,
				name : name ,
				mobile : phone
			} , function(data){
				console.log(data);
				switch (data){
					case "1":
						Settings.InfoSubmit = true;
						$("#pageUse").css({top:0,left:0});
						$("#pageGuide").addClass("GuideOut");
						var barcode = "http://www.wsestar.com/test/gree201609/checkout.php?id=<?php echo $userId; ?>&p=<?php echo $BarCodePara; ?>";
						$("#useCode").qrcode({ 
							render: "canvas", //方式 
							width: OffsetLeftFullScreen(318), //宽度 
							height:OffsetLeftFullScreen(315), //高度 
							text: barcode //二维码识别参数 
						});
						setTimeout(function(){
							$("#pageGuide").hide();
							$("#pageUse").addClass("UseIn").show();
						},250)
						break;
					case "-8":
						Message("该手机号已经领取过优惠券!");
					default:
						Message("服务器忙，请稍候再试。");
				}
			});
		}
		
		
		function SetSizes(){
			$("#startLogo").SetSizeFullScreen(913,234,215,69);	
			$("#startTitle").SetSizeFullScreen(0,0,640,490);	
			$("#startRibbon").SetSizeFullScreen(39,0,640,789);	
			$(".startLight").SetSizeFullScreen(85,0,640,851);			
			$("#startMachinewhole").SetSizeFullScreen(332,0,640,587);
			$("#startMachine").SetSizeFullScreen(332,0,640,587);
			$("#startMoney").SetSizeFullScreen(593,24,594,172);
			$("#startBtn").SetSizeFullScreen(684,144,346,84);					
			$("#startUp").SetSizeFullScreen(362,532,63,196);			
			$("#startDown").SetSizeFullScreen(525,545,119,183);			
			$("#startLamp1").SetSizeFullScreen(429,90,22,23);	
			$("#startLamp2").SetSizeFullScreen(419,136,22,23);	
			$("#startLamp3").SetSizeFullScreen(419,191,22,23);	
			$("#startLamp4").SetSizeFullScreen(419,250,22,23);	
			$("#startLamp5").SetSizeFullScreen(419,311,22,23);	
			$("#startLamp6").SetSizeFullScreen(419,370,22,23);	
			$("#startLamp7").SetSizeFullScreen(419,428,22,23);	
			$("#startLamp8").SetSizeFullScreen(419,478,22,23);	
			$("#startLamp9").SetSizeFullScreen(429,517,22,23);	
			$("#startLamp10").SetSizeFullScreen(472,521,22,23);	
			$("#startLamp11").SetSizeFullScreen(514,521,22,23);	
			$("#startLamp12").SetSizeFullScreen(560,521,22,23);	
			$("#startLamp13").SetSizeFullScreen(606,516,22,23);	
			$("#startLamp14").SetSizeFullScreen(612,462,22,23);	
			$("#startLamp15").SetSizeFullScreen(612,412,22,23);	
			$("#startLamp16").SetSizeFullScreen(612,357,22,23);	
			$("#startLamp17").SetSizeFullScreen(612,296,22,23);	
			$("#startLamp18").SetSizeFullScreen(612,239,22,23);	
			$("#startLamp19").SetSizeFullScreen(612,182,22,23);	
			$("#startLamp20").SetSizeFullScreen(612,135,22,23);	
			$("#startLamp21").SetSizeFullScreen(599,90,22,23);	
			$("#startLamp22").SetSizeFullScreen(557,90,22,23);	
			$("#startLamp23").SetSizeFullScreen(515,90,22,23);	
			$("#startLamp24").SetSizeFullScreen(473,90,22,23);	
			
			$("#machine1").SetSizeFullScreen(469,138,68,98);	
			$("#machine2").SetSizeFullScreen(469,231,68,98);	
			$("#machine3").SetSizeFullScreen(469,325,68,98);	
			$("#machine4").SetSizeFullScreen(469,419,68,98);			
			$(".slot").OffsetZoom({width:68,height:98});
			$(".slot").css("padding-top",OffsetTopFullScreen(5));
			$(".slot").css("padding-bottom",OffsetTopFullScreen(5));
			
			
			$(".guideInput").css("font-size",OffsetLeftFullScreen(25));
			$("#guideLogo").SetSizeFullScreen(913,234,215,69);	
			$("#guideRibbon").SetSizeFullScreen(39,0,640,789);	
			$("#guideTitle").SetSizeFullScreen(97,71,499,151);	
			$("#guideCoupon").SetSizeFullScreen(211,38,566,291);	
			$("#guideInfo").SetSizeFullScreen(532,81,468,230);	
			$("#guideName").SetSizeFullScreen(597,171,354,49);	
			$("#guidePhone").SetSizeFullScreen(681,171,354,49);	
			$("#guideSubmit").SetSizeFullScreen(762,96,439,103);	
			$("#guideRule").SetSizeFullScreen(25,467,150,49);		
	
			$("#useLogo").SetSizeFullScreen(913,234,215,69);	
			$("#useRibbon").SetSizeFullScreen(39,0,640,789);
			$("#useCoupon").SetSizeFullScreen(181,38,566,285);				
			$("#useSeal").SetSizeFullScreen(181,38,566,285);				
			$("#useTitle").SetSizeFullScreen(64,71,499,151);	
			$("#useText").SetSizeFullScreen(465,71,499,46);	
			$("#useCode").SetSizeFullScreen(566,164,318,315);	
			$("#useRule").SetSizeFullScreen(25,467,150,49);	
			$("#useShare").SetSizeFullScreen(530,209,245,31);	

			$("#ruleText").css({"font-size":OffsetLeftFullScreen(27)});
			$("#ruleText p").css({"line-height":OffsetTopFullScreen(2.5)});
			$("#ruleLogo").SetSizeFullScreen(913,234,215,69);
			$("#ruleRibbon").SetSizeFullScreen(39,0,640,789);	
			$("#ruleTitle").SetSizeFullScreen(102,69,499,170);	
			$("#ruleContent").SetSizeFullScreen(216,69,499,630);	
			$("#ruleText").SetSizeFullScreen(262,107,425,548);	
			$("#ruleBack").SetSizeFullScreen(23,527,88,50);	

			$("#shareContent").SetSizeFullScreen(328,51,529,340);	
			// $("#shareClose").SetSizeFullScreen(333,504,45,42);	
			$("#shareArrow").SetSizeFullScreen(39,341,267,161);	
			
			ShowPageRegist();

			// json = eval('(' + '<?php  //echo GetWXConfigDataV2(); ?>' + ')')
			json = eval('(' + '<?php echo GetWXConfigData_www_v2(); ?>' + ')')
// json.debug = true;
			wx.config(json);
			wx.error(function (res) {
				//alert(res.errMsg);
				//alert(res);
			});
		}
		
		function ShowPageRegist(lastpage){
			//$.post("ajax.php?mode=action&action=showpage2&page=action_index&openid=<?php //echo $openid; ?>");
			if(lastpage == null)
				lastpage = "";
			
			desc = Settings.defaultdesc;
			imgUrl = Settings.defaultimgUrl;
			BuildShareData();

			$("#maincontainer").removeClass("hidden")
		}
   </script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript">
		function BuildShareData(){
			if(!WXSettings)
				return;
			if(!visitid)
				visitid = -1;
			if(!userId)
				 userId = -1;
			
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
					$.post("ajax.php?mode=Action&action=ShareAppMessage&page=Index&memo=Share&visitid=" + visitid + "&userid=" + userId +"&token="+token);
				}
				/* cancel: function () { 
					$.post("ajax.php?mode=Action&action=ShareAppMessage&page=Index&memo=Cancel&visitid=" + visitid + "&userid=" + userId +"&token="+token);
				} */
			});
			wx.onMenuShareTimeline({
				title: WXSettings.defaulttimeline,
				desc: WXSettings.defaulttimeline,
				link: WXSettings.link,
				imgUrl: WXSettings.defaultimgUrl,
				success: function () { 
					$.post("ajax.php?mode=Action&action=ShareTimeline&page=Index&memo=Share&visitid=" + visitid + "&userid=" + userId+"&token="+token );
				}
				/* cancel: function () { 
					$.post("ajax.php?mode=Action&action=ShareTimeline&page=Index&memo=Cancel&visitid=" + visitid + "&userid=" + userId +"&token="+token);
				} */
			});
			wx.onMenuShareQQ({
				title: WXSettings.defaulttitle,
				desc: WXSettings.defaultdesc,
				link: WXSettings.link,
				imgUrl: WXSettings.defaultimgUrl,
				success: function () { 
					$.post("ajax.php?mode=Action&action=ShareQQ&page=Index&memo=Share&visitid=" + visitid + "&userid=" + userId +"&token="+token);
				}
				/* cancel: function () { 
					$.post("ajax.php?mode=Action&action=ShareQQ&page=Index&memo=Cancel&visitid=" + visitid + "&userid=" + userId +"&token="+token);
				} */
			});
		}

		wx.ready(function () {
			BuildShareData();
			/* wx.hideMenuItems({
				menuList: [
					'menuItem:share:timeline' // 隐藏分享到朋友圈
				]
			});  */
		});

	</script>
	<script>
	function deviceMotionHandler(eventData) {
		var acceleration = eventData.accelerationIncludingGravity;
		var curTime = new Date().getTime();
		if ((curTime - last_update) > 100) {
			var diffTime = curTime - last_update;
			last_update = curTime;
			x = acceleration.x;
			y = acceleration.y;
			z = acceleration.z;
			var speed = Math.abs(x + y + z - last_x - last_y - last_z) / diffTime * 10000;
			var delta=Math.abs(x + y + z - last_x - last_y - last_z);
			if (speed > SHAKE_THRESHOLD) {
				if((curTime-w_curTime)>2000){
					w_curTime!=0 && new Coin({density:Math.round(delta)});
					w_curTime=curTime;
				}
			}
			last_x = x;
			last_y = y;
			last_z = z;
		}
	}
	function Coin(opts){
		//默认参数
		this.defaults={
			// coinSrc:"http://gw.alicdn.com/tps/i3/TB1QJ5DGpXXXXaBXXXXuv2kGFXX-39-39.png_40x40Q50s150.jpg",     //金币图片地址
			coinSrc:"<?=$imgPath?>startMoneyone.png",     //金币图片地址
			// audioSrc:"http://download.taobaocdn.com/freedom/26370/media/shake.mp3",	//金币音频地址
			audioSrc:"coin.mp3",	//金币音频地址
			coinWidth:OffsetLeftFullScreen(40),           //金币宽度
			coinHeight:OffsetTopFullScreen(40),          //金币高度
			density:30
		};
		this.settings=this._extendDeep(this.defaults,opts);   //深拷贝
		this.density=this.settings.density;                   //密度，即金币个数
		this.timeLag=1000;                                    //金币散落的事件间隔，数字越大表示间隔越大
		this.coinWidth=this.settings.coinWidth;               //金币宽度
		this.coinHeight=this.settings.coinHeight;             //金币高度
		this.wrapWidth=0;
		this.wrapHeight=0;
		this._init();
	}
	Coin.prototype={
		constructor:Coin,
		/**
		 * 动画初始化方法
		 * @method _init
		**/
		_init:function(){
			//初始化包括尺寸大小
			this.wrapWidth=document.documentElement.clientWidth;
			this.wrapHeight=document.documentElement.clientHeight;
			this._requestAnimationFrame();
			this._createCanvas();
			this._createAudio();
		},
		/**
		 * 对象深拷贝方法
		 * @method _extendDeep
		 * @param  {object} parent 父对象
				   {object} child  子对象
		   @return {object} child  父对象继承给子对象
		**/
		_extendDeep:function(child,parent){
			var i,
			toStr = Object.prototype.toString,
			astr = "[object Array]";
			child = child || {};
			for (i in parent) {
				if (parent.hasOwnProperty(i)) {
					if (typeof parent[i] === "object") {
						child[i] = (toStr.call(parent[i]) === astr) ? [] : {};
						extendDeep(parent[i], child[i]);
					} else {
						child[i] = parent[i];
					}
				}
			}
			return child;
		},
		/**
		 * requestAnimationFrame做兼容
		 * @method _requestAnimationFrame
		**/
		_requestAnimationFrame:function(){
			var lastTime = 0;
			var vendors = ['webkit', 'moz'];
			for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
				window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
				window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame'] ||    // name has changed in Webkit
											  window[vendors[x] + 'CancelRequestAnimationFrame'];
			}
			if (!window.requestAnimationFrame) {
				window.requestAnimationFrame = function(callback, element) {
					var currTime = new Date().getTime();
					var timeToCall = Math.max(0, 16.7 - (currTime - lastTime));
					var id = window.setTimeout(function() {
						callback(currTime + timeToCall);
					}, timeToCall);
					lastTime = currTime + timeToCall;
					return id;
				};
			}
			if (!window.cancelAnimationFrame) {
				window.cancelAnimationFrame = function(id) {
					clearTimeout(id);
				};
			}
		},
		/**
		 * 创建canvas画布
		 * @method _createCanvas
		**/
		_createCanvas:function(){
			var _self=this;
			this.canvas=document.createElement('canvas');
			this.canvas.setAttribute("data-id",Date.now());
			if(!this.canvas.getContext){
				alert("您的浏览器不支持canvas");
				return;
			}
			this.context=this.canvas.getContext('2d');
			this.canvas.width=this.wrapWidth;
			this.canvas.height=this.wrapHeight;
			var oBody=document.getElementsByTagName('body')[0];
			oBody.appendChild(this.canvas);
			this._createCacheCanvas();
		},
		_createCacheCanvas:function(){
			var _self=this;
			this.cacheCanvas=document.createElement('canvas');
			this.cacheContext=this.cacheCanvas.getContext('2d');
			this.cacheCanvas.width=this.wrapWidth;
			this.cacheCanvas.height=this.wrapHeight;
			this.coinImg=new Image();
			this.coinImg.src=this.settings.coinSrc;
			this.coinImg.onload=function(){
				_self._startCacheCanvasAnim();
			}
		},
		/**
		 * 执行金币绘制动画
		 * @method _startCanvasAnim
		**/
		_startCacheCanvasAnim:function(){
			var _self=this;
			var availWidth=this.cacheCanvas.width-this.coinWidth;
			var availHeight=this.cacheCanvas.height-this.coinHeight;
			//var disX=availWidth/this.density;  //每个硬币X轴的间距
			var coinRange=availWidth*this.density/(this.density+15);
			var rangeStart=(availWidth-coinRange)/2;
			var g=9.8*280;   //重力加速度
			var bPlayAudio=false;
			var coinAttrArr=[];  //存储金币下落过程中的一些属性参数
			for(var i=0;i<_self.density;i++){
				coinAttrArr[i]={
					rndX:Math.random(),                                    //存储金币开始降落x轴随机值
					rndOrder:Math.round(Math.random()*_self.timeLag/17),   //存储金币撒落顺序的一个数组
					time:0,									               //存储金币绘制的具体时间
					top:0,                                                 //存储金币绘制距离顶部的距离
					left:0,                                                //存储金币弹起后距离左边的距离
					endSpeed:0,                                            //存储金币第一次接触地面的速度
					bEnd:false,								               //存储金币是否触碰到地面
					reDownSpeed:0,                                         //存储金币弹起后重新降落的速度
					reDownHDelta:Math.random()*100+250,                    //存储金币弹起的高度参数，随机值250~350之间
					rndOffsetX:Math.random()*0.06+0.97                     //存储金币x轴的偏移量，随机值0.97~1.03之间
				}
			}
			var startTime =  Date.now();  //开始绘制前的时间
			function draw(){
				var drawStart = Date.now();  //记录重绘的结束事件
				var diff = (drawStart - startTime)/1000;  //计算每次重绘所需要的事件，单位为秒
				startTime = drawStart;   //结束事件传给开始事件
				_self.context.clearRect(0,0,_self.canvas.width,_self.canvas.height);  //清除画布，方便重绘
				_self.cacheContext.clearRect(0,0,_self.cacheCanvas.width,_self.cacheCanvas.height);  //清除画布，方便重绘
				_self.cacheContext.save();
				//根据金币个数循环绘制金币
				for(var i=0;i<_self.density;i++){
					if((coinAttrArr[i].rndOrder==0&&coinAttrArr[i].time==0)){   //如果顺序为0，表示开始下落，同时下落的初始时间为0时，赋值初始时间
						coinAttrArr[i].time=diff;
					}
					if(coinAttrArr[i].time>0){     //如果初始事件大于0，表示已经在下落过程中,则每次的初始时间递增
						coinAttrArr[i].time=coinAttrArr[i].time+diff;
					}
					if(coinAttrArr[i].rndOrder==0){  //如果顺序为0，开始下落，则开始绘制金币
						if(!coinAttrArr[i].bEnd){   //金币下落（过程一），自由落体运动
							coinAttrArr[i].top=g*Math.pow(coinAttrArr[i].time,2)/2-_self.coinHeight;   //自由落体加速度运动，求下落的高度
							//coinAttrArr[i].left=disX*coinAttrArr[i].rndX+i*disX;
							coinAttrArr[i].left=coinRange*coinAttrArr[i].rndX+rangeStart;
						}else if(coinAttrArr[i].endSpeed==0){   //金币弹起后在空中重新下落（过程三）
							coinAttrArr[i].reDownSpeed=coinAttrArr[i].reDownSpeed*1.1;
							coinAttrArr[i].top=coinAttrArr[i].top+coinAttrArr[i].reDownSpeed;
							coinAttrArr[i].left=coinAttrArr[i].left*coinAttrArr[i].rndOffsetX;
						}else{   //金币弹起（过程二）
							coinAttrArr[i].endSpeed=-Math.abs(coinAttrArr[i].endSpeed*0.96);
							if(Math.abs(coinAttrArr[i].endSpeed)<1) coinAttrArr[i].endSpeed=0;
							coinAttrArr[i].top=coinAttrArr[i].top+coinAttrArr[i].endSpeed;
							coinAttrArr[i].left=coinAttrArr[i].left*coinAttrArr[i].rndOffsetX;
						}
						//金币第一次降落超过地面时，将其高度设置和地面齐平
						if(coinAttrArr[i].top>_self.cacheCanvas.height-_self.coinHeight&&!coinAttrArr[i].bEnd){
							coinAttrArr[i].top=_self.cacheCanvas.height-_self.coinHeight;
						}
						//金币落地时，计算落地的速度
						if(coinAttrArr[i].top==_self.cacheCanvas.height-_self.coinHeight){
							coinAttrArr[i].endSpeed=g*coinAttrArr[i].time/coinAttrArr[i].reDownHDelta;
							coinAttrArr[i].reDownSpeed=coinAttrArr[i].endSpeed/10;
							coinAttrArr[i].bEnd=true;
						}
						//绘制金币
						_self.cacheContext.drawImage(_self.coinImg,coinAttrArr[i].left,coinAttrArr[i].top,_self.coinWidth,_self.coinHeight);
					}
					coinAttrArr[i].rndOrder=coinAttrArr[i].rndOrder==0?0:coinAttrArr[i].rndOrder-1;//顺序每一次重绘则递减一次，直到为0时，代表开始下落
				}
				_self.cacheContext.restore();
				_self.context.drawImage(_self.cacheCanvas,0,0,_self.canvas.width,_self.canvas.height);
				var firstH=_self._maxNum(coinAttrArr,"top");//求降落过程中高度最大的金币高度
				if(firstH>=_self.cacheCanvas.height-_self.coinHeight&&!bPlayAudio){
					_self._playAudio();
					bPlayAudio=true;
				}
				var lastH=_self._minNum(coinAttrArr,"top");//求降落过程中高度最小的金币高度
				if(lastH<=_self.cacheCanvas.height+_self.coinHeight){ //最后一个金币高度超出canvas的高度停止重绘
					window.requestAnimationFrame(draw);  //重绘，递回调用绘制方法
				}else{
					console.log("金币都撒完了");
					_self._destory();
				}
			}
			window.requestAnimationFrame(draw);  //第一次绘制
		},
		/**
		 * 求最小值
		 * @method _minNum
		 * @param   {arr}    arr  属性数组
					{string} attr 数组下的属性名称
		 * @return  {number}      返回数组下属性值最小的值
		**/
		_minNum:function(arr,attr){
			var tempArr=[];
			for(var i=0;i<arr.length;i++){
				tempArr.push(arr[i][attr]);
			}
			return tempArr.sort(function(a,b){return a-b})[0];
		},
		/**
		 * 求最大值
		 * @method _minNum
		 * @param   {arr}    arr  属性数组
					{string} attr 数组下的属性名称
		 * @return  {number}      返回数组下属性值最大的值
		**/
		_maxNum:function(arr,attr){
			var tempArr=[];
			for(var i=0;i<arr.length;i++){
				tempArr.push(arr[i][attr]);
			}
			return tempArr.sort(function(a,b){return b-a})[0];
		},
		/**
		 * 创建音频对象
		 * @method _createAudio
		**/
		_createAudio:function(){
			this.audio=document.createElement('audio');
			this.audio.setAttribute("preload","load");
			var oSource=document.createElement('source');
			oSource.setAttribute("src",this.settings.audioSrc);
			oSource.setAttribute("type","audio/mp3");
			this.audio.appendChild(oSource);
			var oBody=document.getElementsByTagName('body')[0];
			oBody.appendChild(this.audio);
		},
		/**
		 * 播放音频
		 * @method _playAudio
		**/
		_playAudio:function(){
			this.audio.play();
		},
		/**
		 * 销毁canvas和audio
		 * @method _destory
		**/
		_destory:function(){
			var oBody=document.getElementsByTagName('body')[0];
			oBody.removeChild(this.canvas);
			oBody.removeChild(this.audio);
		}
	}
</script>
</html>