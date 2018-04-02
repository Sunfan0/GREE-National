<?php
	include "paras.php";
	
	if(!defined("ONLINE_TIME"))
		define("ONLINE_TIME","2016-09-29");
	if(!defined("PASSWORD"))
		define("PASSWORD","geli201609");
	
	$mode = Get("mode");
	$loginpassword = Get("loginpassword");
	if($loginpassword!=md5(PASSWORD)){
		die();
	}

	$config = array();
	$c = array();
	$c["name"] = "DaysVisitLine";
	$c["mode"] = "DaysVisitLine";
	$c["title"] = "分日访问状况";
	$c["chart"] = "line";
	array_push($config,$c);
	
	$c = array();
	$c["name"] = "HoursVisitLine";
	$c["mode"] = "HoursVisitLine";
	$c["title"] = "分时访问状况";
	$c["chart"] = "line";
	array_push($config,$c);
	
	$c = array();
	$c["name"] = "DaysUserJoinLine";
	$c["mode"] = "DaysUserJoinLine";
	$c["title"] = "分日用户加入（初次访问）";
	$c["chart"] = "line";
	array_push($config,$c);
	
	$c = array();
	$c["name"] = "HoursUserJoinLine";
	$c["mode"] = "HoursUserJoinLine";
	$c["title"] = "分时用户加入（初次访问）";
	$c["chart"] = "line";
	array_push($config,$c);
	
	
	$c = array();
	$c["name"] = "DaysShareLine";
	$c["mode"] = "DaysShareLine";
	$c["title"] = "分日用户分享";
	$c["chart"] = "line";
	array_push($config,$c);
	
	$c = array();
	$c["name"] = "HoursShareLine";
	$c["mode"] = "HoursShareLine";
	$c["title"] = "分时用户分享";
	$c["chart"] = "line";
	array_push($config,$c);
	
	
	$c = array();
	$c["name"] = "FromUrlPie";
	$c["mode"] = "FromUrlPie";
	$c["title"] = "用户访问来源";
	$c["chart"] = "bar";
	array_push($config,$c);
		
	$c = array();
	$c["name"] = "ShareTargetPie";
	$c["mode"] = "ShareTargetPie";
	$c["title"] = "用户分享行为";
	$c["chart"] = "bar";
	array_push($config,$c);
	
	$c = array();
	$c["name"] = "DaysGotLine";
	$c["mode"] = "DaysGotLine";
	$c["title"] = "分日抽取特殊优惠券人数";
	$c["chart"] = "line";
	array_push($config,$c);
	
	$c = array();
	$c["name"] = "HoursGotLine";
	$c["mode"] = "HoursGotLine";
	$c["title"] = "分时抽取特殊优惠券人数";
	$c["chart"] = "line";
	array_push($config,$c);
	
	$c = array();
	$c["name"] = "DaysNoGotLine";
	$c["mode"] = "DaysNoGotLine";
	$c["title"] = "分日抽取普通优惠券人数";
	$c["chart"] = "line";
	array_push($config,$c);
	
	$c = array();
	$c["name"] = "HoursNoGotLine";
	$c["mode"] = "HoursNoGotLine";
	$c["title"] = "分时抽取普通优惠券人数";
	$c["chart"] = "line";
	array_push($config,$c);
	
	$c = array();
	$c["name"] = "Before24HoursVisitLine";
	$c["mode"] = "Before24HoursVisitLine";
	$c["title"] = "过去24小时的访问量";
	$c["chart"] = "line";
	array_push($config,$c);
	
	$c = array();
	$c["name"] = "Before1HoursVisitLine";
	$c["mode"] = "Before1HoursVisitLine";
	$c["title"] = "过去1小时的访问量";
	$c["chart"] = "line";
	array_push($config,$c);
	
	
	switch($mode){
		case "Login"://登录
			echo 1;
			break;
		case "GetConfig":
			echo json_encode($config);
			break;
		case 'DaysVisitLine'://分日，折线图//visithistory
			$strSql= " select date_format(visittime,'%Y-%m-%d') as title,count(*) as value from visithistory ";
			$strSql.= " where  visittime >= '".ONLINE_TIME."' ";
			$strSql.= " group by date_format(visittime,'%Y-%m-%d') order by date_format(visittime,'%Y-%m-%d') asc ";
			$result = DBGetDataRowsSimple($strSql);
			if($result!=null){
				$result = FillDate($result);
			}
			echo json_encode($result);
			break;
		case 'HoursVisitLine'://分时，折线图//visithistory
			$strSql= " select date_format(visittime,'%H') as title,count(*) as value from visithistory  ";
			$strSql.= " where visittime >= '".ONLINE_TIME."' ";
			$strSql.= " group by date_format(visittime,'%H') order by date_format(visittime,'%H') asc ";
			$result = DBGetDataRowsSimple($strSql);
			if($result!=null){
				$result = FillHour($result);
			}
			echo json_encode($result);
			break;
		case 'DaysUserJoinLine'://分日，折线图//custinfo
			$strSql= " select date_format(createtime,'%Y-%m-%d') as title,count(*) as value from custinfo ";
			$strSql.= " where  createtime >= '".ONLINE_TIME."' ";
			$strSql.= " group by date_format(createtime,'%Y-%m-%d') order by date_format(createtime,'%Y-%m-%d') asc ";
			$result = DBGetDataRowsSimple($strSql);
			if($result!=null){
				$result = FillDate($result);
			}
			echo json_encode($result);
			break;
		case 'HoursUserJoinLine'://分时，折线图//custinfo
			$strSql= " select date_format(createtime,'%H') as title,count(*) as value from custinfo  ";
			$strSql.= " where createtime >= '".ONLINE_TIME."' ";
			$strSql.= " group by date_format(createtime,'%H') order by date_format(createtime,'%H') asc ";
			$result = DBGetDataRowsSimple($strSql);
			if($result!=null){
				$result = FillHour($result);
			}
			echo json_encode($result);
			break;
		case 'DaysShareLine'://分日，折线图//分享
			$strSql= " select date_format(visittime,'%Y-%m-%d') as title,count(*) as value from actionhistory ";
			$strSql.= " where  visittime >= '".ONLINE_TIME."' ";
			$strSql.= " group by date_format(visittime,'%Y-%m-%d') order by date_format(visittime,'%Y-%m-%d') asc ";
			$result = DBGetDataRowsSimple($strSql);
			if($result!=null){
				$result = FillDate($result);
			}
			echo json_encode($result);
			break;
		case 'HoursShareLine'://分时，折线图//分享
			$strSql= " select date_format(visittime,'%H') as title,count(*) as value from actionhistory  ";
			$strSql.= " where visittime >= '".ONLINE_TIME."' ";
			$strSql.= " group by date_format(visittime,'%H') order by date_format(visittime,'%H') asc ";
			$result = DBGetDataRowsSimple($strSql);
			if($result!=null){
				$result = FillHour($result);
			}
			echo json_encode($result);
			break;	
		case 'FromUrlPie'://进入来源
			$strSql= " select visiturl as title,count(*) as value from visithistory ";
			$strSql.= " where  visittime >= '".ONLINE_TIME."' ";
			$strSql.= " group by visiturl ";
			$result = DBGetDataRowsSimple($strSql);
			echo json_encode($result);
			break;
		case 'ShareTargetPie'://分享途径
			$strSql= " select action as title ,count(*) as value from actionhistory ";
			$strSql.= " where  visittime >= '".ONLINE_TIME."' ";
			$strSql.= " group by action ";
			$result = DBGetDataRowsSimple($strSql);
			echo json_encode($result);
			break;
			
		case 'DaysGotLine'://分日特殊优惠券
			$strSql= " select date_format(gottime,'%Y-%m-%d') as title,count(*) as value from custinfo ";
			$strSql.= " where  gottime >= '".ONLINE_TIME."' and (giftlevel<>0 and giftlevel<>20) ";
			$strSql.= " group by date_format(gottime,'%Y-%m-%d') ";
			$result = DBGetDataRowsSimple($strSql);
			if($result!=null){
				$result = FillDate($result);
			}
			echo json_encode($result);
			break;
		case 'HoursGotLine'://分时特殊优惠券
			$strSql= " select date_format(gottime,'%H') as title,count(*) as value from custinfo ";
			$strSql.= " where  gottime >= '".ONLINE_TIME."' and (giftlevel<>0 and giftlevel<>20) ";
			$strSql.= " group by date_format(gottime,'%H') ";
			$result = DBGetDataRowsSimple($strSql);
			if($result!=null){
				$result = FillHour($result);
			}
			echo json_encode($result);
			break;
		case 'DaysNoGotLine'://分日普通优惠券
			$strSql= " select date_format(gottime,'%Y-%m-%d') as title,count(*) as value from custinfo ";
			$strSql.= " where  gottime >= '".ONLINE_TIME."' and giftlevel=20 ";
			$strSql.= " group by date_format(gottime,'%Y-%m-%d') ";
			$result = DBGetDataRowsSimple($strSql);
			if($result!=null){
				$result = FillDate($result);
			}
			echo json_encode($result);
			break;
		case 'HoursNoGotLine'://分时普通优惠券
			$strSql= " select date_format(gottime,'%H') as title,count(*) as value from custinfo ";
			$strSql.= " where  gottime >= '".ONLINE_TIME."' and giftlevel=20 ";
			$strSql.= " group by date_format(gottime,'%H') ";
			$result = DBGetDataRowsSimple($strSql);
			if($result!=null){
				$result = FillHour($result);
			}
			echo json_encode($result);
			break;
		
	 
		case 'Before24HoursVisitLine':
			//$strSql= " select floor((unix_timestamp(now())-unix_timestamp(concat(date_format(visittime,'%Y/%m/%d %H'),':00:00')))/3600) as title,count(*) as value from visithistory ";
			$strSql= " select date_format(visittime,'%H') as title,count(*) as value from visithistory ";
			$strSql.= " where visittime > concat(date_format(date_add(now(),interval -24 hour),'%Y/%m/%d %H'),':00:00')  ";
			$strSql.= " group by date_format(visittime,'%H') order by  date_format(visittime,'%Y/%m/%d %H')  ";
			$result = DBGetDataRowsSimple($strSql);
			if($result!=null){
				$result = FillHourAdd($result);
			}
			echo json_encode($result);
			break;
		 case 'Before1HoursVisitLine':
			$strSql= " select date_format(visittime,'%i') as title,count(*) as value from visithistory ";
			$strSql.= " where unix_timestamp(visittime)>=unix_timestamp(now())-3600 ";
			$strSql.= " group by date_format(visittime,'%i') order by date_format(visittime,'%Y/%m/%d %H:%i')  ";
			$result = DBGetDataRowsSimple($strSql);
			if($result!=null){
				$result = FillMinute($result);
			}
			echo json_encode($result);
			break;	
			

		case 'ShowGiftData':
			//(日期，预计实物奖总数，已领取实物奖总数，剩余实物奖品总数，虚拟领取总数)
			$strSql = " select date_format(g.gifttime,'%Y-%m-%d') as timer,sum(g.giftcount) as plancount,sum(g.gotcount) as gotcount,sum(g.giftcount) - sum(g.gotcount) as overcount,u.cnt as falsecount,u1.cnt as msgcount ,g1.cnt as usecount from giftcount g ";
			$strSql.= " left join (select date_format(gottime,'%Y-%m-%d') as gottimer, count(*) as cnt from custinfo where giftlevel=20 group by gottimer) u on date_format(g.gifttime,'%Y-%m-%d') = date_format(u.gottimer,'%Y-%m-%d') ";
			///
			$strSql.= " left join (select date_format(gifttime,'%Y-%m-%d') as gottimer, count(*) as cnt from giftdetail where isused=1 group by gottimer) g1 on date_format(g.gifttime,'%Y-%m-%d') = date_format(g1.gottimer,'%Y-%m-%d') ";
			$strSql.= " left join (select date_format(gifttime,'%Y-%m-%d') as gottimer, count(*) as cnt from giftdetail where gottermobile!='' and hasgot=1 group by gifttime ) u1 on date_format(g.gifttime,'%Y-%m-%d') = date_format(u1.gottimer,'%Y-%m-%d') ";
			$strSql.= " group by date_format(g.gifttime,'%Y-%m-%d') ";
		//echo $strSql;
		//die();
			$result = DBGetDataRowsSimple($strSql);
			echo json_encode($result);
			break;
		
		case 'ShowDetailGiftData':
			$strSql= " select giftlevel,giftname,date_format(gifttime,'%Y-%m-%d') as gifttime,giftcount,gotcount,giftcount - gotcount as count from giftcount ";
			$results = DBGetDataRows($strSql);	
			echo json_encode($results);			
			break;
		
	}
	
	function FillMinute($arr){//填充分钟。3分钟间隔
		for($i=0;$i<=59;$i++){
			
			$m = str_pad($i,2,'0',STR_PAD_LEFT);
			$found = false;
			for($j=0;$j<count($arr);$j++){
				if($arr[$j]["title"] == $m){
					$found = true;
				}
			}
			
			if(!$found){
				$a = array();
				$a["title"] = $m;
				$a["value"] = 0;
				array_push($arr,$a);
			}
		}
		
		
		$arrResult = array();
		$timeSpan = 3;
		for($i=0;$i<count($arr);$i+=$timeSpan){
			$t = array();
			$t["title"] = $arr[$i]["title"]."分";
			$t["value"] = 0;
			for($j=0;$j<$timeSpan;$j++)
				$t["value"] += $arr[$i+$j]["value"];
			array_push($arrResult , $t);
		}
		
		return $arrResult;
	}
	function FillHourAdd($arr){//填充小时
		for($i=0;$i<24;$i++){
			$h = str_pad($i,2,'0',STR_PAD_LEFT);
			$found = false;
			for($j=0;$j<count($arr);$j++){
				if($arr[$j]["title"] == $h){
					$found = true;
				}
			}
			
			if(!$found){
				$a = array();
				$a["title"] = $h;
				$a["value"] = 0;
				array_push($arr,$a);
			}
		}
		
		$arrResult = array();
		for($i=0;$i<count($arr);$i++){
			$t = array();
			$t["title"] = ($arr[$i]["title"]+1)."点";
			$t["value"] = $arr[$i]["value"];
			array_push($arrResult , $t);
		} 
		return $arrResult;
	}
	function FillHour($arr){//填充小时
		for($i=0;$i<24;$i++){
			$h = str_pad($i,2,'0',STR_PAD_LEFT);
			$found = false;
			for($j=0;$j<count($arr);$j++){
				if($arr[$j]["title"] == $h){
					$found = true;
				}
			}
			
			if(!$found){
				$a = array();
				$a["title"] = $h;
				$a["value"] = 0;
				array_push($arr,$a);
			}
		}
		
		$arrResult = array();
		for($i=0;$i<count($arr);$i++){
			$t = array();
			$t["title"] = $arr[$i]["title"]."点";
			$t["value"] = $arr[$i]["value"];
			array_push($arrResult , $t);
		} 
		return $arrResult;
	}
	function FillDate($arr){//填充日期
		$days=prDates(ONLINE_TIME,date('Y-m-d'));
		for($i=0;$i<count($days);$i++){
			$d = str_pad($days[$i],2,'0',STR_PAD_LEFT);
			$found = false;
			for($j=0;$j<count($arr);$j++){
				if($arr[$j]["title"] == $d){
					$found = true;
				}
			}
			
			if(!$found){
				$a = array();
				$a["title"] = $d;
				$a["value"] = 0;
				array_push($arr,$a);
			}
		}
		
		$title = array();
		$value = array();
		// 取得列的列表 
		foreach ($arr as $key => $row){ 
			$title[$key]  = $row['title'] . "点"; 
			$value[$key] = $row['value']; 
		} 
		array_multisort($title, SORT_ASC, $value, SORT_ASC, $arr); 
		return $arr;
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