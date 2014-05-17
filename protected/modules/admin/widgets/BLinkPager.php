<?php
/**
 * CLinkPager class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CLinkPager displays a list of hyperlinks that lead to different pages of target.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CLinkPager.php 3515 2011-12-28 12:29:24Z mdomba $
 * @package system.web.widgets.pagers
 * @since 1.0
 */
class BLinkPager extends CBasePager
{
    /**
     * @var integer maximum number of page buttons that can be displayed. Defaults to 10.
     */
    public $maxButtonCount=10;
    /**
     * @var string the text label for the next page button. Defaults to 'Next &gt;'.
     */
    public $nextPageLabel;
    /**
     * @var string the text label for the previous page button. Defaults to '&lt; Previous'.
     */
    public $prevPageLabel;
    /**
     * @var string the text label for the first page button. Defaults to '&lt;&lt; First'.
     */
    public $firstPageLabel;
    /**
     * @var string the text label for the last page button. Defaults to 'Last &gt;&gt;'.
     */
    public $lastPageLabel;
    /**
     * @var string the text shown before page buttons. Defaults to 'Go to page: '.
     */
    public $header;
    /**
     * @var string the text shown after page buttons.
     */
    public $footer='';
    /**
     * @var mixed the CSS file used for the widget. Defaults to null, meaning
     * using the default CSS file included together with the widget.
     * If false, no CSS file will be used. Otherwise, the specified CSS file
     * will be included when using this widget.
     */
    public $cssFile;
    /**
     * @var array HTML attributes for the pager container tag.
     */
    public $htmlOptions=array();

    /**
     * Initializes the pager by setting some default property values.
     */
    public function init()
    {
        if($this->nextPageLabel===null)
            $this->nextPageLabel=Yii::t('yii','Next &gt;');
        if($this->prevPageLabel===null)
            $this->prevPageLabel=Yii::t('yii','&lt; Previous');
        if($this->firstPageLabel===null)
            $this->firstPageLabel=Yii::t('yii','&lt;&lt; First');
        if($this->lastPageLabel===null)
            $this->lastPageLabel=Yii::t('yii','Last &gt;&gt;');
        if($this->header===null)
            $this->header=Yii::t('yii','Go to page: ');

        if(!isset($this->htmlOptions['id']))
            $this->htmlOptions['id']=$this->getId();
        if(!isset($this->htmlOptions['class']))
            $this->htmlOptions['class']='yiiPager';
    }

    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        if (($pageCount=$this->getPageCount())<=1)
            return;
        echo CHtml::tag('div', array('class'=>'pagination'));
        echo CHtml::tag('ul');
        $currentPage = $this->getCurrentPage(false);
        list($beginPage,$endPage)=$this->getPageRange();

        echo CHtml::tag('li');
        echo CHtml::link('首页', $this->createPageUrl(0));
        echo CHtml::closeTag('li');
        echo CHtml::tag('li');
        echo CHtml::link('上页', $this->createPageUrl($currentPage-1));
        echo CHtml::closeTag('li');
        for ($i=$beginPage;$i<=$endPage;++$i) {
            if ($i == $currentPage) {
                $list_css['class'] = 'active';
            } else {
                $list_css['class'] = '';
            }
            echo CHtml::tag('li', $list_css);
            echo CHtml::link($i+1, $this->createPageUrl($i));
            echo CHtml::closeTag('li');
        }
        echo CHtml::tag('li');
        echo CHtml::link('下页', $this->createPageUrl($currentPage+1));
        echo CHtml::closeTag('li');
        echo CHtml::tag('li');
        echo CHtml::link('末页', $this->createPageUrl($this->getPageCount()));
        echo CHtml::closeTag('li');
        echo CHtml::closeTag('ul');
        echo CHtml::closeTag('div');
    }

    /**
     * Creates the page buttons.
     * @recho CHtml::link('1', $this->createPageUrl(1));eturn array a list of page buttons (in HTML code).
     */
    protected function createPageButtons()
    {
        if(($pageCount=$this->getPageCount())<=1)
            return array();

        list($beginPage,$endPage)=$this->getPageRange();
        $currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
        $buttons=array();

        // first page
        $buttons[]=$this->createPageButton('firstPageLabel',0,self::CSS_FIRST_PAGE,$currentPage<=0,false);

        // prev page
        if(($page=$currentPage-1)<0)
            $page=0;
        $buttons[]=$this->createPageButton('prevPageLabel',$page,self::CSS_PREVIOUS_PAGE,$currentPage<=0,false);

        // internal pages
        for($i=$beginPage;$i<=$endPage;++$i)
            $buttons[]=$this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);

        // next page
        if(($page=$currentPage+1)>=$pageCount-1)
            $page=$pageCount-1;
        $buttons[]=$this->createPageButton('nextPageLabel',$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);

        // last page
        $buttons[]=$this->createPageButton('lastPageLabel',$pageCount-1,self::CSS_LAST_PAGE,$currentPage>=$pageCount-1,false);

        return $buttons;
    }

    /**
     * Creates a page button.
     * You may override this method to customize the page buttons.
     * @param string $label the text label for the button
     * @param integer $page the page number
     * @param string $class the CSS class for the page button. This could be 'page', 'first', 'last', 'next' or 'previous'.
     * @param boolean $hidden whether this page button is visible
     * @param boolean $selected whether this page button is selected
     * @return string the generated button
     */
    protected function createPageButton($label,$page,$class,$hidden,$selected)
    {
        if($hidden || $selected)
            $class.=' '.($hidden ? '' : 'active');
        return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page)).'</li>';
    }

    /**
     * @return array the begin and end pages that need to be displayed.
     */
    protected function getPageRange()
    {
        $currentPage=$this->getCurrentPage();
        $pageCount=$this->getPageCount();

        $beginPage=max(0, $currentPage-(int)($this->maxButtonCount/2));
        if(($endPage=$beginPage+$this->maxButtonCount-1)>=$pageCount)
        {
            $endPage=$pageCount-1;
            $beginPage=max(0,$endPage-$this->maxButtonCount+1);
        }
        return array($beginPage,$endPage);
    }
}
