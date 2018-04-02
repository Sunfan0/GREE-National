<?php
//die();
set_time_limit(0);
	include "paras.php";

	function export_csv($filename,$data) { 
		header("Content-type:text/csv"); 
		header("Content-Disposition:attachment;filename=".$filename); 
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
		header('Expires:0'); 
		header('Pragma:public'); 
		echo $data; 
	} 
	
	//$userInfo = DBGetDataRowByField("bgmanager","username",$loginName);
	//$strSql = " SELECT o.id ,o.goodsid , o.salerid , o.salermanagerid , o.salescenterid , o.salestime , o.out_trade_no , o.processstatus , o.ordermobile , ";
	//$strSql .= " s.name as salername , m.name as salermanagername , c.name as centername , g.name as productname ";
	$strSql = " SELECT c.giftlevel ,c.friendhelpgiftlevel,c.giftlevel+c.friendhelpgiftlevel, c.name , c.mobile ,c.gottime , c.usetime ,a.name as agencyname,shops.name as shopname,s.name as salername , s.mobile as salermobile , c.useinfo FROM `custinfo` c ";
	$strSql .= " left join custinfo c1 on c.friendid = c1.id ";
	$strSql .= " left join salers s on c.usesaler = s.id ";
	$strSql .= " left join shops on shops.id = s.shopsid ";
	$strSql .= " left join agencies a on a.id = shops.agencyid ";
	$strSql .= " WHERE c.isgiftused = 1 ";
$strSql = "SELECT * FROM gree201603.`custinfo`  ";
	$datas = DBGetDataRowsSimple($strSql);
	
	//$strCSV = iconv('utf-8', 'gbk' , "数据id,产品id,产品名称,营业点id,营业点名称," . SALERMANAGER_DISPLAY_NAME . "id," . SALERMANAGER_DISPLAY_NAME . "姓名," . SALER_DISPLAY_NAME . "id," . SALER_DISPLAY_NAME . "姓名,系统单号,销售时间,客户电话,处理状态\r\n");
	$strCSV = "优惠券金额,好友帮助金额,总金额,姓名,电话,获取时间,使用时间,经销商,门店,核销员,核销电话,使用信息,使用状况\n";
	$strCSV = "";
	//数据id,产品id,产品名称,营业点id,营业点名称," . mb_convert_encoding(SALERMANAGER_DISPLAY_NAME,"gbk") . "id," . mb_convert_encoding(SALERMANAGER_DISPLAY_NAME,"gbk") . "姓名," . mb_convert_encoding(SALER_DISPLAY_NAME,"gbk") . "id," . mb_convert_encoding(SALER_DISPLAY_NAME,"gbk") . "姓名,系统单号,销售时间,客户电话,处理状态\r\n";
//var_dump($datas);
	for($i=0;$i<count($datas);$i++){
		for($j=0;$j<count($datas[$i]) / 2;$j++){
			//echo "$i , $j , $datas[$i][$j] <br>";
			//$strCSV .= iconv('utf-8', 'gbk' , $datas[$i][$j]);
			$strCSV .= mb_convert_encoding ($datas[$i][$j] , "gbk");
			$strCSV .= ",";
		}
		$strCSV .= "\r\n";
	}
	
	export_csv("data.csv",$strCSV);
?>