<?php
/**
 *	优惠券印花等欢迎度排行表
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	models
 *
 *	$Id$
 */

class StatHotMerchant extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{stat_hot_merchant}}';
    }
}

