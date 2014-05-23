<?php
/**
 *	短地址转换
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2012-2013
 *	@version	1.0
 *	@package	Ming
 *
 *	$Id$
 */

class MingShortUrl
{
    public static function shortUrl($url)
    {
        $base32 = array(
            'a','b','c','d','e','f','g','h',
            'i','j','k','l','m','n','o','p',
            'q','r','s','t','u','v','w','x',
            'y','z','0','1','2','3','4','5',
        );
        $hex = md5($url);
        $hexLen = strlen($hex);
        $subHexLen = $hexLen / 8;
        $code = array();
        
        for($i = 0; $i < $subHexLen; $i++)
        {
            $subHex = substr($hex, $i * 8, 8);
            $int = 0x3FFFFFFF & (1 * ('0x'.$subHex));
            $subCode = '';
            for($j = 0; $j < 6; $j++)
            {
                $val = 0x0000001F & $int;
                $subCode .= $base32[$val];
                $int = $int >> 5;
            }
            $code[] = $subCode;
        }
        return array_shift($code);
    }
    
    public static function getShurlByCode($code)
    {
        $baseUrl = 'http://shurl.in/';
        return $baseUrl.$code;
    }
    
    /**
     * 通过shurl短地址接口获取短地址
     * @param string $url
     * @return string
     */
	public static function getShurlCode($url)
	{
		$shUrl = "http://shurl.in/api.php";
		$postData = array('url' => $url);
        
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $shUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		$code = curl_exec($ch);
		curl_close($ch);
        
		return $code;
	}
    
    /**
     * 通过新浪短地址接口获取短地址
     * @param string $url
     * @return string 
     */
	public static function getSShortUrl($url)
	{
		$sUrl = "http://api.t.sina.com.cn/short_url/shorten.json?source=3784921135&url_long=$url";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $sUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		$content = curl_exec($ch);
		curl_close($ch);
        
        $short_url = "";
		if(!empty($content))
		{
			$data = json_decode($content, true);
			if(isset($data[0]['url_short']) && !empty($data[0]['url_short']))
			{
				$short_url = $data[0]['url_short'];
			}
		}
		return $short_url;
	}
	
    /**
     * 通过谷歌短地址接口获取短地址
     * @param string $url
     * @return string 
     */
	public static function getGShortUrl($url)
	{
        $prefixUrl = 'http://goo.gl/';
		$gUrl = "http://goo.gl/api/shorten";
		$post_data = array(
            "security_token" => "",
            "url" => $url,
        );
        
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $gUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($ch);
		curl_close($ch);
        
		$result = json_decode($output);
		return $prefixUrl.$result->short_url;
	}
}