<?php

/*
 * 创建客户端用户表单
 */

/**
 * 2014-5-12 11:16:45 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * UserCreateForm.php hugb
 *
 */
class UserCreateForm extends BaseForm {

    public $username;
    public $password;
    public $repassword;
    public $name;
    public $sex = 0;
    public $century;
    public $mobile;

    public function rules() {
        return array(
            array('username,password,repassword,name', 'required'),
            array('username', 'email'),
            array('repassword', 'checkRepassword'),
            array('mobile', 'match', 'pattern' => '/^(1(([35][0-9])|(47)|[8][0126789]))\d{8}$/', 'message' => Yii::t('admin', 'Mobile format error.')),
            array('username', 'checkUsername'),
            array('sex,mobile,century', 'safe')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        $this->username = trim($this->username);
        return true;
    }

    public function attributeLabels() {
        return array(
            'username' => Yii::t('admin', 'Username'),
            'password' => Yii::t('admin', 'Password'),
            'repassword' => Yii::t('admin', 'Repeat password'),
            'name' => Yii::t('admin', 'Name'),
            'sex' => Yii::t('admin', 'Sex'),
            'mobile' => Yii::t('admin', 'Mobile'),
            'century' => Yii::t('admin', 'century')
        );
    }

    public function checkUsername() {
        $accountBehavior = new AccountBehavior();
        if ($accountBehavior->isExist($this->username)) {
            $this->addError('username', Yii::t('admin', 'Username already exists'));
        }
    }

    public function checkRepassword() {
        if ($this->password != $this->repassword) {
            $this->addError('repassword', Yii::t('admin', 'Two passwords do not match'));
        }
    }

}