<?php
class MerchantProductBehavior extends BaseBehavior{

    public function getList($param =array()){

        $pager = null;
        $page=-1;
        $pageSize=20;

        $criteria = new CDbCriteria;
        $criteria->order="id DESC";

        if(isset($param['page']) && is_numeric($param['page']))
           $page = $param['page'];
        if(isset($param['pageSize']) && is_numeric($param['pageSize']))
           $pageSize = $param['pageSize'];
        if(isset($param['name']) && !empty($param['name']))
            $criteria->addSearchCondition("name",$param['name']);

        if(-1 != $page){
            $count=MerchantProduct::model()->count($criteria);
            $pager = new CPagination($count);
            $pager->setCurrentPage($page-1);
            $pager->pageSize = $pageSize;
            $pager->applyLimit($criteria);
        }

        $data = MerchantProduct::model()->findAll($criteria);

        return compact('data','pager');
    }

    public function getById($id){
        return MerchantProduct::model()->findByPK($id);
    }

    public  function saveOrUpdate($param){
        $obj = new MerchantProduct;
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
}