<?php
	header("Access-Control-Allow-Origin:http://www.wsestar.com");
	include "paras.php";

	$mode = Get("mode");
	$token = Get("token");
	switch($mode){
		case "getarealist":
			$strSql = " Select id as areaid , name as areaname from areas ";
			$result = DBGetDataRows($strSql);
			echo json_encode($result);
			break;
		case "getagencylist":
			$areaId = (int)(Get("area"));
			$strSql = " Select id as agencyid , name as agencyname from agencies where areaid = $areaId ";
			$result = DBGetDataRows($strSql);
			echo json_encode($result);
			break;
		case "getshoplist":
			$agencyId = (int)(Get("agency"));
			$strSql = " Select id as shopid , name as shopname from shops where agencyId = $agencyId";
			$result = DBGetDataRows($strSql);
			echo json_encode($result);
			break;
	
		/* case "getshopslist"://根据区域id获取对应门店名称
			 $salescenterid = (int)(Get("salescenterid"));
			$strSql = " SELECT * FROM `shops` s  ";
			$strSql .= " Where s.salescenterid = $salescenterid ";
			$strSql .= "  order by s.name ";
			$result = DBGetDataRows($strSql);
			echo json_encode($result);
			break; */
		case "applysaler"://销售人员申请
			$openid = Get("openid");
			$name = Get("name");
			$mobile = Get("mobile");
			$shopsid = Get("shopsid");
			$salerId = Get("userId");
			$salesCenterId = Get("salesCenterId");
			$arrFields = array("status","name","mobile","shopsid","salescenterid");
			$arrValues = array(0,$name,$mobile,$shopsid,$salesCenterId);
			$salerInfo = DBGetDataRowByField("salers","openid",$openid);
			if($salerInfo["mobile"] != "" && $salerInfo["name"] != "")
				die("-9");
			$r = DBUpdateField("salers" , $salerId , $arrFields ,$arrValues);
			if(!$r){
				echo -1;
			}else{
				echo 1;
			}
			break;
		
			
	}
	
	
?>