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

    function getFirstError() {
        if (!$this->hasErrors()) {
            return '';
        }
        $names = array();
        $allErrors = $this->getErrors();
        while (list($key, ) = each($allErrors)) {
            $names[] = $key;
        }
        $this->unsetAttributes($names);
        foreach ($allErrors as $key => $value) {
            return array_shift($value);
        }
    }

}