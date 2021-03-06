<?php

/*
 * 商户分类
 */

/**
 * 2014-5-13 16:26:26 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * CategoryBehavior.php hugb
 *
 */
class CategoryBehavior extends BaseBehavior {

    public function getAll() {
        return Category::model()->findAll();
    }
    
    public function getNameById($id, $full = false) {
        $rs = Category::model()->findByPk($id);
        if(empty($rs)) return false;
        if($full){
            $pRs = Category::model()->findByAttributes(array('id' => $rs->parentid));
            if(empty($pRs)) return array($rs->name);
            return array($pRs->name,$rs->name);
        }
        return $rs->name;
    }
}