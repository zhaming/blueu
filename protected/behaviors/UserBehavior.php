<?php

/*
 * 完成用户相关业务
 */

/**
 * 2014-5-10 11:17:40 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * UserBehavior.php hugb
 *
 */
class UserBehavior extends BaseBehavior {

    public function getList($filter = array()) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('account.roleid=5');
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

        $count = User::model()->with('account')->count($criteria);

        $pager = new CPagination($count);
        $pager->setPageSize(2);
        $pager->applyLimit($criteria);

        $data = User::model()->with('account')->findAll($criteria);
        return array('pager' => $pager, 'data' => $data);
    }

    public function delete($id) {
        return Account::model()->updateByPk($id, array("status" => 2));
    }

    public function disable($id) {
        return Account::model()->updateByPk($id, array("status" => 1));
    }

    public function enable($id) {
        return Account::model()->updateByPk($id, array("status" => 0));
    }

    public function regsiter($data) {
        $account = new Account();
        $user = new User();
        $account->username = $data['username'];
        $account->password = md5($data['password']);
        $account->roleid = 5;

        $user->name = $data['name'];
        $user->sex = isset($data['sex']) ? $data['sex'] : 0;
        $user->century = isset($data['century']) ? $data['century'] : 'other';
        $user->mobile = isset($data['mobile']) ? $data['mobile'] : '';

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $account->save();
            $user->id = $account->id;
            $user->save();
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            $this->error = $e->getMessage();
        }

        return false;
    }

    public function apiLogin($data) {
        $account = Account::model()->findByAttributes(array('username' => $this->username));
        if (empty($account)) {
            $this->error = '帐号无效';
        } else if (md5($data['password']) != $account->password) {
            $this->error = '密码错误';
        } else {
            return 'xcvxccvxcvxc';
        }
        return false;
    }

    public function resetpwd($data) {
        $account = Account::model()->findByAttributes(array('username' => $this->username));
        if (empty($account)) {
            $this->error = '帐号无效';
        } else if (md5($data['password']) != $account->password) {
            $this->error = '密码错误';
        } else {
            return Account::model()->updateByPk($account->id, array("password" => md5($data['newpassword'])));
        }
        return false;
    }

}