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

        if(isset($param['in'])){
            foreach ($param["in"] as $key => $value) {
                $criteria->addInCondition($key,$value);
            }
        }
        if(isset($param['conditions'])){
            foreach ($param['conditions'] as $key => $value) {
               $criteria->addCondition($value,"AND");
            }
        }

        if(isset($param['join'])){
            $criteria->join = $param['join'];
        }
        if(-1 != $page){
            $count=MerchantProduct::model()->count($criteria);
            $pager = new CPagination($count);
            $pager->validateCurrentPage = false;
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

/**
 * 废弃
 * @param  [type]  $shopId   [description]
 * @param  integer $page     [description]
 * @param  integer $pageSize [description]
 * @return [type]            [description]
 */
    public function getListByShopId($shopId,$page=1,$pageSize=10){
        $criteria = new CDbCriteria;
        $criteria->addColumnCondition(array("shopid"=>$shopId));

        $count=MerchantShopProduct::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->setCurrentPage($page-1);
        $pager->pageSize = $pageSize;
        $pager->applyLimit($criteria);

        $res  =  MerchantShopProduct::model()->findAll($criteria);
        $data = array();
        if(!empty($res)){
            foreach ($res as $key => $value) {
                $data[] = $value->product;
            }
        }
        return compact("data","pager");
    }

    public  function saveOrUpdate($param){
        $obj = new MerchantProduct;
        $obj->setAttributes($param);
        if (!empty($param['id'])) {
            $obj->setIsNewRecord(false);
        }else{
            $obj->id = null;
            $obj->setIsNewRecord(true);
            $obj->created = time();
        }
        $res = $obj->save();
        if($res) return $obj;
        return false;
    }
}