<?php
	if(!defined("APPID"))
		define("APPID","wx7fa6fd4b94f47973");
	if(!defined("APPSECRET"))
		define("APPSECRET","bd7ec0f1b39c565d46f4082c27fb6400");
	if(!defined("APPNAME"))
		define("APPNAME","wsestarservice");

	if(!defined("APPID"))
		define("APPID","wxd15f2060944c23ba");
	if(!defined("APPSECRET"))
		define("APPSECRET","743defb56a6a64852961ce1452a1139d");
	if(!defined("APPNAME"))
		define("APPNAME","mzone029service");
	
	if(!defined("DB"))
		define("DB","salesmanagement");
	if(!defined("URL_BASE"))
		define("URL_BASE","http://www.wsestar.com/test/");
	if(!defined("PATH_FUNCTION"))
		define("PATH_FUNCTION","functions.V4.php");
		//define("PATH_FUNCTION","../common/functions.V3.php");
	if(!defined("PATH_DBACCESS"))
		define("PATH_DBACCESS","dbaccess.v5.php");
		//define("PATH_DBACCESS","../common/dbaccess.v5.php");
	if(!defined("CHECK_TIMMING"))
		define("CHECK_TIMMING","10000");
	if(!defined("AJAXPATH"))
		define("AJAXPATH","ajax.php");
	
	if(!defined("DEBUG"))
		define("DEBUG",false);
	
	date_default_timezone_set('Asia/Shanghai');

	include PATH_FUNCTION;
	include PATH_DBACCESS;

	
	$dbms='mysql';     //数据库类型
	$host='localhost'; //数据库主机名
	$dbName='gree201609';    //使用的数据库
	$dbUser='root';      //数据库连接用户名
	$dbPass='lim1hou';          //对应的密码
	//$dbPass='root'; 
	
	function CheckRights($loginName , $loginPassword , $right){
		$managerInfo = DBGetDataRowByField("bgmanager","username",$loginName);
		if($managerInfo == null)
			return -9;
		if($managerInfo["password"] != $loginPassword)
			return -8;
		if($managerInfo["manage".$right] != 1)
			return -7;
		return $managerInfo["id"];
	}
	
	$HISTORY_TYPE = array("Add" => 1 , "Update" => 0 , "Delete" => -1);
	$HISTORY_TYPE_TEXT = array(-1 => "删除" , 0 => "更新" , 1 => "新增");
	
	
?>