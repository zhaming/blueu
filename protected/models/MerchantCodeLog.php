<?php
/**
 * 优惠券，印花 code表 流水表
 */
class MerchantCodeLog extends  CActiveRecord{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{merchant_code_log}}';
    }

    public function isUsed($codeid,$userid){

        $res =  $this->findByAttributes(array("codeid"=>$codeid,"userid"=>$userid,"isused"=>1));
        if (empty($res)) {
            return  false;
        }

        return true;
    }

    public function isHave($codeid,$userid){
        $res =  $this->findByAttributes(array("codeid"=>$codeid,"userid"=>$userid,"isused"=>0));
        if (empty($res)) {
            return  false;
        }

        return true;
    }
}