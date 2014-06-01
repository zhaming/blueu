<?php

/*
 * 上传地图表单
 */

/**
 * 2014-6-1 15:49:08 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * MapUploadForm.php hugb
 *
 */
class MapUploadForm extends BaseForm {

    public $name;
    public $marketplace;
    public $floor;

    public function rules() {
        return array(
            array('name,marketplace,floor', 'required')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        return true;
    }

    public function attributeLabels() {
        return array(
            'name' => Yii::t('admin', 'Name'),
            'marketplace' => Yii::t('admin', 'Market place'),
            'floor' => Yii::t('admin', 'Floor')
        );
    }

}
