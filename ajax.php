<?php
	include "paras.php";
	$mode = Get("mode");
	
	$userId = Get("userid");
	$token = Get("token");
	if($userId!=""){
		$userinfo = DBGetDataRowByField("custinfo" ,'id', $userId);
		if(!isset($_SESSION["stropenid"])){//session中是否存在数据
			$_SESSION["stropenid"]=$userinfo["openid"];
		}
		$checktoken = md5(substr($_SESSION["stropenid"], 0, 10).$userId);
		if($checktoken!=$token){
			die("-8");
		}  
	}
	$giftRates = array(//设置百分比
		"2016-09-29 00:00:00" => 9,
		"2016-09-30 00:00:00" => 9,
		"2016-10-01 00:00:00" => 15,
		"2016-10-02 00:00:00" => 15,
		"2016-10-03 00:00:00" => 14,
		"2016-10-04 00:00:00" => 9,
		"2016-10-05 00:00:00" => 9,
		"2016-10-06 00:00:00" => 7,
		"2016-10-07 00:00:00" => 7,
		"2016-10-08 00:00:00" => 4,
		"2016-10-09 00:00:00" => 4,
	);
	switch($mode){
		case "Action":
			$action = Get("action");
			$page = Get("page");
			$currenturl = GetRefferPage();
			$openid = Get("openid");
			$memo = Get("memo");
			$visitid = Get("visitid");
			if($action == ""){
				echo "para error";
				die();
			}
			ActionHistory($page , $currenturl , $action , $memo , $visitid , $openid);
			break;
			
		case "SubmitInfo"://获得优惠券，提交信息
	//-7防止恶意更改提交数据，1更新成功，-1更新失败
			$name = Get("name");
			$mobile = Get("mobile");
//使用电话号码判断是否已经领取过			
			$mobileinfo = DBGetDataRowByField("custinfo" ,'mobile', $mobile);
			if($mobileinfo!=null){
				die('-8');//提示该手机号码已经领取过优惠券
			}
			
			if($userinfo['mobile']!=""){
				die('-7');
			}
			
			if($userinfo["giftid"] == 0 || $userinfo["giftid"] == -99){//20元优惠券
				DBBeginTrans();
				if(!DBUpdateField("custinfo" , $userId , array("name","mobile") ,array($name,$mobile)))
					AjaxRollBack("-6");
				
			}else{//特殊优惠券
				DBBeginTrans();
				if(!DBUpdateField("custinfo" , $userId , array("name","mobile") ,array($name,$mobile)))
					AjaxRollBack("-5");
				if(!DBUpdateField("giftdetail",$userinfo["giftid"],array("gotternickname","gottername","gottermobile"),array($userinfo["nickname"],$name,$mobile)))
					AjaxRollBack("-4");
			}
			
			DBCommitTrans();
			echo 1;
			break;
		case "GetGift":
			if($userinfo["giftlevel"] != 0 && $userinfo["mobile"] != ""){
				echo -4;//如果已经抽了优惠券，并且提交了信息
				die();
			}
			if($userinfo["giftlevel"] != 0){
				echo $userinfo["giftlevel"];//如果已经抽了优惠券，没有提交信息
				die();
			}
			$targetTime =  date("Y-m-d 00:00:00" , time() + 86400 * 2);
			$strSql = "Select giftlevel , giftcount as total , gotcount as got , giftcount - gotcount as count from giftcount where gifttime = '$targetTime' ";
			$giftLevels = DBGetDataRows($strSql);
			
			if($giftLevels == null){
				if(!DBUpdateField("custinfo" , $custId , array("gotgift","giftlevel","gottime","giftid") ,array(1,20,$DB_FUNCTIONS["now"],-99)))
					die("-1");
				die("20");//20元优惠券
			}
			$giftCount = 0;
			for($i=0;$i<count($giftLevels);$i++){
				$giftCount += $giftLevels[$i]["count"];
			}
			if($giftCount == 0){//当天已经抽完
				if(!DBUpdateField("custinfo" , $userId , array("giftlevel","gottime","giftid","gotgift") ,array(20,$DB_FUNCTIONS["now"],-99,1)))
					die("-1");
				die("20");//
			}

			$rnd = mt_rand(0 , 100);
			if($rnd > $giftRates[$targetTime]){
				if(!DBUpdateField("custinfo" , $userId , array("giftlevel","gottime","giftid","gotgift") ,array(20,$DB_FUNCTIONS["now"],-99,1)))
					die("-1");
				die("20");//
			}

			$gotGiftLevel = 0;
			for($i=0;$i<count($giftLevels);$i++){
				$rnd = mt_rand(0 , $giftCount);
				if($rnd <= $giftLevels[$i]["count"]){//在奖品总数范围之内
					$gotGiftLevel = $giftLevels[$i]["giftlevel"];
					break;
				}
				$giftCount = $giftCount - $giftLevels[$i]["count"];
			}

			if($gotGiftLevel == 0){
				if(!DBUpdateField("custinfo" , $userId , array("giftlevel","gottime","giftid","gotgift") ,array(20,$DB_FUNCTIONS["now"],-99,1)))
					die('-1');
				die("20");//
			}

			DBBeginTrans();
			$giftInfo = DBGetDataRowByFieldForUpdate("giftdetail",array("giftlevel","hasgot","gifttime"),array($gotGiftLevel,0,$targetTime));
			
			if($giftInfo == null){
				if(!DBUpdateField("custinfo" , $userId , array("giftlevel","gottime","giftid","gotgift") ,array(20,$DB_FUNCTIONS["now"],-99,1)))
					die('-1');
				die("20");//
			}
			
			if(!DBUpdateField("custinfo" , $userId , array("giftlevel","gottime","giftid","gotgift") ,array($gotGiftLevel,$DB_FUNCTIONS["now"],$giftInfo["id"],1)))
				AjaxRollBack();
			if(!DBUpdateField("giftdetail" , $giftInfo["id"] , array("hasgot","gotterid","gottime") ,array(1,$userId,$DB_FUNCTIONS["now"])))
				AjaxRollBack();
			$strSql = " Update giftcount Set gotcount = gotcount + 1 Where gifttime = '$targetTime' and giftlevel = $gotGiftLevel ";
			if(!DBExecute($strSql))
				AjaxRollBack();
			DBCommitTrans();
			echo $giftInfo["giftlevel"];
			
			die();
			break;
		
	
	}
?>