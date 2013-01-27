<?php
include "settings/setting.php";
include_once "includes/database/sql.php";
$sql1=new SQL();
$sql1->query('select count(*) from '.$_GET['table']);