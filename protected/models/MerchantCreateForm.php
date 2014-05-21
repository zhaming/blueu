<?php

/*
 * 创建商户表单
 */

/**
 * 2014-5-12 16:53:48 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * MerchantCreateForm.php hugb
 *
 */
class MerchantCreateForm extends BaseForm {

    public $id;
    public $username;
    public $password;
    public $repassword;
    public $name;
    public $legal;
    public $telephone;
    public $bank;
    public $shopnum;
    private $error;

    public function rules() {
        return array(
            array('username,password,repassword,name', 'required'),
            array('username', 'email'),
            array('repassword', 'checkRepassword'),
            array('telephone', 'match', 'pattern' => '/^(1(([35][0-9])|(47)|[8][0126789]))\d{8}$/', 'message' => Yii::t('admin', 'Mobile format error.')),
            array('username', 'checkUsername'),
            array('legal,telephone,bank,shopnum', 'safe')
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
            'name' => Yii::t('admin', 'Name')
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