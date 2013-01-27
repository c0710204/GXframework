<?php
//GLOSET
date_default_timezone_set("Asia/Shanghai");


//build-mode-set
//$cfg['build']="mobile";
$cfg['build']="local";

include $_SERVER['DOCUMENT_ROOT'].__CFG_document_place__."/settings/".$cfg['build'].".php";

?>

