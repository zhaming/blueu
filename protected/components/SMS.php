<?php

/*
 *	短信模块 Class
 *	author	yanxf <walkfine@gmail.com>
 *	version	sms_1.0
 */

class SMS{
	public static function send($content,$number='18608032904')
	{
		if(empty($content))
			return false;
		$url = 'http://sms.daoser.com/sms/send/message/'.urlencode($content).'/phone/'.$number;
		return SMS::get($url);
	}


	protected static function mkheader()
	{
		$headers = array(
			'Host: erp.wanthings.com',
			'Connection: keep-alive',
			'Cache-Control: no-cache',
			'Pragma: no-cache',
			'User-Agent: Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4',
			'Accept: image/png,image/*;q=0.8,*/*;q=0.5',
			'Referer: http://www.scjj.gov.cn:8635/',
			'Accept-Encoding: gzip,deflate,sdch',
			'Accept-Language: en-US,en;q=0.8,zh-CN;q=0.6,zh;q=0.4',
			'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.3',
//			'Cookie: ASP.NET_SessionId=usvzvwrp2qkwo3ejd5miwq45'
		);
		return $headers;
	}

	protected static function get($url,$data=null)
	{
	//	session_start();
	//	$sid = session_id();
	//	$ckfilename = dirname(__FILE__).'/../../assets/cookie_'.$sid;
	//	$headers = SMS::mkheader();
		$ch = curl_init();
		// 2. 设置选项，包括URL
	//	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	//	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
		curl_setopt($ch, CURLOPT_URL, $url);

	//	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:9.0.1) Gecko/20100101 Firefox/9.0.1'); // 模拟用户使用的浏览器
	//	curl_setopt($ch, CURLOPT_REFERER, 'http://www.scjj.gov.cn:8635/login.aspx'); // referer

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);// 获取的信息以文件流的形式返回
	//	curl_setopt($ch, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
	//	if(!file_exists ($ckfilename))
	//		curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfilename); // 存放Cookie信息的文件名称
	//	curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfilename); // 读取上面所储存的Cookie信息

		if(!empty($data))
		{
			curl_setopt($ch, CURLOPT_POST, 1); // 发送一个常规的Post请求
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
		}

		// 3. 执行并获取HTML文档内容
		$output = curl_exec($ch);
		// 4. 释放curl句柄
		curl_close($ch);

	//	$fp = fopen(dirname(__FILE__).'/../../assets/log_'.$sid,'ab');
	//	fwrite($fp,$output.'\r\r\r\r\r');
	//	fclose($fp);

		return $output;
	}


}
?>
