<?php
/**
 * 商铺逻辑
 */
class StationBehavior extends BaseBehavior{

	public function create($params)
	{
	    $model = new Station;
		$model->uuid = $params['uuid'];
		$model->name = $params['name'];
		$model->positionX = $params['positionX'];
		$model->positionY = $params['positionY'];
		$model->shopid = $params['shopid'];
		if(!empty($params['disabled']))
			$model->disabled = 1;
        if($model->save())
		{
			$shop = MerchantShop::model()->findByPk($model->shopid);
			$shop->stations = $shop->stations+1;
			return $shop->save();
		}else
			return false;
		
	}


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
        if(isset($param['catid']) && is_numeric($param['catid']))
            $criteria->addColumnCondition(array("catid"=>$param['catid']));
        if(isset($param['districtid']) && is_numeric($param['districtid']))
            $criteria->addColumnCondition(array("districtid"=>$param['districtid']));
        if(!empty($param['order']))
            $criteria->order = $param['order'];
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
        $res =  $obj->save();
        if($res)
            return $obj;
        else
            return false;
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
            $account->roleid = 4;//写死的商家角色
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
