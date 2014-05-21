<?php

/*
 * 
 */

/**
 * 2014-5-21 10:48:16 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * FindPwdForm.php hugb
 *
 */
class FindPwdForm extends BaseForm {

    public $username;

    public function rules() {
        return array(
            array('username', 'required'),
            array('username', 'email')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        return true;
    }

    public function attributeLabels() {
        return array(
            'username' => Yii::t('admin', 'Email')
        );
    }

}