<?php
class MerchantCouponBehavior extends BaseBehavior{
    public function getList($param = array()){
        $pager = null;
        $page=-1;
        $pageSize=20;

        $criteria = new CDbCriteria;

        if(isset($param['page']) && is_numeric($param['page']))
           $page = $param['page'];
        if(isset($param['pageSize']) && is_numeric($param['pageSize']))
           $pageSize = $param['pageSize'];
        if(!empty($param['name']))
            $criteria->addSearchCondition("name",$param['name']);

        if(-1 != $page){
            $count= MerchantCoupon::model()->count($criteria);
            $pager = new CPagination($count);
            $pager->validateCurrentPage = false;
            $pager->setCurrentPage($page-1);
            $pager->pageSize = $pageSize;
            $pager->applyLimit($criteria);
        }

        $data = MerchantCoupon::model()->findAll($criteria);

        return compact('data','pager');
    }

     public  function saveOrUpdate($param){
        $obj = new  MerchantCoupon;
        $obj->_attributes = $param;
        if (!empty($param['id'])) {
            $obj->setIsNewRecord(false);
        }else{
            $obj->id = null;
            $obj->setIsNewRecord(true);
            $obj->created =  time();
        }

        $res =  $obj->save();
        if($res){
            return $obj;
        }
        else
            return false;
    }

   public function getById($id){
        return MerchantCoupon::model()->findByPK($id);
    }
}