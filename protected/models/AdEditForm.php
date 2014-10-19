<?php

/*
 * 广告编辑表单
 */

/**
 * 2014-5-29 8:40:11 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * AdEditForm.php hugb
 *
 */
class AdEditForm extends BaseForm {

    public $id;
    public $url;
    public $placetag;
    public $desc;
    public $disabled;

    public function rules() {
        return array(
            array('id,url,placetag', 'required'),
            array('url', 'url'),
            array('desc', 'safe')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        return true;
    }

    public function attributeLabels() {
        return array(
            'url' => Yii::t('admin', 'Url'),
            'placetag' => Yii::t('admin', 'Place tag'),
            'desc' => Yii::t('admin', 'Description')
        );
    }

}