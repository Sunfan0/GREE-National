<?php
	include "paras.php";

	function export_csv($filename,$data) { 
		//header("Content-type:text/csv; charset=gb2312"); 
		header("Content-type:text/csv"); 
		header("Content-Disposition:attachment;filename=".$filename); 
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
		header('Expires:0'); 
		header('Pragma:public'); 
		echo $data; 
		die();
	}
	
	$loginName = Get("loginname");
	$loginPassword = Get("loginpassword");
	$processorid = CheckRights($loginName , $loginPassword , "salescenter");
	if($processorid < 0){
		die("-9");
	} 
	$strSql = " SELECT c.id, c.giftlevel , c.name , c.mobile ,c.gottime,c.usetime , c.useinfo , s.name as salername , s.mobile as salermobile , shops.name as shopname ,shops.area as areaname, a.name as agencyname FROM `custinfo` c ";
	$strSql .= " left join salers s on c.usesaler = s.id ";
	$strSql .= " left join shops on s.shopsid = shops.id  ";
	$strSql .= " left join agencies a on shops.agencyid = a.id  ";
	$strSql .= " where c.isgiftused = 1 ";
	$data = DBGetDataRows($strSql);
	

	$strCSV = " id, giftlevel,name,mobile , gottime , usetime , areaname,agencyname,shopname,salername,salermobile,useinfo \n";
	for($i=0;$i<count($data);$i++){
		$strCSV .= $data[$i]["id"];
		$strCSV .= "," . $data[$i]["giftlevel"];
		$strCSV .= "," . $data[$i]["name"];
		$strCSV .= "," . $data[$i]["mobile"];
		$strCSV .= "," . $data[$i]["gottime"];
		$strCSV .= "," . $data[$i]["usetime"];
		$strCSV .= "," . $data[$i]["areaname"];
		$strCSV .= "," . $data[$i]["agencyname"];
		$strCSV .= "," . $data[$i]["shopname"];
		$strCSV .= "," . $data[$i]["salername"];
		$strCSV .= "," . $data[$i]["salermobile"];
		$strCSV .= "," . $data[$i]["useinfo"];
		$strCSV .= "\n";
	}
	
	//export_csv("data.csv",iconv('utf-8', 'gb2312' , $strCSV));
	export_csv("datause.csv", "\xEF\xBB\xBF".$strCSV);
?>