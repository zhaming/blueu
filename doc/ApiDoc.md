BlueU客户端接口文档
========================

文档版本: *v0.1-14-05-19*  
接口协议: *http*  
报文格式: *json*  
报文编码: *utf-8*  
正式接口: *待发布*  
测试接口: *mocky.shifang.info*  



接口名               地址              类型
[用户注册](#user)  /api/user/register PSOT
[用户登录](#user)  /api/user/login    PSOT
[重置密码](#user)  /api/user/resetpwd PSOT
[用户登出](#user)  /api/user/logout   PSOT
[编辑资料](#user)  /api/user/1/edit   PSOT
[启用推送](#user)  /api/user/1/push   PSOT
[用户详情](#user)  /api/user/1        GET


## 约定  
接口报文默认外层始终有且至少有error_code和error_msg字段, 分别为状态码和状态消息.  
1.接口访问正常情况, error_code始终返回0; 错误的时候返回非0, 视服务端情况为准;  
2.error_msg字段返回接口访问情况信息, 如果出错, 服务端会返回错误情况, 供客户端酌情使用;  
3.如果服务端状态正常,并且需要返回数据, 将数据报文放入data字段, 不需要返回时或访问失败, 服务端不保持该字段;  

示例1, 接口访问成功, 服务端不带数据:  
<pre>
{
    "error_code": 0,
    "error_msg": "success"
}
</pre>

示例2, 接口访问失败:  
<pre>
{
    "error_code": 101,
    "error_msg": "用户没有权限访问"
}
</pre>

示例3, 服务端返回单条数据:  
<pre>
{
    "error_code": 0,
    "error_msg": "success",
    "data": {
    "id": 1
        "name": "name"
    }
}
</pre>

示例4, 服务端返回多组数据:  
<pre>
{
    "error_code": 0,
    "error_msg": "success",
    "data":[{
        "id": 1
        "name": "name"
    },{
        "id": 2
        "name": "name2"
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


## 用户注册 {#user}
地址：/api/user/register

###接口输入

提交方式：POST

 参数名     必填   类型     示例            说明
username    是  string  zhansan@test.com 帐号
password    是  string  123456           密码
name        是  string  张三              昵称
sex         否  int     0                0:保密 1:女 2:男
period      否  string  70               年代

完整参数示例:
<pre>
    curl -X POST -H "Accept: application/json" -d '{"username":"0000000002","password":"123456","name":"张三"}' http://api.blueu.com/api/user/register
</pre>

###接口输出

参数名      必有  类型    示例   说明
error_code  是   int   见示例  返回数据
error_msg   是  string 见示例  返回数据

<pre>
{
    "error_code": 0,
    "error_msg": "success"
}
</pre>


## 用户登录 {#user}
地址：/api/user/login

###接口输入

提交方式：POST

 参数名     必填   类型     示例            说明
username    是  string  zhansan@test.com 帐号  
password    是  string  123456           密码

完整参数示例:
<pre>
    curl -X POST -H "Accept: application/json" -d '{"username":"0000000002","password":"123456"}' http://api.blueu.com/api/user/login
</pre>

###接口输出

参数名      必有   类型     示例    说明
error_code  是    int    见示例  返回数据
error_msg   是   string  见示例  返回数据
data        是    map    见示例  返回数据

<pre>
{
    "error_code": 0,
    "error_msg": "success"，
    "data": {
        "token_id": "00320d40-89f8-4b28-d18e-fe12abefcf47"
    }
}
</pre>


## 重置密码 {#user}
地址：/api/user/resetpwd

###接口输入

提交方式：POST

 参数名      必填   类型     示例  说明
password     是  string  12312  密码
newpassword  是  string  123456 新密码

完整参数示例:
<pre>
    curl -X POST -H "Accept: application/json" -H "X-Auth-Token:00320d40-89f8-4b28-d18e-fe12abefcf47" -d '{"password":"0000000002","newpassword":"123456"}' http://api.blueu.com/api/user/resetpwd
    or
    curl -X POST -H "Accept: application/json" -H "X-Auth-Username:zhangsan" -H "X-Auth-Password:zhangsan" -d '{"password":"0000000002","newpassword":"123456"}' http://api.blueu.com/api/user/resetpwd
</pre>

###接口输出

参数名      必有   类型     示例    说明
error_code  是    int    见示例  返回数据
error_msg   是   string  见示例  返回数据

<pre>
{
    "error_code": 0,
    "error_msg": "success"
}
</pre>


## 用户登出 {#user}
地址：/api/user/logout

###接口输入

提交方式：POST

 参数名     必填   类型     示例            说明
username    是  string  zhansan@test.com  帐号  
password    是  string  123456            密码

完整参数示例:
<pre>
    curl -X POST -H "Accept: application/json" -H "X-Auth-Token:00320d40-89f8-4b28-d18e-fe12abefcf47" -d '{"username":"0000000002","password":"123456"}' http://api.blueu.com/api/user/logout
</pre>

###接口输出

参数名      必有   类型     示例    说明
error_code  是    int    见示例  返回数据
error_msg   是   string  见示例  返回数据

<pre>
{
    "error_code": 0,
    "error_msg": "success"
}
</pre>


## 用户修改资料 {#user}
地址：/api/user/1/edit

###接口输入

提交方式：POST

参数名  必填   类型     示例   说明
name    否  string    张三   名称

完整参数示例:
<pre>
    curl -X POST -H "Accept: application/json" -H "X-Auth-Token:00320d40-89f8-4b28-d18e-fe12abefcf47" -d '{"name":"张三"}' http://api.blueu.com/api/user/1/edit
</pre>

###接口输出

参数名      必有   类型     示例    说明
error_code  是    int    见示例  返回数据
error_msg   是   string  见示例  返回数据

<pre>
{
    "error_code": 0,
    "error_msg": "success"
}
</pre>


## 用户信息推送开关 {#user}
地址：/api/user/1/push

###接口输入

提交方式：POST

参数名  必填   类型   示例   说明
enable  是    int    1   是否开启

完整参数示例:
<pre>
    curl -X POST -H "Accept: application/json" -H "X-Auth-Token:00320d40-89f8-4b28-d18e-fe12abefcf47" -d '{"enable":1}' http://api.blueu.com/api/user/1/push
</pre>

###接口输出

参数名      必有   类型     示例    说明
error_code  是    int    见示例  返回数据
error_msg   是   string  见示例  返回数据

<pre>
{
    "error_code": 0,
    "error_msg": "success"
}
</pre>


## 用户信息推送开关 {#user}
地址：/api/user/1

###接口输入

提交方式：GET

参数名  必填   类型   示例   说明

完整参数示例:
<pre>
    curl -X POST -H "Accept: application/json" http://api.blueu.com/api/user/1
</pre>

###接口输出

参数名      必有   类型     示例    说明
error_code  是    int    见示例  返回数据
error_msg   是   string  见示例  返回数据
data        是    map    见示例  返回数据

<pre>
{
    "error_code": 0,
    "error_msg": "success",
    "data": {
        "name": "xxx"
    }
}
</pre>