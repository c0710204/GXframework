<?php
/*
if (!(file_exists($_SERVER['DOCUMENT_ROOT'].'/album/'.date('Ymd'))))
{
	mkdir($_SERVER['DOCUMENT_ROOT'].'/album/'.date('Ymd'));
}
$cfg['file']['pic']['album_dir']='/album/'.date('Ymd').'/'.date('His').rand(0, 10000);
if (!(file_exists($_SERVER['DOCUMENT_ROOT'].'/video/'.date('Ymd'))))
{
	mkdir($_SERVER['DOCUMENT_ROOT'].'/video/'.date('Ymd'));
}
$cfg['file']['pic']['video_dir']='/video/'.date('Ymd').'/'.date('His').rand(0, 10000);
if (!(file_exists($_SERVER['DOCUMENT_ROOT'].'/errorlog/'.date('Ymd'))))
{
	mkdir($_SERVER['DOCUMENT_ROOT'].'/errorlog/'.date('Ymd'));
}

$cfg['file']['log']['errorlog']='/errorlog/'.date('Ymd').'/'.date('His').rand(0, 10000);*/
$cfg['file']['log']['sqllog']='/log/sql.txt';
$cfg['file']['log']['apilog']='/log/api.txt';
$cfg['file']['log']['memberlog']='/log/member.txt';