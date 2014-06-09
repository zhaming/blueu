<?php
/**
 *	蓝牙基站model
 *	@author		hugb <hu198021688500@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	models
 *
 *	$Id$
 */

class StationAds extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{station_ads}}';
    }


    public function relations(){
        return array(
            'station' => array(
                self::HAS_ONE, 'Station', array('id'=>'stationid')
            ),
            'shop' =>array(
                self::HAS_ONE,"MerchantShop",array('id'=>"shopid")
            ),
        );
    }

}

