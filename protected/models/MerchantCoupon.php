<?php

/**
 * 优惠券表
 */
class MerchantCoupon  extends  CActiveRecord{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{merchant_coupon}}';
    }

    public function relations(){
        return array(
            'coupon' => array(
                self::HAS_ONE, 'MerchantCode', array('id'=>'codeid')
            ),
            'shop' =>array(
                self::HAS_ONE,"MerchantShop",array('id'=>"shopid")
            ),
        );
    }
}