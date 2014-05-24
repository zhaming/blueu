<?php

/*
 * 创建管理员表单
 */

/**
 * 2014-5-24 11:43:28 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * AdminCreateForm.php hugb
 *
 */
class AdminCreateForm extends BaseForm {

    public $username;
    public $password;
    public $repassword;

    public function rules() {
        return array(
            array('username,password,repassword', 'required'),
            array('username', 'email'),
            array('repassword', 'checkRepassword'),
            array('username', 'checkUsername')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        return true;
    }

    public function attributeLabels() {
        return array(
            'username' => Yii::t('admin', 'Username'),
            'password' => Yii::t('admin', 'Password'),
            'repassword' => Yii::t('admin', 'Repeat password')
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