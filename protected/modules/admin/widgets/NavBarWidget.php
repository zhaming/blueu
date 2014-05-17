<?php
class NavBarWidget extends CWidget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
		// $current_id = ManagerBehavior::getCurrentManagerId();
        $this->render("NavBar",compact('current_id'));
    }
}
?>
