<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 2014-5-21 9:41:15 UTF-8
 * @package application.components
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * BaseFrom.php hugb
 *
 */
class BaseForm extends CFormModel {

    protected $error;

    public function getFirstError() {
        // 自定义的错误
        if ($this->error) {
            return $this->error;
        }

        // 验证产生的错误
        if (!$this->hasErrors()) {
            return '';
        }

        // 将验证失败的域的值重置
        $names = array();
        $allErrors = $this->getErrors();
        while (list($key, ) = each($allErrors)) {
            $names[] = $key;
        }
        $this->unsetAttributes($names);
        // 返回第一个错误
        foreach ($allErrors as $key => $value) {
            return array_shift($value);
        }
    }

}