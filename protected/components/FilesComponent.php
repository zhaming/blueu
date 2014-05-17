<?php

/*
 *	文件模块 Class
 *	author	yanxf <walkfine@gmail.com>
 */

class FilesComponent
{
	//资源目录层级
	public $dir_level;
	public $dir_base;
	public $dir_root;
	public $dir_thumb_base;
	public $dir_thumb_root;
	
	const MKEY = 'wanthings';

	public $error;
	

	public function __construct()
	{
		$this->dir_level = 1;
		$this->dir_base = '/statics/upload/source';
		$this->dir_thumb_base = '/statics/upload/thumb';

		///fix path
		$this->dir_root = Yii::app()->getBasePath()."/..".$this->dir_base;
		$this->dir_thumb_root = Yii::app()->getBasePath()."/..".$this->dir_thumb_base;
		// echo $this->dir_thumb_root ;
	}





	protected function getDir($hash)
	{
		$dirs = str_split($hash,2);
		$dir = '';
		if($this->dir_level)
		{
			for($i=0;$i<$this->dir_level;$i++)
			{
				$dir = $dir.'/'.$dirs[$i];
			}
		}
		$dir_full = $this->dir_root.$dir;
		
		return $dir_full;
	}

	protected function getPath($hash)
	{
		$dir = $this->getDir($hash);
		return $dir.'/'.$hash;
	}



	public function uploadError($code)
	{
		$err = '';
		switch($code)
		{
			case '1':
				$err = '文件大小超过了php.ini定义的upload_max_filesize值';
				break;
			case '2':
				$err = '文件大小超过了HTML定义的MAX_FILE_SIZE值';
				break;
			case '3':
				$err = '文件上传不完全';
				break;
			case '4':
				$err = '无文件上传';
				break;
			case '6':
				$err = '缺少临时文件夹';
				break;
			case '7':
				$err = '写文件失败';
				break;
			case '8':
				$err = '上传被其它扩展中断';
				break;
			case '999':
			default:
				$err = '无有效错误代码';
		}
		return $err;
	}


	public function upload($name)
	{
		//资源根目录
		$dir_root_url = Yii::app()->getBaseUrl(true).$this->dir_base;
		if(empty($_FILES[$name]))
		{
			$this->error = '无文件上传';
			return false;
		}
		$file = $_FILES[$name];
		
		if(!is_array($_FILES[$name]['name']))
		{
			if(!empty($file["error"]))
			{
				$err = $this->uploadError($file["error"]);
				$this->error = $err;
				return false;
			}
			$hash_name = md5_file($file["tmp_name"]);
			$file_exts = explode('.',$file['name']);
			$file_ext = strtolower(end($file_exts));
			
			$dir = $this->getDir($hash_name);
	
			//查询是否已经存在该资源
			$criteria = new CDbCriteria;
			$criteria->addCondition('hash_code = "'.$hash_name.'"');
			$model = Files::model()->find($criteria);
			if(empty($model))
			{
				//echo $dir;
				if(!file_exists($dir))
				{
					mkdir($dir,0755,true);
				}
				if(move_uploaded_file($file["tmp_name"], $dir.'/'.$hash_name))
				{
					$model = new Files;
					$model->file_name = $file['name'];
					$model->file_type = $file['type'];
					$model->file_size = $file['size'];
					$model->file_extension = $file_ext;
					$model->hash_code = $hash_name;
					$model->ctime = time();
					$model->save();
				}
			}
			//var_dump($model);
			//$result = $model->getAttributes();
			$result['id'] = $model->id;
			$result['hash'] = $model->hash_code;
			$result['name'] = $model->file_name;
			$result['size'] = $model->file_size;
			$result['type'] = $model->file_type;
			$result['extension'] = $model->file_extension;

		}else{
			
			for($i=0; $i< count($file['name']);$i++)
			{
				if(!empty($file["error"][$i]))
				{
					$err = $this->uploadError($file["error"][$i]);
					$this->error = $err;
					return false;
				}
				$hash_name = md5_file($file["tmp_name"][$i]);
				$file_exts = explode('.',$file['name'][$i]);
				$file_ext = strtolower(end($file_exts));
				
				$dir = $this->getDir($hash_name);
	
				//查询是否已经存在该资源
				$criteria = new CDbCriteria;
				$criteria->addCondition('hash_code = "'.$hash_name.'"');
				$model = Files::model()->find($criteria);
				if(empty($model))
				{
					//echo $dir;
					if(!file_exists($dir))
					{
						mkdir($dir,0755,true);
					}
					if(move_uploaded_file($file["tmp_name"][$i], $dir.'/'.$hash_name))
					{
						$model = new Files;
						$model->file_name = $file['name'][$i];
						$model->file_type = $file['type'][$i];
						$model->file_size = $file['size'][$i];
						$model->file_extension = $file_ext;
						$model->hash_code = $hash_name;
						$model->ctime = time();
						$model->save();
					}
				}
				//var_dump($model);
				//$result = $model->getAttributes();
				$result[$i]['id'] = $model->id;
				$result[$i]['hash'] = $model->hash_code;
				$result[$i]['name'] = $model->file_name;
				$result[$i]['size'] = $model->file_size;
				$result[$i]['type'] = $model->file_type;
				$result[$i]['extension'] = $model->file_extension;

			}
			//pclose(popen("/home/xinchen/backend.php &", 'r'));
		}
		return $result;

	}



