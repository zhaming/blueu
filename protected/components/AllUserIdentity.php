<?php

class AllUserIdentity extends CUserIdentity {

    const ERROR_STATUS_INVALID = 3;

    private $id;
    private $roleid;

    public function authenticate() {
        $accounts = Account::model()->findByAttributes(array('username' => $this->username));
        if (empty($accounts)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif ($accounts['status'] == 1) {
            $this->errorCode = self::ERROR_STATUS_INVALID;
        } elseif ($accounts['status'] == 2) {
            $this->errorCode = self::ERROR_STATUS_INVALID;
        } else if (md5($this->password) != $accounts['password']) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->id = $accounts['id'];
            $this->roleid = $accounts['roleid'];
            $this->errorCode = self::ERROR_NONE;
            //Yii::app()->user->setState('aid', $accounts['id']);
        }
        return !$this->errorCode;
    }

    public function getId() {
        return $this->id;
    }

    public function getRoleid() {
        return $this->roleid;
    }

}