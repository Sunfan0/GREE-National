<?php
	include "paras.php";

	$mode = Get("mode");
	
	switch($mode){
		case "AddGiftCount":
			$giftlevel = Get("giftlevel");
			$giftname = Get("giftname");
			$fromgifttime = Get("fromgifttime");//日期格式（2016-08-10 00:00:00）
			$togifttime = Get("togifttime");
			$giftcount = Get("giftcount");
			DBBeginTrans();
			if($togifttime==""){
				$giftinfo = DBGetDataRowByField("giftcount" ,array("giftname","gifttime"), array($giftname,$fromgifttime));
				if($giftinfo!=null){
					if(!DBUpdateField("giftcount",$giftinfo["id"],array("giftcount"),array($giftinfo["giftcount"]+$giftcount)))
						AjaxRollBack('-1');
				}else{
					$arrFields = array("giftlevel" ,"giftname","gifttime","giftcount");
					$arrValues = array($giftlevel,$giftname,$fromgifttime,$giftcount);
					$r=DBInsertTableField("giftcount",$arrFields,$arrValues);
					if($r<=0){
						AjaxRollBack('-1');
					}
				}
				for($i=0;$i<$giftcount;$i++){
					$arrFields = array("giftlevel" ,"giftname","gifttime");
					$arrValues = array($giftlevel,$giftname,$fromgifttime);
					$r=DBInsertTableField("giftdetail",$arrFields,$arrValues);
					if($r<=0)
						AjaxRollBack('-1');
				}
			}else{
				$days=prDates(date('Y-m-d',strtotime($fromgifttime)),date('Y-m-d',strtotime($togifttime)));
				//echo count($days);
				//die();
				for($i=0;$i<count($days);$i++){
					$giftinfo = DBGetDataRowByField("giftcount" ,array("giftname","gifttime"), array($giftname,$days[$i].' 00:00:00'));
					if($giftinfo!=null){
						if(!DBUpdateField("giftcount",$giftinfo["id"],array("giftcount"),array($giftinfo["giftcount"]+$giftcount)))
							AjaxRollBack('-1');
					}else{
						$arrFields = array("giftlevel" ,"giftname","gifttime","giftcount");
						$arrValues = array($giftlevel,$giftname,$days[$i].' 00:00:00',$giftcount);
						$r=DBInsertTableField("giftcount",$arrFields,$arrValues);
						if($r<=0){
							AjaxRollBack('-1');
						}
					}
					
					for($j=0;$j<$giftcount;$j++){
						$arrFields = array("giftlevel" ,"giftname","gifttime");
						$arrValues = array($giftlevel,$giftname,$days[$i].' 00:00:00');
						$r=DBInsertTableField("giftdetail",$arrFields,$arrValues);
						if($r<=0)
							AjaxRollBack('-1');
						//DBCommitTrans();
					}
				}
			}
			DBCommitTrans();
			echo 1;
			break;
		case "ShowGiftData":	
			$strSql= " select giftlevel,giftname,gifttime,giftcount from giftcount ";
			$results = DBGetDataRows($strSql);	
			echo json_encode($results);			
			break;
			

	}
	
	function prDates($start,$end){ // 两个日期之间的所有日期 
		$p=array();
		$dt_start = strtotime($start);//转为日期格式  
		$dt_end = strtotime($end);  
		while ($dt_start<=$dt_end){  
			//echo date('Y-m-d',$dt_start).","; 
			array_push($p,date('Y-m-d',$dt_start));
			$dt_start = strtotime('+1 day',$dt_start); 
			
		} 
		return $p;
	}  
	
	
	
	

	
?>