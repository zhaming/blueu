<?php

/*
 * 登录表单
 */

/**
 * 2014-5-21 0:00:27 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * LoginForm.php hugb
 *
 */
class LoginForm extends BaseForm {

    public $username;
    public $password;
    public $rememberme;

    public function rules() {
        return array(
            array('username,password', 'required'),
            array('username', 'email'),
            array('rememberme', 'safe')
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
            'rememberme' => Yii::t('admin', 'Remember me')
        );
    }

}
