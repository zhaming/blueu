<?php
/**
 *	人工推送表单
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

class PushManualForm extends BaseForm {
    
    public $id;
    public $source;
    public $sid;
    public $name;
    public $shopid;
    public $msg;
    public $limit;

    public function rules() {
        return array(
            array('source,sid,name,shopid,msg,limit', 'required'),
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        return true;
    }

    public function attributeLabels() {
        return array(
            'source' => Yii::t('admin', 'VSource'),
            'sid' => Yii::t('admin', 'VSID'),
            'name' => Yii::t('admin', 'VSourceName'),
            'shopid' => Yii::t('admin', 'Shop'),
            'msg' => Yii::t('admin', 'VTaskMsg'),
            'limit' => Yii::t('admin', 'VPushLimit'),
        );
    }
}