	public function mUpload($name)
	{
		//资源根目录
		$dir_root_url = Yii::app()->getBaseUrl(true).$this->dir_base;
		if(empty($_FILES[$name]))
		{
			$this->error = '无文件上传';
			return false;
		}
		$file = $_FILES[$name];
		
		if(!is_array($_FILES[$name]['name']))
		{
			if(!empty($file["error"]))
			{
				$err = $this->uploadError($file["error"]);
				$this->error = $err;
				return false;
			}
			$hash_name = md5_file($file["tmp_name"]);
			$file_exts = explode('.',$file['name']);
			$file_ext = strtolower(end($file_exts));
			
			$dir = $this->getDir($hash_name);
	
			//查询是否已经存在该资源
			$criteria = new CDbCriteria;
			$criteria->addCondition('hash_code = "'.$hash_name.'"');
			$model = Files::model()->find($criteria);
			if(empty($model))
			{
				//echo $dir;
				if(!file_exists($dir))
				{
					mkdir($dir,0755,true);
				}
				if(move_uploaded_file($file["tmp_name"], $dir.'/'.$hash_name))
				{
					$model = new Files;
					$model->file_name = $file['name'];
					$model->file_type = $file['type'];
					$model->file_size = $file['size'];
					$model->file_extension = $file_ext;
					$model->hash_code = $hash_name;
					$model->ctime = time();
					$model->save();
				}
			}
			//var_dump($model);
			//$result = $model->getAttributes();
			$result[0]['id'] = $model->id;
			$result[0]['hash'] = $model->hash_code;
			$result[0]['name'] = $model->file_name;
			$result[0]['size'] = $model->file_size;
			$result[0]['type'] = $model->file_type;
			$result[0]['extension'] = $model->file_extension;

		}else{
			
			for($i=0; $i< count($file['name']);$i++)
			{
				if(!empty($file["error"][$i]))
				{
					$err = $this->uploadError($file["error"][$i]);
					$this->error = $err;
					return false;
				}
				$hash_name = md5_file($file["tmp_name"][$i]);
				$file_exts = explode('.',$file['name'][$i]);
				$file_ext = strtolower(end($file_exts));
				
				$dir = $this->getDir($hash_name);
	
				//查询是否已经存在该资源
				$criteria = new CDbCriteria;
				$criteria->addCondition('hash_code = "'.$hash_name.'"');
				$model = Files::model()->find($criteria);
				if(empty($model))
				{
					//echo $dir;
					if(!file_exists($dir))
					{
						mkdir($dir,0755,true);
					}
					if(move_uploaded_file($file["tmp_name"][$i], $dir.'/'.$hash_name))
					{
						$model = new Files;
						$model->file_name = $file['name'][$i];
						$model->file_type = $file['type'][$i];
						$model->file_size = $file['size'][$i];
						$model->file_extension = $file_ext;
						$model->hash_code = $hash_name;
						$model->ctime = time();
						$model->save();
					}
				}
				//var_dump($model);
				//$result = $model->getAttributes();
				$result[$i]['id'] = $model->id;
				$result[$i]['hash'] = $model->hash_code;
				$result[$i]['name'] = $model->file_name;
				$result[$i]['size'] = $model->file_size;
				$result[$i]['type'] = $model->file_type;
				$result[$i]['extension'] = $model->file_extension;

			}
			//pclose(popen("/home/xinchen/backend.php &", 'r'));
		}
		return $result;

	}


