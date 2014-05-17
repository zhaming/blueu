<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class ManagerIdentity extends CUserIdentity
{
    private $id;
    private $name;
    private $passwd;
    private $role_id;
    public $errorMessage='帐号或者密码错误!';

    public function __construct($name, $passwd)
    {
        $this->name = $name;
        $this->passwd = $passwd;
    }

    public function authenticate()
    {
        // $manager = Manager::model()->getArrByAttributes(array('name'=>$this->name));
        // if(empty($manager)) {
        //     $this->errorCode=self::ERROR_USERNAME_INVALID;
        // } else if ($manager['status'] == 1) {
        //     $this->errorCode = self::ERROR_USERNAME_INVALID;
        // } else if (McryptComponent::decryption($manager['passwd']) != $this->passwd) {
        //     $this->errorCode=self::ERROR_PASSWORD_INVALID;
        // } else{
        //     $this->errorCode=self::ERROR_NONE;
        //     Yii::app()->user->setState('manager_id', $manager['id']);
        //     $this->role_id = $manager['role_id'];
        // }
        $this->errorCode=self::ERROR_NONE;
        return !$this->errorCode;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return  $this->name;
    }
}
