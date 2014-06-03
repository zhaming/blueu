<?php

/**
 * 印花券表
 */
class MerchantStamp  extends  CActiveRecord{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{merchant_stamp}}';
    }

    public function relations(){
        return array(
            'code' => array(
                self::HAS_ONE, 'MerchantCode', array('id'=>'codeid')
            ),
            'shop' =>array(
                self::HAS_ONE,"MerchantShop",array('id'=>"shopid")
            ),
        );
    }
}