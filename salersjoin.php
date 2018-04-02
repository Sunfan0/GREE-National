<?php
	include "paras.php";
	$openId = Get("wang");
	$userInfo=null;
	if($openId == ""){
		$arrInfo = InitCustInfoV3();
		$openId = $arrInfo["openid"];
		$nickname=$arrInfo["nickname"];
		$imgurl=$arrInfo["headimgurl"];
	} else{
		$userInfo = DBGetDataRowByField("salers","openid",$openId);
		$nickname=$userInfo["nickname"];
		$imgurl=$userInfo["imgurl"];
	}
	if($userInfo == null){//没有进行查找
		$userInfo = DBGetDataRowByField("salers","openid",$openId);
	} 
	
	if($userInfo == null){//查找数据为空
		$userId = DBInsertTableField("salers",array("openid","nickname","imgurl"), array($openId,$nickname,$imgurl));
		$hasReg = 0;
		$status = 0;
	} else {
		$userId = $userInfo["id"];
		$status = $userInfo["status"];
		if($userInfo["name"] == "")
			$hasReg = 0;
		else
			$hasReg = 1;
	} 
	
?>
<!DOCTYPE html >
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<title>销售员申请</title>
		<link rel="stylesheet" href="style/style.css" charset="utf-8" />
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
	</head>	
	<body>
		<div id="apply" class="float fullScreen">
			<table width="80%" align="center" class="pure-table pure-table-bordered">
				<tr>
					<td align="center" colspan="2">您正在申请成为格力销售人员。</td>
				</tr>
				<tr>
					<td align="center" colspan="2" id="rulememo" align="left">

					</td>
				</tr>
				<tr>
					<td>姓名</td>
					<td align="center"><input value="" type="text" id="name" placeholder="请输入姓名"></td>
				</tr>
				<tr>
					<td>电话</td>
					<td align="center"><input value="" type="text" id="mobile" placeholder="请输入手机号"></td>
				</tr>
				<tr>
					<td>区域</td>
					<td align="center">
						<select id="area">
							<option>请选择所属区域</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>经销商</td>
					<td align="center">
						<select id="agency">
							<option>请选择所属经销商</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>门店</td>
					<td align="center">
						<select id="shops">
							<option>请选择所属门店</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2"><button id="signup" class="pure-button-primary ">提交申请</button></td>
				</tr>
			</table>
		</div>
	</body>
	<script src="js/jquery-1.11.1.min.js" charset="utf-8"></script>
	<script src="js/jquery.common.js" charset="utf-8"></script>
	<script src="http://weixin.wsestar.com/common/script.js" charset="utf-8"></script>

	<script type="text/javascript" >

		var openid = "<?php echo $openId; ?>";
		var status = "<?php echo $status; ?>";
		var hasReg = "<?php echo $hasReg; ?>";
		var userId = "<?php echo $userId; ?>"
		
		var ruleMemo = "说明：<br>";
		ruleMemo += "1、请确保门店列表中可以找到自己所属的门店。如果无法找到，请与管理人员联系，不要提交申请。<br>";
		ruleMemo += "2、请确保填写的姓名电话与此前申报的姓名电话完全一致，否则申请无法通过。<br>";
		ruleMemo += "3、请勿填写他人信息，否则可能造成申请无法通过，或业绩记入他人名下。<br>";
		
		window.onload = function(){
			BindEvents();
			
			$("#rulememo").html(ruleMemo);
			
			alert(ruleMemo.replace(/<br>/g,"\n"));
			//MessageFix("申请已经截止。");

			if(hasReg != "0"){
				switch(status){
					case "-1":
						Message("您的申请被驳回，您可以修改信息后重新提交申请。");
						break;
					case "0":
						MessageFix("您已经提交过申请，请等待审核。");
						break;
					case "1":
						MessageFix("您的申请已经通过。<br>消费者持优惠券进店消费时，使用微信的“扫一扫”功能扫描其优惠券二维码即可。");
						break;
				}				
			}else{
				InitAreaSelection();
			}
				
			$("#area").change(function(){
				InitAgencySelection();
			})
			$("#agency").change(function(){
				InitShopSelection();
			}) 
		}
		
		function InitAreaSelection(){
			url = "salerajax.php?mode=getarealist";
			$.get(url,function(json,status){
				var data=eval("("+json+")");
				$("#area").html("<option value=''>请选择所属区域</option>");
				if(data == null)
					return;
				for(i=0;i<data.length;i++){
					var str = "<option value='"+data[i].areaid+"'>" + data[i].areaname + "</option>";  
					$("#area").append(str); 
				}
			});
		}
		function InitAgencySelection(){
			url = "salerajax.php?mode=getagencylist&area="+$("#area").val();
			$.get(url,function(json,status){
				var data=eval("("+json+")");
				$("#agency").html("<option value=''>请选择所属经销商</option>");
				if(data == null)
					return;
				for(i=0;i<data.length;i++){
					var str = "<option value='"+data[i].agencyid+"'>" + data[i].agencyname + "</option>";  
					$("#agency").append(str); 
				}
			});
		}
		function InitShopSelection(){
			url = "salerajax.php?mode=getshoplist&agency="+$("#agency").val();
			$.get(url,function(json,status){
				var data=eval("("+json+")");
				$("#shops").html("<option value=''>请选择所属门店</option>");
				if(data == null)
					return;
				for(i=0;i<data.length;i++){
					var str = "<option value='"+data[i].shopid+"'>" + data[i].shopname + "</option>";  
					$("#shops").append(str); 
				}
			});
		} 
		
		function BindEvents(){
			$("#signup").click(function(){
				name=$("#name").val();
				mobile=$("#mobile").val();
				shopsid=$("#shops").val();
				if(!Check())
				return;
				url = "salerajax.php?";
				url += "mode=applysaler";
				url += "&name=" + name;
				url += "&mobile=" + mobile;
				url += "&shopsid=" + shopsid;
				url += "&openid=" + openid;
				url += "&salesCenterId=" +$("#area").val();
				url += "&userId=" + userId;
				$.get(url,function(json,status){
					switch(json){
						case "1":
							MessageFix("申请提交成功，请等待审核。");
							break;
						case "-1":
							Message("服务器忙，请稍候重试。");
							break;
						case "-9":
							Message("您已经提交过申请，请勿重复提交。");
							break;
					}
				});
			})
		}
		function Check(){
			name=$("#name").val();
			mobile=$("#mobile").val();
			shops=$("#shops").val();
			if(name == ""){
				Message("请输入姓名！");
				return false;
			}
			
			if(mobile == ""){
				Message("请输入手机号码！");
				return false;
			}
			
			if(!(/^1[34578][0-9]\d{8}|1[3578][01379]\d{8}|1[34578][01256]\d{8}|134[012345678]\d{7}$/.test(mobile))){
				//请输入正确的号码
				Message("请输入正确的手机号码！");
				return false;
			}
			//alert(shops);
			if(shops == "请选择所属门店"){
				Message("请选择门店！");
				return false;
			}

			return true;
		}
	</script>
</html>