<?php

/**
 * 商铺model
 * @author wzq
 */
class MerchantShop extends CActiveRecord {

    public $picUrl;
    public $id;
    public $merchantid;
    public $name;
    public $pic;
    public $intro;
    public $owner;
    public $selfid;
    public $telephone;
    public $address;
    public $url;
    public $catid;
    public $districtid;
    public $marketplace;
    public $floor;
    public $created;
    public $status;
    public $ismain;
    public $isonly;
    public $longitude;
    public $latitude;
    public $stations;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function afterFind() {
        parent::afterFind();
        $this->picUrl = $this->getPicUrl();
    }

    public function tableName() {
        return '{{merchant_shop}}';
    }

    public function primaryKey() {
        return "id";
    }

    public function relations() {
        $relations = array(
            'merchant' => array(
                self::HAS_ONE,
                'Merchant',
                array("id" => "merchantid")
            ),
            'shop_product' => array(
                self::HAS_MANY,
                "MerchantShopProduct",
                "shopid"
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