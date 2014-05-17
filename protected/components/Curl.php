<?php
/*
	author yanxf
*/
class Curl
{
	public $error;

	public static function post($url,$data=null,$method=null,$type=null)
	{
	//	session_start();
	//	$sid = session_id();
	//	$ckfilename = dirname(__FILE__).'/../../assets/cookie_'.$sid;
	//	$headers = SMS::mkheader();
		$ch = curl_init();
		// 2. 设置选项，包括URL
	//	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	//	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
		if(!empty($type) && $type=='xml')
		{
			$header[] = 'Content-type: text/xml';//定义content-type为xml 
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		if(!empty($method))
		{
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method)); //设置请求方式
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		if(strpos($url,'https') !== false)
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
		}

	//	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:9.0.1) Gecko/20100101 Firefox/9.0.1'); // 模拟用户使用的浏览器
	//	curl_setopt($ch, CURLOPT_REFERER, 'http://www.scjj.gov.cn:8635/login.aspx'); // referer

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);// 获取的信息以文件流的形式返回
	//	curl_setopt($ch, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
	//	if(!file_exists ($ckfilename))
	//		curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfilename); // 存放Cookie信息的文件名称
	//	curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfilename); // 读取上面所储存的Cookie信息

		if(!empty($data))
		{
			//记录报文
		//	$this->logPackets($data,2,$url);

			curl_setopt($ch, CURLOPT_POST, 1); // 发送一个常规的Post请求
			//echo $data;
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
		}
		//curl_setopt($ch,CURLOPT_WRITEHEADER, $headerfilename); //	 设置header部分内容的写入的文件地址，值是一个资源类型
		// 3. 执行并获取HTML文档内容
		$result['content'] = curl_exec($ch);
		
		// 检查是否有错误发生
		if(curl_errno($ch))
		{
		    //echo 'Curl error: ' . curl_error($ch);
			return false;
		}
		$result['info'] = curl_getinfo($ch);
/*
$info 数组结构
"url"
"content_type"
"http_code"
"header_size"
"request_size"
"filetime"
"ssl_verify_result"
"redirect_count"
"total_time"
"namelookup_time"
"connect_time"
"pretransfer_time"
"size_upload"
"size_download"
"speed_download"
"speed_upload"
"download_content_length"
"upload_content_length"
"starttransfer_time"
"redirect_time"
*/
		// 4. 释放curl句柄
		curl_close($ch);

	//	$fp = fopen(dirname(__FILE__).'/../../assets/log_'.$sid,'ab');
	//	fwrite($fp,$output.'\r\r\r\r\r');
	//	fclose($fp);

		return $result;
	}
}
