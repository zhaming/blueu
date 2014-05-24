<?php

/**
 * 优惠券表
 */
class MerchantCoupon  extends  CActiveRecord{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{merchant_merchant_coupon}}';
    }
}