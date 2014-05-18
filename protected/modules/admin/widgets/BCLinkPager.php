<?php

class BCLinkPager extends CLinkPager {

    public function run() {
        if (($pageCount = $this->getPageCount()) <= 1)
            return;
        echo CHtml::tag('div');
        echo CHtml::tag('ul', array('class' => 'pagination', 'style'=>'margin-top:0px'));
        $currentPage = $this->getCurrentPage(false);
        list($beginPage, $endPage) = $this->getPageRange();

        echo CHtml::tag('li');
        echo CHtml::link('首页', $this->createPageUrl(0));
        echo CHtml::closeTag('li');
        echo CHtml::tag('li');
        echo CHtml::link('上一页', $this->createPageUrl($currentPage - 1));
        echo CHtml::closeTag('li');
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            if ($i == $currentPage) {
                $list_css['class'] = 'active';
            } else {
                $list_css['class'] = '';
            }
            echo CHtml::tag('li', $list_css);
            echo CHtml::link($i + 1, $this->createPageUrl($i));
            echo CHtml::closeTag('li');
        }
        echo CHtml::tag('li');
        echo CHtml::link('下一页', $this->createPageUrl($currentPage + 1));
        echo CHtml::closeTag('li');
        echo CHtml::tag('li');
        echo CHtml::link('尾页', $this->createPageUrl($this->getPageCount()));
        echo CHtml::closeTag('li');
        echo CHtml::closeTag('ul');
        echo CHtml::closeTag('div');
    }

}