	public function download($hash,$name=''){ 

  		// Must be fresh start 
  		if( headers_sent() ) 
			die('Headers Sent'); 

		// Required for some browsers 
		if(ini_get('zlib.output_compression'))
			ini_set('zlib.output_compression', 'Off'); 

		//查询是否已经存在该资源
		$criteria = new CDbCriteria;
		$criteria->addCondition('hash_code = "'.$hash.'"');
		$model = Files::model()->find($criteria);


		$file = $this->getPath($hash);
		// File Exists? 
		if( file_exists($file) && !empty($model) ){ 
			// Parse Info / Get Extension
			//$fsize = filesize($file);
			//$path_parts = pathinfo($file); 
			//$ext = strtolower($path_parts["extension"]); 
			
			$fsize = $model->file_size;
			$ext = strtolower($model->file_extension);
			if(empty($name))
				$old_name = $model->file_name;
			else
				$old_name = $name;
			// Determine Content Type 
			switch ($ext) { 
				case "pdf": $ctype="application/pdf"; break; 
				case "exe": $ctype="application/octet-stream"; break; 
				case "zip": $ctype="application/zip"; break; 
				case "rar":	$ctype="application/octet-stream"; break;
				case "doc": $ctype="application/msword"; break; 
				case "xls": $ctype="application/vnd.ms-excel"; break; 
				case "ppt": $ctype="application/vnd.ms-powerpoint"; break; 
				case "gif": $ctype="image/gif"; break; 
				case "png": $ctype="image/png"; break; 
				case "jpeg": $ctype="image/jpeg"; break;
				case "jpg": $ctype="image/jpeg"; break; 
				default: $ctype="application/force-download"; 
			} 

			header("Pragma: public"); // required 
			header("Expires: 0"); 
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
			header("Cache-Control: private",false); // required for certain browsers 
			header("Content-Type: $ctype"); 
			//header("Content-Disposition: attachment; filename=\"".basename($file)."\";" ); 
			header("Content-Disposition: attachment; filename=\"".$old_name."\";" ); 
			header("Content-Transfer-Encoding: binary"); 
			header("Content-Length: ".$fsize); 
			ob_clean(); 
			flush(); 
			readfile( $file ); 

		}else
			die('File Not Found'); 
	}







	public function downloadById($id,$name='')
	{
		$result = $this->getById($id);
		if(!empty($result))
			$this->download($result['hash_code'],$name);
		else
			return false;
	}

	public function preUpload($hash)
	{
		//查询文件是否存在
		$criteria = new CDbCriteria;
		$criteria->addCondition('hash_code = "'.$hash.'"');
		$model = Files::model()->find($criteria);
		if(empty($model))
		{
			return false;
		}
		//$result = $model->getAttributes();
		$result['id'] = $model->id;
		$result['hash'] = $model->hash_code;
		$result['name'] = $model->file_name;
		$result['size'] = $model->file_size;
		$result['type'] = $model->file_type;
		$result['extension'] = $model->file_extension;
		return $result;
	}





