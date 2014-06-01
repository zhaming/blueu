<?php

class AllUserIdentity extends CUserIdentity {

    const ERROR_STATUS_INVALID = 3;

    private $id;

    public function authenticate() {
        $accounts = Account::model()->findByAttributes(array('username' => $this->username));
        if (empty($accounts)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            $this->errorMessage = Yii::t('admin', 'Username invalid');
        } elseif ($accounts->status == 1) {
            $this->errorCode = self::ERROR_STATUS_INVALID;
            $this->errorMessage = Yii::t('admin', 'User status invalid');
        } elseif ($accounts->status == 2) {
            $this->errorCode = self::ERROR_STATUS_INVALID;
            $this->errorMessage = Yii::t('admin', 'User status invalid');
        } else if (md5($this->password) != $accounts->password) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            $this->errorMessage = Yii::t('admin', 'Password invalid');
        } else {
            $this->id = $accounts->id;
            $this->errorCode = self::ERROR_NONE;
            $this->setState('status', $accounts->status);
            $this->setState('roleid', $accounts->roleid);
        }
        return !$this->errorCode;
    }

    public function getId() {
        return $this->id;
    }

}
