<?php
	include "paras.php";
	$salerOpenId = 'oFb3-tngKOnVckkw3rEi_dSxPci0';
	if($salerOpenId == ""){
		$salerOpenId = InitOpenid();
	}

	$userId = Get("id");
	$p = Get("p");
	//传递的二维码参数
	$salerInfo = DBGetDataRowByField("salers","openid",$salerOpenId);//是否是销售人员
	if($salerInfo == null || $salerInfo["status"] != 1)
		die("-1");
//审批通过的销售人员

	$salerId=$salerInfo["id"];//销售人员id
	$salerstropenid= substr($salerOpenId, 0, 10);
	$salerstrnow = date("YmdHi", time());
	$token = md5($salerId.$salerstropenid.$salerstrnow);
	//销售人员的验证参数

	$userinfo = DBGetDataRowByField("custinfo","id",$userId);
	if($userinfo == null)
		die("-2");

	$useropenid=$userinfo["openid"];
	$stropenid = substr($useropenid, 0, 10);
	$hasflag=0;
	for($i=0;$i<11;$i++){//10分钟之内
		$strnow = date("YmdHi", time()-60*$i);
		$codepara = md5($userId.$stropenid.$strnow);
		$codepara = substr($codepara, 0, 10);

		if($p==$codepara){//二维码参数和用户数据库数据符合
			$hasflag=1;
			break;
		}
	}
	$isused=$userinfo["isgiftused"];
	
