<?php

/*
 * 创建优惠券表单
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
 * CouponEditForm.php hugb
 *
 */
class CouponCreateForm extends BaseForm {

    public $id;
    public $name;
    public $price;
    public $intro;
    public $total;
    public $pic;
    public $shopids;
    public $validity_start;
    public $validity_end;
    public $validityStart;
    public $validityEnd;

    public function rules() {
        return array(
            array('id,name,price,total,shopids,validityStart,validityEnd', 'required'),
            array('id', 'type', 'type' => 'integer', 'allowEmpty' => false),
            array('name', 'checkName'),
            array('price', 'numerical', 'allowEmpty' => false, 'min' => 0),
            array('total', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'min' => 0),
            array('pic', 'file', 'allowEmpty' => true, 'types' => 'image/gif, image/jpeg', 'maxSize' => 1024 * 1024 * 3),
            array('shopids', 'checkShopIds'),
            array('validityStart', 'date', 'format' => 'yyyy-MM-dd', 'allowEmpty' => false, 'timestampAttribute' => 'validity_start'),
            array('validity_start', 'checkValidityStart'),
            array('validityEnd', 'date', 'format' => 'yyyy-MM-dd', 'allowEmpty' => false, 'timestampAttribute' => 'validity_end'),
            array('validity_end', 'checkValidityEnd'),
            array('intro', 'safe')
        );
    }

    public function checkName() {
        if (!empty(MerchantCoupon::model()->findByAttributes(array('name=:name'), '', array(':name' => $this->name)))) {
            $this->addError('name', Yii::t('admin', 'Name have be used.'));
        }
    }

    public function checkValidityStart() {
        if ($this->validity_start + 86400 < time()) {
            $this->addError('validity_start', Yii::t('admin', 'Validity start time must be after now.'));
        }
    }

    public function checkValidityEnd() {
        if ($this->validity_end < $this->validity_start) {
            $this->addError('validity_end', Yii::t('admin', 'Validity end time must be after start.'));
        }
    }

    public function checkShopId() {
        if (empty($this->shopid) || count($this->shopid) == 0) {
            $this->addError('shopid', Yii::t('admin', 'Shop is required.'));
        }
    }

    public function attributeLabels() {
        return array(
            'name' => Yii::t('admin', 'Name'),
            'price' => Yii::t('admin', 'Price'),
            'intro' => Yii::t('admin', 'Introduce'),
            'total' => Yii::t('admin', 'Total'),
            'pic' => Yii::t('admin', 'Picture'),
            'validity_start' => Yii::t('admin', 'Validity start'),
            'validity_end' => Yii::t('admin', 'Validity end')
        );
    }

}
