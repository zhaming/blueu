<?php
/**
 *	推送命令
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	commands
 *
 *	$Id$
 */

class PushCommand extends CConsoleCommand
{
    public function getHelp() {
        return "基于一定条件向客户端推送商户相关广告消息\n";
    }
    
    public function run($args)
    {
        /*$taskid = isset($args[0]) ? $args[0] : 0;
        $_push = new PushBehavior();
        $result = $_push->push($taskid);
        echo $result;*/
        echo 'push';
    }
}
?>
