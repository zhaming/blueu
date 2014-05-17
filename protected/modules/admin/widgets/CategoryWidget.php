<?php
class CategoryWidget extends CWidget
{
	public $category_id = 0;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $c = $this->controller->id;
        $a = $this->controller->action->id;
        
		$bhv = new CategoryBehavior;
		$list = $bhv->getDropDownList();
		

		echo CHtml::dropDownList('category',$this->category_id,$list,array('class'=>'input-xlarge'));
		
		//$this->render("category", compact('c', 'a'));
    }
}
?>
