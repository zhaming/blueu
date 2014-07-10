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
    public $agreement;

    public function rules() {
        return array(
            array('username,password,repassword,name', 'required'),
            array('username', 'email'),
            array('repassword', 'checkRepassword'),
            //array('telephone', 'match', 'pattern' => '/^(1(([35][0-9])|(47)|[8][0126789]))\d{8}$/', 'message' => Yii::t('admin', 'Mobile format error.')),
            array('username', 'checkUsername'),
            array('agreement', 'checkAgreement'),
            array('legal,bank,shopnum', 'safe')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        $this->username = trim($this->username);
        // 如果是管理员或者商户添加账户，跳过协议检查
        if (HelpTemplate::isLoginAsAdmin() || HelpTemplate::isLoginAsMerchant()) {
            $this->agreement = true;
        }
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

    public function checkAgreement() {
        if (!$this->agreement) {
            $this->addError('agreement', Yii::t('admin', 'You must accept agreement.'));
        }
    }

    public function checkRepassword() {
        if ($this->password != $this->repassword) {
            $this->addError('repassword', Yii::t('admin', 'Two passwords do not match'));
        }
    }

    public function execute($roleid = 4) {
        if (!$this->validate()) {
            return false;
        }
        $account = new Account();
        $merchant = new Merchant();
        $account->username = $this->username;
        $account->password = md5($this->password);
        $account->roleid = $roleid;  //分店商户
        $account->registertime = time();

        $merchant->name = $this->name;
        $merchant->legal = $this->legal;
        $merchant->telephone = $this->telephone;
        $merchant->bank = $this->bank;

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $account->save();
            $this->id = $merchant->id = $account->id;
            $merchant->save();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            $this->error = $e->getMessage();
            $this->error = Yii::t('admin', 'Create failure.');
            return false;
        }
        return true;
    }

    public function updateShopSelfId($shopId) {
        return MerchantShop::model()->updateByPk($shopId, array('selfid' => $this->id));
    }

}