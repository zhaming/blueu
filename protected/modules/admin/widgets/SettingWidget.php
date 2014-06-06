<?php

/*
 * 界面设置
 */

/**
 * 2014-6-6 10:13:29 UTF-8
 * @package application.modules.admin.widgets
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * SettingWidget.php hugb
 *
 */
class SettingWidget extends CWidget {

    public function init() {
        parent::init();
    }

    public function run() {
        $this->render("setting");
    }

}