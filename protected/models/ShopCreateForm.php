<?php

/*
 * 创建店铺表单
 */

/**
 * 2014-6-22 13:40:48 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * ShopCreateForm.php hugb
 *
 */
class ShopCreateForm extends BaseForm {

    public $merchantid;
    public $name;
    public $owner;
    public $intro;
    public $pic;
    public $telephone;
    public $address;
    public $url;
    public $catid;
    public $districtid;
    public $marketplace;
    public $floor;
    public $isonly;
    public $ismain;

    public function rules() {
        return array(
            array('merchantid,name,owner,catid,districtid', 'required'),
            array('pic', 'file', 'allowEmpty' => true, 'types' => 'gif,jpg,png,jpeg', 'maxSize' => 1024 * 1024 * 5),
            array('url', 'url', 'allowEmpty' => true),
            array('ismain', 'checkMain'),
            array('intro,telephone,address,url,marketplace,floor,isonly', 'safe')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        if (HelpTemplate::isLoginAsAdmin() && $this->merchantid) {
            $accountBehavior = new AccountBehavior();
            if (is_numeric($this->merchantid)) {
                $account = $accountBehavior->getAccount($this->merchantid);
            } else {
                $account = $accountBehavior->getAccountByUsername($this->merchantid);
            }
            if ($account['roleid'] != HelpTemplate::MERCHANT_ROLE) {
                $this->addError('merchantid', Yii::t('admin', 'Is not a valid merchant account.'));
                return false;
            }
            $this->merchantid = $account['id'];
        }
        if (HelpTemplate::isLoginAsMerchant()) {
            $this->merchantid = Yii::app()->user->getId();
        }

        return true;
    }

    public function afterValidate() {
        parent::afterValidate();
        $this->ismain = empty($this->ismain) ? 0 : 1;
        $this->isonly = empty($this->isonly) ? 0 : 1;
    }

    public function execute() {
        // 验证
        if (!$this->validate()) {
            return false;
        }
        $shop = new MerchantShop();
        $shop->merchantid = $this->merchantid;
        $shop->name = $this->name;
        // 图片处理
        $fileBehavior = new FileBehavior();
        if ($fileBehavior->isHaveUploadFile('shop[pic]')) {
            $file = $fileBehavior->saveUploadFile('shop[pic]');
            if (!$file) {
                $this->error = Yii::t('admin', 'Save picutre failure.');
                return false;
            }
            $shop->pic = $file['path'];
        }
        $shop->intro = $this->intro;
        $shop->owner = $this->owner;
        $shop->selfid = $this->ismain == '1' ? $this->merchantid : null;
        $shop->telephone = $this->telephone;
        $shop->address = $this->address;
        $shop->url = $this->url;
        $shop->catid = $this->catid;
        $shop->districtid = $this->districtid;
        $shop->marketplace = $this->marketplace;
        $shop->floor = $this->floor;
        $shop->created = time();
        if (HelpTemplate::isLoginAsAdmin()) {
            $shop->status = 1;
        } else if (HelpTemplate::isLoginAsMerchant()) {
            $shop->status = 0;
        } else {
            $shop->status = 0;
        }
        $shop->ismain = $this->ismain;
        $shop->isonly = $this->isonly;
        $shop->stations = 0;
        if (!$shop->save()) {
            $this->error = Yii::t('admin', 'Save failure.');
            return false;
        }

        return true;
    }

    public function checkMain() {
        if ($this->ismain != 1) return;
        $shopBehavior = new MerchantShopBehavior();
        if ($shopBehavior->existMain($this->merchantid)) {
            $this->addError('ismain', Yii::t('admin', 'Main shop is exist.'));
        }
    }

    public function attributeLabels() {
        return array(
            'merchantid' => Yii::t('admin', 'Account'),
            'name' => Yii::t('admin', 'Name'),
            'owner' => Yii::t('admin', 'Shop owner'),
            'intro' => Yii::t('admin', 'Introduce'),
            'pic' => Yii::t('admin', 'Picture'),
            'telephone' => Yii::t('admin', 'Telephone'),
            'address' => Yii::t('admin', 'Address'),
            'url' => Yii::t('admin', 'Url'),
            'catid' => Yii::t('admin', 'Industry'),
            'districtid' => Yii::t('admin', 'District'),
            'marketplace' => Yii::t('admin', 'Marketplace'),
            'floor' => Yii::t('admin', 'Floor'),
            'isonly' => Yii::t('admin', 'Shop only'),
            'ismain' => Yii::t('admin', 'Shop main')
        );
    }

}
