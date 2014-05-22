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

    public function isExist($username) {
        return Account::model()->countByAttributes(array('username' => $username)) > 0;
    }

    public function sendResetPwdMail($email) {
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
        $mailer->Subject = '密码重置';
        $mailer->Body = 'xxxxx';
        return $mailer->Send();
    }

    public function getAccount($id) {
        return Account::model()->findByPk($id);
    }

    public function resetPwd($data) {
        if (empty($data['id']) && empty($data['username'])) {
            $this->error = '用户id和username不能同时为空';
            return false;
        }
        $account = null;
        if (empty($data['username'])) {
            $account = Account::model()->findByPk($data['id']);
        } else {
            $account = Account::model()->findByAttributes(array('username' => $data['username']));
        }
        if ($account->password != md5($data['password'])) {
            $this->error = '密码不正确';
            return false;
        }
        return Account::model()->updateByPk($account->id, array('password' => md5($data['newpassword'])));
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
}