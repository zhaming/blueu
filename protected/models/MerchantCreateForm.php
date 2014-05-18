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
class MerchantCreateForm extends CFormModel {

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
            array('repassword', 'checkRepassword'),
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
            'username' => '用户名',
            'password' => '密码',
            'repassword' => '确认密码',
            'name' => '名称'
        );
    }

    public function save() {
        if ($this->validate()) {
            $account = new Account();
            $merchant = new Merchant();
            $account->username = $this->username;
            $account->password = md5($this->password);
            $account->roleid = 4;

            $merchant->name = $this->name;

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $account->save();
                $merchant->id = $account->id;
                $merchant->save();
                $transaction->commit();
                return true;
            } catch (Exception $e) {
                $transaction->rollback();
                $this->error = $e->getMessage();
            }
        } else {
            $firstError = array_shift($this->getErrors());
            $this->error = array_shift($firstError);
        }
        return false;
    }

    public function checkUsername() {
        $accountBehavior = new AccountBehavior();
        if ($accountBehavior->isExist($this->username)) {
            $this->addError('username', '用户名已经存在');
        }
    }

    public function checkRepassword() {
        if ($this->password != $this->repassword) {
            $this->addError('repassword', '两次输入的密码不一致');
        }
    }

    public function getError() {
        return $this->error;
    }

}