<?php

class BreadcrumbsWidget extends CWidget {

    public function init() {
        parent::init();
    }

    public function run() {
        $menu = '';
        $menus = array(
            'site' => Yii::t('admin', 'Console'),
            'user' => Yii::t('admin', 'Client'),
            'merchant' => Yii::t('admin', 'Merchant'),
            'acl' => Yii::t('admin', 'Access control'),
            'manager' => Yii::t('admin', 'Administrator'),
            'feedback' => Yii::t('admin', 'Feedback'),
            'log' => Yii::t('admin', 'Log'),
            'map' => Yii::t('admin', 'Map'),
            'advertisement' => Yii::t('admin', 'Advertisement'),
            'settings' => Yii::t('admin', 'Settings')
        );
        $controllerName = Yii::app()->controller->id;
        if (key_exists($controllerName, $menus)) {
            $menu = $menus[$controllerName];
        }
        $this->render("breadcrumbs", array('menu' => $menu));
    }

}