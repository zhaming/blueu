<?php

class NavbarWidget extends CWidget {

    public function init() {
        parent::init();
    }

    public function run() {
        $this->render("navbar");
    }

}