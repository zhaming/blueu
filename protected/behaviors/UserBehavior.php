<?php

/*
 * 完成用户相关业务逻辑
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

    public function getList($filter = array(), $page = null, $pagesize = null) {
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
        $page != null && $pager->setCurrentPage($page - 1);
        $pagesize != null && $pager->setPageSize($pagesize);
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

    public function register($data) {
        $account = new Account();
        $user = new User();
        $account->username = $data['username'];
        $account->password = md5($data['password']);
        $account->roleid = 5;
        $account->registertime = time();

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
        $account = Account::model()->findByAttributes(array('username' => $data['username'], 'roleid' => 5));
        if (empty($account)) {
            $this->error = Yii::t('admin', 'Username is invalid');
            return false;
        }
        if (md5($data['password']) != $account->password) {
            $this->error = Yii::t('admin', 'Password is not correct');
            return false;
        }
        Account::model()->updateByPk($account->id, array('logintime' => time()));
        return array('id' => $account['id'], 'username' => $account['username']);
    }

    public function apiLogout($data) {
        $token = Token::model()->findByPk($data['token_id']);
        if ($token == null) {
            $this->error = Yii::t('api', 'Token is not exist');
            return false;
        }
        $userData = CJSON::decode($token->data);
        if ($userData['username'] != $data['username']) {
            $this->error = Yii::t('api', 'Illegal identity');
            return false;
        }
        return Token::model()->deleteByPk($data['token_id']);
    }

    public function resetpwd($data) {
        $account = Account::model()->findByAttributes(array('username' => $data['username']));
        if (empty($account)) {
            $this->error = Yii::t('admin', 'Username is invalid');
        } else if (md5($data['password']) != $account->password) {
            $this->error = Yii::t('admin', 'Password is not correct');
        } else {
            return Account::model()->updateByPk($account->id, array("password" => md5($data['newpassword'])));
        }
        return false;
    }

    public function edit($userId, $data) {
        $enableEdit = array(
            'name'
        );
        while (list($key, ) = each($data)) {
            if (!in_array($key, $enableEdit)) {
                $this->error = $key . ' ' . Yii::t('api', 'Not editable');
                return false;
            }
        }
        return User::model()->updateByPk($userId, $data);
    }

    public function push($userId, $enable = 1) {
        return User::model()->updateByPk($userId, array('pushable' => $enable));
    }

    public function detail($userId) {
        $user = User::model()->findByPk($userId);
        if ($user == null) {
            $this->error = Yii::t('api', 'User is no exist');
            return false;
        }
        return $user;
    }

    public function like($data) {
        return true;
    }

}