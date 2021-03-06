<?php

/*
 * 帐号
 */

/**
 * 2014-5-13 16:26:26 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * AccountBehavior.php hugb
 *
 */
class AccountBehavior extends BaseBehavior {

    const DEFAULT_EXPIRE_DELTA = 3600;

    public function login($data, $fromAPI = false) {
        $account = Account::model()->findByAttributes(array('username' => $data['username'], 'roleid' => 5));
        if (empty($account)) {
            $this->error = Yii::t('admin', 'Username is invalid');
            return false;
        }
        if (md5($data['password']) != $account->password) {
            $this->error = Yii::t('admin', 'Password is not correct');
            return false;
        }
        $account->logintime = time();
        if ($fromAPI) {
            $account->token = HelpTemplate::UUID();
        }
        if (!$account->save()) {
            $this->error = Yii::t('admin', 'Login failure.');
            return false;
        }
        return $account;
    }

    public function logout($userId) {
        return Account::model()->updateByPk($userId, array('token' => ''));
    }

    public function getByToken($tokenId) {
        return Account::model()->findByAttributes(array('token' => $tokenId));
    }

    public function getAllAdmin() {
        return Account::model()->findAllByAttributes(array('roleid' => 1));
    }

    public function isExist($username) {
        return Account::model()->countByAttributes(array('username' => $username)) > 0;
    }

    public function sendResetPwdMail($email) {
        $account = Account::model()->findByAttributes(array('username' => $email));
        if (!$account) {
            $this->error = Yii::t('admin', 'Username is not exist.');
            return false;
        }
        $key = McryptComponent::encryption($email . ' ' . time());
        $mailer = Yii::createComponent('application.extensions.mailer.MailerHelp');
        $mailer->Host = 'smtp.163.com';
        $mailer->IsSMTP();
        $mailer->SMTPAuth = true;
        $mailer->From = 'hu198021688500@163.com';
        $mailer->AddReplyTo('hu198021688500@163.com');
        $mailer->AddAddress($email);
        $mailer->FromName = 'admin@blueu.com';
        $mailer->Username = 'hu198021688500';
        $mailer->Password = '198502021';
        $mailer->CharSet = 'UTF-8';
        $mailer->Subject = Yii::t('admin', 'Reset password');
        $mailer->Body = Yii::app()->params['host'] . 'user/resetpwd/key/' . $key;
        if (!$mailer->Send()) {
            $this->error = Yii::t('admin', 'Send email failure.');
            return false;
        }
        return Account::model()->updateByPk($account->id, array('resetpwdkey' => $key));
    }

    public function getAccount($id) {
        return Account::model()->findByPk($id);
    }

    public function getAccountByUsername($uername) {
        return Account::model()->findByAttributes(array('username' => $uername));
    }

    public function getAccountByKey($key) {
        return Account::model()->findByAttributes(array('resetpwdkey' => $key));
    }

    public function resetPwd($data) {
        if (empty($data['id']) && empty($data['username'])) {
            $this->error = Yii::t('admin', 'User id and username can not be empty.');
            return false;
        }
        $account = null;
        if (empty($data['username'])) {
            $account = Account::model()->findByPk($data['id']);
        } else {
            $account = Account::model()->findByAttributes(array('username' => $data['username']));
        }
        if (isset($data['password']) && $account->password != md5($data['password'])) {
            $this->error = Yii::t('admin', 'Password is wrong.');
            return false;
        }

        $this->error = Account::model()->updateByPk($account->id, array('password' => md5($data['newpassword']), 'resetpwdkey' => ''));
        return true;
    }

    public function addAdmin($data) {
        $account = new Account();
        $account->username = $data['username'];
        $account->password = md5($data['password']);
        $account->roleid = 1;
        $account->status = 0;
        $account->registertime = time();
        if (!$account->save()) {
            $this->error = Yii::t('admin', 'Save failure.');
            return false;
        }
        return $account->getAttributes();
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

    public function edit($data) {
        if (!isset($data['id'])) {
            $this->error = 'id' . Yii::t('api', ' is not set');
            return false;
        }

        $userId = $data['id'];
        unset($data['id']);

        $enableEdit = array(
            'status'
        );

        while (list($key, ) = each($data)) {
            if (!in_array($key, $enableEdit)) {
                $this->error = $key . ' ' . Yii::t('api', 'Not editable');
                return false;
            }
        }

        Account::model()->updateByPk($userId, $data);

        return true;
    }

}