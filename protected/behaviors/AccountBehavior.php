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

}