	public function get($hash)
	{
		//查询文件是否存在
		$criteria = new CDbCriteria;
		$criteria->addCondition('hash_code = "'.$hash.'"');
		$model = Files::model()->find($criteria);
		if(empty($model))
		{
			return false;
		}
		//$result = $model->getAttributes();
		$result['id'] = $model->id;
		$result['hash'] = $model->hash_code;
		$result['name'] = $model->file_name;
		$result['size'] = $model->file_size;
		$result['type'] = $model->file_type;
		$result['extension'] = $model->file_extension;
		return $result;
	}






	protected function getImageThumbDir($hash)
	{
		$dirs = str_split($hash,2);
		$dir = '';
		if($this->dir_level)
		{
			for($i=0;$i<$this->dir_level;$i++)
			{
				$dir = $dir.'/'.$dirs[$i];
			}
		}
		$dir_full = $this->dir_thumb_root.$dir.'/'.$hash;

		return $dir_full;
	}


	private function resizeImage($hash,$ext,$width,$height,$cut)
	{
		//查询是否已经存在该资源
		$criteria = new CDbCriteria;
		$criteria->addCondition('hash_code = "'.$hash.'"');
		$model = Files::model()->find($criteria);
		if(empty($model))
		{
			$this->error = '数据库查询为空';
			throw new CHttpException(404,'此页面不存在');
			return false;
		}



		//加载源文件，生成新文件
		$file = $this->getPath($hash);
		if(!file_exists($file))
		{
			$this->error = '源文件不存在';
			throw new CHttpException(404,'此页面不存在');
			return false;
		}
		$file_type = strtolower($model->file_extension);
	    if($file_type == "jpg"|| $file_type == "jpeg"| $file_type == "jpe")
	    {
	        $new_image = imagecreatefromjpeg($file);
	    }
	    if($file_type == "gif")
	    {
	        $new_image = imagecreatefromgif($file);
	    }
	    if($file_type == "png")
	    {
	        $new_image = imagecreatefrompng($file);
	    }


		$src_width = imagesx($new_image);
		$src_height = imagesy($new_image);

		//生成图象
		//实际图象的比例
		$ratio = ($src_width)/($src_height);

		if(!empty($width) && !empty($height))
		{
			//新输出的图片尺寸
			$resize_ratio = ($width)/($height);

			//裁图
			if($cut)
			{
				if($ratio>=$resize_ratio)//高度优先
				{

					switch($cut)
					{
						case 'left':
							$begin_width = 0;	//左边截取
							$thumb = imagecreatetruecolor($width,$height);
							imagecopyresampled($thumb, $new_image, 0, 0, $begin_width, 0, $width,$height, ($src_height*$resize_ratio), $src_height);
							break;

						case 'right':
							$begin_width = $src_width - $src_height*$resize_ratio;	//右边截取
							$thumb = imagecreatetruecolor($width,$height);
							imagecopyresampled($thumb, $new_image, 0, 0, $begin_width, 0, $width,$height, $src_height*$resize_ratio, $src_height);
							break;

						default:
							$begin_width = ($src_width - ($src_height * $resize_ratio))/2;	//居中截取
							$thumb = imagecreatetruecolor($width,$height);
							imagecopyresampled($thumb, $new_image, 0, 0, $begin_width, 0, $width,$height, (($src_height)*$resize_ratio), $src_height);
					}
				}else{//宽度优先

					switch($cut)
					{
						case 'top':
							$begin_height = 0;	//从头部开始截取
							$thumb = imagecreatetruecolor($width,$height);
							imagecopyresampled($thumb, $new_image, 0, 0, 0, $begin_height, $width, $height, $src_width, ($src_width/$resize_ratio));
							break;

						case 'bottom':
							$begin_height = $src_height - $src_width/$resize_ratio;	//底部截取
							$thumb = imagecreatetruecolor($width,$height);
							imagecopyresampled($thumb, $new_image, 0, 0, 0, $begin_height, $width, $height, $src_width, $src_width/$resize_ratio);
							break;

						default:
							$begin_height = ($src_height - ($src_width / $resize_ratio))/2;	//居中截取
							$thumb = imagecreatetruecolor($width,$height);
							imagecopyresampled($thumb, $new_image, 0, 0, 0, $begin_height, $width, $height, $src_width, ($src_width/$resize_ratio));
					}
				}


			}else{//填补
				$thumb = imagecreatetruecolor($width,$height);
				
				//填补黑色
				//$thumb = imagecolorallocate($thumb,0,0,0);
				//填补白色(有问题 待解决)
				//$thumb = imagecolorallocate($thumb,255,255,255);

				if($ratio>=$resize_ratio)
				{
					$begin_height = ($height - ($width / $ratio))/2;	//新图补高度
					imagecopyresampled($thumb, $new_image, 0, $begin_height, 0, 0, $width, ($width)/$ratio, $src_width, $src_height);
				}else{
					$begin_width = ($width - ($height * $ratio))/2;	//居中截取
					imagecopyresampled($thumb, $new_image, $begin_width, 0, 0, 0, ($height)*$ratio, $height, $src_width, $src_height);
				}
			}
		}else{
			//只限定一边尺寸，原比例输出
			if(!empty($width))
			{
				$thumb = imagecreatetruecolor($width,($width)/$ratio);
				imagecopyresampled($thumb, $new_image, 0, 0, 0, 0, $width, ($width)/$ratio, $src_width, $src_height);
			}else{
	            $thumb = imagecreatetruecolor(($height)*$ratio,$height);
	            imagecopyresampled($thumb, $new_image, 0, 0, 0, 0, ($height)*$ratio, $height, $src_width, $src_height);
			}
		}

		//return $thumb;
		//ImageJpeg($thumb,$this->dstimg);
		//ImageJpeg($thumb,null,75);//以75%质量输出
	//	ImageJpeg($thumb);
		//imagepng() - 以 PNG 格式将图像输出到浏览器或文件
		//imagegif() - 输出图象到浏览器或文件
		//imagewbmp() 


		//保存新文件
		$thumb_dir = $this->getImageThumbDir($hash);
		if(!file_exists($thumb_dir))
		{
			mkdir($thumb_dir,0755,true);
		}
		//缩略图路径
		if($cut)
			$file_name = 'w-'.$width.'_h-'.$height.'_c-'.$cut.'.'.$ext;
		else
			$file_name = 'w-'.$width.'_h-'.$height.'.'.$ext;
		$thumb_file = $thumb_dir.'/'.$file_name;
	    
		if($ext=="jpg"||$ext=="jpeg"||$ext="jpe")
		{
			ImageJpeg($thumb,$thumb_file);
		}
	    if($ext=="gif")
		{
			imagegif($thumb,$thumb_file);
		}
	    if($ext=="png")
		{
			imagepng($thumb,$thumb_file);
		}
		
		ImageDestroy ($new_image);//释放与 image 关联的内存
	}











