<?php
/**
 *	类库-客户端类
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2012-2013
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

class MingClient {

    /**
     * 判断是否为IE浏览器
     * @return bool
     */
    public static function is_ie() {
        $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if((strpos($useragent, 'opera') !== false) || (strpos($useragent, 'konqueror') !== false)) return false;
        if(strpos($useragent, 'msie ') !== false) return true;
        return false;
    }
    
    /**
     * 获取访问者IP
     * @return string
     */
    public static function ip($truth = false) {
        if($truth == false){
            $ips = array(
                '182.148.123.6',
                '182.131.123.4',
                '182.148.131.6',
                '183.145.13.10',
                '182.158.123.6',
                '182.148.123.5',
            );
            return $ips[array_rand($ips)];
        }else{
            if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
                $ip = getenv('HTTP_CLIENT_IP');
            } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
                $ip = getenv('REMOTE_ADDR');
            } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            $matches = array();
            return preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : 'unknown';
        }
    }
    
    public static function url() {
        $scheme = $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $script_name = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : preg_replace("/(.*)\.php(.*)/i", "\\1.php", $_SERVER['PHP_SELF']);
        $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 
            $script_name.($_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : $_SERVER['PATH_INFO']);
        return $scheme.$_SERVER['HTTP_HOST'].$relate_url;
    }
    
    public static function referer() {
        return $_SERVER['HTTP_REFERER'];
    }
}