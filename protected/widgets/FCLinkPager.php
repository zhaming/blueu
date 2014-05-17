<?php
/*
 *	AjaxCLinkPager Widget
 *	author	yanxf <walkfine@gmail.com>
 *	version	1.0
 */
class FCLinkPager extends CLinkPager{

	public function init()
	{
		if($this->nextPageLabel===null)
			$this->nextPageLabel=Yii::t('yii','&gt;');
		if($this->prevPageLabel===null)
			$this->prevPageLabel=Yii::t('yii','&lt;');
		if($this->firstPageLabel===null)
			$this->firstPageLabel=Yii::t('yii','&lt;&lt;');
		if($this->lastPageLabel===null)
			$this->lastPageLabel=Yii::t('yii','&gt;&gt;');
		if($this->header===null)
			$this->header=Yii::t('yii',' ');

		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->getId();
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='';
	}
}
?>
