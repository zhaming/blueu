<?php
/**
 *	类库-加密类
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2012-2013
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

class MingCrypt {

	private static $publicKey = 'ming';
	private static $originalKey = 'a*=ee2mv@476=Vx/';
	private static $newKey;
    private static $authKey = 'zhaming';

	public static function encrypt($text)
	{
		if(empty($text) || !is_string($text)) return false;
		$newKey = self::getNewKey();
		$rijndael = new Rijndael(CRYPT_RIJNDAEL_MODE_ECB);
		$rijndael->setKey($newKey);
		$cryptText = $rijndael->encrypt($text);
		return base64_encode($cryptText);
	}

	public static function decrypt($text)
	{
		if(empty($text) || !is_string($text)) return false;
		$text = base64_decode($text);
		$newKey = self::getNewKey();
		$rijndael = new Rijndael(CRYPT_RIJNDAEL_MODE_ECB);
		$rijndael->setKey($newKey);
		return $rijndael->decrypt($text);
	}

	public static function getNewKey()
	{
		if(empty(self::$newKey))
			self::$newKey = self::encryptKey(self::$originalKey, self::$publicKey);
		return self::$newKey;
	}

	public static function encryptKey($str, $key)
	{
		$key = md5($key);
		$code = self::makeCode();
		//$time = microtime();
		//$times = explode(" ", $time);
		//$str = $times[0] . $str . $times[1];
		$tmp = "";
		$total_key = strlen($key);
		for ($i = 0; $i < strlen($str); $i++)
		{
			$tmp_str = substr($str, $i, 1); //截取一个字符
			$key_code = ord($key[$i % $total_key]); //获得一个私钥里的字符的asc码
			$tmp_code = ord($tmp_str); //获得该字符的asc码
			$k = $code[($key_code + $tmp_code) % sizeof($code)]; //将两个asc码相乘，再取一个码表里的字符串
			$int = $code[intval(($key_code + $tmp_code) / sizeof($code))];
			$tmp .= chr($int) . chr($k);
		}
		return $tmp;
	}

	public static function decryptKey($str, $key)
	{
		$str = utf8_decode($str);
		$key = md5($key);
		$code = self::makeCode();
		$tmp = "";
		$total_key = strlen($key);
		$j = 0;
		for($i = 0; $i < strlen($str); $i = $i + 2)
		{
			$int = ord(substr($str, $i, 1));
			$tmp_str = ord(substr($str, $i + 1, 1));
			$key_code = ord($key[$j % $total_key]); //获得一个私钥里的字符的asc码
			$int = array_search($int, $code);
			$k = array_search($tmp_str, $code);
			$total = $int * sizeof($code) + $k;
			$needle = $total - $key_code;
			$tmp .= chr($needle);
			$j++;
		}
		//$str = substr($tmp,10,-10);
		return $tmp;
	}

	private static function makeCode()
	{
		$code = array();
		$key = 0;
		for ($i=ord('0');$i<=ord('9');$i++)
		{
			$code[$key] = $i;
			$key++;
		}
		for ($i=ord('A');$i<=ord('Z');$i++)
		{
			$code[$key] = $i;
			$key++;
		}
		for ($i=ord('a');$i<=ord('z');$i++)
		{
			$code[$key] = $i;
			$key++;
		}
		return $code;
	}
    
    public static function authCrypt($text, $opt = 'ENCODE')
    {
        $text = $opt == 'ENCODE' ? $text : base64_decode($text);
        $len = strlen(self::$authKey);
        $code = '';
        for($i = 0; $i < strlen($text); $i++)
        {
            $k = $i % $len;
            $code .= $text[$i] ^ self::$authKey[$k];
        }
        $code = $opt == 'DECODE' ? $code : base64_encode($code);
        return $code;
    }
}