	public function renderImage($hash,$ext,$width=0,$height=0,$cut=false)
	{

		//获取原始图片。直接取原图，可能存在输出格式与索取格式不匹配问题
		if(empty($width) && empty($height))
		{
			$file = $this->getPath($hash);
			//echo $file;die();
			if(file_exists($file))
			{
			//	echo fread(fopen($file,'rb'),filesize($file));
				$this->renderHeader($ext);
				readfile( $file ); 
				return true;
			}else{
				$this->error = 'file not exist';
				throw new CHttpException(404,'此页面不存在');
				return false;
			}
		}

		//获取缩略图
		if($cut)
			$file_name = 'w-'.$width.'_h-'.$height.'_c-'.$cut.'.'.$ext;
		else
			$file_name = 'w-'.$width.'_h-'.$height.'.'.$ext;
		
		$thumb_dir = $this->getImageThumbDir($hash);

		$thumb_file = $thumb_dir.'/'.$file_name;
		
		if(!file_exists($thumb_file))
		{
			$this->resizeImage($hash,$ext,$width,$height,$cut);
		}
		//echo fread(fopen($thumb_file,'rb'),filesize($thumb_file));
		$this->renderHeader($ext);
		readfile($thumb_file);
		return true;
	}


	public function renderHeader($ext)
	{
		if($ext=="jpg" || $ext=="jpe" || $ext=="jpeg")
	    {
			header('Content-Type: image/jpeg');
	    }
	    if($ext=="gif")
	    {
			header('Content-Type: image/gif');
	    }
	    if($ext=="png")
	    {
			header('Content-Type: image/png');
	    }	
	}

