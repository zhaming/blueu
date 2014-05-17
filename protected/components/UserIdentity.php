<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $id;
    private $passwd;
    private $email;
    public $errorMessage='帐号或者密码错误!';

    public function __construct($passwd, $email)
    {
        $this->passwd = $passwd;
        $this->email = $email;
    }

    public function authenticate()
    {
        $user = User::model()->getUserByAttributes(array('email' => $this->email, 'type' => User::USER_TYPE_GENERA));

        if(empty($user)) {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        } else if (McryptComponent::decryption($user['passwd']) != $this->password) {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        } else{
            $this->errorCode=self::ERROR_NONE;
            //Yii::app()->session['user_id'] = $this->id = $user['id'];
            Yii::app()->user->setState('user_id', $user['id']);
            $this->id = $user['id'];
            $this->name = $user['name'];
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

}
