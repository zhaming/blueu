<?php
/**
 * 优惠券，印花 code表
 */
class MerchantCode extends  CActiveRecord{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{merchant_code}}';
    }

    public function getNewCode(){
        $time = time();
        $str = date("ymd",$time);
        $criteria = new CDbCriteria();
        $criteria->order="id desc";

        $res  = $this->find($criteria);
        $lastid=0;
        if(!empty($res)){
            $lastid = $res->id;
        }
        // $str  = $str.$lastid;
        $len = strlen($str.$lastid);
        if($len <12){
            $md5 = md5(time());
            $md5 = substr($md5,1,12- $len);
            $str = $str.$md5.$lastid;
        }else{
            $str =$str.md5(time());
        }
        return $str;
    }
}