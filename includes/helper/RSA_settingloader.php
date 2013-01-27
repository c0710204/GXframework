<?php 

//__CFG_document_place__='';
include_once  $_SERVER['DOCUMENT_ROOT'].__CFG_document_place__.'/settings/setting.php';
//include($_SERVER['DOCUMENT_ROOT'].__CFG_document_place__.'/includes/helper/Crypt/RSA.php');
//include($_SERVER['DOCUMENT_ROOT'].__CFG_document_place__.'/includes/helper/Crypt/RSA.php');

//$rsa = new Rsa($_SERVER['DOCUMENT_ROOT'].__CFG_document_place__.'/settings');
//$rsa = new Crypt_RSA();

function makekey()
{
	
	include_once($_SERVER['DOCUMENT_ROOT'].__CFG_document_place__.'/includes/helper/Crypt/RSA.php');
	$rsa = new Crypt_RSA();
	$rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_RAW);
	$key = $rsa->createKey(512);
	$e =new Math_BigInteger($key['publickey']['e'], 10);
	$n = new Math_BigInteger($key['publickey']['n'], 10);
//	echo $n->toHex();
//	echo "\n<br>\n";
//	echo $e->toHex();
	$keyinfo['publickey']=$n->toHex();
	$keyinfo['e']=$e->toHex();
	$keyinfo['privatekey']=$key['privatekey'];
	return $keyinfo;
}

include $_SERVER['DOCUMENT_ROOT'].__CFG_document_place__.'/settings/secfile.php';
$js_keypath=$cfg['secfile']['js_key'];
if(file_exists($js_keypath))
{

	$str=file_get_contents($js_keypath);
	$rsa_data=json_decode($str);
}

	static $e=17;

	$now=time();
	
	if (!(isset($rsa_data)))
	//	if (true)
	{
		$rsa_data->timeout=3600*24;
		$rsa_data->lastUpdata=$now;
		//$rsa->createKey();
		$key=makekey();
//		$privatekey=$rsa->getprivatekey();
//		$publickey=$rsa->getpublickey();
		$rsa_data->privatekey=$key['privatekey'];
		$rsa_data->publickey=($key['publickey']);
		$privatekey=$rsa_data->privatekey;
		$publickey=$rsa_data->publickey;
	//	var_dump($rsa_data);
	}
	else
	{
		
		$RSA_timeout=$rsa_data->timeout;
		$RSA_lastUpdata=$rsa_data->lastUpdata;
		$time=$now-$RSA_lastUpdata;
		if ($time>$RSA_timeout)
		{
			$rsa_data->lastUpdata=time();
			$key=makekey();
			//$rsa->createKey();
//			$privatekey=$rsa->getprivatekey();
//			$publickey=$rsa->getpublickey();
			$rsa_data->privatekey=$key['privatekey'];
			$rsa_data->publickey=($key['publickey']);
			$privatekey=$rsa_data->privatekey;
			$publickey=$rsa_data->publickey;
	//	var_dump($rsa_data);
		}
		else 
		{
			
			$privatekey=$rsa_data->privatekey;
			$publickey=$rsa_data->publickey;
		//	var_dump($rsa_data);
		}
	}
	
	$json=json_encode($rsa_data);
	if (file_exists($js_keypath))unlink($js_keypath);
	$f=fopen($js_keypath, 'w+');
	fwrite($f, $json);
	fclose($f);
	//
	
	
	
/*
 * 
include_once($_SERVER['DOCUMENT_ROOT'].__CFG_document_place__.'/includes/helper/Crypt/RSA.php');
$rsa = new Crypt_RSA();
$rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_RAW);
$key = $rsa->createKey(512);
echo $key['privatekey'];
echo '  ';
$e = new Math_BigInteger($key['publickey']['e'], 10);
$n = new Math_BigInteger($key['publickey']['n'], 10);
echo $e->toHex();
echo '  ';

echo $n->toHex();

 * */
 