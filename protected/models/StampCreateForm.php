<?php

/*
 * 印花创建表单
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
 * StampCreateForm.php hugb
 *
 */
class StampCreateForm extends BaseForm {

    public $name;
    public $total;
    public $intro;
    public $pic;
    public $shopids;
    public $validity_start;
    public $validity_end;
    public $validityStart;
    public $validityEnd;

    public function rules() {
        return array(
            array('name,total,shopids,validityStart,validityEnd', 'required'),
            array('name', 'checkName'),
            array('total', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'min' => 0),
            array('pic', 'file', 'allowEmpty' => false, 'types' => 'image/gif, image/jpeg', 'maxSize' => 1024 * 1024 * 3),
            array('shopids', 'type', 'type' => 'array', 'allowEmpty' => false),
            array('shopids', 'checkShopIds'),
            array('validityStart', 'date', 'format' => 'yyyy-MM-dd', 'allowEmpty' => false, 'timestampAttribute' => 'validity_start'),
            array('validityStart', 'checkValidityStart'),
            array('validityEnd', 'date', 'format' => 'yyyy-MM-dd', 'allowEmpty' => false, 'timestampAttribute' => 'validity_end'),
            array('validityEnd', 'checkValidityEnd'),
            array('intro', 'safe')
        );
    }

    public function checkName() {
        $rs = MerchantStamp::model()->findByAttributes(array('name' => $this->name));
        if (!empty($rs)) {
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

    public function checkShopIds() {
        if (empty($this->shopids) || count($this->shopids) == 0) {
            $this->addError('shopid', Yii::t('admin', 'Shop is required.'));
        }
    }

    public function attributeLabels() {
        return array(
            'name' => Yii::t('admin', 'Name'),
            'total' => Yii::t('admin', 'Total'),
            'intro' => Yii::t('admin', 'Introduce'),
            'pic' => Yii::t('admin', 'Picture'),
            'validity_start' => Yii::t('admin', 'Validity start'),
            'validity_end' => Yii::t('admin', 'Validity end')
        );
    }

}
