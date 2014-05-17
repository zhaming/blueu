<?php
class TController extends CController
{
    public $post_params = array();
    public $get_params = array();
    public $post_params_string = '';
    public $get_params_string = '';
    public $params = array(
        'post'=>array(),
        'get'=>array()
    );

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        $this->post_params_string = Yii::app()->request->getPost('params');
        $this->post_params = json_decode($this->post_params_string, true);
        $this->params['post'] = $this->post_params;
        $this->get_params_string = Yii::app()->request->getQuery('params');
        $this->get_params = json_decode($this->get_params_string, true);
        $this->params['get'] = $this->get_params;
        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false;
            }
        }
        return true;
    }


    /**
     * 获取get参数
     *
     * @param $name 键名
     * @param $default 默认值, 如果没有传入则返回null
     *
     * @return
     */
    public function getQuery($name, $default=null)
    {
        return isset($this->params['get'][$name]) ? $this->params['get'][$name] : $default;
    }

    /**
     * 获取post参数
     *
     * @param $name 键名
     * @param $default 默认值, 如果没有传入则返回null
     *
     * @return
     */
    public function getPost($name, $default=null)
    {
        return isset($this->params['post'][$name]) ? $this->params['post'][$name] : $default;
    }


    protected  function post($url,$data=null,$method=null)
    {
/*
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);// 获取的信息以文件流的形式返回

        if(!empty($data))
        {
            curl_setopt($ch, CURLOPT_POST, 1); // 发送一个常规的Post请求
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // 发送的数据
        }
*/
        $output = Curl::post($url,$data,$method);

        echo '<pre>';
        echo '请求地址:<br>';
        echo $url;
        echo '<br><br>请求方法:<br>';
        echo $method;
        echo '<br><br>参数:<br>';
        if(is_string($data))
            echo $data;
        if(is_array($data))
            print_r($data);
        echo '<br>返回报文：<br>';
        echo $output['content'];
        echo '<br><br>解析结果：<br>';
        print_r(CJSON::decode($output['content']));
        echo '</pre>';
        echo '====================================================================';
        return $output['content'];

    }

}

?>