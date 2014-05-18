<?php

/*
 * 创建用户表单
 */

/**
 * 2014-5-12 11:16:45 UTF-8
 * @package application.models
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * UserCreateForm.php hugb
 *
 */
class UserCreateForm extends CFormModel {

    public $username;
    public $password;
    public $repassword;
    public $name;
    public $sex = 0;
    public $mobile;
    public $period;
    private $error;

    public function rules() {
        return array(
            array('username,password,repassword,name', 'required'),
            array('sex,mobile,period', 'safe')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        $this->username = trim($this->username);
        return true;
    }

    public function attributeLabels() {
        return array(
            'username' => '用户名',
            'password' => '密码',
            'repassword' => '确认密码',
            'name' => '昵称',
            'sex' => '性别',
            'mobile' => '手机号',
            'period' => '年代'
        );
    }

    public function save() {
        if ($this->validate()) {
            $account = new Account();
            $user = new User();
            $account->username = $this->username;
            $account->password = md5($this->password);
            $account->type = 1;

            $user->name = $this->name;
            $user->sex = $this->sex;
            $user->mobile = $this->mobile;
            $user->period = $this->period;

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $account->save();
                $user->id = $account->id;
                $user->save();
                $transaction->commit();
                return true;
            } catch (Exception $e) {
                $transaction->rollback();
                $this->error = $e->getMessage();
            }
        } else {
            $firstError = array_shift($this->getErrors());
            $this->error = array_shift($firstError);
        }
        return false;
    }

    public function getError() {
        return $this->error;
    }

}