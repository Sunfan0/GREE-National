<?php
	header("Access-Control-Allow-Origin:http://www.wsestar.com");
	include "paras.php";
	$perpage = 20;
	$mode = Get("mode");
	$processorid=1;
	$loginName = Get("loginname");
	$loginPassword = Get("loginpassword");
	$processorid = CheckRights($loginName , $loginPassword , "salescenter");
	if($processorid < 0){
		die("-9");
	} 
	//根据不同账号和密码分配管理不同区域的数据
	/* $AreaInfo = DBGetDataRowByField("bgmanager","username",$loginName);
	$centerid=$AreaInfo["salescenterid"]; */

	switch($mode){
		case "checklogin":
			echo 1;
			break;
		case "getagencylist":
			$areaId = Get("area");
			$strSql = " Select id as agencyid , name as agencyname from agencies  ";
			if($areaId != "0"){
				$strSql.=" where areaid = $areaId ";
			}
			$result = DBGetDataRowsSimple($strSql);
			echo json_encode($result);
			break;
		
		case "getagencydata":
			$strSql = " SELECT a.id , a.name as agencyname,a1.id as areaid,a1.name as areaname from `agencies` a ";
			$strSql.= " left join `areas` a1 on a.areaid=a1.id "; 
			//$strSql.= " order by a.name "; 
			$search = Get("search");
			$toLike = $search["value"];
			$strSql .= "where  (a1.name like '%" . $toLike . "%') ";
			$sqlPara = GetPageParas();
			$strSqlDetail = $strSql . $sqlPara["where"] . $sqlPara["limit"];
			$dataDetail = DBGetDataRows($strSqlDetail);
			$strSqlCountAll = "Select count(*) FROM agencies ";
			$dataCountAll = DBGetDataRow($strSqlCountAll);

			$result["data"] = $dataDetail;
			$result["draw"] = Get("draw");
			$result["recordsFiltered"] = $dataCountAll[0];
			$result["recordsTotal"] = $dataCountAll[0];
			echo json_encode($result);
			break;
			
		case "getarealist":	
			$strSql= " SELECT * from `areas` ";
			$result = DBGetDataRowsSimple($strSql);
			echo json_encode($result);
			break;
		case "showagency":	
			$agencyid = Get("agencyid");
			$strSql = " SELECT a.id , a.name as agencyname,a1.id as areaid,a1.name as areaname from `agencies` a ";
			$strSql.= " left join `areas` a1 on a.areaid=a1.id ";
			$strSql.= " where a.id= $agencyid ";
			$result = DBGetDataRow($strSql);
			echo json_encode($result);
			break;
		case "updateagency":
			$agencyname = Get("agencyname");
			$areaid = Get("areaid");
			$addid = Get("addid");
			$arrFields = array("areaid","name");
			$arrValues = array($areaid,$agencyname);
			if($addid == ""){
				$WAid = DBInsertTableField("agencies",$arrFields,$arrValues);
				if($WAid<=0){
					echo -1;
				}else{
					echo 1;
				}
			}else{
				$r = DBUpdateField("agencies" , $addid , $arrFields , $arrValues);
				if(!$r){
					echo -1;
				}else{
					echo 1;
				}
			}
			break;
		case "deleteagency":
			$agencyid = Get("agencyid");
			$data = DBDeleteData("agencies",$agencyid);
			echo $data;
			break;	
			
		case "getshopdata":
			$strSql = " SELECT s.id,s.name as shopname,s.area as areaname,s.agencyid,a.name as agencyname from `shops` s ";
			$strSql.= " left join `agencies` a on s.agencyid=a.id "; 
			//$strSql.= " order by s.name "; 
			$search = Get("search");
			$toLike = $search["value"];
			$strSql .= "where  (s.area like '%" . $toLike . "%') ";
			$sqlPara = GetPageParas();
			$strSqlDetail = $strSql . $sqlPara["where"] . $sqlPara["limit"];
			$dataDetail = DBGetDataRows($strSqlDetail);
			$strSqlCountAll = "Select count(*) FROM shops ";
			$dataCountAll = DBGetDataRow($strSqlCountAll);

			$result["data"] = $dataDetail;
			$result["draw"] = Get("draw");
			$result["recordsFiltered"] = $dataCountAll[0];
			$result["recordsTotal"] = $dataCountAll[0];
			echo json_encode($result);
			break;	
		case "showshop":	
			$shopid = Get("shopid");
			$strSql = " SELECT s.id,s.name as shopname,s.area as areaname,s.agencyid,a.areaid,a.name as agencyname from `shops` s ";
			$strSql.= " left join `agencies` a on s.agencyid=a.id ";
			$strSql.= " where s.id= $shopid ";
			$result = DBGetDataRow($strSql);
			echo json_encode($result);
			break;
		case "updateshop":
			$shopname = Get("shopname");
			$areapage = Get("areapage");
			$agencypageid = Get("agencypageid");
			$addshopid = Get("addshopid");
			$arrFields = array("agencyid","area","name");
			$arrValues = array($agencypageid,$areapage,$shopname);
			if($addshopid == ""){
				$WAid = DBInsertTableField("shops",$arrFields,$arrValues);
				if($WAid<=0){
					echo -1;
				}else{
					echo 1;
				}
			}else{
				$r = DBUpdateField("shops" , $addshopid , $arrFields , $arrValues);
				if(!$r){
					echo -1;
				}else{
					echo 1;
				}
			}
			break;
		case "deleteshop":
			$shopid = Get("shopid");
			$data = DBDeleteData("shops",$shopid);
			echo $data;
			break;	
		
		case "getsalerinfo"://销售人员列表
			$type = Get("type");
			$currentpage = Get("currentpage");
			$currentpage=$currentpage-1;
			$p=$currentpage*$perpage;
			if($type != "-1" && $type != "0" && $type != "1")
				die();
			
			$detail=array();
			$data=array();
			$strSql= "select  count(*) as total from salers Where status = $type and name <> '' and mobile <> '' ";
			$result = DBGetDataRow($strSql);
			
			$data["total"]=$result[0];
			if($data["total"]==0){
				$detail=null;
				echo json_encode($detail);
				die();
			}
			$strSql = " SELECT s.id , s.nickname , s.imgurl , s.name , s.mobile , ss.name as shopname , a.name as agencyname , ss.area FROM `salers` s Left Join shops ss on s.shopsid = ss.id ";
			$strSql .= " Left Join agencies a on ss.agencyid = a.id  ";
			$strSql .= " Where status = $type and s.name <> '' and s.mobile <> ''";
			$strSql .= " order by s.name ";
			$strSql .= " limit $p,$perpage";
			$datas = DBGetDataRows($strSql);
			
			foreach($datas as $result){
				$data["id"]=$result["id"];
				$data["nickname"]=$result["nickname"];
				$data["imgurl"]=$result["imgurl"];
				$data["name"]=$result["name"];
				$data["mobile"]=$result["mobile"];
				$data["shopname"]=$result["shopname"];
				$data["agencyname"]=$result["agencyname"];
				$data["area"]=$result["area"];
				$data["pagecount"]=ceil($data["total"]/$perpage);
				$data["perpage"]=$perpage;
				array_push($detail,$data);
			}
			echo json_encode($detail);
			die();
			
			break;
		case "getsalerinfoexcel"://销售人员列表
			$type = Get("type");
			if($type != "-1" && $type != "0" && $type != "1")
				die();
			$strSql = " SELECT s.id , s.nickname , s.imgurl , s.name , s.mobile , ss.name as shopname , a.name as agencyname , ss.area , s.status  FROM `salers` s Left Join shops ss on s.shopsid = ss.id ";
			$strSql .= " Left Join agencies a on ss.agencyid = a.id  ";
			//$strSql .= " Where status = $type and s.name <> '' and s.mobile <> '' ";
			$strSql .= " Where s.name <> '' and s.mobile <> '' ";
			$result = DBGetDataRows($strSql);
//myecho($strSql);
			echo json_encode($result);
			die();
			break;
		//保留上
		case "updatesaler"://重新审核按钮操作
			$id = (int)(Get("id"));
			//$managerid = Get("managerid");//记录当前进入页面的人的id
			DBBeginTrans();
			$Info = DBGetDataRowByField("salers","id",$id);
			$salescenterid = $Info['salescenterid'];
			$status = $Info['status'];
			$openid = $Info['openid'];
			$name = $Info['name'];
			$mobile = $Info['mobile'];
			$shopsid = $Info['shopsid'];
			$nickname = $Info['nickname'];
			$imgurl = $Info['imgurl'];
			$datacreatetime=$Info['createtime'];
			$datalastmodifytime=$Info['lastmodifytime'];
			$infos = DBUpdateField("salers" , $id , array("status") ,array(0));
			if(!$infos)
				AjaxRollBack();
			$arrFields = array("salescenterid","managerid","type","processer","processtime","dataid","status","name","mobile","shopsid","openid","nickname","imgurl","datacreatetime","datalastmodifytime");
			$arrValues = array($salescenterid,0,-1,0,$DB_FUNCTIONS["now"],$id,$status,$name,$mobile,$shopsid,$openid,$nickname,$imgurl,$datacreatetime,$datalastmodifytime);
			$id = DBInsertTableField("salershistory" , $arrFields , $arrValues);
			if($id <= 0)
				AjaxRollBack();
			AjaxCommit();
		
			break;
		case "passsaler":
			$id = (int)(Get("id"));
			//$managerid = Get("managerid");//记录当前进入页面的人的id
			DBBeginTrans();
			$Info = DBGetDataRowByField("salers","id",$id);
			$salescenterid = $Info['salescenterid'];
			$status = $Info['status'];
			$openid = $Info['openid'];
			$name = $Info['name'];
			$mobile = $Info['mobile'];
			$shopsid = $Info['shopsid'];
			$nickname = $Info['nickname'];
			$imgurl = $Info['imgurl'];
			$datacreatetime=$Info['createtime'];
			$datalastmodifytime=$Info['lastmodifytime'];
			$infos = DBUpdateField("salers" , $id , array("status") ,array(1));
			if(!$infos)
				AjaxRollBack();
			$arrFields = array("salescenterid","managerid","type","processer","processtime","dataid","status","name","mobile","shopsid","openid","nickname","imgurl","datacreatetime","datalastmodifytime");
			$arrValues = array($salescenterid,0,-1,0,$DB_FUNCTIONS["now"],$id,$status,$name,$mobile,$shopsid,$openid,$nickname,$imgurl,$datacreatetime,$datalastmodifytime);
			$id = DBInsertTableField("salershistory" , $arrFields , $arrValues);
			if($id <= 0)
				AjaxRollBack();
			
			AjaxCommit();
			break;
		case "refusesaler":
			$id = (int)(Get("id"));
			//$managerid = Get("managerid");//记录当前进入页面的人的id
			DBBeginTrans();
			$Info = DBGetDataRowByField("salers","id",$id);
			$salescenterid = $Info['salescenterid'];
			$status = $Info['status'];
			$openid = $Info['openid'];
			$name = $Info['name'];
			$mobile = $Info['mobile'];
			$shopsid = $Info['shopsid'];
			$nickname = $Info['nickname'];
			$imgurl = $Info['imgurl'];
			$datacreatetime=$Info['createtime'];
			$datalastmodifytime=$Info['lastmodifytime'];
			$infos = DBUpdateField("salers" , $id , array("status") ,array(-1));
			if(!$infos)
				AjaxRollBack();
			$arrFields = array("salescenterid","managerid","type","processer","processtime","dataid","status","name","mobile","shopsid","openid","nickname","imgurl","datacreatetime","datalastmodifytime");
			$arrValues = array($salescenterid,0,-1,0,$DB_FUNCTIONS["now"],$id,$status,$name,$mobile,$shopsid,$openid,$nickname,$imgurl,$datacreatetime,$datalastmodifytime);
			$id = DBInsertTableField("salershistory" , $arrFields , $arrValues);
			if($id <= 0)
				AjaxRollBack();
			
			AjaxCommit();
			break;
		case "GetProvidedList":
			$result = array();
			$strSql0 = " select giftlevel , sum(giftcount) as cnt from giftcount  group by giftlevel ";
			$data0 = DBGetDataRows($strSql0);//总数
			
			$strSql1 = " select giftlevel, count(*) as cnt from custinfo where giftlevel = 20 and gotgift=1 ";
			$data1 = DBGetDataRows($strSql1);
			$result["ptotalcount20"] = GetData($data1 , 20) == null ? 0 : GetData($data1 , 20)["cnt"];
			$result["ptotalcount50"] = GetData($data0 , 50) == null ? 0 : GetData($data0 , 50)["cnt"];
			$result["ptotalcount100"] = GetData($data0 , 100) == null ? 0 : GetData($data0 , 100)["cnt"];
			$result["ptotalcount500"] = GetData($data0 , 500) == null ? 0 : GetData($data0 , 500)["cnt"];
			$result["ptotalcount1000"] = GetData($data0 , 1000) == null ? 0 : GetData($data0 , 1000)["cnt"];
			$strSql = " select giftlevel , count(*) as cnt from giftdetail where hasgot = 1  group by giftlevel ";
			$data = DBGetDataRows($strSql);//已领取
			$result["pselfcount50"] = GetData($data , 50) == null ? 0 : GetData($data , 50)["cnt"];
			$result["pselfcount100"] = GetData($data , 100) == null ? 0 : GetData($data , 100)["cnt"];
			$result["pselfcount500"] = GetData($data , 500) == null ? 0 : GetData($data , 500)["cnt"];
			$result["pselfcount1000"] = GetData($data , 1000) == null ? 0 : GetData($data , 1000)["cnt"];
		
			echo(json_encode($result));
			break;
		case "GettotaluseDetail":
			$giftLevel = Get("giftLevel");//
			$strSql = " select * from custinfo where gotgift=1 and isgiftused = 1 ";	
			if($giftLevel != "0")
				$strSql .= " and giftlevel = " . (int)$giftLevel;
			$data = DBGetDataRows($strSql);
			echo(json_encode($data));
			break;
		case "GetTotalGiftDetail":
			$giftLevel = Get("giftLevel");
			$strSql = " SELECT c.isgiftused , c.giftlevel , c.name , c.mobile ,c.gottime,c.usetime , c.useinfo , s.name as salername , s.mobile as salermobile , shops.name as shopname ,shops.area as areaname, a.name as agencyname FROM `custinfo` c ";
			$strSql .= " left join salers s on c.usesaler = s.id ";
			$strSql .= " left join shops on s.shopsid = shops.id  ";
			$strSql .= " left join agencies a on shops.agencyid = a.id  ";
			$strSql .= " where c.isgiftused = 1 ";
			if($giftLevel != "0")
				$strSql .= " and c.giftlevel = " . (int)$giftLevel;
		
			$data = DBGetDataRowsSimple($strSql);
			echo(json_encode($data));
			break;
		case "GetProvidedDetail"://显示每个优惠券发放明细,20元优惠券20
			$giftLevel = Get("giftLevel");
			$strSql = " select c.giftlevel,c.name,c.mobile,c.nickname,c.gottime  from custinfo c where  c.gotgift=1 ";
			if($giftLevel != "0")
				$strSql .= " and c.giftlevel = " . (int)$giftLevel;
			$data = DBGetDataRows($strSql);
			if($data == null)
				$data = array();
			echo(json_encode($data));
			break;
		case "GetUsedtotal":
			$result = array();
			$strSql = " select giftlevel as level , count(*) as cnt from custinfo where gotgift = 1 and isgiftused = 1 group by giftlevel ";
			$data = DBGetDataRows($strSql);
			$result["usedcount20"] = GetData($data , 20) == null ? 0 : GetData($data , 20)["cnt"];
			$result["usedcount50"] = GetData($data , 50) == null ? 0 : GetData($data , 50)["cnt"];
			$result["usedcount100"] = GetData($data , 100) == null ? 0 : GetData($data , 100)["cnt"];
			$result["usedcount500"] = GetData($data , 500) == null ? 0 : GetData($data , 500)["cnt"];
			$result["usedcount1000"] = GetData($data , 1000) == null ? 0 : GetData($data , 1000)["cnt"];
			echo(json_encode($result));
			break;
		
		} 
	
	function GetData($datas , $k){
		for($i = 0 ; $i < count($datas) ; $i ++){
			if($datas[$i][0] == $k)
				return $datas[$i];
		}
	}
	function GetPageParas(){
		$start = Get("start");
		$length = Get("length");
		$search = Get("search[value]");
		$columns = Get("columns");
		$orders = Get("order");
		$strWhere = "";
//myecho(count($orders));
		if(count($orders) > 0){
			if($orders[0]["column"] != ""){
				$columnName = $columns[$orders[0]["column"]]["data"];
				$orderDir = $orders[0]["dir"];
				$strWhere = "  order by $columnName $orderDir ";
			}
		}
		$strLimit = " limit $start , $length ";
		
		return array("where" => $strWhere , "limit" => $strLimit);
	}
?>