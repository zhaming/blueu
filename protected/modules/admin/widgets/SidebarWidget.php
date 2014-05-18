<?php

class SidebarWidget extends CWidget {

    public function init() {
        parent::init();
    }

    public function run() {
        $this->render("sidebar");
    }

}