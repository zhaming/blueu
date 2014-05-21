<?php
/**
 *商品model
 *@author wzq
 */
class MerchantProduct extends  CActiveRecord{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{merchant_product}}';
    }

    public function relations() {
        $relations = array(
            'merchant' => array(
                self::HAS_ONE,
                'Merchant',
                array("id"=>"merchantid")
            ),
            // 'shops' => array(
            //     self::MANY_MANY,
            //     'MerchantShop',
            //     'merchant_shop_product(shopid，productid)',
            // ),
            'shop_product' =>array(
                self::HAS_MANY,
                "MerchantShopProduct",
                "productid"
            )
        );
        return $relations;
    }
}