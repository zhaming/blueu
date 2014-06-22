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
 * CouponCreateForm.php hugb
 *
 */
class CouponCreateForm extends BaseForm {

    public $name;
    public $price;
    public $intro;
    public $total;
    public $pic;
    public $shopid;
    public $validity_start;
    public $validity_end;
    public $validityStart;
    public $validityEnd;

    public function rules() {
        return array(
            array('name', 'required'),
            array('price', 'numerical', 'allowEmpty' => false, 'min' => 0),
            array('total', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'min' => 0),
            array('validityStart', 'date', 'format' => 'yyyy-MM-dd', 'allowEmpty' => false, 'timestampAttribute' => 'validity_start'),
            array('validityEnd', 'date', 'format' => 'yyyy-MM-dd', 'allowEmpty' => false, 'timestampAttribute' => 'validity_end'),
            array('shopid', 'checkShopId'),
            array('intro', 'safe')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        return true;
    }

    public function afterValidate() {
        parent::afterValidate();
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