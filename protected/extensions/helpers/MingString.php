<?php
/**
 *	字符串类
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2012-2013
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

class MingString {

    /**
     * 格式化输出
     * @param  string|array|object $var
     * @param  bool $isexit
     * @return void
     */
    public static function prints($var, $isexit = false) {
        $var = empty($var) ? 'NULL' : $var;
        if(is_array($var)) {
            echo '<pre>';
            print_r($var);
            echo '</pre>';
        } elseif(is_string($var)) {
            echo $var.'<br>';
        } else {
            echo '<pre>';
            var_dump($var);
        }
        if($isexit) exit;
    }
    
    public static function cmdPrints($var, $isexit = false) {
        if(is_string($var)) {
            echo $var."\n";
        } else {
            var_dump($var);
            echo "\n";
        }
        if($isexit) exit;
    }

    /**
     * 转义
     * @param  string|array $var
     * @return string|array
     */
    public static function new_addslashes($var) {
        if(is_string($var)) {
			//去除字符串两端的空字符
			$var = trim($var);
            $var = addslashes($var);
        } elseif(is_array($var)) {
            foreach($var as $k => $v) {
                $var[$k] = self::new_addslashes($v);
            }
        }
        return $var;
    }

    /**
     * 反转义
     * @param  string|array $var
     * @return string|array
     */
    public static function new_stripslashes($var) {
        if(is_string($var)) {
            $var = stripslashes($var);
        } elseif(is_array($var)) {
            foreach($var as $k => $v) {
                $var[$k] = self::new_stripslashes($v);
            }
        }
        return $var;
    }

    /**
     * 字符串转化为数组
     * @param  string $string
     * @return array
     */
    public static function str2arr($string) {
        $return = array();
        $string = urldecode($string);
        $tempArray = explode('||', $string);
        $nullValue = urlencode(base64_encode("^^^"));
        foreach ($tempArray as $tempValue) {
            list($key,$value) = explode('|', $tempValue);
            $decodedKey = base64_decode(urldecode($key));
            if($value != $nullValue) {
                $returnValue = base64_decode(urldecode($value));
                if(substr($returnValue, 0, 8) == '^^array^')
                    $returnValue = Ming_String::str2arr(substr($returnValue, 8));
                $return[$decodedKey] = $returnValue;
            }else{
            	$return[$decodedKey] = null;
            }
        }
        return $return;
    }

    /**
     * 数组转化为字符串
     * @param  array $array
     * @param  bool  $isform 是否为页面GET/POST数据
     * @return string
     */
    public static function arr2str($array) {
        $return = '';
        $nullValue="^^^";
        foreach ($array as $key => $value) {
            if(is_array($value))
                $returnValue = '^^array^'.Ming_String::arr2str($value);
            else
                $returnValue = (strlen($value) > 0) ? $value : $nullValue;
            $return .= urlencode(base64_encode($key)) . '|' . urlencode(base64_encode($returnValue)) . '||';
        }
        return urlencode(substr($return, 0, -2));
    }

    /**
	 * 字符编码转换
	 *
	 * @param string $charset_in	输入字符编码
	 * @param string $charset_out	输出字符编码
	 */
	public static function changeCode($str, $charset_in = 'gb2312', $charset_out = 'utf-8'){
		if ( function_exists('mb_convert_encoding')) {
			$str = mb_convert_encoding($str, $charset_out, $charset_in);
		}else {
			$str = iconv($charset_in, $charset_out, $str);
		}

		return $str;
	}

	/**
	 * 数组转换为等式字符串
	 *
	 * @param array $array
	 * @return string
	 */
	public static function arr2equation($array){
		if(empty($array) || !is_array($array)) return false;
		$equation = '';
		foreach ($array as $key => $value) {
			$equation .= $key . '=' . $value . ',';
		}

		return $equation;
	}

    /**
     * Unicode编码转换
     * @param <string> $string
     * @return <string>
     */
    public static function unicodeDecode($string)
    {
        $pattern = '/(\\\\u([\w]{4}))/i';
        $matches = array();
        preg_match_all($pattern, $string, $matches);
        if(!empty($matches))
        {
            for($i = 0; $i < count($matches[0]); $i++)
            {
                $str = $matches[0][$i];
                if(strpos($str, '\\u') === 0)
                {
                    $code = base_convert(substr($str, 2, 2), 16, 10);
                    $code2 = base_convert(substr($str, 4), 16, 10);
                    $str = chr($code).chr($code2);
                    $str = mb_convert_encoding($str, 'UTF-8', 'UCS-2');
                }
                $string = str_replace($matches[0][$i], $str, $string);
            }
        }
        return $string;
    }

    /**
     * 文字标题缩略显示
     * @author zham, 20080105
     *
     * @param string $string
     * @param integer $limit
     * @param string $ext_str
     * @return string
     */
    public static function str_cut($string, $limit=10, $ext_str=".."){
        $string = trim($string);
        if(self::get_real_len($string, "UTF-8") > $limit){
            return self::get_real_sub($string, $limit, "UTF-8").$ext_str;
        }else{
            return $string;
        }
    }

    /**
     * 获得字符串的真实长度
     * @author zham, 20080105
     *
     * @param string $str
     * @param string $charset
     * @return integer
     */
    public static function get_real_len($str, $charset="UTF-8")
    {
        if (!$str) return 0;
        $len = 0;
        $cnt = mb_strlen($str, $charset);
        for ($i = 0; $i < $cnt; $i++) {
            $char = mb_substr($str, $i, 1, $charset);
            if (ord($char) < 128) {
                $len += 1;
            } else {
                $len += 2;
            }
        }
        return $len;
    }

    /**
     * 获得截取指定长度的子字符串
     * @author zham, 20080105
     *
     * @param string $str
     * @param integer $limit
     * @param string $charset
     * @return string
     */
    public static function get_real_sub($str, $limit, $charset="UTF-8")
    {
        if (!$str) return 0;
        $sub = "";
        $len = 0; $i = 0;
        do {
            $char = mb_substr($str, $i, 1, $charset);
            $sub .= $char;
            if (ord($char) < 128) {
                $len += 1;
            } else {
                $len += 2;
            }
            $i++;
        } while ($len < $limit);
        return $sub;
    }
    
    /**
     * 截取字符串
     * @param string $sourceStr
     * @param integer $cutLength
     * @param string $extStr
     * @return string 
     */
    public static function cutStr($sourceStr, $cutLength = 10, $extStr = '..'){
		$returnStr = ''; $i = 0; $n = 0;
		$strLength = strlen($sourceStr);
		if ($strLength > $cutLength){
			while (($n < $cutLength) and ($i <= $strLength)){
				$tempStr = substr($sourceStr, $i, 1);
				$ascnum = Ord($tempStr);
				if ($ascnum >= 224){
					$returnStr = $returnStr . substr($sourceStr, $i, 3);
					$i = $i+3;
					$n++;
				}elseif ($ascnum >= 192){ 
					$returnStr=$returnStr.substr($sourceStr,$i,2);
					$i=$i+2;
					$n++;
				}elseif ($ascnum >= 65 && $ascnum <= 90){
					$returnStr = $returnStr.substr($sourceStr, $i, 1);
					$i = $i+1;
					$n++;
				}else{ 
					$returnStr = $returnStr.substr($sourceStr, $i, 1);
					$i = $i+1;
					$n = $n+0.5;
				}
			}
			if ($strLength > $i)
				$returnStr = $returnStr.$extStr;
			return $returnStr;
		}
		else
			return $sourceStr;
	}
    
    /**
     * 对象转化为数据
     * @param object $obj
     * @return array 
     */
    public static function obj2arr($obj)
    {
        $array = is_object($obj) ? get_object_vars($obj) : $obj;
        foreach($array as $k => $v)
        {
            $v = is_object($v) || is_array($v) ? self::obj2arr($v) : $v;
            $array[$k] = $v;
        }
        return $array;
    }
    
    /**
     * 数组转化为json
     * @param array $var
     * @return string 
     */
    public static function arr2json($var)
    {
        if(empty($var) || !is_array($var)) return $var;
        foreach($var as $k => $v)
            if(is_string($v)) $var[$k] = urlencode($v);
        return urldecode(json_encode($var));
    }
    
    /**
     * json转化为数据
     * @param string $var
     * @return array 
     */
    public static function json2arr($var)
    {
        return json_decode(strip_tags($var), true);
    }
    
    /**
     * 判断远程文件是否存在
     * @param string $remote
     * @return boolean 
     */
    public static function remote_file_exists($remote)
    {
        return @file_get_contents($remote, false, null, -1, 1);
    }

    /**
     * 判断两个时间是否同一天
     * @param integer $first 时间戳
     * @param integer $second 时间戳
     * @return boolean 
     */
    public static function sameDay($first, $second)
    {
        date_default_timezone_set('Asia/Chongqing');
        $firstD = date('Y-m-d', $first);
        $secondD = date('Y-m-d', $second);
        return $firstD == $secondD;
    }
}