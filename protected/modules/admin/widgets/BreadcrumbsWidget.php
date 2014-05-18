<?php

class BreadcrumbsWidget extends CWidget {

    public function init() {
        parent::init();
    }

    public function run() {
        $menu = '';
        $menus = array(
            'site' => '控制台',
            'user' => '用户管理',
            'merchant' => '商户管理',
            'activity' => '活动管理',
            'statistics' => '统计管理',
            'push' => '推送管理',
            'sys' => '系统管理'
        );
        $controllerName = Yii::app()->controller->id;
        if (key_exists($controllerName, $menus)) {
            $menu = $menus[$controllerName];
        }
        $this->render("breadcrumbs", array('menu' => $menu));
    }

}