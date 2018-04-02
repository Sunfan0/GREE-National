<?php
	include "paras.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<title>添加奖品</title>
		<link rel="stylesheet" href="style/style.css" charset="utf8" />
		<link rel="stylesheet" href="http://www.wsestar.com/common/pure/pure-min.css">
	</head>
	<body>
		<div id="divAddAward" class="fullScreen" style="text-align:center">
			<table width="80%" align="center" class="pure-table pure-table-bordered">
				<thead>
					<tr><td  align="center" colspan=2>添加奖品</td></tr>
				</thead>
				<tbody>
					<tr>
						<td align="center">奖品名称：</td>
						<td align="center">		
							<input type="text" id="nametext" >
						</td>
					</tr>
					<tr>
						<td align="center">奖品level：</td>
						<td align="center">		
							<input type="text" id="leveltext" >
							<br><span style='color:red'>(内容格式只能为数字)</span>
						</td>
					</tr>
					<tr>
						<td align="center">奖品发放时间：</td>
						<td align="center">		
							<input type="text" id="Fromtimetext" ><span>---</span><input type="text" id="Totimetext" >
							<br><span style='color:red'>(插入日期区间的数据，需要满足每天奖品发放数量相同，如果只插入一天数据，则只填写第一个输入框内，日期格式：2016-08-09 00:00:00)</span>
						</td>
					</tr>
					<tr>
						<td align="center">奖品发放数量：</td>
						<td align="center">		
							<input type="text" id="counttext" >
						</td>
					</tr>
					
					<tr>
						<td align="center" colspan='2'><button id="btnConfirmadd" class="pure-button pure-button-primary ">确定</button></td>
					</tr>
				</tbody>
			</table>
			<br><br>
			<p style="font-size:150%"><b>奖品数据显示</b></p>
			<br>
			<table width="80%" align="center" class="pure-table pure-table-bordered">
				<thead>
					<tr>
						<td  align="center" >序号</td>
						<td  align="center" >奖品名称</td>
						<td  align="center" >奖品level</td>
						<td  align="center" >奖品发放时间</td>
						<td  align="center" >奖品发放数量</td>
					</tr>
				</thead>
				<tbody id="datalist">
				</tbody>
			</table>
		</div>
		
	</body>
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script  type="text/javascript" src="js/jquery.common.js" ></script>
	<script  type="text/javascript" src="js/md5.min.js" ></script>
	<script  type="text/javascript" src="js/PageSize.v2.js" ></script>
	<script  type="text/javascript" src="js/script.js" ></script>
	<script type="text/javascript">
	window.onload=function(){
		BindEvents();
		ShowData();
	}
	function BindEvents(){
		$("#btnConfirmadd").click(function(){
			nametext = $("#nametext").val();
			leveltext = $("#leveltext").val();
			fromtimetext = $("#Fromtimetext").val();
			totimetext = $("#Totimetext").val();
			counttext = $("#counttext").val();
			if(!Check())
				return;
			url = "addajax.php?";
			url += "mode=AddGiftCount";
			url += "&giftname=" + nametext;
			url += "&giftlevel=" + leveltext;
			url += "&fromgifttime=" + fromtimetext;
			url += "&togifttime=" + totimetext;
			url += "&giftcount=" + counttext;
			$.get(url,function(json,status){
				data=eval("("+json+")");
				//data=json.indexOf("-1");
				switch(data){
					case 1:
						alert("添加成功！");
						ShowData();
						break;
					default:
						alert("添加失败！");
						break;
				}
			});
		
		
		
		})
	
	}
	function ShowData(){
		url = "addajax.php?";
		url += "mode=ShowGiftData";
		$("#datalist").html("");
		$.get(url,function(json,status){
			if(json == "" || json == null || json == "null")
				return;
			var data=eval("("+json+")");
			for(i=0;i<data.length;i++){
				order = i+1;
				giftname = data[i].giftname;
				giftlevel = data[i].giftlevel;
				gifttime = data[i].gifttime;
				giftcount = data[i].giftcount;
				$("#datalist").append("<tr><td align='center'>"+order+"</td><td align='center'>"+giftname+"</td><td align='center'>"+giftlevel+"</td><td align='center'>"+gifttime+"</td><td align='center'>"+giftcount+"</td></tr>");
			}
		});
	}
	function Check(){
		if($("#nametext").val()==""){
			alert("请填写奖品名称！");
			return false;
		}
		if($("#leveltext").val()==""){
			alert("请填写奖品level！");
			return false;
		}
		if($("#Fromtimetext").val()==""){
			alert("请填写奖品发放时间！");
			return false;
		}
		if($("#counttext").val()==""){
			alert("请填写奖品发放数量！");
			return false;
		}
		return true;
	}
		
	</script>
   

</html>