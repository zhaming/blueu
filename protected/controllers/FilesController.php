<?php

class FilesController extends Controller
{
	public function actionIndex()
	{
		if(empty($_GET['name']))
			return false;
		$hash = $_GET['name'];
		$files = new FilesComponent();
		$files->download($hash);
	}

	public function actionImage()
	{
		if(empty($_GET['name']))
			return false;

		$hash	= null;
		$cut	= false;//top bottom left right
		$width	= 0;
		$height	= 0;

		$params = explode('.',$_GET['name']);
		if(count($params)!=2)
			return false;
		$ext = strtolower($params[1]);
		
		if(substr($params[0],0,4)=='b64_')
		{
			$params[0] = FilesComponent::decrypt(substr($params[0],4));
		}
		/*
		断点测试
		$test = '1e57da0edcc5a90d06e376d5a79bed79_w-200_h-130_c-top';
		var_dump($test);
		echo '<br>';
		var_dump(FilesComponent::decrypt(FilesComponent::encrypt($test)));
		die();
		*/

		$params = explode('_',$params[0]);
		if(count($params)==1)
		{
			$hash = $params[0];
		}else{
			//带参数 解析参数
			foreach($params as $value)
			{
				$vals = explode('-',$value);
				if(count($vals)==1)
				{
					if($vals[0] == 'c')
						$cut = 'middle';
					elseif(strlen($vals[0])==32)
						$hash = $vals[0];
				}elseif(count($vals)==2){
					if($vals[0] == 'w')
						$width = $vals[1];
					if($vals[0] == 'h')
						$height = $vals[1];
					if($vals[0] == 'c')
						$cut = $vals[1];
				}
			}
		}
		
		$images = new FilesComponent();

		// print_r( $images->getImagePath($hash));
		// die();
		$images->renderImage($hash,$ext,$width,$height,$cut);
	}


	public function actionUpload()
	{
		//echo "<pre>";
		$bhv = new FilesComponent;
		$img = $bhv->upload('file');
		if(!$img){
			$result['error'] = $bhv->error;
		}else{
			$result = $img;
		}
		//header("Content-Type:application/json");
		echo CJSON::encode($result);
	}

	public function actionEditorUpload()
	{
		$bhv = new FilesComponent;
		$img = $bhv->upload('filedata');
		if(!$img){
			$result = array(
				'err'=>$bhv->error,
				'msg'=>''
			);
		}else{
			$result = array(
				'err'=>'',
				'msg'=>'/images/'.$img['hash'].'.jpg'
			);
		}
		echo CJSON::encode($result);
	}


// We'll be outputting a PDF
//header('Content-type: application/pdf');
// It will be called downloaded.pdf
//header('Content-Disposition: attachment; filename="downloaded.pdf"');


//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
//header("Location: http://$host$uri/$extra");


}


