<?php

/*
 * 编辑店铺表单
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
 * ShopEditForm.php hugb
 *
 */
class ShopEditForm extends BaseForm {

    public $id;
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
            array('id,name,owner,catid,districtid', 'required'),
            array('pic', 'file', 'allowEmpty' => true, 'types' => 'gif,jpg,png,jpeg', 'maxSize' => 1024 * 1024 * 5),
            array('url', 'url', 'allowEmpty' => true),
            array('intro,telephone,address,marketplace,floor,isonly,ismain', 'safe')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
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
        $shop = MerchantShop::model()->findByPk($this->id);
        if (empty($shop)) {
            $this->error = Yii::t("admin", "Shop is not exist.");
            return false;
        }
        
        if (!HelpTemplate::isLoginAsAdmin() && $shop->merchantid != Yii::app()->user->getId() && $shop->selfid != Yii::app()->user->getId()) {
            $this->error = Yii::t("admin", "You don't have permission.");
            return false;
        }
        if ($this->ismain) {
            $params = array('merchantid' => $shop->merchantid, 'ismain' => 1);
            $shops = MerchantShop::model()->findAllByAttributes($params);
            if (!empty($shops)) {
                foreach ($shops as $value) {
                    if ($value->id != $this->id) {
                        $this->addError('ismain', Yii::t('admin', 'Main shop is exist.'));
                        return false;
                    }
                }
            }
        }
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
        $shop->telephone = $this->telephone;
        $shop->address = $this->address;
        $shop->url = $this->url;
        $shop->catid = $this->catid;
        $shop->districtid = $this->districtid;
        $shop->marketplace = $this->marketplace;
        $shop->floor = $this->floor;
        if (HelpTemplate::isLoginAsAdmin()) {
            $shop->status = 1;
        } else if (HelpTemplate::isLoginAsMerchant()) {
            $shop->status = 0;
        } else {
            $shop->status = 0;
        }
        $shop->ismain = $this->ismain;
        $shop->isonly = $this->isonly;
        if (!$shop->save()) {
            $this->error = Yii::t('admin', 'Save failure.');
            return false;
        }

        return true;
    }

    public function attributeLabels() {
        return array(
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
