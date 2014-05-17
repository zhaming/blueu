<?php
class AjaxUploadFileWidget extends CWidget{

	public $msg;
	public $type;
	public $url;
	public $callback;
	
	public function init(){
	    parent::init();
	}

	public function run(){
		
		Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/statics/styles/upload-widget.css');
		Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/statics/plugins/ajaxfileupload.js');
        $this->render("ajaxuploadfile");
	}
}
?>