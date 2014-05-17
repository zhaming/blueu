<?php

/*
 *	日志模块 Class
 *	author	yanxf <walkfine@gmail.com>
 */

class LogComponent{
	public static function visitor($type=null)
	{
		if(empty($type))
		{
			if(strpos($_SERVER['REQUEST_URI'],'admin') !== false)
				$type = 'admin';
			if(strpos($_SERVER['REQUEST_URI'],'interface') !== false)
				$type = 'interface';
			if(strpos($_SERVER['REQUEST_URI'],'images') !== false)
				$type = 'images';
			if(strpos($_SERVER['REQUEST_URI'],'download') !== false)
				$type = 'download';
		}
		if($type=="images")
			return true;
		$visitor = new LogVisitor();
		$visitor->url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		//$visitor->hash =  ParseUrl::hash($visitor->url);
		//$user = UserBehavior::getCurrentUser();
		if(!empty($user))
			$visitor->uid = $user['id'];
		if(!empty($_SERVER['HTTP_USER_AGENT']))
			$visitor->user_agent = $_SERVER['HTTP_USER_AGENT'];
		if(!empty($_SERVER['HTTP_REFERER']))
			$visitor->referer = $_SERVER['HTTP_REFERER'];
		$visitor->vip = $_SERVER['REMOTE_ADDR'];
		
		if(!empty($type))
			$visitor->type = $type;
		$visitor->ctime = time();
		return $visitor->save();
	}
}
?>
