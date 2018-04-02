<?php
	include "paras.php";
	//$openid = Get("wang");
	$openid1='oFb3-tizHASV4Sy2BXZ-uXqKB9sY';//测试id=5,未使用
	$userInfo1 = DBGetDataRowByField("custinfo" , "openid" , $openid1);
	$userId1=$userInfo1["id"];

	
	$stropenid1 = substr($openid1, 0, 10);
	$strdate = date("YmdHi", time());
	$BarCodePara1 = md5($userId1.$stropenid1.$strdate);//二维码参数
	$BarCodePara1 = substr($BarCodePara1, 0, 10);
	
	$openid2='oFb3-tnJR7zTU52cP-37LIYlScrg';//测试id=2,已使用
	$userInfo2 = DBGetDataRowByField("custinfo" , "openid" , $openid2);
	$userId2=$userInfo2["id"];

	
	$stropenid2 = substr($openid2, 0, 10);
	$strdate = date("YmdHi", time());
	$BarCodePara2 = md5($userId2.$stropenid2.$strdate);//二维码参数
	$BarCodePara2 = substr($BarCodePara2, 0, 10);
?>
<!DOCTYPE html >
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<title>测试二维码</title>
		<link rel="stylesheet" href="style/style.css" charset="utf-8" />
		<link rel="stylesheet" href="http://www.wsestar.com/common/pure/pure-min.css">
	</head>	
	<body>
		<div id="divpage" class=" fullScreen " style='text-align:center'>
			<table width="80%" height='70%' align="center" class="pure-table">
				<tr>
					<td align='center'>测试未核销二维码</td>
					<td align='center' id='code1' style='width:100px;height:100px'>
						
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td align='center'>测试已核销二维码</td>
					<td align='center' id='code2' style='width:100px;height:100px'>
						
					</td>
				</tr>
			</table>
		</div>
	</body>
	<script src="js/jquery-1.11.1.min.js" charset="utf-8"></script>
	<script src="js/jquery.common.js" charset="utf-8"></script>
	<script type="text/javascript" src="http://cdn.staticfile.org/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>

	<script>
		window.onload=function(){
			barcode1 = "http://www.wsestar.com/test/gree201609/indexcheckout.php?id=<?php echo $userId1; ?>&p=<?php echo $BarCodePara1; ?>";
			$("#code1").qrcode({//未核销 
				render: "canvas", //方式 
				text: barcode1 //二维码识别参数 
			});
			barcode2 = "http://www.wsestar.com/test/gree201609/indexcheckout.php?id=<?php echo $userId2; ?>&p=<?php echo $BarCodePara2; ?>";
			$("#code2").qrcode({//未核销 
				render: "canvas", //方式 
				text: barcode2 //二维码识别参数 
			});
		}
</script>
</html>
