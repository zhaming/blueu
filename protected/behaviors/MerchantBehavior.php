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

    public function getlist($filter = array()) {
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
        $pager->setPageSize(2);
        $pager->applyLimit($criteria);

        $data = Merchant::model()->with('account')->findAll($criteria);
        return array('pager' => $pager, 'data' => $data);
    }

}
