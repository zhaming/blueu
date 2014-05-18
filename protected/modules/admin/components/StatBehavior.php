<?php

class StatBehavior {

    /**
     * 统计日志保存更新stat_count
     */
    public function saveOrUpdate($data) {
        print_r($data);
        $stat = Stats ::model()->findByAttributes(array('user_id' => $data['user_id']));
        if (empty($stat)) {
            $stat = new Stats;
            $stat->user_id = $data['user_id'];
            $stat->save();
        }

        /**
         * 添加统计日志
         */
        if (!empty($data['tag'])) {
            $statcount = new Statcount;
            $statcount->user_id = $data['user_id'];
            $statcount->url = $data['url'];
            $statcount->tag = $data['tag'];
            $statcount->save();
        }
        $this->updateStat();
    }

    /**
     * 统计所有的statcount
     */
    public function updateStat() {
        $stats = Stats::model()->findAll();
        $resources = 0;
        $lie = 0;
        $problem = 0;
        foreach ($stats as $stat) {
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('user_id' => $stat['user_id'], 'tag' => 1));
            $resources = Statcount::model()->count($criteria);
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('user_id' => $stat['user_id'], 'tag' => 2));
            $lie = Statcount::model()->count($criteria);
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('user_id' => $stat['user_id'], 'tag' => 3));
            $problem = Statcount::model()->count($criteria);
            if ($resources != 0)
                $stat->resources += $resources;
            if ($lie != 0)
                $stat->lie += $lie;
            if ($problem != 0)
                $stat->problem += $problem;
            $stat->save();
        }
    }

    /**
     * 获取所有统计记录
     */
    public function getList($param, $page = -1, $pageSize = 15) {

        $ids = array();
        $pages = null;
        $criteria = new CDbCriteria;

        if (!empty($param['username'])) {
            $userbehavior = new UserBehavior;
            $username = $userbehavior->getUserByLoginName($param['username']);
            if (!empty($username)) {
                foreach ($username as $key => $user) {
                    $ids[] = $user['id'];
                }
            }
            $criteria->addInCondition("user_id", $ids);
        }

        $criteria->order = "ctime DESC";
        $criteria->addColumnCondition(array('is_deleted' => 0));
        if (!empty($param['page']))
            $page = $param['page'];
        $count = Stats :: model()->count($criteria);
        $pages = new CPagination($count);
        $pages->setCurrentPage(0);
        $pages->pageSize = $pageSize;
        $pages->applyLimit($criteria);

        $stats = Stats :: model()->findAll($criteria);

        foreach ($stats as $key => $stat) {
            $userbehavior = new UserBehavior;
            $username = $userbehavior->getUserById($stat['user_id']);
            $result[$key]['user'] = $username;
            $result[$key]['stat'] = $stat;
        }
        return compact('pages', 'result');
    }

    public function getListByUserId($user_id) {
        $error = 0;
        $criteria = new CDbCriteria;
        $criteria->addColumnCondition(array('is_deleted' => 0, 'user_id' => $user_id));
        $dat = Stats::model()->find($criteria);

        $userbehavior = new UserBehavior;
        $username = $userbehavior->getUserById($dat['user_id']);

        $data['score'] = $username['score'];

        if (!empty($dat)) {
            $data['resources'] = $dat['resources'];
            $data['lie'] = $dat['lie'];
            $data['problem'] = $dat['problem'];
        } else {
            $error = '没有此用户';
            $data = $dat;
        }

        return compact("error", "data");
    }

    /*
      author: yanxf
     */

    public static function getUrlVisits($url) {
        $purl = ParseUrl::decode($url);
        if ($purl['host'] != $_SERVER['HTTP_HOST'])
            return UrlStatBehavior::getHits($url);
        $criteria = new CDbCriteria;
        $criteria->addCondition('hash ="' . $purl['hash'] . '"');
        $count = LogVisitor::model()->count($criteria);
        return $count;
    }

    public function lastDayVisitor() {
        $criteria = new CDbCriteria;
        $end_time = strtotime(date('Y-m-d H:0:0', time()));
        $start_time = $end_time - 86400;
        $criteria->addCondition('ctime >' . $start_time);
        //	$criteria->addCondition('ctime <'.$end_time);
        $criteria->order = 'ctime ASC';
        $models = LogVisitor::model()->findAll($criteria);

        if (!empty($models)) {
            foreach ($models as $value) {
                //划分数据片区

                $key = floor(($value->ctime - $start_time) / 3600);
                $data_split[$key][] = $value;

                //统计重复地址
                $addr[$value->url][] = $value;
            }
            foreach ($addr as $key => $value) {
                $stat_addr[$key] = count($value);
            }
            arsort($stat_addr);
            $stat['addr'] = $stat_addr;

            foreach ($data_split as $value) {

                $data['x'] = strtotime(date('Y-m-d H:0:0', $value[0]->ctime)) * 1000;
                foreach ($value as $v) {
                    $data_pv[md5($v['uid'] . $v['user_agent'] . $v['vip'] . floor($v->ctime / 10))][] = $v;
                    $data_uv[md5($v->uid . $v->user_agent . $v->vip)][] = $v;
                    $data_ip[$v->vip][] = $v;
                }
                $stat_tp[] = array($data['x'], count($value));
                $stat_pv[] = array($data['x'], count($data_pv));
                $stat_uv[] = array($data['x'], count($data_uv));
                $stat_ip[] = array($data['x'], count($data_ip));
                $data_pv = $data_uv = $data_ip = array();
            }


            $stat['tp'] = CJSON::encode($stat_tp);
            $stat['uv'] = CJSON::encode($stat_uv);
            $stat['pv'] = CJSON::encode($stat_pv);
            $stat['ip'] = CJSON::encode($stat_ip);
            return $stat;
        }
        return false;
    }

    public function lastWeekVisitor() {
//		$cache = Yii::app()->cache;
        //$cache->flush();
//		$stat = $cache->get('last_week_visitor');
//		if(empty($stat))
//		{
        $criteria = new CDbCriteria;
        $end_time = strtotime(date('Y-m-d', time()));
        //$end_time = time();
        $start_time = $end_time - 86400 * 7;
        $criteria->addCondition('ctime >' . $start_time . ' AND ctime <' . $end_time);
        $criteria->order = 'ctime ASC';
        $models = LogVisitor::model()->findAll($criteria);
        if (!empty($models)) {
            foreach ($models as $value) {
                //划分数据片区

                $key = floor(($value->ctime - $start_time) / 86400);
                $data_split[$key][] = $value;
                //统计重复地址
                $addr[$value->url][] = $value;
            }
            foreach ($addr as $key => $value) {
                $stat_addr[$key] = count($value);
            }
            arsort($stat_addr);
            $stat['addr'] = $stat_addr;

            foreach ($data_split as $value) {

                $data['x'] = strtotime(date('Y-m-d', $value[0]->ctime)) * 1000;
                foreach ($value as $v) {
                    $data_pv[md5($v['uid'] . $v['user_agent'] . $v['vip'] . floor($v->ctime / 10))][] = $v;
                    $data_uv[md5($v->uid . $v->user_agent . $v->vip)][] = $v;
                    $data_ip[$v->vip][] = $v;
                }
                $stat_tp[] = array($data['x'], count($value));
                $stat_pv[] = array($data['x'], count($data_pv));
                $stat_uv[] = array($data['x'], count($data_uv));
                $stat_ip[] = array($data['x'], count($data_ip));
                $data_pv = $data_uv = $data_ip = array();
            }
            $stat['tp'] = CJSON::encode($stat_tp);
            $stat['uv'] = CJSON::encode($stat_uv);
            $stat['pv'] = CJSON::encode($stat_pv);
            $stat['ip'] = CJSON::encode($stat_ip);
//				$cache->set('last_week_visitor',$stat,86400);//设定缓存,这里的过期时间有问题。
            return $stat;
        }
        return false;

//		}else{
//			return $stat;
//		}
    }

    public function lastMonthVisitor() {
//		$cache = Yii::app()->cache;
        //$cache->flush();
//		$stat = $cache->get('last_month_visitor');
//		if(empty($stat))
//		{
        $criteria = new CDbCriteria;
        $end_time = strtotime(date('Y-m-d 0:0:0', time()));
        //$end_time = time();
        $start_time = $end_time - 86400 * 30;
        $criteria->addCondition('ctime >' . $start_time . ' AND ctime <' . $end_time);
        $criteria->order = 'ctime ASC';
        $models = LogVisitor::model()->findAll($criteria);
        if (!empty($models)) {
            foreach ($models as $value) {
                //划分数据片区

                $key = floor(($value->ctime - $start_time) / 86400);
                $data_split[$key][] = $value;
                //统计重复地址
                $addr[$value->url][] = $value;
            }
            foreach ($addr as $key => $value) {
                $stat_addr[$key] = count($value);
            }
            arsort($stat_addr);
            $stat['addr'] = $stat_addr;


            foreach ($data_split as $value) {
                $data['x'] = strtotime(date('Y-m-d', $value[0]->ctime)) * 1000;
                //		echo $data['x'].'|'.$value[0]->ctime.'|'.date('Y-m-d H:i:s',$value[0]->ctime).'<br>';
                foreach ($value as $v) {
                    $data_pv[md5($v['uid'] . $v['user_agent'] . $v['vip'] . floor($v->ctime / 10))][] = $v;
                    $data_uv[md5($v->uid . $v->user_agent . $v->vip)][] = $v;
                    $data_ip[$v->vip][] = $v;
                }
                $stat_tp[] = array($data['x'], count($value));
                $stat_pv[] = array($data['x'], count($data_pv));
                $stat_uv[] = array($data['x'], count($data_uv));
                $stat_ip[] = array($data['x'], count($data_ip));
                $data_pv = $data_uv = $data_ip = array();
            }
            $stat['tp'] = CJSON::encode($stat_tp);
            $stat['uv'] = CJSON::encode($stat_uv);
            $stat['pv'] = CJSON::encode($stat_pv);
            $stat['ip'] = CJSON::encode($stat_ip);

//				$cache->set('last_month_visitor',$stat,86400);//设定缓存,这里的过期时间有问题。

            return $stat;
        }
        return false;

//		}else{
//			return $stat;
//		}
    }

    public function lastMonthUser() {

        for ($i = 1; $i <= 30; $i++) {
            $day_time[] = strtotime(date('Y-m-d', (time() - (86400 * ($i - 2)))));
        }
        foreach ($day_time as $day) {
            $criteria = new CDbCriteria;
            $criteria->addCondition('ctime<' . $day);
            $count = User::model()->count($criteria);
            $stat[] = array($day * 1000, $count);
        }

        $stat['tp'] = CJSON::encode($stat);
        return $stat;
    }

}

?>
