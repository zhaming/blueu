<?php
/**
 * 商铺逻辑
 */
class MerchantShopBehavior extends BaseBehavior{

    public  function getList($param = array()){
        $pager = null;
        $page=-1;
        $pageSize=20;

        $criteria = new CDbCriteria;
        $criteria->order="id DESC";

        if(isset($param['page']) && is_numeric($param['page']))
           $page = $param['page'];
        if(isset($param['pageSize']) && is_numeric($param['pageSize']))
           $pageSize = $param['pageSize'];
        if(isset($param['merchantid']) && is_numeric($param['merchantid'])){
            $criteria->addColumnCondition(array("merchantid"=>$param['merchantid']));
            if(isset($param['selfid']) && is_numeric($param['selfid']))
               $criteria->addCondition('selfid='.$param['selfid'],'OR');
        }
        if(isset($param['name']) && !empty($param['name']))
            $criteria->addSearchCondition("name",$param['name']);
        if(isset($param['owner']) && !empty($param['owner']))
            $criteria->addSearchCondition("owner",$param['owner']);
        if(isset($param['isonly']) && is_numeric($param['isonly']))
            $criteria->addColumnCondition(array("isonly"=>$param['isonly']));

        if(-1 != $page){
            $count=MerchantShop::model()->count($criteria);
            $pager = new CPagination($count);
            $pager->setCurrentPage($page-1);
            $pager->pageSize = $pageSize;
            $pager->applyLimit($criteria);
        }

        $data = MerchantShop::model()->findAll($criteria);

        return compact('data','pager');
    }

    public function saveOrUpdate($param){
        $obj = new MerchantShop;
        $obj->_attributes = $param;
        if (!empty($param['id'])) {
            $obj->setIsNewRecord(false);
        }else{
            $obj->id = null;
            $obj->setIsNewRecord(true);
            $obj->created =  time();
        }
       return $obj->save();
    }

    public function getById($id){
        return MerchantShop::model()->findByPK($id);
    }

//创建分店账号用
    public function createAccount($username,$passwd,$shopid){
        $account = new Account();
        $merchant = new Merchant();
        $shop = $this->getById($shopid);
        $transaction = Yii::app()->db->beginTransaction();
        try {

            $account->username = $username;
            $account->password = md5($passwd);
            $account->registertime = time();
            $account->save();

            $merchant->id = $account->id;
            $merchant->name =  $username;
            $merchant->save();

            $shop->selfid =  $account->id;
            $shop->save();

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
        return true;
    }
}