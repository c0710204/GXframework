<?php
	include "settings/setting.php";
	include "includes/database/sql.php";
	$GET=$_GET;
	$POST=$_POST;
	$TABLE=$GET['table'];
	$sql1=new SQL();
	$flag=0;
	include "includes/api/action_moduleupdate.php";
	$statue=new moduleupdate();
	//$data["moduleId"]=$cfg["moduleList"][$TABLE];
	//$ans=$statue->sql_getUpadtaStatue($sql1, $data);
	if ((!(isset($GET['noclear'])))||(!($GET['noclear']))) $sql1->query('TRUNCATE '.$TABLE);
	include "includes/api/action_$TABLE.php";
	$actionspace=new $TABLE();
	if (!(isset($GET['action']))) $GET['action']=substr($actionspace->default_action,3);
	//echo $GET['action'];
	if (isset($GET['action']))
	{
		$ACTION=$GET['action'];
	}
	else
	{
		$ACTION=$TABLE;
	}
	$MODE='get';
	$callback = isset($_GET['callback']) ? $_GET['callback'] : '';
	$sql1=new SQL();
	$sql1->debug_only_in_error=true;
	$sql1->table=$TABLE;
	
	$ACTION1="sql_".$MODE.$ACTION.'_school';
	$data=$GET;
//	$sql1->debug=true;
	if (isset($_GET['callback']))unset($data['callback']);
	unset($data['table']);
	unset($data['action']);
	unset($data['_']);
	unset($data['MODE']);
	
	$ans=$actionspace->$ACTION1($sql1,$data);
	$MODE='set';
	$ACTION="sql_".$MODE.$ACTION;
	$data=$ans;
	if ((isset($_GET['DataLimitStart'])) &&  (isset($_GET['DataLimitLength'])))
	{
		$data=array_slice($ans, $_GET['DataLimitStart'],$_GET['DataLimitLength']);
	}
	elseif (!(isset($_GET['DataLimitStart'])) &&  (isset($_GET['DataLimitLength'])))
	{
		$data=array_slice($ans, 0,$_GET['DataLimitLength']);
	}
	
	else $data=$ans;
//	echo count($data);
//	var_dump($data);
	$ans1=$actionspace->$ACTION($sql1,$data);
	echo $ans1;
	
?>