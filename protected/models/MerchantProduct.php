<?php

/**
 * 商品model
 * @author wzq
 */
class MerchantProduct extends CActiveRecord {

    public $picUrl;
    public $id;
    public $name;
    public $pic;
    public $intro;
    public $price;
    public $discount;
    public $shopid;
    public $merchantid;
    public $created;
    public $status;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function afterFind() {
        parent::afterFind();
        $this->picUrl = $this->getPicUrl();
    }

    public function tableName() {
        return '{{merchant_product}}';
    }

    public function rules() {
        return array(
            array('id,name,pic,intro,price,discount,shopid,merchantid', 'safe'),
        );
    }

    public function relations() {
        $relations = array(
            'merchant' => array(
                self::HAS_ONE,
                'Merchant',
                array("id" => "merchantid")
            ),
            // 'shops' => array(
            //     self::MANY_MANY,
            //     'MerchantShop',
            //     'merchant_shop_product(shopid，productid)',
            // ),
            'shop_product' => array(
                self::HAS_MANY,
                "MerchantShopProduct",
                "productid"
            )
        );
        return $relations;
    }

    public function getPicUrl() {
        if (empty($this->pic))
            return '';
        return Yii::app()->params['host'] . Yii::app()->params['url_web'] . 'upload/original/' . $this->pic;
    }

}