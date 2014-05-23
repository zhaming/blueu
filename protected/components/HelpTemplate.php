<?php

/*
 * 
 */

/**
 * 2014-5-23 22:52:51 UTF-8
 * @package application
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * HelpTemplate.php hugb
 *
 */
class HelpTemplate extends CComponent {

    public static function sex($index) {
        $map = array(
            0 => Yii::t('admin', 'Unknown'),
            1 => Yii::t('admin', 'Female'),
            2 => Yii::t('admin', 'Male')
        );
        return $map[$index];
    }

    public static function accountStatus($index) {
        $map = array(
            0 => Yii::t('admin', 'Normal'),
            1 => Yii::t('admin', 'Disable'),
            2 => Yii::t('admin', 'Deleted')
        );
        return $map[$index];
    }
    
    public static function role($index) {
        $map = array(
            1 => Yii::t('admin', 'Administrator'),
            4 => Yii::t('admin', 'Merchant'),
            5 => Yii::t('admin', 'Client user')
        );
        return $map[$index];
    }

    public static function isLoginAsAdmin() {
        return Yii::app()->user->getState('roleid') == 1;
    }

    public static function isLoginAsMerchant() {
        return Yii::app()->user->getState('roleid') == 4;
    }

}
