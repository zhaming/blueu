<?php

/*
 * 商户编辑表单
 */

/**
 * 2014-5-31 13:11:37 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * MerchantEditForm.php hugb
 *
 */
class MerchantEditForm extends BaseForm {

    public $id;
    public $name;

    public function rules() {
        return array(
            array('id,name', 'required'),
            array('', 'safe')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        return true;
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('admin', 'Id'),
            'name' => Yii::t('admin', 'Name')
        );
    }

}
