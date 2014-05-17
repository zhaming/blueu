<?php
/**
 * section:
 *     system 默认
 * key:
 *     system.timeout
 * cache_key
 */
class ConfigBehavior extends CActiveRecordBehavior
{
    public $enable;
    public $cache_key_base = 'config';

    /**
     * 检测缓存是否开启
     * 
     * @return boolean
     */
    private function _isCacheEnabled()
    {
        return !is_null(Yii::app()->getComponent('cache'));
    }

    /**
     * 设置配置数据
     * 
     * @param string $key     标示
     * @param string $value   值
     * @param string $section 默认为系统
     * @param string $comment 配置说明
     * 
     * @return $result boolean 设置是否成功
     */
    public function set($key, $value, $section='system', $comment='')
    {
        if (empty($key)) {
            return false;
        }
        if (empty($section)) {
            return false;
        }
        $criteria = new CDbCriteria;
        $criteria->addColumnCondition(array('section' => $section));
        $criteria->addColumnCondition(array('_key' => $key));
        $query_result = $this->getOwner()->find($criteria);
        if (is_null($query_result)) {
            $this->getOwner()->setIsNewRecord(true);
            $this->getOwner()->setAttributes(array());
            $this->getOwner()->id = null;
            $this->getOwner()->section = $section;
            $this->getOwner()->_value = $value;
            $this->getOwner()->_key = $key;
            $this->getOwner()->_comment = $comment;
            $this->getOwner()->is_deleted = 0;
            $result = $this->getOwner()->save();
            // $result = $this->getOwner()->id;
        } else {
            $query_result->section = $section;
            $query_result->_value = $value;
            $query_result->_key = $key;
            $query_result->is_deleted = 0;
            $result = $query_result->save();
        }
        if ($this->_isCacheEnabled()) {
            Yii::app()->cache->delete($this->cache_key_base.'_'.$section);
            Yii::app()->cache->delete($this->cache_key_base.'_'.$section.'_'.$key);
        }
        return $result;
    }

    /**
     * 获取配置数据
     * 
     * @param string $key     标示
     * @param string $section 段
     * @param string $default 默认值
     * 
     * @return string          设置的值，如果没有设置则为null
     */
    public function get($key, $section='system', $default=null)
    {
        $result = $default;
        if ($this->_isCacheEnabled()) {
            $result = Yii::app()->cache->get($this->cache_key_base.'_'.$section.'_'.$key);
        } else {
            $result = null;
        }
        if (!$result) {
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('section' => $section));
            $criteria->addColumnCondition(array('_key' => $key));
            $criteria->addColumnCondition(array('is_deleted' => 0));
            $query_result = $this->getOwner()->find($criteria);
            if (!is_null($query_result)) {
                $result = $query_result->_value;
                if ($this->_isCacheEnabled()) {
                    Yii::app()->cache->set($this->cache_key_base.'_'.$section.'_'.$key, $result);
                }
            } else {
                $result = $default;
            }
        }
        return $result;
    }

    /**
     * 批量获取某个段的配置
     * 
     * @param string $section 段,默认为system
     * 
     * @return array          key=>value
     */
    public function mget($section='system')
    {
        $result = array();
        if ($this->_isCacheEnabled()) {
            $result = Yii::app()->cache->get($this->cache_key_base.'_'.$section);
        }
        if (empty($result)) {
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('section' => $section));
            $criteria->addColumnCondition(array('is_deleted' => 0));
            $query_result = $this->getOwner()->findAll($criteria);
            if (!empty($query_result)) {
                foreach ($query_result as $row) {
                    $result[$row->_key] = $row->_value;
                }
                if ($this->_isCacheEnabled()) {
                    Yii::app()->cache->set($this->cache_key_base.'_'.$section, $result);
                }
            }
        }
        return $result;
    }

    /**
     * 删除某个配置
     * 
     * @param string $key     标示
     * @param string $section 段
     * 
     * @return string          是否成功
     */
    public function del($key, $section)
    {
        $result = false;
        $criteria = new CDbCriteria;
        $criteria->addColumnCondition(array('section' => $section));
        $criteria->addColumnCondition(array('_key' => $key));
        $query_result = $this->getOwner()->find($criteria);
        $query_result->is_deleted = 1;
        $result = $query_result->save();
        if ($this->_isCacheEnabled()) {
            Yii::app()->cache->delete($this->cache_key_base.'_'.$section);
            Yii::app()->cache->delete($this->cache_key_base.'_'.$section.'_'.$key);
        }
        return $result;
    }
}
?>
