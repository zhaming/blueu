<?php
/**
 *	注册用户统计表
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	models
 *
 *	$Id$
 */

class StatRegistered extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{stat_registered}}';
    }
}

