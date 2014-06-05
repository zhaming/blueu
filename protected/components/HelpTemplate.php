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

    const ENABLED = 0;
    const DISABLED = 1;
    const ADMIN_ROLE = 1;
    const USER_ROLE = 5;
    const MERCHANT_ROLE = 4;
    const SUPER_ADMIN_ID = 1;
    const USER_SEX_UNKNOWN = 0;
    const USER_SEX_FEMALE = 1;
    const USER_SEX_MALE = 2;
    const USER_STATUS_NORMAL = 0;
    const USER_STATUS_DISABLED = 1;
    const USER_STATUS_DELETED = 2;
    const AD_SOURCE_MAN_MADE = 0;
    const AD_SOURCE_SHOP = 1;
    const AD_SOURCE_PRODUCT = 2;
    const AD_SOURCE_COUPON = 3;
    const AD_SOURCE_STAMP = 4;

    public static function UUID() {
        $chars = md5(uniqid(mt_rand(), true));
        $uuid = substr($chars, 0, 8) . '-'
                . substr($chars, 8, 4) . '-'
                . substr($chars, 12, 4) . '-'
                . substr($chars, 16, 4) . '-'
                . substr($chars, 20, 12);
        return $uuid;
    }

    public static function sex($flag) {
        $map = array(
            self::USER_SEX_UNKNOWN => Yii::t('admin', 'Unknown'),
            self::USER_SEX_FEMALE => Yii::t('admin', 'Female'),
            self::USER_SEX_MALE => Yii::t('admin', 'Male')
        );
        return $map[$flag];
    }

    public static function accountStatus($flag) {
        $map = array(
            self::USER_STATUS_NORMAL => Yii::t('admin', 'Normal'),
            self::USER_STATUS_DISABLED => Yii::t('admin', 'Disable'),
            self::USER_STATUS_DELETED => Yii::t('admin', 'Deleted')
        );
        return $map[$flag];
    }

    public static function role($flag) {
        $map = array(
            self::ADMIN_ROLE => Yii::t('admin', 'Administrator'),
            self::MERCHANT_ROLE => Yii::t('admin', 'Merchant'),
            self::USER_ROLE => Yii::t('admin', 'Client user')
        );
        return $map[$flag];
    }

    public static function loginRole() {
        $roleId = Yii::app()->user->getState('roleid');
        if ($roleId == self::ADMIN_ROLE) {
            if (Yii::app()->user->getId() == self::SUPER_ADMIN_ID) {
                return Yii::t('admin', 'Super admin');
            } else {
                return Yii::t('admin', 'Administrator');
            }
        }
        if ($roleId == self::MERCHANT_ROLE) {
            return Yii::t('admin', 'Merchant');
        }
        return '';
    }

    public static function isLoginAsAdmin() {
        return Yii::app()->user->getState('roleid') == self::ADMIN_ROLE;
    }

    public static function isLoginAsSuperAdmin() {
        return Yii::app()->user->getId() == self::SUPER_ADMIN_ID;
    }

    public static function isLoginAsMerchant() {
        return Yii::app()->user->getState('roleid') == self::MERCHANT_ROLE;
    }

    public static function getAdUrl($path) {
        return Yii::app()->params['host'] . Yii::app()->params['url_web'] . 'upload/original/' . $path;
    }

    public static function getMapUrl($path) {
        return Yii::app()->params['host'] . Yii::app()->params['url_web'] . 'upload/original/' . $path;
    }

    public static function getAvatarUrl($path, $size = '100_200') {
        if (empty($path)) {
            return Yii::app()->params['host'] . Yii::app()->params['url_web'] . 'upload/default/avatar_180_200.jpg';
        } else {
            return Yii::app()->params['host'] . Yii::app()->params['url_web'] . 'upload/avatar/' . $path;
        }
    }

    public static function adSource($flag) {
        $map = array(
            self::AD_SOURCE_MAN_MADE => '',
            self::AD_SOURCE_SHOP => Yii::t('admin', 'Shop'),
            self::AD_SOURCE_PRODUCT => Yii::t('admin', 'Product'),
            self::AD_SOURCE_COUPON => Yii::t('admin', 'Coupon'),
            self::AD_SOURCE_STAMP => Yii::t('admin', 'Stamp')
        );
        return $map[$flag];
    }

    public static function getAdPlaceTags() {
        return array(
            'top' => Yii::t('admin', '顶部'),
            'right' => Yii::t('admin', '右边')
        );
    }

    public static function roleColoration($flag) {
        $map = array(
            self::ADMIN_ROLE => 'green',
            self::MERCHANT_ROLE => 'light-orange',
            self::USER_ROLE => 'orange'
        );
        return $map[$flag];
    }

    public static function yesOrNo($value) {
        if ($value) {
            return Yii::t('admin', 'Yes');
        } else {
            return Yii::t('admin', 'No');
        }
    }

}
