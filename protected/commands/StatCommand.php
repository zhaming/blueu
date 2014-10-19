<?php
/**
 *	统计命令
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	commands
 *
 *	$Id$
 */

class StatCommand extends CConsoleCommand
{
    public function getHelp() {
        return "针对平台数据进行统计，便于后期分析\n";
    }
    
    public function run($args)
    {
        /*$taskid = isset($args[0]) ? $args[0] : 0;
        $_push = new PushBehavior();
        $result = $_push->push($taskid);
        echo $result;*/
        echo 'stat';
    }
}
?>
