<?php
/**
 *	网站参数
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

return array(
    'host' => 'http://blueu2.dev/',
    'url_web' => 'statics/',
    
    'appid' => '2674298',
    'apikey' => 'Tp3bIrUoG13eoE5GvwVRcI9W',
    'secretkey' => 'ItaHRAXueuTwYPANjLtNcA4mRObGoi1e',
    'pem_dev' => '/../statics/assets/APNs-dev.pem',
    'pem_pro' => '/../statics/assets/APNs-pro.pem',
    'message_type' => 1,
    'deployed' => false,
    'pushCmd' => '/usr/bin/php %s/console.php push %s %s',
    'statCmd' => '/usr/bin/php %s/console.php stat %s',
    
	'title' => '蓝友寻宝',
	'title_separator' => '-',
	'meta_keywords' => '手机客户端精准推广',
	'meta_description' => '国内领先的基于蓝牙4.0技术推广平台',
	'icpnumber' => '蜀ICP备14008870号',
	'netpaynumber' => '蜀ICP备14008870号',
	'copyright' => '版权所有',
    'page_size' => 20,
);