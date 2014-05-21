<?php

/*
 * 商户业务逻辑
 */

/**
 * 2014-5-10 11:41:38 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * MerchantBehavior.php hugb
 *
 */
class MerchantBehavior extends BaseBehavior {

    public function getlist($filter = array(), $page = null, $pagesize = null) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('account.roleid=4');
        $criteria->addCondition('account.status!=2');
        $criteria->order = 't.id desc';
        foreach ($filter as $key => $value) {
            switch ($key) {
                case 'search':
                    foreach ($value as $column => $keyword) {
                        $criteria->addSearchCondition($column, $keyword);
                    }
                    break;

                default:
                    break;
            }
        }

        $count = Merchant::model()->with('account')->count($criteria);

        $pager = new CPagination($count);
        $page != null && $pager->setCurrentPage($page - 1);
        $pagesize != null && $pager->setPageSize($pagesize);
        $pager->applyLimit($criteria);

        $data = Merchant::model()->with('account')->findAll($criteria);
        return array('pager' => $pager, 'data' => $data);
    }

    public function detail($merchantId) {
        $merchant = User::model()->findByPk($merchantId);
        if ($merchant == null) {
            $this->error = Yii::t('api', 'Merchant is no exist');
            return false;
        }
        return $merchant;
    }

    public function register($data) {
        $account = new Account();
        $merchant = new Merchant();
        $account->username = $data['username'];
        $account->password = md5($data['password']);
        $account->roleid = 4;

        $merchant->name = $data['name'];

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $account->save();
            $merchant->id = $account->id;
            $merchant->save();
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            $this->error = $e->getMessage();
        }
        return false;
    }

}
