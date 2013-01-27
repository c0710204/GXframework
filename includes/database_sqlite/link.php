<?php
include $_SERVER['DOCUMENT_ROOT'] . __CFG_document_place__ . '/settings/setting.php';
if (!isset($database_host)) $link_database_host = $cfg["database_host"];
else $link_database_host = $database_host;
if (!isset($database_user)) $link_database_user = $cfg["database_user"];
else $link_database_user = $database_user;
if (!isset($database_pass)) $link_database_pass = $cfg["database_pass"];
else $link_database_pass = $database_pass;
if (!isset($database_dbname)) $link_database_dbname = $cfg["database_dbname"];
else $link_database_dbname = $database_dbname;
if (!isset($database_port)) $link_database_port = $cfg["database_port"];
else $link_database_port = $database_port; 
try {
	
	$dblink = new PDO ('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . __CFG_document_place__ . $cfg["database_dbroot"] .'/'. $link_database_dbname.'.db3');
	$dblink->exec("set names 'utf8'");
	$dblink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} 
catch (PDOException $e) {
	$err = $e -> getCode();
	$errstr = $e -> getMessage();
	if ($err != 0) {
		$str = "<br/>SQLite Connecting Fail ,Code=" . $err . ",string=$errstr<br/>";
		$l -> writelog($str, 'sql-ERROR');
		$dblink = 0;
		return -10001;
	} 
} 

?>