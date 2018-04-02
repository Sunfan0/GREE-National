<?php
 //die();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<title>后台数据</title>
		<link rel="stylesheet" href="style/demo.css" type="text/css"/>
		<link rel="stylesheet" href="http://www.wsestar.com/common/pure/pure-min.css">
	</head>
	<body>
		<div id="divLogin" class="float fullScreen">
			<table width="80%" align="center" class="pure-table pure-table-bordered">
				<tr>
					<td align='right'>密码</td>
					<td align='center'><input type="password" id="loginPassword"/></td>
				</tr>
				<tr>
					<td align='center' colspan='2'>
						<button id="btnLogin" class="pure-button pure-button-primary ">登录</button>
					</td>
				</tr>
			</table>
		</div>
		<div id="divselect" class="float hidden fullScreen" >
			<table width="80%"  align="center" class="pure-table pure-table-bordered">
				<tr>
					<td align='center'><button id="btnvisit" class="pure-button pure-button-primary ">访问统计</button></td>
				</tr>
				<tr>
					<td align='center'><button id="btngetgift" class="pure-button pure-button-primary ">奖品数量统计</button></td>
				</tr>
				<tr>
					<td align='center'><button id="btnexport" class="pure-button pure-button-primary ">用户信息导出</button></td>
				</tr>
			</table>
		</div>
		<div id='canvasDiv' class="float hidden fullScreen">
			<button id="visitreturn" class="pure-button pure-button-primary">返回</button>
		
		</div>
		<div id='giftcount' class="float hidden fullScreen" >
			<button id="giftreturn" class="pure-button pure-button-primary">返回</button>
			<p style="font-size:150%;margin-left:45%"><b>奖品数据显示</b></p>
			<table width="80%" align="center" class="pure-table pure-table-bordered">
				<thead>
					<tr>
						<td  align="center">奖品发放日期</td>
						<td  align="center">预计发放特殊优惠券总数</td>
						<td  align="center">实际抽到特殊优惠券总数</td>
						<td  align="center">剩余特殊优惠券总数</td>
						<td  align="center">特殊优惠券已登记信息人数</td>
						<td  align="center">特殊优惠券使用人数</td>
						<td  align="center">实际领取普通优惠券总数</td>
					</tr>
				</thead>
				<tbody id="giftdetail">
					
				</tbody>
			</table>
			<p style="font-size:150%;margin-left:42%"><b>分类实物奖品数据显示</b></p>
			<table width="80%" align="center" class="pure-table pure-table-bordered">
				<thead>
					<tr>
						<td  align="center" >奖品发放日期</td>
						<td  align="center" >奖品名称</td>
						<td  align="center" >预计特殊优惠券发放数量</td>
						<td  align="center" >实际特殊优惠券领取数量</td>
						<td  align="center" >特殊优惠券剩余数量</td>
					</tr>
				</thead>
				<tbody id="datalist">
				</tbody>
			</table>
		</div>
	</body>
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	
	<script type="text/javascript" src="js/jquery.common.js"></script>
	<script type="text/javascript" src="js/ichart.1.2.1.min.js"></script>
	<script src="js/md5.min.js" charset="utf-8"></script>
	<script type="text/javascript">
		var loginPassword="";
		PageSize.oriHeight = 1008;
		PageSize.oriWidth = 640;
		PageSize.windowHeight = $(window).height();
		PageSize.windowWidth = $(window).width();
	
		var ViewWidth=OffsetLeftFullScreen(640);
		var ViewHeight=OffsetTopFullScreen(500);
		var colors=["#6C3365","#484891","#336666","#616130","#613030","#642100","#5B4B00","#844200","#5B4B00","#467500",
					"#28004D","#006000","#460046","#006030","#600030","#003E3E","#2F0000","#000079","#000000","#000079",
					"#7E3D76","#842B00","#5151A2","#484891","#796400","#3D7878","#5B5B00","#707038","#548C00","#743A3A",
					"#3A006F","#007500","#5E005E","#01814A","#820041","#005757","#4D0000","#003D79","#272727","#000093",
					"#8F4586","#A23400","#5A5AAD","#BB5E00","#977C00","#408080","#737300","#808040","#64A600","#804040"];
		//console.log(ViewWidth);
		//console.log(ViewHeight);
		
		
		window.onload = function(){
			BindEvents();
		}
		function ShowGiftData(){
			url = "bgajax.php?";
			url += "mode=ShowGiftData&loginpassword=" + loginPassword;
			$("#giftdetail").html("");
			$.get(url,function(json,status){
				if(json == "" || json == null || json == "null")
					return;
				var data=eval("("+json+")");
				for(i=0;i<data.length;i++){
					timer = data[i].timer;
					plancount = data[i].plancount;
					gotcount = data[i].gotcount;
					overcount = data[i].overcount;
					falsecount = data[i].falsecount;
					msgcount = data[i].msgcount;
					usecount = data[i].usecount;
					if(falsecount==null){
						falsecount = 0;
					}
					if(msgcount==null){
						msgcount = 0;
					}
					if(usecount==null){
						usecount = 0;
					}
					
					$("#giftdetail").append("<tr><td align='center'>"+timer+"</td><td align='center'>"+plancount+"</td><td align='center'>"+gotcount+"</td><td align='center'>"+overcount+"</td><td align='center'>"+msgcount+"</td><td align='center'>"+usecount+"</td><td align='center'>"+falsecount+"</td></tr>");
				}
			});
			url = "bgajax.php?";
			url += "mode=ShowDetailGiftData&loginpassword=" + loginPassword;
			$("#datalist").html("");
			$.get(url,function(json,status){
				if(json == "" || json == null || json == "null")
					return;
				var data=eval("("+json+")");
				for(i=0;i<data.length;i++){
					giftname = data[i].giftname;
					giftlevel = data[i].giftlevel;
					gifttime = data[i].gifttime;
					giftcount = data[i].giftcount;
					giftgotcount = data[i].gotcount;
					count = data[i].count;
					$("#datalist").append("<tr><td align='center'>"+gifttime+"</td><td align='center'>"+giftname+"</td><td align='center'>"+giftcount+"</td><td align='center'>"+giftgotcount+"</td><td align='center'>"+count+"</td></tr>");
				}
			});
	
		} 
		function BindEvents(){
			$("#btnLogin").click(function(){
			
				loginPassword = md5($("#loginPassword").val());
				url = "bgajax.php?mode=Login&loginpassword=" + loginPassword;
				$.get(url,function(json,status){
					switch(json){
						case "1":
							$("#divLogin").addClass("hidden");
							$("#divselect").removeClass("hidden");
							//$("#canvasDiv").removeClass("hidden");
							//GetConfig();
							break;
						default:
							alert("登陆失败。");
							break;
					}
				});
				
			})
			$("#btnvisit").click(function(){
				
				$("#divselect").addClass("hidden");
				$("#canvasDiv").removeClass("hidden");
				GetConfig();
				
			})
			$("#btngetgift").click(function(){
				$("#divselect").addClass("hidden");
				$("#giftcount").removeClass("hidden");
				///奖品数量的获取
				ShowGiftData()
			})
			$("#btnexport").click(function(){
				window.open("excel.php?loginpassword=" + loginPassword);
			})
			$("#visitreturn").click(function(){
				
				$("#canvasDiv").addClass("hidden");
				$("#divselect").removeClass("hidden");
				
			})
			$("#giftreturn").click(function(){
				$("#giftcount").addClass("hidden");
				$("#divselect").removeClass("hidden");
			})
		
		}
		
		function GetConfig(){
			$.post("bgajax.php?mode=GetConfig&loginpassword=" + loginPassword, function(data){	
					if(data==""){
						alert("服务器配置有误，请与管理员联系！");
						return;
					}
					data = eval("(" + data + ")");
					//console.log(data);
					for(i=0;i<data.length;i++){	
						strHtml = '<div id="'+data[i].name+'"></div> ';
						$("#canvasDiv").append(strHtml);
						$("#"+data[i].name).html(data[i].title+"&nbsp;&nbsp;&nbsp;&nbsp;加载中。。。").css({"text-align":"center","fontSize":OffsetLeftFullScreen(15),"color":"#8B0000"});
						PageData(data[i].chart,data[i].mode,data[i].name,data[i].title);
					}
				}
			);
		}
		
		function PageData(chart,mode,name,title){
			switch(chart){
				case "line":
					var DataView_value=[],DataView_labels=[],DataView_total=0;
					$.post("bgajax.php?mode="+mode+"&loginpassword=" + loginPassword, function(data){	
							data = eval("(" + data + ")");
							if(data==null){
								$("#"+name).html(title+"&nbsp;&nbsp;&nbsp;&nbsp;暂无数据").css({"text-align":"center","fontSize":OffsetLeftFullScreen(15),"color":"#8B0000"});
								return;
							}
							
							// console.log(data);
							for(i=0;i<data.length;i++){	
								DataView_total=parseInt(data[i].value)+DataView_total;
								pvalue=data[i].value;
								DataView_value.push(pvalue);
								DataView_labels.push(data[i].title);
							}
							ViewLineBasic2D(name,title+"【"+DataView_total+"人】",DataView_value,DataView_labels);
						}
					);
					break;
				case "pie":
					var DataView_total=0;
					$.post("bgajax.php?mode="+mode+"&loginpassword=" + loginPassword, function(data){	
							data = eval("(" + data + ")");
							if(data==null){
								$("#"+name).html(title+"&nbsp;&nbsp;&nbsp;&nbsp;暂无数据").css({"text-align":"center","fontSize":OffsetLeftFullScreen(15),"color":"#8B0000"});
								return;
							}
							
							var newdata = [];
							for(var i=0;i<data.length;i++){
								DataView_total=parseInt(data[i].value)+DataView_total;
								var d = {};
								d.name = data[i].title;
								pvalue=data[i].value;
								d.value = pvalue;
								if(colors[i])
									d.color = colors[i];
								newdata.push(d);
							}
							ViewPie2D(name,title+"【"+DataView_total+"人】",newdata);
						}
					);
					break;
				case "bar":
					var DataView_total=0;
					$.post("bgajax.php?mode="+mode+"&loginpassword=" + loginPassword, function(data){	
							data = eval("(" + data + ")");
							if(data==null){
								$("#"+name).html(title+"&nbsp;&nbsp;&nbsp;&nbsp;暂无数据").css({"text-align":"center","fontSize":OffsetLeftFullScreen(15),"color":"#8B0000"});
								return;
							}
							
							var newdata = [];
							for(var i=0;i<data.length;i++){
								DataView_total=parseInt(data[i].value)+DataView_total;
								var d = {};
								d.name = data[i].title;
								pvalue=data[i].value;
								d.value = pvalue;
								if(colors[i])
									d.color = colors[i];
								newdata.push(d);
							}
							ViewBar2D(name,title+"【"+DataView_total+"人】",newdata);
						}
					);
					break;
				
			} 
			
		}
		
		 
		function bar2D(name,title,newdata){		
			new iChart.Column2D({
					render : name,
					data: newdata,
					title : title,
					//showpercent:true,
					//decimalsnum:2,
					//animation : true,//开启过渡动画
					//animation_duration:600,//800ms完成动画
					width : 800,
					height : 400,
					coordinate:{
						background_color:'#fefefe',
						scale:[{
							width : 60,
							 start_scale:0,
							
							 /* listeners:{
								parseText:function(t,x,y){
									return {text:t+"%"}
								}
							} */
						}]
					},
				}).draw();
		
		}  
	
		
		function ViewLineBasic2D(name,title,value,labels){		
			//console.log(name);
			//console.log(value);
			//console.log(labels);
			var data = [
						
						{
							name : name,
							value:value,
							color:'#f68f70',
							line_width:2
						}
					 ];
			 
			var chart = new iChart.LineBasic2D({
				render : name,		//图表渲染的HTML DOM的id.
				data: data,				
				align:'center',				
				title : title,
				//animation : true,//开启过渡动画
				//animation_duration:600,//800ms完成动画
				// subtitle : '平均每个人访问2-3个页面(访问量单位：万)',
				// footnote : '数据来源：模拟数据',
				width : ViewWidth,
				height : ViewHeight,
				background_color:'#FEFEFE',
				tip:{		//提示框的配置项.(默认为false)
					enable:true,
					shadow:true,
					move_duration:400,
					border:{				//此处设置了开启边框配置项。
						 enable:true,
						 radius : 5,
						 width:2,
						 color:'#3f8695'
					},
					listeners:{					//事件的配置项。(默认为null)
						 // tip:提示框对象、name:数据名称、value:数据值、text:当前文本、i:数据点的索引
						parseText:function(tip,name,value,text,i){
							return name+"访问量:"+value+"人";	
						}
					}
				},
				tipMocker:function(tips,i){		//当有多条线段(数据)时，可以利用tipMocker将tip整合到一起。作为一个iChart.Tip展示出来。
					return "<div style='font-weight:600'>"+
							labels[i]+" "+//日期
							"</div>"+tips.join("<br/>");
				},
				legend : {		//图例的配置项
					enable : true,
					row:1,//设置在一行上显示，与column配合使用
					column : 'max',
					valign:'top',
					sign:'bar',
					background_color:null,//设置透明背景
					offsetx:-80,//设置x轴偏移，满足位置需要
					border : true
				},
				crosshair:{
					enable:true,
					line_color:'#62bce9'//十字线的颜色
				},
				sub_option : {	//图中折线段的配置项
					label:false,
					point_size:10
				},
				coordinate:{
					width:640,
					height:240,
					axis:{
						color:'#dcdcdc',
						width:1
					},
					scale:[{
						 position:'left',	
						 // start_scale:0,
						 // end_scale:2000,
						 // scale_space:500,
						 // scale_size:2,
						 scale_color:'#9f9f9f'
					},{
						 position:'bottom',	
						 labels:labels
					}]
				}
			});
		
		//开始画图
		chart.draw();
	}
		
		function ViewPie2D(name,title,newdata){
			//console.log(name);
			//console.log(newdata);
			
			new iChart.Pie2D({
				render : name,
				data: newdata,
				title : title,
				legend : {
					enable : true
				},
				showpercent:true,
				decimalsnum:2,
				width : ViewWidth,
				height : ViewHeight,
				radius:140
			}).draw();
		}
		
		function ViewBar2D(name,title,newdata){
			//console.log(name);
			//console.log(newdata);
			
			new iChart.Bar2D({
					render : name,
					data: newdata,
					title : title,
					align:'right',
					// footnote : 'Data from StatCounter',
					width : 800,
					height : 400,
					//animation : true,//开启过渡动画
					//animation_duration:600,//800ms完成动画
					coordinate:{
						width:450,
						height:220,
						scale:[{
							 position:'bottom',	
							 start_scale:0,
							 // end_scale:100,
							 // scale_space:10,
							 // listeners:{
								// parseText:function(t,x,y){
									// return {text:t+"%"}
								// }
							 // }
						}]
					},
					rectangle:{
						listeners:{
							drawText:function(r,t){
								return t+"%";
							}
						}
					}
			}).draw();
		}
		
		
	</script>
</html>