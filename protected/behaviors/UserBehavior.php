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

        $fileBehavior = new FileBehavior();
        if ($fileBehavior->isHaveUploadFile()) {
            $file = $fileBehavior->saveUploadAvatar();
            if ($file) {
                $user->avatar = $file['path'];
            }
        }

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $account->save();
            $user->id = $account->id;
            $user->save();
            $transaction->commit();
            return $user;
        } catch (Exception $e) {
            $transaction->rollback();
            $this->error = $e->getMessage();
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

    /**
     * 获取用户推送相关配置
     * @param integer $userid
     * @return array 
     */
    public function getPushSetting($userid){
        $userExtR = UserExt::model()->with('user')->findByPk($userid);
        $userR = $userExtR->user;
        $setting = array(
            'pushable' => $userR->pushable,
            'likepush' => $userR->likepush,
            'user_id' => $userExtR->user_id,
            'channel_id' => $userExtR->channel_id,
            'platform' => $userExtR->platform,
        );
        return $setting;
    }
}