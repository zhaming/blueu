<?php
class MerchantStampBehavior extends BaseBehavior{
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
        if(!empty($param['shopid']) && is_numeric($param['shopid']))
            $criteria->addColumnCondition(array("shopid"=>$param['shopid']));


        if(-1 != $page){
            $count= MerchantStamp::model()->count($criteria);
            $pager = new CPagination($count);
            $pager->validateCurrentPage = false;
            $pager->setCurrentPage($page-1);
            $pager->pageSize = $pageSize;
            $pager->applyLimit($criteria);
        }

        $data = MerchantStamp::model()->findAll($criteria);

        return compact('data','pager');
    }

     public  function saveOrUpdate($param){
        $obj = new  MerchantStamp;
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
        return MerchantStamp::model()->findByPK($id);
    }
}