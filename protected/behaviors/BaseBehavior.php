<?php

/*
 * 业务基类
 */

/**
 * 2014-5-19 11:16:15 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * BaseBehavior.php hugb
 *
 */
class BaseBehavior {

    public $errcode;
    public $error;

    public function errorLog($error) {
        if (empty($this->error))
            $this->error = $error;
        else
            $this->error = $this->errormsg . '|' . $error;
    }

    public function htmtocode($content) {
        $content = str_replace("\n", "<br>", str_replace(" ", "&nbsp;", $content));
        return $content;
    }

    public function sql_ck($content) {
        $check = eregi('select|insert|update|delete|\`|\'|\/\*|\.\.\/|\.\/|union|into|load_file|outfile', $content);
        if ($check) {
            $log = fopen("../log/check_" . date("Ym") . ".log", "ab");
            $log_content = date("Y-m-d G:i:s") . "  " . getenv('remote_addr') . "  " . $content . "  " . $_SERVER["REQUEST_URI"] . "\r\n";
            fwrite($log, $log_content);
            fclose($log);
            $log = fopen("../log/check_" . date("Ym") . ".log", "rb");
            $logs = fread($log, filesize("../log/check_" . date("Ym") . ".log"));
            $arr_checkers = explode("\r\n", $logs);
            $checker_tm = 1;
            foreach ($arr_checkers as $arr_checker) {
                $checker = explode("  ", $arr_checker);
                if (@$checker['1'] == getenv('remote_addr')) {
                    $checker_tm++;
                }
                if ($checker_tm >= 10) {
                    fclose($log);
                    echo "<script>alert('请不要再继续尝试，我们将保留追究您法律责任的权利');location.replace(\"../login.php\");</script>";
                    exit();
                }
            }
            fclose($log);
            echo "<script>alert('请不要尝试非法注入');location.replace(\"../login.php\");</script>";
            exit();
        }
    }

    public function getError() {
        return $this->error;
    }

}
