<?php

/*
 * 
 */

/**
 * 2014-5-24 15:39:22 UTF-8
 * @package application
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * UserController.php hugb
 *
 */
class UserController extends CController {

    public $layout = false;

    public function actionResetpwd() {

        $key = Yii::app()->request->getQuery('key');
        $newpassword = Yii::app()->request->getQuery('newpassword');
        if (empty($key)) {
            echo 'key不能为空';
            return;
        }
        if (empty($newpassword)) {
            echo 'newpassword';
            return;
        }
        $data = explode(' ', McryptComponent::decryption($key));
        if (count($data) != 2) {
            echo '数据非法';
            return;
        }

        $expire_at = intval($data[1]) + AccountBehavior::DEFAULT_EXPIRE_DELTA;
        if (time() > $expire_at) {
            echo '已过期';
            return;
        }
        $accountBehavior = new AccountBehavior();
        $account = $accountBehavior->getAccountByKey($key);
        if (!$account) {
            echo '用户不存在';
            return;
        }
        if ($account->username != $data[0]) {
            echo '数据非法';
            return;
        }
        if ($accountBehavior->resetPwd(array('username' => $data[0], 'newpassword' => $newpassword))) {
            echo '密码已重置';
        } else {
            echo '密码重置失败';
        }
    }

}
