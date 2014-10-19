<?php

/*
 * 	字符串截取 Class
 * 	author	yanxf <walkfine@gmail.com>
 * 	version	mocube_3.0
 */

class StringTools {

    //字符截取
    public static function cutStr($sourceStr, $cutLength = 10, $extStr = '...') {
        $returnStr = '';
        $i = 0;
        $n = 0;
        $strLength = strlen($sourceStr);
        if ($strLength > $cutLength) {
            while (($n < $cutLength) and ($i <= $strLength)) {
                $tempStr = substr($sourceStr, $i, 1);
                $ascnum = Ord($tempStr);
                if ($ascnum >= 224) {
                    $returnStr = $returnStr . substr($sourceStr, $i, 3);
                    $i = $i + 3;
                    $n++;
                } elseif ($ascnum >= 192) {
                    $returnStr = $returnStr . substr($sourceStr, $i, 2);
                    $i = $i + 2;
                    $n++;
                } elseif ($ascnum >= 65 && $ascnum <= 90) {
                    $returnStr = $returnStr . substr($sourceStr, $i, 1);
                    $i = $i + 1;
                    $n++;
                } else {
                    $returnStr = $returnStr . substr($sourceStr, $i, 1);
                    $i = $i + 1;
                    $n = $n + 0.5;
                }
            }
            if ($strLength > $i) {
                $returnStr = $returnStr . $extStr;
            }
            return $returnStr;
        }
        else
            return $sourceStr;
    }

}