	public static function getFileInfo($hash)
	{
		if(empty($hash))
			return false;
		$criteria = new CDbCriteria;
		$criteria->addCondition('hash_code',$hash);
		$file = Files::Model()->find($criteria);
		if(!empty($file))
			return $file->attributes;
		else
			return false;
	}


	public static function getImageUrl($hash,$width=0,$height=0,$cut=false,$encrypt=false)
	{
		if(empty($hash))
			return false;
		
		$url[] = '/images/';
		if($encrypt)
		{
			$url[] = 'b64_';
			$ourl[] = $hash;
			if(!empty($width))
				$ourl[] = '_w-'.$width;
			if(!empty($height))
				$ourl[] = '_h-'.$height;
			if(!empty($cut))
				$ourl[] = '_c-'.$cut;
		
			$url[] = self::encrypt(implode('',$ourl));
		}else{
			$url[] = $hash;
			if(!empty($width))
				$url[] = '_w-'.$width;
			if(!empty($height))
				$url[] = '_h-'.$height;
			if(!empty($cut))
				$url[] = '_c-'.$cut;
		}

		$url[] = '.jpg';
		return implode('',$url);
	}

	public static function getImageEncryptUrl($hash,$width=0,$height=0,$cut=false)
	{
		if(empty($hash))
			return false;
		$url[] = '/images/';
		$url[] = 'b64_';

		$ourl[] = $hash;
		if(!empty($width))
			$ourl[] = '_w-'.$width;
		if(!empty($height))
			$ourl[] = '_h-'.$height;
		if(!empty($cut))
			$ourl[] = '_c-'.$cut;

		$url[] = self::encrypt(implode('',$ourl));
		$url[] = '.jpg';
		return implode('',$url);
	}

	private static function encrypt($input=null)
	{
		if($input===null)
			return false;
		$key = self::MKEY;

   		$td = mcrypt_module_open('tripledes', '', 'ecb', '');
    	$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    	mcrypt_generic_init($td, $key, $iv);
    	$encrypted_data = mcrypt_generic($td, $input);
    	mcrypt_generic_deinit($td);
    	mcrypt_module_close($td);
		//return $encrypted_data;
		return self::url_base64_encode($encrypted_data);
	}

	public static function decrypt($input=null)
	{
		if($input===null)
			return false;
		$input = self::url_base64_decode($input);
		$key = self::MKEY;

   		$td = mcrypt_module_open('tripledes', '', 'ecb', '');
    	$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    	mcrypt_generic_init($td, $key, $iv);
    	$encrypted_data = mdecrypt_generic($td, $input);
    	mcrypt_generic_deinit($td);
    	mcrypt_module_close($td);
		return trim($encrypted_data);
	}
	private static function url_base64_encode($string)
	{
		$data = base64_encode($string);
		$data = str_replace(array('+','/','='),array('-','_',''),$data);
		return $data;
	}
	private static function url_base64_decode($string)
	{
		$data = str_replace(array('-','_'),array('+','/'),$string);
		$mod4 = strlen($data) % 4;
		if ($mod4) {
			$data .= substr('====', $mod4);
		}
		return base64_decode($data);
	}

	public function getById($id){
        $result = Files::Model()->findByPk($id);
        return $result;
    }

	public function getByHash($hash){
        $criteria = new CDbCriteria;
		$criteria->addCondition('hash_code = "'.$hash.'"');
        $result = Files::Model()->find($criteria);
        return $result;
    }

   /**
    * 根据id获取images
    */
    public function getListByIds($ids){
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id',$ids);
        $result = Files::Model()->findAll($criteria);
        return $result;
    }

}
?>
