<?php
function buildAccessToken()
{
	$r=rand(0, 100000000);
	$md5=md5($r);
	return $md5;
}
function Token_decode($Token)
{
	
	
}
function Token_encode($uname,$upass)
{
	return md5($uname."bistu".$upass);
}