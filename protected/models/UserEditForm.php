<?php

/*
 * 用户编辑表单
 */

/**
 * 2014-5-31 15:30:51 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * UserEditForm.php hugb
 *
 */
class UserEditForm extends BaseForm {

    public $id;
    public $name;
    public $mobile;
    public $status;
    public $pushable = false;

    public function rules() {
        return array(
            array('id,name,status', 'required'),
            array('mobile', 'numerical'),
            array('pushable', 'boolean')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        return true;
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('admin', 'Id'),
            'name' => Yii::t('admin', 'Name'),
            'status' => Yii::t('admin', 'Status')
        );
    }

}