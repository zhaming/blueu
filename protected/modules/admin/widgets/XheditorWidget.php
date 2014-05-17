<?php
class XheditorWidget extends CWidget
{
	public $content = '';
	public $width = 600;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $c = $this->controller->id;
        $a = $this->controller->action->id;
        $this->render("Xheditor", compact('c', 'a'));
    }
}
?>
