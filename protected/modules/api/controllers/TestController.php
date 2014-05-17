<?php
class TestController extends TController
{
    public function actionIndex()
    {
        $url = 'http://jiuxiao.dev/api/project/test';

    	$params['user'] = "test@test.com";
    	$params['passwd'] = '123456';
		//$params['media'] = "@/Users/daoser/Sites/yii/jiuxiao/statics/images/404logo.png";
		if (version_compare(phpversion(), '5.5.0', '<')) {
			$params['media'] = "@/Users/daoser/Sites/yii/jiuxiao/statics/images/404logo.png";
		}else{
			//$params['media'] = new CurlFile('/Users/daoser/Sites/yii/jiuxiao/statics/images/404logo.png', 'image/png', '404logo2.png');
		}

    $this->post($url,$params,'POST');
       	//$this->post($url,json_encode($params),'post');	
       	//$this->post($url,'1,2,3,4,5,4,54','post');	
       	//文件不方便打包，所以还是采用原始数据提交方式；不使用json
    }

    public function actionLogin()
    {
    	$url = 'http://jiuxiao.dev/api/user/login';
      $url = 'http://jiuxiao.wanthings.com/api/user/login';

    	echo '<p style="color:red">密码错误</p>';
    	$params['user'] = "test@test.com";
    	$params['passwd'] = '1234562';
       	$this->post($url,JsonTools::json_encode_cn($params),'POST'); 

    	echo '<p style="color:red">账号错误</p>';
    	$params['user'] = "test2@test.com";
    	$params['passwd'] = '1234562';
       	$this->post($url,JsonTools::json_encode_cn($params),'POST'); 

        echo '<p style="color:red">正确密码</p>';
      $params['user'] = "test@test.com";
      $params['passwd'] = '123456';

      $result = $this->post($url,JsonTools::json_encode_cn($params),'POST');
      $result = CJSON::decode($result);
      Config::model()->set('token',$result['data']['token']);
    }

    public function actionUserProject()
    {
    	$url = 'http://jiuxiao.dev/api/user/project';
      $url = 'http://jiuxiao.wanthings.com/api/user/project';

    	echo '<p style="color:red">token错误</p>';
    	$url = 'http://jiuxiao.dev/api/user/project?token=hj0hfre82ft7lnggofuj1i46';
      $this->post($url,'','GET');

    	echo '<p style="color:red">token正确 方法错误</p>';
      $url = 'http://jiuxiao.dev/api/user/project?token='.Config::model()->get('token');
      $this->post($url,'','POST'); 


      echo '<p style="color:red">token正确 方法正确</p>';
      $url = 'http://jiuxiao.dev/api/user/project?token='.Config::model()->get('token');
      $this->post($url,'','GET'); 
    }


    public function actionProjectList()
    {
      $token = Config::model()->get('token');
      $url = 'http://jiuxiao.dev/api/project/list?project_id=1&token='.$token;

      echo '<p style="color:red">正确提交</p>';
      $this->post($url,'','GET');


      $url = 'http://jiuxiao.dev/api/project/list?project_id=2&token='.$token;

      echo '<p style="color:red">项目没有文件</p>';
      $this->post($url,'','GET');


      $url = 'http://jiuxiao.dev/api/project/list?project_id=4000&token='.$token;

      echo '<p style="color:red">没有项目</p>';
      $this->post($url,'','GET');
    }


    public function actionProject_file()
    {
      $token = Config::model()->get('token');
      $url = 'http://jiuxiao.dev/api/project/file?doc_id=4&token='.$token;

      echo '<p style="color:red">正确提交</p>';
      $this->post($url,'','GET');
    }

    public function actionProject_upload()
    {
      $token = Config::model()->get('token');
      $url = 'http://jiuxiao.dev/api/project/file?doc_id=4&token='.$token;

      echo '<p style="color:red">正确提交</p>';
      $url = 'http://jiuxiao.dev/api/project/file?token='.$token;
      if (version_compare(phpversion(), '5.5.0', '<')) {
        $params['file'] = "@/Users/daoser/Sites/yii/jiuxiao/statics/images/404logo.png";
      }else{
        //$params['file'] = new CurlFile('/Users/daoser/Sites/yii/jiuxiao/statics/images/404logo.png', 'image/png', '404logo2.png');
      }
      $this->post($url,$params,'POST');
    }

    public function actionProject_delete()
    {
      $token = Config::model()->get('token');


      echo '<p style="color:red">错误提交，不存在的文件</p>';
      $url = 'http://jiuxiao.dev/api/project/file?doc_id=700000&token='.$token;
      $this->post($url,'','DELETE');

      echo '<p style="color:red">正确提交</p>';
      $url = 'http://jiuxiao.dev/api/project/file?doc_id=2&token='.$token;
      $this->post($url,'','DELETE');

      echo '<p style="color:red">正确提交</p>';
      $url = 'http://jiuxiao.dev/api/project/file?doc_id=3&token='.$token;
      $this->post($url,'','DELETE');
    }

