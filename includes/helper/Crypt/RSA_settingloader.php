<?php 
include($_SERVER['DOCUMENT_ROOT'].'/api'.'/includes/helper/Crypt/rsa.php');

$rsa = new Crypt_RSA();
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/api'.'/settings/RSA.json'))
{
	$str=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api'.'/settings/RSA.json');
	$rsa_data=json_decode($str);
}

//echo  $rsa->getPrivateKey();
//var_dump($rsa_data);
	$now=time();
	
	if (!(isset($rsa_data)))
	{
		$rsa_data->timeout=1;
		$rsa_data->lastUpdata=$now;
		extract($rsa->createKey(1024,3600));
		$rsa_data->privatekey=$privatekey;
		$rsa_data->publickey=$publickey;
	}
	else
	{
		
		$RSA_timeout=$rsa_data->timeout;
		$RSA_lastUpdata=$rsa_data->lastUpdata;
		$time=$now-$RSA_lastUpdata;
		if ($time>$RSA_timeout)
		{
			$rsa_data->lastUpdata=time();
			extract($rsa->createKey(1024,3600));
			$rsa_data->privatekey=$privatekey;
			$rsa_data->publickey=$publickey;		
		}
		else 
		{
			
			$privatekey=$rsa_data->privatekey;
			$publickey=$rsa_data->publickey;
		}
	}
	
	$json=json_encode($rsa_data);
	if (file_exists($_SERVER['DOCUMENT_ROOT'].'/api'.'/settings/RSA.json'))unlink($_SERVER['DOCUMENT_ROOT'].'/api'.'/settings/RSA.json');
	$f=fopen($_SERVER['DOCUMENT_ROOT'].'/api'.'/settings/RSA.json', 'w+');
	fwrite($f, $json);
	fclose($f);
	//