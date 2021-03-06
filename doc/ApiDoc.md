BlueU客户端接口文档
========================

文档版本:*v0.1-14-05-19*  
接口协议:*http*  
报文格式:*json*  
报文编码:*utf-8*  
正式接口:*待发布*  
测试接口:*t.blueu.cn*  


接口名             |                 地址              |  类型
------------------ | --------------------------------- | --------
[用户注册](#api1)  |  /api/user/register               |  POST
[用户登录](#api2)  |  /api/user/login                  |  POST
[重置密码](#api3)  |  /api/user/resetpwd               |  POST
[用户登出](#api4)  |  /api/user/logout                 |  POST
[编辑资料](#api5)  |  /api/user/1/edit                 |  POST
[启用推送](#api6)  |  /api/user/1/push                 |  POST
[用户详情](#api7)  |  /api/user/1                      |  GET
[用户列表](#api8)  |  /api/users                       |  GET
[商户详情](#api9)  |  /api/merchant/1                  |  GET
[商户列表](#api10) |  /api/merchants                   |  GET
[广告列表](#api11) |  /api/advertisement/list          |  GET
[广告点击](#api12) |  /api/advertisement/click         |  POST
[到店状态](#api13) |  /api/push/toshop                 |  POST
[推送点击](#api14) |  /api/push/click                  |  POST
[商铺列表](#api15) |  /api/merchantshop/list           |  GET
[商铺详情](#api16) |  /api/merchantshop/detail         |  GET
[商品列表](#api17) |  /api/merchantshop/products       |  GET
[商品详情](#api18) |  /api/merchantshop/productdetail  |  GET
[基站广告](#api19) |  /api/advertisement/station       |  GET
[地图](#api20)     |  /api/map/detail                  |  POST
[意见反馈](#api21) |  /api/feedback/create             |  POST
[关注](#api22)     |  /api/user/like                   |  POST
[关注](#api23)     |  /api/user/like                   |  GET
[分享](#api24)     |  /api/user/share                  |  POST
[分享](#api25)     |  /api/user/share                  |  GET
[优惠券列表](#api26) |  /api/merchantcode/couponlist    |  GET
[优惠券获取](#api27) |  /api/merchantcode/getcoupon     |  POST
[印花列表](#api28)  |  /api/merchantcode/stamplist      |  GET
[印花获取](#api29)  |  /api/merchantcode/getstamp       |  GET
[搜索](#api30)     |  /api/search                      |  GET


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
 
 
 
## 用户注册 {#api1}
地址：/api/user/register

###接口输入

提交方式：POST

参数名   | 必填 |  类型  |       示例        | 说明
-------- | ---- | ------ | ----------------- | --------
username |  是  | string | zhansan@test.com  | 帐号
password |  是  | string | 123456            | 密码
name     |  是  | string | 张三              | 昵称
sex      |  否  |  int   |  0                | 0:保密 1:女 2:男
period   |  否  | string | 70                | 年代

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" -d '{"username":"zhansan@test.com","password":"123456","name":"张三"}' http://{domain}/api/user/register
</pre>

###接口输出

  参数名   | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |   int   | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"
}
</pre>


## 用户登录 {#api2}
地址：/api/user/login

###接口输入

提交方式：POST

参数名   | 必填 |   类型 |        示例      | 说明
-------- | ---- | ------ | ---------------- | -------
username |  是  | string | zhansan@test.com | 帐号
password |  是  | string | 123456           | 密码

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" -d '{"username":"zhansan@test.com","password":"123456"}' http://{domain}/api/user/login
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |   int   | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据
data       |  是  |   map   | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"，
    "data":{
        "token_id":"00320d40-89f8-4b28-d18e-fe12abefcf47"
    }
}
</pre>


## 重置密码 {#api3}
地址：/api/user/resetpwd

###接口输入

提交方式：POST

参数名      | 必填 |   类型 |    示例    |说明
----------- | ---- | ------ | ---------- | ------
password    |  是  | string | 123456     | 密码
newpassword |  是  | string | 1234567890 | 新密码

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" -H "X-Auth-Token:00320d40-89f8-4b28-d18e-fe12abefcf47" -d '{"password":"123456","newpassword":"1234567890"}' http://{domain}/api/user/resetpwd
</pre>

或者

<pre>
curl -X POST -H "Accept:application/json" -H "X-Auth-Username:zhangsan" -H "X-Auth-Password:zhangsan" -d '{"password":"123456","newpassword":"1234567890"}' http://{domain}/api/user/resetpwd
</pre>

###接口输出

参数名     | 必有 |  类型  |  示例  |  说明
---------- | ---- | ------ | ------ | --------
error_code |  是  |   int  | 见示例 | 返回数据
error_msg  |  是  | string | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"
}
</pre>


## 用户登出 {#api4}
地址：/api/user/logout

###接口输入

提交方式：POST

参数名    |  必填 |  类型  |       示例          说明
--------- | ----- | ------ | ---------------- | ------
username  |  是   | string | zhansan@test.com | 帐号  
password  |  是   | string | 123456           | 密码

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" -H "X-Auth-Token:00320d40-89f8-4b28-d18e-fe12abefcf47" -d '{"username":"zhansan@test.com","password":"123456"}' http://{domain}/api/user/logout
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |   int   | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"
}
</pre>


## 用户修改资料 {#api5}
地址：/api/user/1/edit

###接口输入

提交方式：POST

参数名 | 必填 |  类型   |  示例 |  说明
------ | ---- | ------- | ----- | --------
name   |  否  | string  |  张三 |  名称

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" -H "X-Auth-Token:00320d40-89f8-4b28-d18e-fe12abefcf47" -d '{"name":"张三"}' http://{domain}/api/user/1/edit
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"
}
</pre>


## 用户信息推送开关 {#api6}
地址：/api/user/1/push

###接口输入

提交方式：POST

参数名 | 必填 | 类型 | 示例 |  说明
------ | ---- | ---- | ---- | -----
enable |  是  | int  |   1  |是否开启

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" -H "X-Auth-Token:00320d40-89f8-4b28-d18e-fe12abefcf47" -d '{"enable":1}' http://{domain}/api/user/1/push
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"
}
</pre>


## 用户详情 {#api7}
地址：/api/user/1

###接口输入

提交方式：GET

参数名 | 必填 | 类型 | 示例 | 说明
------ | ---- | ---- | ---- | ----

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" http://{domain}/api/user/1
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据
data       |  是  |   map   | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success",
    "data":{ 
	    "id":"4",
	    "name":"王五",
	    "sex":"1",
	    "century":null,
        "mobile":null,
        "pushable":"1"
    }
}
</pre>



## 用户列表 {#api8}
地址：/api/users

###接口输入

提交方式：GET

查询参数

参数名   | 必填 |  类型 | 示例 |  说明
-------- | ---- | ----- | ---- | --------
page     |  否  |  int  |   1  |  当前页码
pagesize |  否  |  int  |   2  |  每页显示的数据条数

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" http://api.blueu.cn/api/users?page=1&pagesize=2
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |   int   | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据
data       |  是 |   map   | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success",
    "data":[{
	    "id":"5",
	    "name":"刘六",
	    "sex":"0",
	    "century":null,
	    "mobile":null,
	    "pushable":"1"
    },{
	    "id":"4",
	    "name":"王五",
	    "sex":"1",
	    "century":null,
	    "mobile":null,
	    "pushable":"1"
    }]
}
</pre>



## 商户详情 {#api9}
地址：/api/merchant/1

###接口输入

提交方式：GET

参数名 | 必填 | 类型 | 示例 | 说明
------ | ---- | ---- | ---- | ---- 

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" http://{domain}/api/merchant/1
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据
data       |  是  |   map   | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success",
    "data":{
    	"id":"8",
    	"name":"360",
    	"legal":null,
    	"telephone":"",
    	"bank":"",
    	"shopnum":"0"
    }
}
</pre>



## 商户列表 {#api10}
地址：/api/merchants

###接口输入

提交方式：GET

查询参数

参数名   | 必填 | 类型 |  示例 |  说明
-------- | ---- | ---- | ----- | --------
page     |  否  |  int |   1   | 当前页码
pagesize |  否  |  int |   2   | 每页显示的数据条数

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" http://{domain}/api/merchants?page=1&pagesize=2
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  | 说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据
data       |  是  |   map   | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success",
    "data":[{
    	"id":"9",
    	"name":"麻辣空间",
    	"legal":null,
    	"telephone":"",
    	"bank":"",
    	"shopnum":"0"
    },{
    	"id":"8",
    	"name":"360",
    	"legal":null,
    	"telephone":"",
    	"bank":"",
    	"shopnum":"0"
    }]
}
</pre>



## 广告列表 {#api11}
地址：/api/advertisement/list

###接口输入

提交方式：GET

参数名   | 必填| 类型 |  示例 | 说明
placetag | 是  |string|  top  | 广告位 top:上方 right:右侧
source   | 是  |string|  1    | 来源，1商铺 2商品 3优惠券 4印花 5信用卡优惠
page     | 否  |  int |   1   | 当前页码，默认1
pagesize | 否  |  int |   2   | 每页显示的数据条数

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" http://{domain}/api/advertisement/list
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据
data       |  是  |   map   | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success",
    "data":{
        "id":"8",
        "pic":"http://domain/upload/ad/123.jpg",
        "url":"http://www.baidu.com/",
        "source":"2",
        "sid":"123"
    }
}
</pre>



## 广告点击 {#api12}
地址：/api/advertisement/click

###接口输入

提交方式：POST

参数名 | 必填 | 类型  | 示例|  说明
------ | ---- | ----- | --- | -------
id     |  是  | int   |  6  | 广告ID

完整参数示例:
<pre>
    curl -X POST -H "Accept:application/json" -d '{"id":"6"}' http://{domain}/api/advertisement/click
</pre>

###接口输出

参数名     | 必有|   类型  |  示例  |  说明
---------- | --- | ------- | ------ | --------
error_code |  是 |   int   | 见示例 | 返回数据
error_msg  |  是 |  string | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"，
}
</pre>



## 到店状态 {#api13}
地址：/api/push/toshop

###接口输入

提交方式：POST

参数名   | 必填 |   类型 |   示例                              | 说明
-------- | ---- | ------ | ----------------------------------- | --------
userid   |  是  | int    | 6                                   | 用户ID
uuid     |  是  | string | 991CC36-C8DB-96DB-1A32-AB756C6BC5A9 | 密码
param    |  否  | string | {"distance":"7.00"}                 | 基站扩展信息
left     |  否  | int    | 1                                   | 是否离开 0否 1是

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" -d '{"userid":"2","uuid":"991CC36-C8DB-96DB-1A32-AB756C6BC5A9","left":"0"}' http://{domain}/api/push/toshop
</pre>

###接口输出

参数名     | 必有|   类型  |  示例  |  说明
---------- | --- | ------- | ------ | --------
error_code |  是 |   int   | 见示例 | 返回数据
error_msg  |  是 |  string | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"，
}
</pre>


## 推送点击 {#api14}
地址：/api/push/click

###接口输入

提交方式：POST

参数名   | 必填 | 类型 |示例|  说明
-------- | ---- | ---- | -- | --------
pushid   |  是  | int  | 6  | 推送ID

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" -d '{"pushid":"6"}' http://{domain}/api/push/click
</pre>

###接口输出

参数名     | 必有|   类型  |  示例  |  说明
---------- | --- | ------- | ------ | --------
error_code |  是 |   int   | 见示例 | 返回数据
error_msg  |  是 |  string | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"，
}
</pre>


##商铺列表{#api15}
地址 /api/merchantshop/list
###接口输入

提交方式：GET|POST

参数名     | 必填  | 类型  |    示例   | 说明
---------- | ----- | ----- | --------- | --------
merchantid | 否    |int    | 14        |商户ID
page       | 否    |int    | 1         | 页数 默认1
pagesize   | 否    |int    | 10        |每页条数 默认10
catid      | 否    | int   | 1         | 店铺分类ＩＤ，行业
districtid | 否    | int   | 1         | 商圈ＩＤ
order      | 否    | string| TIME_DESC | 排序。参数见说明

#### order 参数说明

参数         |  说明
-------------|-----------------
  TIME_DESC  | 按照创建时间倒序
  TIME_ASC   | 创建时间顺序
  SHOP_DESC  | 店铺ID倒序
  SHOP_ASC   | 店铺ＩＤ　顺序


完整参数示例:

<pre>
curl -X GET -H "Accept:application/json" http://{domain}/api/merchantshop/list?merchantid=19&page=1$&pagesize=10
</pre>

###接口输出

参数名     | 必有|   类型  |  示例  |  说明
---------- | --- | ------- | ------ | --------
error_code |  是 |  int    | 见示例 | 返回数据
error_msg  |  是 |  string | 见示例 | 返回数据
data       |  是 |   map   | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success",
    "data":[
        {"id":"8","merchantid":"14","name":"qwerq","owner":"qwer","selfid":null,"telephone":"qwer","address":"","url":"qwer","catid":"5","districtid":"1","marketplace":"qew","floorer":"0","created":"1400658222","status":"1","ismain":"0","isonly":"0","longitude":"0","latitude":"0","stations":"0"}
        {"id":"7","merchantid":"14","name":"14\u53f7\u5e97","owner":"14\u53f7\u5e97","selfid":null,"telephone":"14\u53f7\u5e9714\u53f7\u5e97","address":"14\u53f7\u5e97","url":"14\u53f7\u5e97","catid":"4","districtid":"3","marketplace":"14\u53f7\u5e97","floor":"12","created":"1400642941","status":"1","ismain":"1","isonly":"1","longitude":"0","latitude":"0","stations":"0"}
    ]
}
</pre>

##商铺列表{#api16}
地址  /api/merchantshop/detail

### 接口输入
提交方式  GET|POST

参数名| 必有 |   类型  |  示例
----- | ---- | ------- | ----
id    |  是  |  int    | 7

### 接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据
data       |  是  |   map   | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"Success",
    "data":{
          "id":"7",
          "merchantid":"14",
          "name":"14\u53f7\u5e97",
          "owner":"14\u53f7\u5e97",
          "selfid":null,
          "telephone":"14\u53f7\u5e9714\u53f7\u5e97",
          "address":"14\u53f7\u5e97",
          "url":"14\u53f7\u5e97",
          "catid":"4",
          "districtid":"3",
          "marketplace":"14\u53f7\u5e97",
          "floor":"12",
          "created":"1400642941",
          "status":"1",
          "ismain":"1",
          "isonly":"1",
          "longitude":"0",
          "latitude":"0",
          "stations":"0"
    }
}
</pre>



##商品列表{#api17}

地址 /api/merchantshop/products

### 接口输入
提交方式 GET|POST

参数名     | 必有 | 类型  | 示例 | 说明
---------- | ---- |------ | ---- |
shopid     | 否   | int   |  7   | 店铺ID
page       | 否   | int   |  1   | 页数 默认1
pagesize   | 否   | int   |  10  |每页条数 默认10
discount   | 否   | string|  yes | 折扣

### 参数说明

discount = yes   请求有折扣的商品
discount = no    请求不打折的商品
不传请求所有的

### 接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |    int  | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据
data       |  是  |   map   | 见示例 | 返回数据

<pre>
{
  "error_code":0,
  "error_msg":"Success",
  "data":[
          {"id":"24","name":"adsf","pic":"","intro":"asdf","price":"0.00","discount":"1.00","shopid":"0","merchantid":"14","created":"1400664947","status":"1"},
          {"id":"26","name":"adsf","pic":"","intro":"asdf","price":"0.00","discount":"1.00","shopid":"0","merchantid":"18","created":"1400665183","status":"1"},
        ]
}
</pre>



##商品详情{#api18}

地址 /api/merchantshop/productdetail

###接口输入

提交方式 GET | POST

参数名     | 必有  | 类型 | 示例| 说明
---------- | ---   |----- | --- | -----
productid  | 是    | int  | 29  | 商品ID

### 接口输出

参数名     | 必有|   类型  |  示例  |  说明
---------- | --- | ------- | ------ | --------
error_code |  是 |  int    | 见示例 | 返回数据
error_msg  |  是 |  string | 见示例 | 返回数据
data       |  是 |   map   | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"Success",
    "data":{
        "id":"29",
        "name":"adsf",
        "pic":"",
        "intro":"asdf",
        "price":"0.00",
        "discount":"1.00",
        "shopid":"0",
        "merchantid":"14",
        "created":"1400664755",
        "status":"1"
    }
}
</pre>


## 基站广告 {#api19}
地址：/api/advertisement/station

###接口输入

提交方式：GET

参数名    | 必填 | 类型  |  示例  | 说明
uuid     | 是  |string|  xxx  | 基站识别码

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" http://{domain}/api/advertisement/station
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据
data       |  是  |   map   | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success",
    "data":{
        "name":"红烧肉",
        "pic":"http://domain/xxx/14/06/03/3d8683226fbaccc6673bebacaa3163de.jpg",
        "intro":"全民最爱的红烧肉",
        "shopid":"2",
        "source":"2",
        "sid":"19",
        "telephone":"86345345",
        "address":"新界油麻地左敦路32号",
        "url":"www.hll.com.hk",
        "catname":"麵包/西餅",
    }
}
</pre>


## 地图 {#api20}
地址：/api/map/detail

###接口输入

提交方式：POST

参数名       | 必填| 类型  | 示例| 说明
marketplace  | 是  |string | xxx | 商场
floor	     | 是  |string | 1   | 楼层

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" -d '{"marketplace":"xxx", "floor":"xxx"}' http://{domain}/api/map/detail
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据
data       |  是  |   map   | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success",
    "data": {
        "id": "1",
        "name": "dfsd",
        "marketplace": "ddd",
        "floor": "12",
        "map": "http://blueu.hugb.com/statics/upload/original/14/05/31/6cf0d999a3e156999b61269b451a692c.jpg",
        "created": "1401609871"
    }
}
</pre>


## 意见反馈 {#api21}
地址：/api/feedback/create

###接口输入

提交方式：POST

参数名  | 必填| 类型  | 示例| 说明
content | 是  |string | xxx | 内容

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" -d '{"content":"xxx"}' http://{domain}/api/feedback/create
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"
}
</pre>


## 关注 {#api22}
地址：/api/user/like

###接口输入

提交方式：POST

参数名 | 必填| 类型| 示例| 说明
source | 是  | int |  1  | 来源，1商铺 2商品 3优惠券 4印花
sid    | 是  | int | 123 | 来源ID
shopid | 否  | int | 123 | 店铺ID，可为空

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" -d '{"source":1, "sid":123}' http://{domain}/api/user/like
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"
}
</pre>


## 关注列表 {#api23}
地址：/api/user/like

###接口输入

提交方式：GET

参数名   | 必填| 类型| 示例| 说明
page     | 否  | int |  1  | 页数 默认1
pagesize | 否  | int | 10  |每页条数 默认10

完整参数示例:

<pre>
curl -X GET -H "Accept:application/json" http://{domain}/api/user/like？page=1&pagesize=2
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据
data       |  是  |   map   | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"
    "data":[{
            "id":1,
            "source":1,
            "sid":1,
            "shopid":2,
            "created":134567891
        }
    ]
}
</pre>


## 分享 {#api24}
地址：/api/user/share

###接口输入

提交方式：POST

参数名 | 必填| 类型| 示例| 说明
source | 是  | int |  1  | 来源，1商铺 2商品 3优惠券 4印花
sid    | 是  | int | 123 | 来源ID

完整参数示例:

<pre>
curl -X POST -H "Accept:application/json" -d '{"source":1, "sid":123}' http://{domain}/api/user/share
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"
}
</pre>


## 分享列表 {#api25}
地址：/api/user/share

###接口输入

提交方式：GET

参数名   | 必填| 类型| 示例| 说明
page     | 否  | int |  1  | 页数 默认1
pagesize | 否  | int | 10  |每页条数 默认10

完整参数示例:

<pre>
curl -X GET -H "Accept:application/json" http://{domain}/api/user/share？page=1&pagesize=2
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据
data       |  是  |   map   | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"
    "data":[{
            "id":1,
            "source":1,
            "sid":1,
            "created":134567891
        }
    ]
}
</pre>



## 优惠券列表 {#api26}
地址：/api/merchantcode/couponlist

###接口输入

提交方式：GET

参数名    | 必填 | 类型 | 示例| 说明
---------|-----|-----|----|---------------
page     | 否  | int |  1  | 页数 默认1
pagesize | 否  | int | 10  | 每页条数 默认10
shopid   | 否  | int | 1   | 店铺id

完整参数示例:

<pre>
curl -X GET -H "Accept:application/json" http://{domain}/api/merchantcode/couponlist ？page=1&pagesize=2&shopid=1
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据
data       |  是  |   map   | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"
    "data":[
        {
            "id":"6",
            "name":"eeeeeeeff",
            "pic":"77f904a9c86068136791af70e0c922f9",
            "price":"123.00",
            "validity_start":"1401638400",
            "validity_end":"1403884800",
            "suit":"",
            "codeid":"3",
            "shopid":"1",
            "merchantid":"1",
            "created":"1401758748"
        }
    ]
}
</pre>


## 优惠券获取 {#api27}
地址：/api/merchantcode/getcoupon

###接口输入

提交方式：POST

参数名    | 必填 | 类型 | 示例| 说明
---------|-----|-----|----|---------------
userid   | 是  | int |  1  | 用户id
codeid   | 是  | int | 1  | 优惠券id

完整参数示例:

<pre>
curl -X GET -H "Accept:application/json" -d '{"userid":1,"codeid":1}'  http://{domain}/api/merchantcode/getcoupon
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"
}
</pre>



## 印花列表 {#api28}
地址：/api/merchantcode/stamplist

###接口输入

提交方式：GET

参数名    | 必填 | 类型 | 示例| 说明
---------|-----|-----|----|---------------
page     | 否  | int |  1  | 页数 默认1
pagesize | 否  | int | 10  | 每页条数 默认10
shopid   | 否  | int | 1   | 店铺id

完整参数示例:

<pre>
curl -X GET -H "Accept:application/json" http://{domain}/api/merchantcode/stamplist?page=1&pagesize=2&shopid=1
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据
data       |  是  |   map   | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"
    "data":[
        {
          "id":"1",
          "name":"test",
          "pic":"14\/06\/05\/1c6bff1b2b97c0cf4275aaad7020b51f.jpg",
          "validity_start":"1401811200",
          "validity_end":"1403107200",
          "suit":"",
          "codeid":"3",
          "shopid":"1",
          "merchantid":"1",
          "created":"1401758689"
        }
    ]
}
</pre>




## 印花获取 {#api29}
地址：/api/merchantcode/getstamp

###接口输入

提交方式：POST

参数名    | 必填 | 类型 | 示例| 说明
---------|-----|-----|----|---------------
userid   | 是  | int |  1  | 用户id
codeid   | 是  | int | 1  | 印花id

完整参数示例:

<pre>
curl -X GET -H "Accept:application/json" -d '{"userid":1,"codeid":1}'  http://{domain}/api/merchantcode/getstamp
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据

<pre>
{
    "error_code":0,
    "error_msg":"success"
}
</pre>


## 搜索 {#api30}
地址：/api/search

###接口输入

GET

参数名    | 必填 | 类型 | 示例    | 说明
---------|-----|-----|---------|---------------
key      | 否  | int |  刘一手  | 搜索关键字
page     | 否  | int |  1      | 第几页
pagesize | 否  | int |  10     | 分页条数

完整参数示例:

<pre>
curl -X GET -H "Accept:application/json"  http://{domain}/api/search?key=刘一手&page=1
</pre>

###接口输出

参数名     | 必有 |   类型  |  示例  |  说明
---------- | ---- | ------- | ------ | --------
error_code |  是  |  int    | 见示例 | 返回数据
error_msg  |  是  |  string | 见示例 | 返回数据
data       | 否   |  string  | 见示例| 返回数据

####data 返回值说明

type区分:
shop->店铺
product->商品
coupon->优惠券
stamp->印花
<pre>
{
"error_code":0,
"error_msg":"Success",
"data":{
    "key":"\u5218",
    "page":1,
    "pagesize":10,
    "data":[
          {
            "id":"9",
            "name":"\u5218\u4e00\u624b",
            "pic":"14\/06\/03\/e022de25bf5d09c3d1b85d40008d2f55.jpg",
            "intro":"",
            "type":"shop"
          },
          {
            "id":"21",
            "name":"adsf",
            "pic":"1c31516643f2f0fb47f1b59c4c20962b",
            "intro":"asdf",
            "type":"product"
          },
          {
            "id":"1",
            "name":"\u4f18\u60e0\u5238\uff11",
            "pic":"14\/06\/08\/c4b293169e513c6229d7737d84cf55fe.jpg",
            "intro":"\u4f18\u60e0\u5238\u7684\u7b80\u4ecb\u6d4b\u8bd5",
            "type":"coupon"
          },
          {
            "id":"5",
            "name":"\u6b22\u8fce\u5927\u5bb6\u4f7f\u7528",
            "pic":"71c16f61b3c7e49ab548b16537353da3",
            "intro":"",
            "type":"stamp"
          }
        ]
    }
}
</pre>