    public function actionProject_put()
    {
      $token = Config::model()->get('token');

      echo '<p style="color:red">新上传错误提交，没有上传文件</p>';
      $params['hash']='507e62961cd9595829614c5564358935';
      $params['path']='基本综合资料/股权结构';
      $params['project_id']='1';
      $url = 'http://jiuxiao.dev/api/project/file?token='.$token;
      $this->post($url,JsonTools::json_encode_cn($params),'PUT');

      echo '<p style="color:red">新上传错误提交，没有对应项目</p>';
      $params['hash']='507e62961cd9595829614c5564358934';
      $params['project_id']='10000';
      $params['path']='基本综合资料/股权结构';
      $url = 'http://jiuxiao.dev/api/project/file?token='.$token;
      $this->post($url,JsonTools::json_encode_cn($params),'PUT');

      echo '<p style="color:red">新上传正确提交</p>';
      $params['hash']='507e62961cd9595829614c5564358934';
      $params['project_id']='1';
      $params['path']='基本综合资料/股权结构';
      $url = 'http://jiuxiao.dev/api/project/file?token='.$token;
      $this->post($url,JsonTools::json_encode_cn($params),'PUT');




      echo '<p style="color:red">上传新版本错误提交，缺少参数</p>';
      $params['hash']='507e62961cd9595829614c5564358934';
      $params['version']='1';
      $url = 'http://jiuxiao.dev/api/project/file?doc_id=1&token='.$token;
      $this->post($url,JsonTools::json_encode_cn($params),'PUT');


      echo '<p style="color:red">上传新版本错误提交，版本错误</p>';
      $params['hash']='507e62961cd9595829614c5564358934';
      $params['version']='10';
      $params['comment']='测试提交版本';
      $url = 'http://jiuxiao.dev/api/project/file?doc_id=1&token='.$token;
      $this->post($url,JsonTools::json_encode_cn($params),'PUT');



      echo '<p style="color:red">上传新版本错误提交，不存在文件</p>';
      $params['hash']='507e62961cd9595829614c5564358935';
      $params['version']='0';
      $params['comment']='测试提交版本';
      $url = 'http://jiuxiao.dev/api/project/file?doc_id=1&token='.$token;
      $this->post($url,JsonTools::json_encode_cn($params),'PUT');

      echo '<p style="color:red">上传新版本正确提交</p>';
      $params['hash']='507e62961cd9595829614c5564358934';
      $params['version']='0';
      $params['comment']='测试提交版本';
      $url = 'http://jiuxiao.dev/api/project/file?doc_id=1&token='.$token;
      $this->post($url,JsonTools::json_encode_cn($params),'PUT');
    }




    public function actionProject_history()
    {
      $token = Config::model()->get('token');

      echo '<p style="color:red">错误提交，不存在的文件</p>';
      $url = 'http://jiuxiao.dev/api/project/history?doc_id=700000&token='.$token;
      $this->post($url,'','GET');

      echo '<p style="color:red">正确提交</p>';
      $url = 'http://jiuxiao.dev/api/project/history?doc_id=1&token='.$token;
      $this->post($url,'','GET');

    }


    public function actionComment()
    {
      $token = Config::model()->get('token');

      echo '<p style="color:red">错误提交，不存在的文件</p>';
      $url = 'http://jiuxiao.dev/api/project/comment?doc_id=7000&token='.$token;
      $params['content']='测试提交版本';
      $this->post($url,JsonTools::json_encode_cn($params),'POST');


      echo '<p style="color:red">正确提交</p>';
      $url = 'http://jiuxiao.dev/api/project/comment?doc_id=1&token='.$token;
      $params['content']='测试提交版本';
      $this->post($url,JsonTools::json_encode_cn($params),'POST');

      echo '<p style="color:red">获取评论</p>';
      $url = 'http://jiuxiao.dev/api/project/comment?doc_id=1&token='.$token;
      $this->post($url,'','GET');

    }
    public function actionRule()
    {
      $token = Config::model()->get('token');

      echo '<p style="color:red">正确提交</p>';
      $url = 'http://jiuxiao.dev/api/project/rule?doc_id=1&token='.$token;
      $temp['agency_category'] = 1;
      $temp['type'] = 6;
      $params[] = $temp;

      $temp['agency_category'] = 2;
      $temp['type'] = 4;
      $params[] = $temp;

      $temp['agency_category'] = 3;
      $temp['type'] = 6;
      $params[] = $temp;

      $this->post($url,JsonTools::json_encode_cn($params),'PUT');



    }
}
?>
