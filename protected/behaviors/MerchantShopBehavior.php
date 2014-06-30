<?php

/**
 * 商铺逻辑
 */
class MerchantShopBehavior extends BaseBehavior {

    public function getList($param = array()) {
        $pager = null;
        $page = -1;
        $pageSize = 20;

        $criteria = new CDbCriteria();
        $criteria->order = "id DESC";

        if (isset($param['page']) && is_numeric($param['page'])) {
            $page = $param['page'];
        }
        if (isset($param['pageSize']) && is_numeric($param['pageSize'])) {
            $pageSize = $param['pageSize'];
        }
        if (isset($param['merchantid']) && is_numeric($param['merchantid'])) {
            $criteria->addColumnCondition(array("merchantid" => $param['merchantid']));
            if (isset($param['selfid']) && is_numeric($param['selfid'])) {
                $criteria->addCondition('selfid=' . $param['selfid'], 'OR');
            }
        }
        if (!empty($param['or_search']) && is_array($param['or_search'])) {
            foreach ($param['or_search'] as $key => $value) {
                $criteria->addSearchCondition($key, $value, true, "OR");
            }
        }
        if (isset($param['name']) && !empty($param['name'])) {
            $criteria->addSearchCondition("name", $param['name']);
        }
        if (isset($param['owner']) && !empty($param['owner'])) {
            $criteria->addSearchCondition("owner", $param['owner']);
        }
        if (isset($param['isonly']) && is_numeric($param['isonly'])) {
            $criteria->addColumnCondition(array("isonly" => $param['isonly']));
        }
        if (isset($param['catid']) && is_numeric($param['catid'])) {
            $criteria->addColumnCondition(array("catid" => $param['catid']));
        }
        if (isset($param['districtid']) && is_numeric($param['districtid'])) {
            $criteria->addColumnCondition(array("districtid" => $param['districtid']));
        }
        if (!empty($param['order'])) {
            $criteria->order = $param['order'];
        }
        if (-1 != $page) {
            $count = MerchantShop::model()->count($criteria);
            $pager = new CPagination($count);
            $pager->validateCurrentPage = false;
            $pager->setCurrentPage($page - 1);
            $pager->pageSize = $pageSize;
            $pager->applyLimit($criteria);
        }

        $data = MerchantShop::model()->findAll($criteria);

        return compact('data', 'pager');
    }

    public function saveOrUpdate($param) {
        $obj = new MerchantShop;
        $obj->_attributes = $param;
        if (!empty($param['id'])) {
            $obj->setIsNewRecord(false);
        } else {
            $obj->id = null;
            $obj->setIsNewRecord(true);
            $obj->created = time();
        }
        $res = $obj->save();
        if ($res)
            return $obj;
        else
            return false;
    }

    public function getById($id) {
        return MerchantShop::model()->findByPK($id);
    }

//创建分店账号用
    public function createAccount($username, $passwd, $shopid) {
        $account = new Account();
        $merchant = new Merchant();
        $shop = $this->getById($shopid);
        $transaction = Yii::app()->db->beginTransaction();
        try {

            $account->username = $username;
            $account->password = md5($passwd);
            $account->registertime = time();
            $account->roleid = 4; //写死的商家角色
            $account->save();

            $merchant->id = $account->id;
            $merchant->name = $username;
            $merchant->save();

            $shop->selfid = $account->id;
            $shop->save();

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
        return true;
    }

    public function existMain($merchantid) {
        return MerchantShop::model()->findByAttributes(array('merchantid' => $merchantid, 'ismain' => 1));
    }

    public function existOnly($merchantid) {
        return MerchantShop::model()->findByAttributes(array('merchantid' => $merchantid));
    }

    public function getShopsCriteria($params = array()) {
        $criteria = new CDbCriteria();
        $criteria->order = "id DESC";
        if (!empty($params['name'])) {
            $criteria->addSearchCondition('name', $params['name']);
        }
        if (!empty($params['owner'])) {
            $criteria->addSearchCondition("owner", $params['owner']);
        }
        if (!empty($params['merchantid'])) {
            $criteria->addColumnCondition(array('merchantid' => $params['merchantid'], 'selfid' => $params['merchantid']), 'or');
        }
        if (!empty($params['isonly'])) {
            $criteria->addColumnCondition(array('isonly' => 1));
        }
        if (!empty($params['ismain'])) {
            $criteria->addColumnCondition(array('ismain' => 1));
        }
        return $criteria;
    }

    public function getShopsWithPager($params = array()) {
        $page = empty($params['page']) ? 1 : intval($params['page']);
        $pageSize = empty($params['pagesize']) ? Yii::app()->params->page_size : intval($params['pagesize']);

        if (HelpTemplate::isLoginAsMerchant()) {
            $params['merchantid'] = Yii::app()->user->getId();
        }

        $criteria = $this->getShopsCriteria($params);
        $count = MerchantShop::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->validateCurrentPage = false;
        $pager->setCurrentPage($page - 1);
        $pager->pageSize = $pageSize;
        $pager->applyLimit($criteria);

        $data = MerchantShop::model()->findAll($criteria);

        return compact('data', 'pager');
    }

}