?>
<!DOCTYPE html >
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<title>线下核销</title>
		<link rel="stylesheet" href="style/style.css" charset="utf-8" />
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
	</head>	
	<body>
		<div id="divUnused" class="float hidden fullScreen">
			<table width="80%" align="center"  class=" pure-table  pure-table-bordered">
				<thead>
					<tr><td colspan="2" align="center">优惠券相关信息</td></tr>
				</thead>
				<tbody>
					<tr><td colspan="2" align="center">用户信息</td></tr>
					<tr>
						<td>姓名</td>
						<td align="center" id="unname"></td>
					</tr>
					<tr>
						<td>电话</td>
						<td align="center" id="unmobile"></td>
					</tr>
					<tr>
						<td>优惠券金额</td>
						<td align="center" id="unselfgift">100元优惠券</td>
					</tr>
					<tr>
						<td>获取时间</td>
						<td align="center" id="unselftime">gottime</td>
					</tr>
					
					<tr><td colspan="2" align="center">此优惠券可用</td></tr>
					<tr>
						<td>商品类别</td>
						<td>
							<label for="type1"><input id="type1" type="radio" name="optionsRadios" value="格力家用空调" >格力家用空调</label><br>
							<label for="type2"><input id="type2" type="radio" name="optionsRadios" value="晶弘冰箱" >晶弘冰箱</label><br>
							<label for="type3"><input id="type3" type="radio" name="optionsRadios" value="净水机" >净水机</label><br>
							<label for="type4"><input id="type4" type="radio" name="optionsRadios" value="净化器" >净化器</label><br>
						</td>
					</tr>
					
					<tr><td colspan="2" align="center"><button id="btnconfirm" class="pure-button-primary ">确认核销</button></td></tr>
				</tbody>
			</table>
		</div>
		
		
		<div id="divUsed" class="float hidden fullScreen">
			<table width="80%" align="center"  class=" pure-table  pure-table-bordered">
				<thead>
					<tr><td colspan="2" align="center">优惠券相关信息</td></tr>
				</thead>
				<tbody>
					<tr><td colspan="2" align="center">用户信息</td></tr>
					<tr>
						<td>姓名</td>
						<td align="center" id="name">【客户姓名】</td>
					</tr>
					<tr>
						<td>电话</td>
						<td align="center" id="mobile">【客户电话】</td>
					</tr>
					<tr>
						<td>优惠券金额</td>
						<td align="center" id="selfgift">100元优惠券</td>
					</tr>
					<tr>
						<td>获取时间</td>
						<td align="center" id="selftime">gottime</td>
					</tr>
					<tr><td colspan="2" align="center">此优惠券已使用</td></tr>
					<tr>
						<td>使用时间</td>
						<td id="usetime">【使用时间】</td>
					</tr>
					<tr>
						<td>使用门店</td>
						<td id="shops">【使用门店】</td>
					</tr>
					<tr>
						<td>核销人员</td>
						<td id="salername">【核销人员姓名】</td>
					</tr>
					<tr>
						<td>购买商品类别</td>
						<td id="usetype">【购买商品类别】</td>
					</tr>
					
				</tbody>
			</table>
		</div>
		
		
		
		<div id="divOverdue" class="float hidden fullScreen"><!--二维码扫描出现问题-->
			<table style="width:100%;height:100%">
				<tr>
					<td valign="middle" align="center" style="font-size:170%;line-height:100%;" >
						<b>二维码参数错误，请用户刷新后重试！</b>
					</td>
				</tr>
			</table>
		</div>
	
	</body>
	<script src="js/jquery-1.11.1.min.js" charset="utf-8"></script>
	<script src="js/jquery.common.js" charset="utf-8"></script>
	<script src="js/md5.min.js" charset="utf-8"></script>
	<script src="js/script.js" charset="utf-8"></script>
	<!--<script type="text/javascript" src="http://cdn.staticfile.org/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>-->
	<script type="text/javascript" >
	
	var userId = "<?php echo $userId; ?>";
	var salerId = "<?php echo  $salerId; ?>";
	var token = "<?php echo  $token; ?>";
	
	var flag = "<?php echo $hasflag; ?>";
	var isused = "<?php echo $isused; ?>";
	
	window.onload=function(){
		BindEvents();
		if(flag==0){
			$("#divOverdue").removeClass("hidden");//二维码参数有错误页面
			return false;
		}
		if(isused==0){
			$("#divUnused").removeClass("hidden");//未使用画面
		}else{
			$("#divUsed").removeClass("hidden");//已经使用画面
		}
		show();
	}
		function show(){
			url = "checkoutajax.php?";
			url += "mode=showuserinfo";
			url += "&id=" + userId;//用户id
			url += "&checksalerid=" + salerId;
			url += "&checktoken=" + token;
			$.get(url,function(json,status){
				var data=eval("("+json+")");
				//未使用画面显示参数
				$("#unname").html(data.name);
				$("#unmobile").html(data.mobile);
				if(data.giftid == -99)
					$("#unselfgift").html("20元优惠券");
				else
					$("#unselfgift").html(data.giftlevel+'元优惠券');
				$("#unselftime").html(data.gottime);
				
				//已经使用画面显示参数
				$("#name").html(data.name);
				$("#mobile").html(data.mobile);
				$("#selfgift").html(data.giftlevel+'元优惠券');
				$("#selftime").html(data.gottime);
				
				$("#usetime").html(data.usetime);
				$("#shops").html(data.shopname);
				$("#salername").html(data.salername);
				//$("#salermobile").html(data.salermobile);
				//$("#usemoney").html(data.summoney+'元');
				$("#usetype").html(data.useinfo);
			});
			
		}
	
		function BindEvents(){
			$("#btnconfirm").click(function(){
				
				useinfo = "";
				if($("#type1").prop("checked")==true){
					useinfo='格力家用空调';
				}
				if($("#type2").prop("checked")==true){
					useinfo='晶弘冰箱';
				}
				if($("#type3").prop("checked")==true){
					useinfo='净水机';
				}
				if($("#type4").prop("checked")==true){
					useinfo='净化器';
				}
				if(useinfo == ""){
					Message("请选择产品。");
					return;
				}
			
				url = "checkoutajax.php?";
				url += "mode=comfirmsale";
				url += "&id=" + userId;
				url += "&salerId=" + salerId;
				url += "&useinfo=" + useinfo;
				url += "&checksalerid=" + salerId;
				url += "&checktoken=" + token;
				$.get(url,function(json,status){
					switch(json){
						case "1":
							$("#divUsed").removeClass("hidden");
							$("#divUnused").addClass("hidden");
							Message("优惠券已经使用成功，即可享受优惠");
							show();
							break;
						case "-1":
							Message("系统繁忙！请稍后重试")
							break;
						default:
							Message(json);
							break;
					}
				});
			
			})
		}

	</script>
	
</html>