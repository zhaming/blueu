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

    /**
     * 客户端获取用户列表
     * @param integer $page
     * @param integer $pagesize
     * @return array
     */
    public function apiGetList($page = 1, $pagesize = 10) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('account.roleid=5');
        $criteria->addCondition('account.status=0');
        $criteria->order = 't.id desc';
        $criteria->limit = $pagesize;
        $criteria->offset = ($page - 1) * $pagesize;

        return User::model()->with('account')->findAll($criteria);
    }

    /**
     * 
     * @param array $filter
     * @param integer $page
     * @param integer $pagesize
     * @return array
     */
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
                case 'where':
                    foreach ($value as $k => $v) {
                        $criteria->addCondition($k . '=:' . $k);
                        $criteria->params[':' . $k] = $v;
                    }
                default:
                    break;
            }
        }

        $count = User::model()->with('account')->count($criteria);

        $pager = new CPagination($count);
        $pager->validateCurrentPage = false;
        $page != null && $pager->setCurrentPage($page - 1);
        $pagesize != null && $pager->setPageSize($pagesize);
        $pager->applyLimit($criteria);

        $data = User::model()->with('account')->findAll($criteria);
        return array('pager' => $pager, 'data' => $data);
    }

    /**
     * 用户注册
     * @param array $data
     * @return boolean or array
     */
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

    /**
     * 编辑用户
     * @param array $data
     * @return boolean
     */
    public function edit($data) {
        if (!isset($data['id'])) {
            $this->error = 'id' . Yii::t('api', ' is not set');
            return false;
        }
        $userId = $data['id'];
        unset($data['id']);
        $enableEdit = array(
            'name'
        );
        while (list($key, ) = each($data)) {
            if (!in_array($key, $enableEdit)) {
                $this->error = $key . ' ' . Yii::t('api', 'Not editable');
                return false;
            }
        }
        User::model()->updateByPk($userId, $data);
        return true;
    }

    /**
     * 用户是否接收推送开关
     * @param integer $userId
     * @param integer $enable
     * @return boolean
     */
    public function push($userId, $enable = 1) {
        return User::model()->updateByPk($userId, array('pushable' => $enable));
    }

    /**
     * 用户详情
     * @param integer $userId
     * @return boolean or array
     */
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
    public function getPushSetting($userid) {
        $userExtR = UserExt::model()->with('user')->findByPk($userid);
        if (empty($userExtR))
            return false;
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