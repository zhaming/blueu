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

        $criteria = new CDbCriteria;
        $criteria->addColumnCondition(array("codeid"=>$codeid,"userid"=>$userid,"isused"=>1));
        $criteria->order = "usetime asc";
        $res = $this->find($criteria);
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

    public function useCoupon($codeid,$userid){

        $criteria = new CDbCriteria;
        $criteria->addColumnCondition(array("codeid"=>$codeid));
        $criteria->addColumnCondition(array("userid"=>$userid));
        $criteria->order = "usetime asc";
        $res = $this->find($criteria);
        if(!empty($res)){
            $res->isused = 1;
            $res->usetime = time();
            $res->save();
        }
         // $res =  $this->findByAttributes(array("codeid"=>$codeid,"userid"=>$userid,"isused"=>0));

    }

    public function getCouponList($code,$username){
        // $criteria = new CDbCriteria;
        // $criteria->addSearchCondition("name",$param['name']);
        // $criteria->addSearchCondition("name",$param['name']);
        $sql = "select  b.id ,a.name ,a.price ,a.validity_start ,a.validity_end ,
                        b.code ,b.total, c.isused ,d.name as username,d.id as uid
                    from merchant_coupon a , merchant_code b , merchant_code_log c ,user d
                    where a.codeid =b.id
                        and b.type =3
                        and c.isused = 0
                        and c.codeid = b.id
                        and d.id = c.userid
                        and c.userid in(
                            select id from user where user.name like '%".$username."%')
                        and b.code ='".$code."'";
 // c
 // 140603b3f1f2

    $connection = Yii::app()->db;
    $command = $connection->createCommand($sql);
    $res = $command->queryAll();
    // print_r($result);
    // $res  = MerchantCoupon::model()->findBySql($sql);
    return $res;
    }
}