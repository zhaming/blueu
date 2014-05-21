<?php

/*
 * 重置密码表单
 */

/**
 * 2014-5-21 14:40:06 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * ResetPwdForm.php hugb
 *
 */
class ResetPwdForm extends BaseForm {

    public $id;
    public $username;
    public $password;
    public $newpassword;
    public $repassword;

    public function rules() {
        return array(
            array('password,newpassword,repassword', 'required'),
            array('username', 'email', 'allowEmpty' => true),
            array('id', 'safe')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        return true;
    }

    public function attributeLabels() {
        return array(
            'username' => Yii::t('admin', 'Email'),
            'password' => Yii::t('admin', 'Password'),
            'newpassword' => Yii::t('admin', 'New password'),
            'repassword' => Yii::t('admin', 'Repeat password')
        );
    }

}