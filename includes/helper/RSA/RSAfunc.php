<?php
function publickey_encodeing($sourcestr, $fileName)
{
	$key_content = file_get_contents($fileName);
	$pubkeyid    = openssl_get_publickey($key_content);
	if (openssl_public_encrypt($sourcestr, $crypttext, $pubkeyid))
	{
		return base64_encode("" . $crypttext);
	}
	return False;
}
function privatekey_decodeing($crypttext, $fileName,$fromjs = FALSE)
{
	$key_content = file_get_contents($fileName);
	$prikeyid    = openssl_get_privatekey($key_content);
	$crypttext   = base64_decode($crypttext);
	$padding = $fromjs ? OPENSSL_NO_PADDING : OPENSSL_PKCS1_PADDING;
	if (openssl_private_decrypt($crypttext, $sourcestr, $prikeyid, $padding))
	{
		return $fromjs ? rtrim(strrev($sourcestr), "/0") : "".$sourcestr;
	}
	return FALSE;
}
?>