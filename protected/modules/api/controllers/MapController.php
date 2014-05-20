<?php

/* 
 * 地图API
 */

/**
 * 2014-5-20 14:58:43 UTF-8
 * @package application.modeules.api.controllers
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * MapController.php hugb
 *
 */
class MapController extends IController {

    protected $mapBehavior;

    public function init() {
        parent::init();
        $this->mapBehavior = new MapBehavior();
    }
}