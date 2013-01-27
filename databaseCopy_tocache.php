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
	//$sql1->query('TRUNCATE '.$TABLE);
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
	$json=json_encode($ans);	
	$cachestat=file_exists("cache/$TABLE".'_'.$MODE."$ACTION.json");
	if ($cachestat)unlink("cache/$TABLE".'_'.$MODE."$ACTION.json");
	$f=fopen("cache/$TABLE".'_'.$MODE."$ACTION.json", 'w+');
	fwrite($f, $json);
	fclose($f);
	echo filesize("cache/$TABLE".'_'.$MODE."$ACTION.json");
?>