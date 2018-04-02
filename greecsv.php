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
	
	//$strCSV = iconv('utf-8', 'gbk' , "����id,��Ʒid,��Ʒ����,Ӫҵ��id,Ӫҵ������," . SALERMANAGER_DISPLAY_NAME . "id," . SALERMANAGER_DISPLAY_NAME . "����," . SALER_DISPLAY_NAME . "id," . SALER_DISPLAY_NAME . "����,ϵͳ����,����ʱ��,�ͻ��绰,����״̬\r\n");
	$strCSV = "�Ż�ȯ���,���Ѱ������,�ܽ��,����,�绰,��ȡʱ��,ʹ��ʱ��,������,�ŵ�,����Ա,�����绰,ʹ����Ϣ,ʹ��״��\n";
	$strCSV = "";
	//����id,��Ʒid,��Ʒ����,Ӫҵ��id,Ӫҵ������," . mb_convert_encoding(SALERMANAGER_DISPLAY_NAME,"gbk") . "id," . mb_convert_encoding(SALERMANAGER_DISPLAY_NAME,"gbk") . "����," . mb_convert_encoding(SALER_DISPLAY_NAME,"gbk") . "id," . mb_convert_encoding(SALER_DISPLAY_NAME,"gbk") . "����,ϵͳ����,����ʱ��,�ͻ��绰,����״̬\r\n";
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