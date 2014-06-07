<?php

/*
 * 广告创建表单
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
 * AdCreateForm.php hugb
 *
 */
class AdCreateForm extends BaseForm {

    public $url;
    public $placetag;
    public $desc;
    public $type;

    public function rules() {
        return array(
            array('url,placetag,type', 'required'),
            array('url', 'url'),
            array('desc', 'safe')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        $this->type = intval($this->type);
        return true;
    }

    public function attributeLabels() {
        return array(
            'url' => Yii::t('admin', 'Url'),
            'placetag' => Yii::t('admin', 'Place tag'),
            'type' => Yii::t('admin', 'Type'),
            'desc' => Yii::t('admin', 'Description')
        );
    }

}