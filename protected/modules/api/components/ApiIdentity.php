<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class ApiIdentity extends CUserIdentity
{
    private $id;
    private $email;
    private $passwd;
    private $user;

    public function __construct($email, $passwd)
    {
        $this->email = $email;
        $this->passwd = $passwd;
    }

    public function authenticate()
    {
        $user = User::model()->getUserByAttributes(array('email' => $this->email, 'type' => User::USER_TYPE_GENERA));
        if(empty($user)) {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        } else if (McryptComponent::decryption($user['passwd']) != $this->passwd) {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        } else{
            $this->errorCode=self::ERROR_NONE;
            $this->id = $user['id'];
            $this->user = $user;
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

    public function getUser()
    {
        return $this->user;
    }
}
