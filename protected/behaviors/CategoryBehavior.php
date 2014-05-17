<?php
class CategoryBehavior extends BaseBehavior
{

	public function add($params)
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('name = "'.$params['name'].'"');
		$criteria->addCondition('parent_id = '.$params['category']);
		$model = DocumentCategory::model()->find($criteria);
		if(empty($model))
		{
			$model = new DocumentCategory;
			$model->name = $params['name'];
			$model->parent_id = $params['category'];
			$model->ctime = time();
		}
		$model->agency_id = 0;
		$model->is_deleted = 0;
		return $model->save();
	}












    public function delete($id) {
        if (empty($id)) {
            $this->errorLog('没有ID');
            return false;
        }
        $model = DocumentCategory::model()->findByPk($id);
       	$model->is_deleted = ($model->is_deleted == 1 ? 0 : 1);
        $result = $model->save();

//		$key = 'goods_'.$id;
//		Yii::app()->cache->delete($key);

        if ($result)
            return true;
        else {
            $this->errorLog('操作失败');
            return false;
        }
    }

	public function detail($id)
	{
		if (empty($id)) {
            $this->errorLog('没有ID');
            return false;
        }
        $model = DocumentCategory::model()->findByPk($id);
		return $model;
	}

	public function edit($params)
	{
		$model = DocumentCategory::model()->findByPk($params['id']);
		$model->name = $params['name'];
		$model->parent_id = $params['category'];
		$model->ctime = time();
		return $model->save();
	}


	public static function getPath($id)
	{
		$bhv = new CategoryBehavior;
		$model = $bhv->detail($id);
		$path = $model->name;
		while($model->parent_id != 0)
		{
			$model = $bhv->detail($model->parent_id);
			$path = $model->name.'/'.$path;
		}
		return $path;
	}









	public function getList($params=array())
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('is_deleted = 0');
		$criteria->order = 'ctime ASC , order_time DESC';
		$list = DocumentCategory::model()->findAll($criteria);
		if(empty($list))
			return false;
		if(!empty($params['level']))
			$result = $this->getChildren($list,0,0,$params['level']);
		else
			$result = $this->getChildren($list,0);

		return $result;
	}



	public function getChildren($list,$parent_id,$level=0,$max_level = 0)
	{
		$arr = array();
		foreach($list as $v)
		{

			if($v['parent_id'] == $parent_id)
			{
				
				$delimiter = '';
				if($level!=0)
				{
//					$delimiter = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$level).'┗ ';
				}

				$temp['id'] = $v['id'];
				$temp['name'] = $delimiter . $v['name'];
				$temp['ctime'] = $v['ctime'];
				$arr[] = $temp;

				if(empty($max_level) || ($level + 1) < $max_level)
				{
					$children = $this->getChildren($list,$temp['id'],$level+1);
				}
				if(!empty($children))
				{
					$arr = array_merge($arr,$children);
				}
			}
		}
		return $arr;
	}




























	public function getArrayList()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('is_deleted = 0');
		$criteria->order = 'ctime ASC , order_time DESC';
		$list = DocumentCategory::model()->findAll($criteria);
		if(empty($list))
			return false;


		foreach($list as $v)
		{
			if($v->parent_id==0)
			{
				$arr['id'] = $v->id;
				$arr['name'] = $v->name;
				$children = $this->getArrayChildren($list,$arr['id']);
				if(!empty($children))
					$arr['children'] = $children;
				$result[] = $arr;
			}
		}
		return $result;
	}





	public function getArrayChildren($list,$parent_id)
	{
		$arr = array();
		foreach($list as $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$temp['id'] = $v['id'];
				$temp['name'] = $v['name'];
				$arr[] = $temp;
			}
		}
		if(!empty($arr))
		{
			foreach($arr as $key=>$v2)
			{
				$children = $this->getArrayChildren($list,$v2['id']);
				if(!empty($children))
				{
					$arr[$key]['children'] = $children;
				}
			}
		}
		return $arr;
	}








	public function getTreeList()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('is_deleted = 0');
		$criteria->order = 'ctime ASC , order_time DESC';
		$list = DocumentCategory::model()->findAll($criteria);
		if(empty($list))
			return false;

		$result = $this->getTreeChildren($list,0);

		return $result;
	}



	public function getTreeChildren($list,$parent_id,$level=0)
	{
		$arr = array();
		foreach($list as $v)
		{

			if($v['parent_id'] == $parent_id)
			{
				$delimiter = '';
				if($level!=0)
				{
					$delimiter = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$level).'┗ ';
				}
				$temp['id'] = $v['id'];
				$temp['name'] = $delimiter . $v['name'];
				$temp['ctime'] = $v['ctime'];
				$arr[] = $temp;


				$children = $this->getTreeChildren($list,$temp['id'],$level+1);
				if(!empty($children))
				{
					$arr = array_merge($arr,$children);
				}

			}
		}
		return $arr;
	}










	public function getDropDownList()
	{	
		$result[0] = '顶级'; 
		$list = $this->getArrayList();
		if(!empty($list))
		{
			$data = $this->getDropDownChildren($list);
		}else{
			$data = array();
		}
		return $result + $data;
	}

	public function getDropDownChildren($list,$level = 0)
	{
		$arr = array();
		if(!empty($list))
		{
			foreach($list as $v)
			{
				$delimiter = '';
				if($level!=0)
				{
					$delimiter = str_repeat("· · ",$level).'┗ ';
				}
				$arr[$v['id']] = $delimiter . $v['name'];
	
				if(!empty($v['children']))
				{
					$data = $this->getDropDownChildren($v['children'],$level+1);
					$arr = $arr + $data;
				}
			}
		}
		return $arr;
	}



}
