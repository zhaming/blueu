<?php
class ImagesManageWidget extends CWidget
{
	public $cover;
	public $images;
	public $viewer = 0;
	public function init()
	{
		if(!empty($this->images))
		{
			$images = '';
			foreach($this->images as $image)
			{
				if(empty($images))
					$images = $image;
				else
					$images = $images.','.$image;
			}
			$this->images = $images;
		}

	}

	public function run()
	{
		$this->render('ImagesManage');
	}
}
?>
