<?php

class BreadcrumbsWidget extends CWidget {

    public function init() {
        parent::init();
    }

    public function run() {
        $menu = '';
        $menus = array(
            'site' => Yii::t('admin', 'Console'),
            'user' => Yii::t('admin', 'Client user'),
            'merchant' => Yii::t('admin', 'Merchant manager'),
            'acl' => Yii::t('admin', 'Access control'),
            'manager' => Yii::t('admin', 'Administrator manager'),
            'feedback' => Yii::t('admin', 'Feedback'),
            'log' => Yii::t('admin', 'Log manager'),
            'advertisement' => Yii::t('admin', 'Advertisement manager'),
            'settings' => Yii::t('admin', 'System settings')
        );
        $controllerName = Yii::app()->controller->id;
        if (key_exists($controllerName, $menus)) {
            $menu = $menus[$controllerName];
        }
        $this->render("breadcrumbs", array('menu' => $menu));
    }

}