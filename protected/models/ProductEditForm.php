<?php

/*
 * 编辑商品表单
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
 * ProductEditForm.php hugb
 *
 */
class ProductEditForm extends BaseForm {

    public $id;
    public $merchantid;
    public $name;
    public $intro;
    public $pic;
    public $price;
    public $discount;
    public $shopids;

    public function rules() {
        return array(
            array('merchantid,name,pic,price,discount,shopids', 'required'),
            array('pic', 'file', 'allowEmpty' => true, 'types' => 'gif,jpg,png,jpeg', 'maxSize' => 1024 * 1024 * 5),
            array('intro', 'safe')
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
    }

    public function execute() {
        // 验证
        if (!$this->validate()) {
            return false;
        }
        $product = new MerchantProduct();
        $product->name = $this->name;
        // 图片处理
        $fileBehavior = new FileBehavior();
        if ($fileBehavior->isHaveUploadFile('product[pic]')) {
            $file = $fileBehavior->saveUploadFile('product[pic]');
            if (!$file) {
                $this->error = Yii::t('admin', 'Save picutre failure.');
                return false;
            }
            $product->pic = $file['path'];
        }
        $product->intro = $this->intro;
        $product->price = $this->price;
        $product->discount = $this->discount;
        $product->merchantid = $this->merchantid;
        $product->created = time();
        if (HelpTemplate::isLoginAsAdmin()) {
            $product->status = 1;
        } else if (HelpTemplate::isLoginAsMerchant()) {
            $product->status = 0;
        } else {
            $product->status = 0;
        }
        if (!$product->save()) {
            $this->error = Yii::t('admin', 'Save failure.');
            return false;
        }
        foreach ($this->shopids as $value) {
            $shopProduct = new MerchantShopProduct;
            $shopProduct->shopid = $value;
            $shopProduct->productid = $product->id;
            $shopProduct->save();
        }
        return true;
    }

    public function attributeLabels() {
        return array(
            'merchantid' => Yii::t('admin', 'Account'),
            'name' => Yii::t('admin', 'Name'),
            'intro' => Yii::t('admin', 'Introduce'),
            'pic' => Yii::t('admin', 'Picture'),
            'price' => Yii::t('admin', 'Price'),
            'discount' => Yii::t('admin', 'Discount'),
            'shopids' => Yii::t('admin', 'Shop')
        );
    }

}
