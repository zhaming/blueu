BlueU客户端接口文档
========================

文档版本: *v_14-03-22-1*  
接口协议: *http*  
报文格式: *json*  
报文编码: *utf-8*  
正式接口: *待发布*  
测试接口: *mocky.shifang.info*  



接口名                | 地址          | 类型   | 接口情况  | 描述  
-------------------- | ------------- | ----- | -------: |---------  
[商户信息](#merchant) | /api/merchant | GET   | wip      | 获取商户  
[广告列表](#ad)       | /api/ad       | GET   | wip      | 获取广告  
[提交用户](#user)     | /api/user     | PSOT  | wip      | 上传用户  


## 约定  
接口报文默认外层始终有且至少有error_code和error_msg字段, 分别为状态码和状态消息.  
1.接口访问正常情况, error_code始终返回0; 错误的时候返回非0, 视服务端情况为准;  
2.error_msg字段返回接口访问情况信息, 如果出错, 服务端会返回错误情况, 供客户端酌情使用;  
3.如果服务端状态正常,并且需要返回数据, 将数据报文放入data字段, 不需要返回时或访问失败, 服务端不保持该字段;  

示例1, 接口访问成功, 服务端不带数据:  
<pre>
{
  "error_code":0,
  "error_msg":"success"
}
</pre>

示例2, 接口访问失败:  
<pre>
{
  "error_code":101,
  "error_msg":"用户没有权限访问"
}
</pre>

示例3, 服务端返回单条数据:  
<pre>
{
  "error_code":0,
  "error_msg":"success",
  "data":{
    "id":1
    "name":"name"
  }
}
</pre>

示例4, 服务端返回多组数据:  
<pre>
{
  "error_code":0,
  "error_msg":"success",
  "data":[{
    "id":1
    "name":"name"
  },{
    "id":2
    "name":"name2"
  }]
}
</pre>

示例5, 服务端返回多组字典数据:  
<pre>
{
  "error_code":0,
  "error_msg":"success",
  "data":{
      "user":{
        "id":1
        "name":"name"
      },
      "privilege":{
        "id":2
        "name":"name2"
      }
    }
}
</pre>


## 商户信息  {#merchant}  
地址：/api/merchant

###接口输入

提交方式：GET

参数名  | 必填  | 类型   | 示例        | 说明  
-------|------|--------|------------|------  
blueid | 是   | string | 0000000002 | BlueU设备识别码  

完整参数示例:
<pre>
	curl http://apiserver?blueid=0000000002
</pre>

###接口输出

参数名      | 必有 | 类型   | 示例  | 说明  
---------- | --- | ------ | ----- |----  
error_code | 是  | int    | 见示例 | 状态码  
error_msg  | 是  | string | 见示例 | 状态消息  
data     | 是  | array  | 见示例 | 返回数据  

####data数据说明
参数名               | 必有 | 类型    | 示例 | 说明
--------------------|------|--------|-----|------
id                  | 是   | string | 见示例 | 商户编号 
name                | 是   | string | 见示例 | 商户名称 
describ             | 是   | string | 见示例 | 店铺描述 
pic                 | 是   | string | 见示例 | 店铺图片  
url                 | 是   | string | 见示例 | 商铺网址  
positionX           | 是   | string | 见示例 | 基站坐标X  
positionY           | 是   | string | 见示例 | 基站坐标Y  


示例:  
<pre>
{
    "errcode":0,
    "errmsg":"success",
    "data":{
        "id":"2",
        "name":"大蓝咖啡纺织高专店",
        "describ":"大蓝咖啡纺织高专店",
        "pic":"/images/asdasdsadsd.jpg",
        "url":"http://www.baidu.com/",
        "positionX": "1",
        "positionY": "2"
    }
}
</pre>

<pre>
{
  "error_code":1,
  "error_msg":"设备不存在"
}
</pre>


## 广告列表  {#ad}
地址：/api/ad  

###接口输入

提交方式：GET

参数名    | 必填 | 类型    | 示例    | 说明  
---------|------|--------|--------|------  
merid    | 是   | string | 2      | 商户编号  

完整参数示例:
<pre>
	curl http://apiserver?merid=0000000002
</pre>

###接口输出

参数名      | 必有 | 类型   | 示例  | 说明  
---------- | ---- | ------ | ----- |----  
error_code | 是   | int    | 见示例 | 返回数据  
error_msg  | 是   | string | 见示例 | 返回数据  
data     | 是   | array  | 见示例 | 返回数据  

####data数据说明
参数名               | 必有 | 类型    | 示例 | 说明
--------------------|------|--------|-----|------
id                  | 是   | string | 见示例 | 广告编号 
name                | 是   | string | 见示例 | 广告内容 
pic                 | 是   | string | 见示例 | 广告图片  


示例: 
<pre>
{
    "errcode": 0,
    "errmsg": "success",
    "data": [{
        "id": "1",
        "name": "全场7.5折",
        "pic": "/images/asdasdsdasdasdasd.jpg"
    }, {
        "id": "2",
        "name": "清明买就送",
        "pic": "/images/zxczxczcxcxzx.jpg"
    }]
}
</pre>


## 提交用户  {#user}
地址：/api/user

###接口输入

提交方式：POST

参数名  | 必填  | 类型   | 示例        | 说明  
-------|------|--------|------------|------  
blueid | 是   | string | 0000000002 | BlueU设备识别码  
name   | 是   | string | 见示例      | 商户名称 

完整参数示例:
<pre>
    curl -d "blueid=0000000002&name=test" http://apiserver
</pre>

###接口输出

参数名      | 必有 | 类型   | 示例  | 说明  
---------- | ---- | ------ | ----- |----  
error_code | 是   | int    | 见示例 | 返回数据  
error_msg  | 是   | string | 见示例 | 返回数据  

<pre>
{
  "error_code":0,
  "error_msg":"success"
}
</pre>







