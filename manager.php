
<!DOCTYPE html >
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<title>销售人员后台管理</title>
		<link rel="stylesheet" href="style/style.css" charset="utf-8" />
		<link rel="stylesheet" href="http://www.wsestar.com/common/pure/pure-min.css">
		<link rel="stylesheet" type="text/css" href="style/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="style/kkpager_blue.css" />
	</head>	
	<body>
		<div id="divLogin" class="float fullScreen ">
			<table width="80%" align="center" class="pure-table  pure-table-bordered">
				<tr>
					<td align='center'>账号</td>
					<td ><input type="text" id="loginName"></td>
				</tr>
				<tr>
					<td align='center'>密码</td>
					<td ><input type="password" id="loginPassword"></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<button id="btnLogin" class="pure-button pure-button-primary ">登录</button>
					</td>
				</tr>
			</table>
		</div>
		<div id="divselect" class="float hidden fullScreen" style='text-align:center'>
			<table width="80%" height='100%' align="center" class="pure-table pure-table-bordered">
				<tr>
					<td align='center'><button id="btnsalers" class="pure-button pure-button-primary ">销售人员审核</button></td>
				</tr>
				<tr>
					<td align='center'><button id="btngiftgot" class="pure-button pure-button-primary ">查看优惠券发放</button></td>
				</tr>
				<tr>
					<td align='center'><button id="btngiftuse" class="pure-button pure-button-primary ">查看优惠券使用</button></td>
				</tr>
				<tr>
					<td align='center'><button id="btnagency" class="pure-button pure-button-primary ">经销商管理</button></td>
				</tr>
				<tr>
					<td align='center'><button id="btnshop" class="pure-button pure-button-primary ">门店管理</button></td>
				</tr>
			</table>
		</div>
		<div id="divsalersList" class="float hidden fullScreen">
			<button id="btnReturn_salers" class="pure-button pure-button-primary ">返回</button>
			<button id="passsalers" class="pure-button pure-button-primary "onclick='ShowAllowedList()' >查看已通过人员</button>
			<button id="refusesalers" class="pure-button pure-button-primary " onclick='ShowRefusedList()'>查看已拒绝人员</button>
			<button id="initsalers" class="pure-button pure-button-primary " onclick='InitCheckList()'>查看未审核人员</button>
			<table  width="90%" align="center" id="" class=" pure-table  pure-table-bordered"  >
				<thead>
					<tr><td colspan="3" align="center" id='typesaler'>待审核人员列表</td></tr>
				</thead>
				<tbody id="salerslist"></tbody>
			</table>
			<div id="kkpager" style="padding:45px"></div>
		</div>
		<div id="divshops" class="float hidden fullScreen">
			<button id="btnReturn_shops" class="pure-button pure-button-primary ">返回</button>
			<button id="btnadd_shops" class="pure-button pure-button-primary">新增门店</button><br>
			<table width="90%" align="center" id="shoplist" class=" pure-table  pure-table-bordered" >
				<thead>
					<tr>
						<th colspan="4" align="center">门店信息</th>
					</tr>
					<tr>
						<th align="center">门店id</th>
						<th align="center">门店名称</th>
						<th align="center">所属区域名称</th>
						<th align="center">所属经销商名称</th>
					</tr>
				</thead>
				<tbody >
				</tbody>
			</table>
			
		</div>
		<div id="divshopsdetail" class="fullScreenContainer hidden">
			<div id="divTarget0" class="float popContainer">
				<button id="btnReturn_shopsdetail" class="pure-button pure-button-primary">返回</button><br>
				<table width="80%" align="center" class="pure-table pure-table-bordered" >
					<tr>
						<td align='center'>
							所属区域名称
						</td>
						<td align='center'>
							<select id="areapagelist">
							
							</select>
						</td>
					</tr>
					<tr>
						<td align='center'>
							所属经销商名称
						</td>
						<td align='center'>
							<select id="agencypagelist">
							
							</select>
						</td>
					</tr>
					<tr>
						<td align='center' >门店名称
							<input id="addshopid" type="hidden">
						</td>
						<td align='center'>
							<input id="shopname" type="text" placeholder="门店名称">
						</td>
					</tr>
					<tr>
						<td align='center' colspan="2">
							<button id="btn_shopsdata" class="pure-button pure-button-primary ">确定</button>
							<button id="btn_deleteshop" class="pure-button pure-button-primary ">删除</button>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div id="divagencies" class="float hidden fullScreen">
			<button id="btnReturn_agencies" class="pure-button pure-button-primary ">返回</button>
			<button id="btnadd_agencies" class="pure-button pure-button-primary ">新增经销商</button><br>
			<table width="90%" align="center" class=" pure-table  pure-table-bordered" id="agencylist">
				<thead>
					<tr>
						<th colspan="3" align="center">经销商信息</th>
					</tr>
					<tr>
						<th align="center">经销商id</th>
						<th align="center">经销商名称</th>
						<th align="center">所属区域名称</th>
					</tr>
				</thead>
				<tbody >
				</tbody>
			</table>
			
		</div>
		<div id="divagenciesdetail" class="fullScreenContainer hidden">
			<div id="divTarget" class="float popContainer">
				<button id="btnReturn_agenciesdetail" class="pure-button pure-button-primary ">返回</button><br>
				<table width="80%" align="center" class="pure-table pure-table-bordered" >
					<tr>
						<td align='center'>
							所属区域名称
						</td>
						<td align='center'>
							<select id="arealist">
							
							</select>
						</td>
					</tr>
					<tr>
						<td align='center' >经销商名称
							<input id="addid" type="hidden">
						</td>
						<td align='center'>
							<input id="agencyname" type="text" placeholder="经销商名称">
						</td>
					</tr>
					<tr>
						<td align='center' colspan="2">
							<button id="btn_agenciesdata" class="pure-button pure-button-primary ">确定</button>
							<button id="btn_deleteagency" class="pure-button pure-button-primary ">删除</button>
						</td>
					</tr>
				</table>
			</div>
		</div>
		
		<div id="divProvided" class="float hidden fullScreen">
			<button id="btnReturn_Provided" class="pure-button pure-button-primary">返回</button>
			<table width="90%" align="center"  class=" pure-table  pure-table-bordered">
				<thead>
					<tr><th colspan="4" align="center"><b>优惠券发放列表</b></th></tr>
				</thead>
				<tbody>
					<tr><td colspan="4" >特殊优惠券</td></tr>
					<tr>
						<td align="center">优惠券金额</td>
						<td align="center">发放总数</td>
						<td align="center">领取总数</td>
						<td align="center"></td>
					</tr>
					<tr>
						<td align="center">50元优惠券</td>
						<td id="ptotalcount50" align="center" ></td>
						<td id="pselfcount50" align="center" ></td>
						<td align="center"><button id="pget50" class="pure-button pure-button-primary " >查看明细</button></td>
					</tr>
					<tr>
						<td align="center">100元优惠券</td>
						<td id="ptotalcount100" align="center" ></td>
						<td id="pselfcount100" align="center" ></td>
						<td align="center"><button id="pget100" class="pure-button pure-button-primary " >查看明细</button></td>
					</tr>
					<tr>
						<td align="center">500元优惠券</td>
						<td id="ptotalcount500" align="center"></td>
						<td id="pselfcount500" align="center" ></td>
						<td align="center"><button id="pget500" class="pure-button pure-button-primary " >查看明细</button></td>
					</tr>
					<tr>
						<td align="center">1000元优惠券</td>
						<td id="ptotalcount1000" align="center"></td>
						<td id="pselfcount1000" align="center" ></td>
						<td align="center"><button id="pget1000" class="pure-button pure-button-primary" >查看明细</button></td>
					</tr>
					<tr><td colspan="4" >普通优惠券</td></tr>
					<tr>
						<td align="center">优惠券金额</td>
						<td align="center" colspan="2" >领取总数</td>
						<td align="center"></td>
					</tr>
					<tr>
						<td align="center">20元优惠券</td>
						<td id="ptotalcount20" align="center"colspan="2" ></td>
						<td align="center"><button id="pget20" class="pure-button pure-button-primary " >查看明细</button></td>
					</tr>
					<tr>
						<td colspan="4" align="center">
							<button id="pget" class="pure-button pure-button-primary ">查看优惠券发放总明细</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="divtotalUsed" class="float  fullScreen hidden">
			<button id="btnReturn_totalUsed" class="pure-button pure-button-primary ">返回</button><br>
			<table width="90%" align="center"  class=" pure-table  pure-table-bordered">
				<thead>
					<tr><th colspan="3" align="center"><b>优惠券使用列表</b></th></tr>
					<tr>
						<th align="center">优惠券总金额</th>
						<th align="center">已使用人数</th>
						<th align="center"></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td align="center">20元优惠券</td>
						<td id="count20"  align="center"></td>
						<td align="center"><button id="totaluse20" class="pure-button pure-button-primary " >查看使用明细</button></td>
					</tr>

					<tr>
						<td align="center">50元优惠券</td>
						<td id="count50"  align="center"></td>
						<td align="center"><button id="totaluse50" class="pure-button pure-button-primary " >查看使用明细</button></td>
					</tr>
					<tr>
						<td align="center">100元优惠券</td>
						<td id="count100"  align="center"></td>
						<td align="center"><button id="totaluse100" class="pure-button pure-button-primary " >查看使用明细</button></td>
					</tr>
				
					<tr>
						<td align="center">500元优惠券</td>
						<td id="count500" align="center"></td>
						<td align="center"><button id="totaluse500" class="pure-button pure-button-primary " >查看使用明细</button></td>
					</tr>
					<tr>
						<td align="center">1000元优惠券</td>
						<td id="count1000" align="center"></td>
						<td align="center"><button id="totaluse1000" class="pure-button pure-button-primary " >查看使用明细</button></td>
					</tr>
					<tr><td colspan="3" align="center">
						<button id="totaluse" class="pure-button pure-button-primary ">查看优惠券使用总明细</button>
						<button id="totaluseexport" class="pure-button pure-button-primary ">用户信息导出</button>
					</td></tr>
				</tbody>
			</table>
		</div>
		<div id="divProvidedDetail" class="float hidden fullScreen">
			<button id="btnReturn_ProvidedDetail" class="pure-button pure-button-primary ">返回</button><br>
			<table width="90%" align="center" id="" class=" pure-table  pure-table-bordered" >
				<thead>
					<tr>
						<th colspan="5" align="center">已发放【<span id="providedgiftlevel"></span>】优惠券人员列表</th>
					</tr>
					<tr>
						<th align="center">优惠券金额</th>
						<th align="center">领取时间</th>
						<th align="center">姓名</th>
						<th align="center">昵称</th>
						<th align="center">电话</th>
					</tr>
				</thead>
				<tbody id="providedDetailList"></tbody>
			</table>
		</div>
		<div id="divtotaluseDetail" class="float hidden fullScreen">
			<button id="btnReturn_totaluseDetail" class="pure-button pure-button-primary ">返回</button><br>
			<table width="90%" align="center" id="" class=" pure-table  pure-table-bordered" >
				<thead>
					<tr>
						<th colspan="11" align="center">【<span id="totalgiftlevel"></span>】优惠券明细列表</th>
					</tr>
					<tr>
						<th align="center">优惠券金额</th>
						<th align="center">姓名</th>
						<th align="center">电话</th>
						<th align="center">领取时间</th>
						<th align="center">使用时间</th>
						<th align="center">区域</th>
						<th align="center">经销商</th>
						<th align="center">门店</th>
						<th align="center">核销员</th>
						<th align="center">核销电话</th>
						<th align="center">使用信息</th>
					</tr>
				</thead>
				<tbody id="totaluseDetailList"></tbody>
			</table>
		</div>
	</body>
	<script src="http://www.wsestar.com/common/jquery-1.11.1.min.js" charset="utf-8"></script>
	<script src="js/jquery.common.js" charset="utf-8"></script>
	<script src="js/jquery.dataTables.min.js" charset="utf-8"></script>
	<script src="http://www.wsestar.com/common/md5.min.js" charset="utf-8"></script>
	<script src="http://www.wsestar.com/common/script.js" charset="utf-8"></script>
	<script src="js/kkpager.js" charset="utf-8"></script>
	<script type="text/javascript" >
		window.onload = function(){
			BindEvents();
		}
		var currentPage;
		function dataPaging(pagecount,type){
			kkpager.generPageHtml({
				pno : 1,
				total : pagecount,
				mode : 'click',//默认值是link，可选link或者click
				click : function(n){
					currentpage = n;
					this.selectPage(currentpage);
					switch(type){
							case 0:
								$("#typesaler").html("未审核人员列表");
								$("#salerslist").html("");
								url = "manageajax.php?";
								url += "mode=getsalerinfo&type=0&currentpage"+currentpage;
								url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
								$.get(url,function(json,status){
									BuildList("salerslist",json,0);
								});
								break;
							case 1:
								$("#typesaler").html("已通过人员列表");
								$("#salerslist").html("");
								url = "manageajax.php?";
								url += "mode=getsalerinfo&type=1&currentpage="+currentpage;
								url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
								$.get(url,function(json,status){
									BuildList("salerslist",json,1);
								});
								break;
							case -1:
								$("#typesaler").html("已拒绝人员列表");
								$("#salerslist").html("");
								url = "manageajax.php?";
								url += "mode=getsalerinfo&type=-1&currentpage="+currentpage;
								url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
								$.get(url,function(json,status){
									BuildList("salerslist",json,-1);
								});
								break;
							
							default:
								break;
					}
				}
			} , true);
		}
		var agencylistTable = null;
		function agencylist(){
			agencylistTable = $('#agencylist').DataTable({
				"ajax": "manageajax.php?mode=getagencydata&loginname=" + loginName + "&loginpassword=" + loginPassword,
				//"processing": true,//加载效果
				"serverSide": true,//页面在加载时就请求后台，以及每次对 datatable 进行操作时也是请求后台
				"pageLength": 40,//每页显示的数据量
				"columns": [
					{ "data": "id"},
					{ "data": "agencyname"},
					{ "data": "areaname"}
				],
				"aaSorting": [[1, "desc"]]//设置排序
			} ).on('xhr.dt', function ( e, settings, json, xhr ) {
				
				if(json.recordsTotal == 0){
					json.aaData = new Array();
				}
			} );
		}
		var shoplistTable = null;
		function shoplist(){
			shoplistTable = $('#shoplist').DataTable({
				"ajax": "manageajax.php?mode=getshopdata&loginname=" + loginName + "&loginpassword=" + loginPassword,
				//"processing": true,//加载效果
				"serverSide": true,//页面在加载时就请求后台，以及每次对 datatable 进行操作时也是请求后台
				"pageLength": 40,//每页显示的数据量
				"columns": [
					{ "data": "id"},
					{ "data": "shopname"},
					{ "data": "areaname"},
					{ "data": "agencyname"}
				],
				"aaSorting": [[1, "desc"]]//设置排序
			} ).on('xhr.dt', function ( e, settings, json, xhr ) {
				
				if(json.recordsTotal == 0){
					json.aaData = new Array();
				}
			} );
		}
		var setagencyid;
		var setshopid;
		function BindEvents(){
			$('#agencylist tbody').on( 'click', 'td', function () {
				if ($(this).hasClass('selected') ) {
					$(this).removeClass('selected');
				}
				else {
					agencylistTable.$('tr.selected').removeClass('selected');
					$(this).parent().addClass('selected');
					setagencyid=agencylistTable.row('.selected').data().id;
					UpdateInfo(agencylistTable.row('.selected').data().id);
				}
			}); 
			$("#btn_deleteagency").click(function(){
				DeleteInfo(setagencyid);
			})
			$('#shoplist tbody').on( 'click', 'td', function () {
				if ($(this).hasClass('selected') ) {
					$(this).removeClass('selected');
				}
				else {
					shoplistTable.$('tr.selected').removeClass('selected');
					$(this).parent().addClass('selected');
					setshopid=shoplistTable.row('.selected').data().id;
					//$("#areapagelist").val("");
					UpdateshopInfo(shoplistTable.row('.selected').data().id);
				}
			}); 
			$("#btn_deleteshop").click(function(){
				DeleteshopInfo(setshopid);
			})
			$("#totaluseexport").click(function(){
				window.open("useexcel.php?loginname=" + loginName + "&loginpassword=" + loginPassword);
			});
			$("#btngiftgot").click(function(){//优惠券发放
				ShowProvidedList();
			})
			$("#btngiftuse").click(function(){//优惠券使用
				Showtotaluse();
			})
			$("#btnsalers").click(function(){//人员审核
				InitCheckList();//初始化列表
				$("#divselect").addClass("hidden");
				$("#divsalersList").removeClass("hidden");
			})
			$("#btnReturn_salers").click(function(){
				$("#kkpager").html("");
				$("#divsalersList").addClass("hidden");
				$("#divselect").removeClass("hidden");
			})
			$("#areapagelist").change(function(){//门店所属区域
				InitAgencySelection();
			})
			$("#btnshop").click(function(){//门店管理
				shoplist();
				AgencySelect();
				$("#divselect").addClass("hidden");
				$("#divshops").removeClass("hidden");
			})
			$("#btnReturn_shops").click(function(){
				if(shoplistTable != null)
					shoplistTable.destroy();
				$("#divshops").addClass("hidden");
				$("#divselect").removeClass("hidden");
			})
			$("#btnadd_shops").click(function(){//新增门店
				$("btn_deleteshop").addClass("hidden");
				$("#divshopsdetail").removeClass("hidden");
				$("#shopname").val("");
				$("#agencypagelist").val("");
				$("#areapagelist").val("");
				$("#addshopid").val("");
			})
			$("#btnReturn_shopsdetail").click(function(){
				$("#divshopsdetail").addClass("hidden");
			})
			
			$("#btn_shopsdata").click(function(){//提交门店数据
				shopname=$("#shopname").val();//门店名称
				agencypageid=$("#agencypagelist").val();
				areapage=$("#areapagelist").find("option:selected").text();
				addshopid=$("#addshopid").val();//更新或者增加
				url = "manageajax.php?mode=updateshop&shopname="+shopname;
				url += "&areapage=" + areapage + "&addshopid=" + addshopid+ "&agencypageid=" + agencypageid;
				url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
				$.get(url,function(json,status){
					switch(json){
						case "1":
							Message("更新成功。");
							$("#divshopsdetail").addClass("hidden");
							$("#divshops").removeClass("hidden");
							if(shoplistTable != null)
								shoplistTable.destroy();
							shoplist();
							break;
						default:
							Message("更新失败。");
							break;
					}
				});
			})
			$("#btnagency").click(function(){//经销商管理
				agencylist();
				$("#divselect").addClass("hidden");
				$("#divagencies").removeClass("hidden");
			})
			$("#btnReturn_agencies").click(function(){
				if(agencylistTable != null)
					agencylistTable.destroy();
				$("#divagencies").addClass("hidden");
				$("#divselect").removeClass("hidden");
			})
			$("#btnadd_agencies").click(function(){//新增经销商
				$("#divagenciesdetail").removeClass("hidden");
				$("#btn_deleteagency").addClass("hidden");
				$("#agencyname").val("");
				$("#arealist").val("");
				$("#addid").val("");
			})
			$("#btnReturn_agenciesdetail").click(function(){
				$("#divagenciesdetail").addClass("hidden");
			})
			$("#btn_agenciesdata").click(function(){//提交经销商数据
				agencyname=$("#agencyname").val();//经销商名称
				areaid=$("#arealist").val();
				addid=$("#addid").val();//更新或者增加
				url = "manageajax.php?mode=updateagency&agencyname="+agencyname;
				url += "&areaid=" + areaid + "&addid=" + addid;
				url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
				$.get(url,function(json,status){
					switch(json){
						case "1":
							Message("更新成功。");
							$("#divagenciesdetail").addClass("hidden");
							$("#divagencies").removeClass("hidden");
							if(agencylistTable != null)
								agencylistTable.destroy();
							agencylist();
							break;
						default:
							Message("更新失败。");
							break;
					}
				});
			})
			
			$("#btnLogin").click(function(){
				loginName = $("#loginName").val();
				loginPassword = md5($("#loginPassword").val());
				url = "manageajax.php?mode=checklogin&loginname=" + loginName + "&loginpassword=" + loginPassword;
				$.get(url,function(json,status){
					switch(json){
						case "1":
							$("#divLogin").addClass("hidden");
							$("#divselect").removeClass("hidden");
							initarealist();//初始化区域列表
							break;
						default:
							Message("登陆失败。");
							break;
					}
				});
			});
			
			$("#btnReturn_totalUsed").click(function(){
				$("#divtotalUsed").addClass("hidden");
				$("#divselect").removeClass("hidden");
			})
			
			$("#btnReturn_Provided").click(function(){
				$("#divProvided").addClass("hidden");
				$("#divselect").removeClass("hidden");
			})
		
			$("#btnReturn_totaluseDetail").click(function(){
				$("#divtotalUsed").removeClass("hidden");
				$("#divtotaluseDetail").addClass("hidden");
			})
		
			$("#totaluse20").click(function(){
				ShowtotaluseDetail(20);
			});
			$("#totaluse50").click(function(){
				ShowtotaluseDetail(50);
			});
			$("#totaluse100").click(function(){
				ShowtotaluseDetail(100);
			});
			$("#totaluse500").click(function(){
				ShowtotaluseDetail(500);
			});
			$("#totaluse1000").click(function(){
				ShowtotaluseDetail(1000);
			});
			$("#totaluse").click(function(){
				ShowtotaluseDetail(0);
			});
		
			$("#pget50").click(function(){
				ShowProvidedDetail(50);
			});
			$("#pget100").click(function(){
				ShowProvidedDetail(100);
			});
			$("#pget500").click(function(){
				ShowProvidedDetail(500);
			});
			$("#pget1000").click(function(){
				ShowProvidedDetail(1000);
			});
			$("#pget20").click(function(){
				ShowProvidedDetail(20);
			});
			$("#pget").click(function(){
				ShowProvidedDetail(0);
			});
			
			$("#btnReturn_ProvidedDetail").click(function(){
				$("#divProvided").removeClass("hidden");
				$("#divProvidedDetail").addClass("hidden");
			});
			$("#btnReturn_p50").click(function(){
				$("#p50divDetail").addClass("hidden");
				$("#divProvided").removeClass("hidden");
			})
		}

		function Showtotaluse(){
			$("#divselect").addClass("hidden");
			$("#divtotalUsed").removeClass("hidden");
			url = "manageajax.php?mode=GetUsedtotal";
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			$.get(url,function(json){
				var data=eval("("+json+")");
				$("#count20").html(data.usedcount20);
				$("#count50").html(data.usedcount50);
				$("#count100").html(data.usedcount100);
				$("#count500").html(data.usedcount500);
				$("#count1000").html(data.usedcount1000);
	
			});
		}
		function ShowtotaluseDetail(totalLevel){
			$("#divtotalUsed").addClass("hidden");
			$("#divtotaluseDetail").removeClass("hidden");
			if(totalLevel == 0)
				$("#totalgiftlevel").html("");
			else
				$("#totalgiftlevel").html(totalLevel+"元");
			
			url = "manageajax.php?mode=GetTotalGiftDetail&giftLevel="+totalLevel;
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			$.get(url,function(json){
				var data=eval("("+json+")");
				if(data==null){
					alert('暂无数据！');
					return;
				}
				strHtml = "";
				for(i=0;i<data.length;i++){
					strHtml += "	<tr>";
					strHtml += "		<td align='center'>"+data[i].giftlevel+"</td>";
					strHtml += "		<td align='center'>"+data[i].name+"</td>";
					strHtml += "		<td align='center'>"+data[i].mobile+"</td>";
					strHtml += "		<td align='center'>"+data[i].gottime+"</td>";
					strHtml += "		<td align='center'>"+data[i].usetime+"</td>";
					strHtml += "		<td align='center'>"+data[i].areaname+"</td>";
					strHtml += "		<td align='center'>"+data[i].agencyname+"</td>";
					strHtml += "		<td align='center'>"+data[i].shopname+"</td>";
					strHtml += "		<td align='center'>"+data[i].salername+"</td>";
					strHtml += "		<td align='center'>"+data[i].salermobile+"</td>";
					strHtml += "		<td align='center'>"+data[i].useinfo+"</td>";
					strHtml += "	</tr>";
				}
				$("#totaluseDetailList").html(strHtml);
			});
			
		
		}
		function ShowProvidedDetail(giftLevel){
			$("#divProvided").addClass("hidden");
			$("#divProvidedDetail").removeClass("hidden");
			if(giftLevel == 0)
				$("#providedgiftlevel").html("");
			else
				$("#providedgiftlevel").html(giftLevel+"元");
			
			url = "manageajax.php?mode=GetProvidedDetail&giftLevel="+giftLevel;
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;

			$.get(url,function(json){
				var data=eval("("+json+")");
				if(data==null){
					alert('暂无数据！');
					return;
				}
				strHtml = "";
				for(i=0;i<data.length;i++){
						strHtml += "	<tr>";
						strHtml += "		<td align='center'>"+data[i].giftlevel+"</td>";
						strHtml += "		<td align='center'>"+data[i].gottime+"</td>";
						strHtml += "		<td align='center'>"+data[i].name+"</td>";
						strHtml += "		<td align='center'>"+data[i].nickname+"</td>";
						strHtml += "		<td align='center'>"+data[i].mobile+"</td>";
						strHtml += "	</tr>";
				}
				$("#providedDetailList").html(strHtml);
			});
		}
		function ShowProvidedList(){
			url = "manageajax.php?mode=GetProvidedList";
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			$.get(url,function(json){
				var data=eval("("+json+")");
				$("#ptotalcount20").html(data.ptotalcount20);
				$("#ptotalcount50").html(data.ptotalcount50);
				$("#ptotalcount100").html(data.ptotalcount100);
				$("#ptotalcount500").html(data.ptotalcount500);
				$("#ptotalcount1000").html(data.ptotalcount1000);
				
			
				$("#pselfcount50").html(data.pselfcount50);
				$("#pselfcount100").html(data.pselfcount100);
				$("#pselfcount500").html(data.pselfcount500);
				$("#pselfcount1000").html(data.pselfcount1000);
				
			});
			$("#divselect").addClass("hidden");
			$("#divProvided").removeClass("hidden");
		}
		
		function initarealist(){
			url = "manageajax.php?mode=getarealist";
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			$.get(url,function(json,status){
				var data=eval("("+json+")");
				$("#arealist").html("<option value=''>请选择所属区域</option>");
				if(data == null)
					return;
				for(i=0;i<data.length;i++){
					var str = "<option value='"+data[i].id+"'>" + data[i].name + "</option>";  
					$("#arealist").append(str); 
					$("#areapagelist").append(str);
				}
			});
		}
		function UpdateshopInfo(id){
			$("btn_deleteshop").removeClass("hidden");
			AgencySelect();
			$("#divshopsdetail").removeClass("hidden");
			url = "manageajax.php?mode=showshop&shopid="+id;
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			$.get(url,function(json,status){
				var data=eval("("+json+")");
				$("#shopname").val(data.shopname);
				$("#areapagelist").val(data.areaid);
				//InitAgencySelection();
				
				$("#agencypagelist").val(data.agencyid);
				$("#addshopid").val(data.id);
			});
		}
		function DeleteshopInfo(id){
			url = "manageajax.php?mode=deleteshop&shopid="+id;
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			$.get(url,function(json,status){
				var data=eval("("+json+")");
				if(data>0){
					Message("删除成功。");
					$("#divshopsdetail").addClass("hidden");
					if(shoplistTable != null)
						shoplistTable.destroy();
					shoplist();
				}else{
					Message("删除失败。");
				}
			});
		}
		function UpdateInfo(id){
			$("#divagenciesdetail").removeClass("hidden");
			$("#btn_deleteagency").removeClass("hidden");
			url = "manageajax.php?mode=showagency&agencyid="+id;
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			$.get(url,function(json,status){
				var data=eval("("+json+")");
				$("#agencyname").val(data.agencyname);
				$("#arealist").val(data.areaid);
				$("#addid").val(data.id);
			});
		}
		function DeleteInfo(id){
			url = "manageajax.php?mode=deleteagency&agencyid="+id;
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			$.get(url,function(json,status){
				var data=eval("("+json+")");
				if(data>0){
					Message("删除成功。");
					$("#divagenciesdetail").addClass("hidden");
					if(agencylistTable != null)
						agencylistTable.destroy();
					agencylist();
				}else{
					Message("删除失败。");
				}
			});
		}
		function AgencySelect(){
			url = "manageajax.php?mode=getagencylist&area=0";
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			$.get(url,function(json,status){
				var data=eval("("+json+")");
				if(data == null)
					return;
				for(i=0;i<data.length;i++){
					var str = "<option value='"+data[i].agencyid+"'>" + data[i].agencyname + "</option>";  
					$("#agencypagelist").append(str); 
				}
			});
		}
		function InitAgencySelection(){
			url = "manageajax.php?mode=getagencylist&area="+$("#areapagelist").val();
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			$.get(url,function(json,status){
				var data=eval("("+json+")");
				$("#agencypagelist").html("<option value=''>请选择所属经销商</option>");
				if(data == null)
					return;
				for(i=0;i<data.length;i++){
					var str = "<option value='"+data[i].agencyid+"'>" + data[i].agencyname + "</option>";  
					$("#agencypagelist").append(str); 
				}
			});
		}
		
		
		
		function pass(id){
			url = "manageajax.php?";
			//url += "openid=" + openid;
			url += "&mode=passsaler";
			url += "&id=" + id;
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			//url += "&managerid=" + managerid;
			$.get(url,function(json,status){
				var data=eval("("+json+")");
				switch(data){
					
					case 1:
						
						
						InitCheckList();
					break;
					case -1:
						alert("操作失败！");
					break;	
				}
			});
		}

		function refuse(id){
			url = "manageajax.php?";
			//url += "openid=" + openid;
			url += "&mode=refusesaler";
			url += "&id=" + id;
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			//url += "&managerid=" + managerid;
			$.get(url,function(json,status){
				var data=eval("("+json+")");
				switch(data){
					case 1:
						InitCheckList();
					break;
					case -1:
						alert("操作失败！");
					break;	
				}
			});
		}
		
		function update(id){
			url = "manageajax.php?";
			//url += "openid=" + openid;
			url += "&mode=updatesaler";
			url += "&id=" + id;
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			//url += "&managerid=" + managerid;
			$.get(url,function(json,status){
				var data=eval("("+json+")");
				switch(data){
					case 1:
						InitPassList();
						InitRefuseList();
					break;
					case -1:
						alert("操作失败！");
					break;	
				}
			});
		}

		function ShowAllowedList(){
			InitPassList();
			$("#typesaler").html("已通过人员列表");
			/* $("#divsalersList").addClass("hidden");
			$("#divAllowedList").removeClass("hidden"); */
			
		}

		function ShowRefusedList(){
			InitRefuseList();
			$("#typesaler").html("已拒绝人员列表");
			/* $("#divsalersList").addClass("hidden");
			$("#divRefusedList").removeClass("hidden"); */
		}
		
		
		function InitRefuseList(){
			$("#salerslist").html("");
			url = "manageajax.php?";
			url += "mode=getsalerinfo&type=-1&currentpage=1";
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			$.get(url,function(json,status){
				BuildList("salerslist",json,-1);
			});
		}

		function InitPassList(){
			$("#salerslist").html("");
			url = "manageajax.php?";
			url += "mode=getsalerinfo&type=1&currentpage=1";
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			$.get(url,function(json,status){
				BuildList("salerslist",json,1);
			});
		}

		function InitCheckList(){
			$("#typesaler").html("未审核人员列表");
			$("#salerslist").html("");
			url = "manageajax.php?";
			url += "mode=getsalerinfo&type=0&currentpage=1";
			url += "&loginname=" + loginName + "&loginpassword=" + loginPassword;
			$.get(url,function(json,status){
				BuildList("salerslist",json,0);
			});
			
		}
		
		function BuildList(containerID , json , type){
			if(json == "" || json == "null")
				return;
			data = eval("("+json+")");
			dataPaging(data[0].pagecount,type);
			if(data==null){
				alert('暂无数据！');
				return;
			}
			c = $("#"+containerID);
			strHtml = "";
			for(i=0;i<data.length;i++){
				strHtml += "	<tr>";
				strHtml += "		<td><img src='"+data[i].imgurl+"'"+"style='width:"+50+"px;height:"+50+"px'><br>昵称："+data[i].nickname+"</td>";
				strHtml += "		<td><br>姓名："+data[i].name+"<br>电话："+data[i].mobile+"<br>区域："+data[i].area+"<br>经销商："+data[i].agencyname+"<br>门店："+data[i].shopname+"</td>";
				switch(type){
					case 0:
						strHtml += "		<td><button class='pure-button pure-button-primary'onclick='pass(" + data[i]["id"] + ")';>通过</button><button class='pure-button pure-button-primary' onclick='refuse(" + data[i]["id"] + ")';>拒绝</button></td>";
						break;
					case 1:
						strHtml += "		<td><button class='pure-button pure-button-primary' onclick='update(" + data[i]["id"] + ")'>重新审核</button></td>";
						break;
					case -1:
						strHtml += "		<td><button class='pure-button pure-button-primary' onclick='update(" + data[i]["id"] + ")'>重新审核</button></td>";
						break;
				}
				strHtml += "	</tr>";
			}
			c.append(strHtml);
		}
	</script>
	
</html>