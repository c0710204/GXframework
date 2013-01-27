<?php
	include $_SERVER['DOCUMENT_ROOT'].__CFG_document_place__.'/settings/setting.php';
	if (!isset($database_host)) $link_database_host=$cfg["database_host"];
	else $link_database_host=$database_host;
	if (!isset($database_user)) $link_database_user=$cfg["database_user"];
	else $link_database_user=$database_user;
	if (!isset($database_pass)) $link_database_pass=$cfg["database_pass"];
	else $link_database_pass=$database_pass;
	if (!isset($database_dbname)) $link_database_dbname=$cfg["database_dbname"];
	else $link_database_dbname=$database_dbname;
	if (!isset($database_port)) $link_database_port=$cfg["database_port"];
	else $link_database_port=$database_port;
	$dblink = mysql_connect($link_database_host.":".$link_database_port,$link_database_user,$link_database_pass);
	$err=$dblink.mysql_errno();
	$errstr=$dblink.mysql_error();
	if ($err!=0)
	{
		$str= "<br/>MYSQL Connecting Fail ,Code=".$err.",string=$errstr<br/>";
		$l->writelog($str,'sql-ERROR');
		mysql_close($dblink);
		return -10001;
	}
	mysql_set_charset('utf8');
	$q=mysql_select_db($link_database_dbname,$dblink);
	$err=$dblink.mysql_errno();
	$errstr=$dblink.mysql_error();
	if($err!=0)
	{
		$str= "<br/>MYSQL Select databas Fail ,Code=".$err.",string=$errstr<br/>";
		$l->writelog($str,'sql-ERROR');
		mysql_close($dblink);
		return -10002;	
	}
?>
