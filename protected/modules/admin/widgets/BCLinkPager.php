<?php

/*
 * 分页
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
 * BCLinkPager.php hugb
 *
 */
class BCLinkPager extends CLinkPager {

    public function init() {
        parent::init();
        $this->cssFile = false;
        $this->header = '<div>';
        $this->footer = '</div>';
        $this->selectedPageCssClass = 'active';
        $this->prevPageLabel = Yii::t('admin', '&lt; Previous');
        $this->firstPageLabel = Yii::t('admin', '&lt;&lt; First');
        $this->nextPageLabel = Yii::t('admin', 'Next &gt;');
        $this->lastPageLabel = Yii::t('admin', 'Last &gt;&gt;');
        $this->htmlOptions = array('class' => 'pagination', 'style'=>'margin:0;');
    }

}
