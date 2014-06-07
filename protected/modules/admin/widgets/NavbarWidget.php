<?php

/*
 * 头
 */

/**
 * 2014-6-2 9:52:24 UTF-8
 * @package application.modules.admin.widgets
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * NavbarWidget.php hugb
 *
 */
class NavbarWidget extends CWidget {

    public function init() {
        parent::init();
    }

    public function run() {
        $this->render("navbar");
    }

}