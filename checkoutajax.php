<?php
	header("Access-Control-Allow-Origin:http://www.wsestar.com");
	include "paras.php";

	$mode = Get("mode");
	$checktoken = Get("checktoken");
	$checksalerid = Get("checksalerid");
	
	$checksalerinfo = DBGetDataRowByField("salers","id",$checksalerid);
	if($checksalerinfo == null)
		die("1");
	if($checksalerinfo["status"] != 1)
		die("2");

	$checksaleropenid=$checksalerinfo["openid"];
	$strcheckopenid = substr($checksaleropenid, 0, 10);
	$salerflag=false;
	for($i=0;$i<11;$i++){//10分钟之内
		$strnow = date("YmdHi", time()-60*$i);
		$tokenpara = md5($checksalerid.$strcheckopenid.$strnow);
		if($checktoken==$tokenpara){
			$salerflag = true;
			break;
		}
	}
	if($salerflag!=true){
		//echo $tokenpara;
		die("3");
	}
	
	switch($mode){	
		//核销数据
		case "showuserinfo"://显示用户信息
			$id = (int)(Get("id"));
			$strSql = " SELECT g.giftname,sp.name as shopname,s.name as salername,s.mobile as salermobile, c.name,c.mobile,c.giftid,c.giftlevel,c.gottime, ";
			$strSql .= " c.usetime,c.usesaler,c.useinfo  ";
			$strSql .= " FROM `custinfo` c  ";
			$strSql .= " left join salers s on c.usesaler = s.id ";
			$strSql .= " left join giftdetail g on c.giftid = g.id ";
			$strSql .= " left join shops sp on s.shopsid = sp.id ";
			$strSql .= " WHERE c.id=$id ";
//echo $strSql;
			$result = DBGetDataRow($strSql);
//echo $strSql;
			echo json_encode($result);
			break;
			break;
		case "comfirmsale":	//确认核销
			$id = Get("id");//当前用户id
			$useinfo = Get("useinfo");//用户所使用的商品信息
			$salerid = Get("salerId");//销售人员id
			DBBeginTrans();
			$r = DBUpdateField("custinfo" , $id , array("isgiftused","usetime","usesaler","useinfo") ,array(1,$DB_FUNCTIONS["now"],$salerid,$useinfo));//更新custinfo表
			if(!$r)
				AjaxRollBack("-9");
			$giftInfo = DBGetDataRowByField("giftdetail","gotterid",$id);
			$giftid = $giftInfo["id"];
			$p = DBUpdateField("giftdetail" , $giftid , array("isused","usetime","usesaler","useinfo") ,array(1,$DB_FUNCTIONS["now"],$salerid,$useinfo));
			if(!$p)
				AjaxRollBack("-8");
			AjaxCommit();
			break;
		
			
	}
?>