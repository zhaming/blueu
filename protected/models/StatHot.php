<?php
/**
 *	店铺及行业排行表
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	models
 *
 *	$Id$
 */

class StatHot extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{stat_hot}}';
    }
}

