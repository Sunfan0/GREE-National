<?php
	//include_once 'paras.php';

	$DB_FUNCTIONS = array("now" => " DATE_FORMAT(now(), '%Y-%m-%d %H:%i:%s') ");
	if(!defined("DB"))
		define("DB","");
		
	$dbms='mysql';			//数据库类型
	$dbServer='localhost';	//数据库主机名
	$dbName='';				//使用的数据库
	$dbUser='';				//数据库连接用户名
	$dbPass='';				//对应的密码
	$dbh = null;
	
	
	function DBSelectDB($newdb){
		global $db;
		$db = $newdb;
	}
	
	function DBOpen()
	{
		global $dbms , $host , $dbName , $dbh , $dbUser , $dbPass;
		$dsn="$dbms:host=$host;dbname=$dbName;charset=utf8mb4";

		try {
			//$dbh = new PDO($dsn, $dbUser, $dbPass, array(PDO::ATTR_PERSISTENT => true)); //初始化一个PDO对象
			//$dbh = new PDO($dsn, $dbUser, $dbPass, array(PDO::ATTR_PERSISTENT => true,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); //初始化一个PDO对象
			$dbh = new PDO($dsn, $dbUser, $dbPass); //初始化一个PDO对象
			$dbh->exec("set names utf8mb4");
			//$dbh->exec("SET time_zone='Asia/Shanghai';");
			$dbh->exec("SET time_zone='+8:00';");
			
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			die ("Error!: " . $e->getMessage() . "<br/>");
		}

		return $dbh;
	}

	function DBClose($con){
		global $dbh;
		$dbh = null;
	}

	function DBBeginTrans(){
		global $dbh;
		if($dbh == null)
			DBOpen();
		$dbh->beginTransaction();
	}
	function DBCommitTrans(){
		global $dbh;
		$dbh->commit();
	}
	function DBRollbackTrans(){
		global $dbh;
		$dbh->rollBack();
	}

	function DBQuery($strSql){
		global $dbh;
		if($dbh == null)
			DBOpen();
		
		$result = $dbh->query($strSql);
		if(!$result){
			return null;
		}

		if($result->rowCount() == 0)
			return null;
		
		return $result;
	}
	
	 
	function DBGetDataRowsSimple($strSql){
		return DBGetDataRows($strSql , PDO::FETCH_ASSOC);
	}
	
	function DBGetDataRows($strSql , $option = null){
		$result = DBQuery($strSql);
		if($result == null)
			return null;
		
		if($option == null)
			$resultarr = $result->fetchAll();
		else
			$resultarr = $result->fetchAll(PDO::FETCH_ASSOC);
		
		return $resultarr;
	}
	function DBGetDataRow($strSql){
		$result = DBQuery($strSql);
		if($result == null)
			return null;
		
		return $resultarr = $result->fetch();
	}

	function DBGetDataRowByField($tableName , $strField , $strValue , $orderBy = null , $limit = null){
		global $dbh;
		if($dbh == null)
			DBOpen();

		$strWhere = DBPrepareWhere($strField , $strValue);
		$strSql = "Select * From $tableName Where $strWhere ";
		if($orderBy != null)
			$strSql .= " " . $orderBy . " ";
		if($limit != null)
			$strSql .= " " . $limit . " ";
		
		if(!is_array($strValue))
			$strValue = array($strValue);
		$sth = $dbh->prepare($strSql);
		$sth->execute($strValue);
//myecho($strSql);
		return $sth->fetch();
	}
	function DBGetDataRowsByField($tableName , $strField , $strValue , $orderBy = null , $limit = null){
		global $dbh;
		if($dbh == null)
			DBOpen();

		$strWhere = DBPrepareWhere($strField , $strValue);
		$strSql = "Select * From $tableName Where $strWhere ";
		if($orderBy != null)
			$strSql .= " " . $orderBy . " ";
		if($limit != null)
			$strSql .= " " . $limit . " ";
		
		if(!is_array($strValue))
			$strValue = array($strValue);
		$sth = $dbh->prepare($strSql);
		$sth->execute($strValue);
//myecho($strSql);
		return $sth->fetchAll();
	}


	function DBQueryPrepare($strSql , $arrParas){
		global $dbh;
		if($dbh == null)
			DBOpen();
//myecho($dbh);
		$result = $dbh->execute($strSql , $arrParas);
		if(!$result){
			return null;
		}

		if($result->rowCount() == 0)
			return null;
		
		return $result;
	}
	function DBGetDataRowsSimplePrepare($strSql , $arrParas){
		return DBGetDataRows($strSql , PDO::FETCH_ASSOC);
	}
	function DBGetDataRowsPrepare($strSql , $arrParas , $option = null){
		$result = DBQuery($strSql);
		if($result == null)
			return null;
		
		if($option == null)
			$resultarr = $result->fetchAll();
		else
			$resultarr = $result->fetchAll(PDO::FETCH_ASSOC);
		
		return $resultarr;
	}
	function DBGetDataRowPrepare($strSql , $arrParas){
		$result = DBQuery($strSql , $arrParas);
		if($result == null)
			return null;
		
		return $resultarr = $result->fetch();
	}
	function DBGetDataRowByFieldForUpdate($tableName , $strField , $strValue){
		global $dbh;
		if($dbh == null)
			DBOpen();

		$strWhere = DBPrepareWhere($strField , $strValue);
		$strSql = "Select * From $tableName Where $strWhere for update";
		if(!is_array($strValue))
			$strValue = array($strValue);

		$sth = $dbh->prepare($strSql);
		$sth->execute($strValue);
		return $sth->fetch();
	}	
	
	
	
	
	function DBExecute($strSql)
	{
		global $dbh;
		if($dbh == null)
			DBOpen();

		$result = $dbh->exec($strSql);
		if($result === false)
			return false;
		else
			return true;
	}
	function DBExecuteInsert($strSql)
	{
		global $dbh;
		if($dbh == null)
			DBOpen();

		$result = $dbh->exec($strSql);
		if($result === false)
			return false;
		else
			return $dbb->lastInsertId ;
	}
	function DBBuildInsertTableField($tableName , $strField , &$strValue){
		global $DB_FUNCTIONS;
		$strFieldString = "";
		$strValueString = "";
		$arrResValues = array();

		if(is_array($strField)){
			for($i=count($strField)-1;$i>=0;$i--){
				if($i < count($strField)-1){
					$strFieldString .=" , ";
					$strValueString .=" , ";
				}

				$strFieldString .= $strField[$i];
				if(in_array($strValue[$i] , $DB_FUNCTIONS , true)){
					$strValueString .= $strValue[$i];
				} else {
					$strValueString .= "?";
					$arrResValues[] = $strValue[$i];
				}
			}
		}  else {
			$strFieldString .= $strField;
			$strValueString .= "?";
		}
		
		$strFieldString .= " , createtime , lastmodifytime";
		$strValueString .= " , DATE_FORMAT(now(), '%Y-%m-%d %H:%i:%s') , DATE_FORMAT(now(), '%Y-%m-%d %H:%i:%s') ";

		$strSql = "Insert $tableName ( $strFieldString ) Values ( $strValueString ) ";
		$strValue = $arrResValues;
		return $strSql;
	}
	
	
	function DBInsertTableField($tableName , $strField , $strValue){
		global $dbh;
		if($dbh == null)
			DBOpen();


		$strSql = DBBuildInsertTableField($tableName, $strField, $strValue);

		if(!is_array($strValue))
			$strValue = array($strValue);
 //$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sth = $dbh->prepare($strSql);
//error_log($strSql);
//error_log(var_export($strValue, true));
		$result = $sth->execute($strValue);

		//$result = $dbh->exec($strSql);
//error_log(var_export($result, true));
		if($result === false)
			return false;
		else
			return $dbh->lastInsertId() ;
	}
	
	function DBExecuteUpdate($strSql){
		global $dbh;
		if($dbh == null)
			DBOpen();

		$result = $dbh->exec($strSql);
		if($result === false)
			return false;
		else
			return true;
	}
	function DBUpdateField($tableName , $id , $arrFields , $arrValues){
		global $dbh , $DB_FUNCTIONS;
		if($dbh == null)
			DBOpen();

		$strFieldValues = "";
		$strWhere = " Where id = ? ";
		$arrResValues = array();

		if(is_array($arrFields)){
			for($i=0;$i<count($arrFields);$i++){
				if($i > 0)
					$strFieldValues .=" , ";

				//$strFieldValues .= $arrFields[$i];
				if(in_array($arrValues[$i] , $DB_FUNCTIONS , true)){
					$strFieldValues .= $arrFields[$i] . " = " . $arrValues[$i];
				} else {
					$strFieldValues .= $arrFields[$i] . " = ? ";
					$arrResValues[] = $arrValues[$i];
				}
				
			}
			$arrResValues[] = $id;
		}  else {
			$strFieldValues = $arrFields . " = ? ";
			$arrResValues = array($arrValues , $id);
		}
		$strFieldValues .= " , lastmodifytime = now() ";
		$strSql = "Update $tableName Set $strFieldValues " . $strWhere;
		
		$sth = $dbh->prepare($strSql);
		$result = $sth->execute($arrResValues);
//echo $strSql;
		return $result;
		//return DBExecuteUpdate($strSql);
	}
////////
////////
////////
	function DBGetRows($tableName , $strWhere){
		$strSql = "Select * From " . $tableName . " Where " . $strWhere;
		return DBGetDataRows($strSql);
	}

	function DBDeleteData($tableName , $id){
		global $dbh;
		if($dbh == null)
			DBOpen();

		$strSql = "Delete from $tableName Where id = ? ";

		$sth = $dbh->prepare($strSql);
		$result = $sth->execute(array($id));

		return $result;
	}

	function DBIsFunction($value){
		Global $DB_FUNCTIONS;
		if(in_array($value, $DB_FUNCTIONS))
			return true;
		else
			return false;
	}

	function DBPrepareWhere($strField , $strValue){
		$strWhere = "";
		if($strField == null)
			return $strWhere;

		if(is_array($strField)){
			if(count($strField) != count($strValue))
				return null;
			
			for($i=0;$i<count($strField);$i++){
				$strWhere .= sprintf(" %s = ? " , $strField[$i]);
				if($i < count($strField) - 1)
					$strWhere .= " And ";
			}
		}  else {
			$strWhere = sprintf(" %s = ? " , $strField);
		}
		
		return $strWhere;
	}
	
	
	

	
	
	
?>