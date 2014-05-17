<?php

class JsonTools
{
    /* 使json_encode不转义中文字符为unicode */
    public static function json_encode_cn($array)
    {
        if(!is_array($array))
            return false;
        return urldecode(json_encode(self::array_cn($array)));
        //php 5.4 支持 JSON_UNESCAPED_UNICODE
        //return json_encode($array, JSON_UNESCAPED_UNICODE)
    }

    private static function array_cn($array) {
        $data = array();
        foreach ($array as $key=>$value) {
            if (is_array($value)) {
                $data[$key] = self::array_cn($value);
            } else if (gettype($value) == 'string') {
                $data[$key] = urlencode($value);
            } else {
                $data[$key] = $value;
            }
        }
        return $data;
    
    }

}

?>
