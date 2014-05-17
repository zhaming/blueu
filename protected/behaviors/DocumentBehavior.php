<?php
class DocumentBehavior extends BaseBehavior
{


	public function create($file_id,$category_id,$name,$type,$agency_id=0,$memo='')
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('file_id = '.$file_id);
		$criteria->addCondition('category_id = '.$category_id);
		$criteria->addCondition('name = "'.$name.'"');
		$criteria->addCondition('type = '.$type);
		$criteria->addCondition('agency_id = '.$agency_id);
		$model = Document::model()->find($criteria);
		if(empty($model))
		{
			$model = new Document;
			$model->file_id = $file_id;
			$model->category_id = $category_id;
			$model->name = $name;
			$model->type = $type;
			$model->memo = $memo;
			
			if(!empty($agency_id)){
				$model->agency_id = $agency_id;
			}
			$model->ctime = time();
			$model->save();
		}
		return $model;
	}
	

	public static function get($doc_id)
	{
		return Document::model()->findByPk($doc_id);
	}


	public function edit($params)
	{
		$model = $this->get($params['id']);
		$model->category_id = $params['category'];
		$model->name = $params['name'];
		$model->memo = $params['memo'];
		return $model->save();
	}




	//查找并创建目录分类
	public function category($path,$creater=0)
	{
		$path = explode('/',$path);
		foreach($path as $v)
		{
			if(!empty($v))
			{
				$criteria = new CDbCriteria;
				$criteria->addCondition('name = "'.$v.'"');
				if(!empty($parent_id)){
					$criteria->addCondition('parent_id = '.$parent_id);
				}
				$model = DocumentCategory::model()->find($criteria);
				if(empty($model))
				{
					$model = new DocumentCategory;
					$model->name = $v;
					if(!empty($parent_id))
						$model->parent_id = $parent_id;
					if(!empty($creater))
						$model->agency_id = $creater;
					$model->ctime = time();
					$model->save();
				}
				$parent_id = $model->id;
			}
		}
		return $model;
	}









	public function getTreeList()
	{	
		$bhv = new CategoryBehavior;
		$categorys = $bhv->getArrayList();
		$files = $this->getList();

		$result = $this->getTreeChildren($categorys,$files);
	
		//绑定顶级文件位置
		if(!empty($files))
		{
			foreach($files as $f)
			{
				if($f['category_id'] == 0)
				{
					$temp['doc_id'] = $f['id'];
					$temp['name'] = $f['name'];
					$result[] = $temp;
				}
			}
		}
		return $result;
	}

	public function getTreeChildren($list,$files,$level = 0)
	{
		if(!empty($list))
		{
			foreach($list as $key=>$v)
			{
				$list[$key]['isParent'] = 'true';
				$list[$key]['nocheck'] = 'true';
				if(!empty($v['children']))
				{
					$data = $this->getTreeChildren($v['children'],$files,$level+1);
					$list[$key]['children'] = $data;
				}
				
				//绑定文件位置
				if(!empty($files))
				{
					foreach($files as $f)
					{
						if($f['category_id'] == $v['id'])
						{
							$temp['doc_id'] = $f['id'];
							$temp['name'] = $f['name'];
							$list[$key]['children'][] = $temp;
						}
					}
				}
			

			}
		}
		return $list;
	}

	public function getList()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('is_deleted = 0');
		return Document::model()->findAll($criteria);
	}





	public function tidyTree($tree)
	{
		foreach($tree as $key=>$v)
		{
			if(empty($v['children']))
			{
				if(empty($v['doc_id']))
					unset($tree[$key]);
			}else{
				$children = $this->tidyTree($v['children']);
				if(!empty($children))
					$tree[$key]['children'] = $children;
				else
					unset($tree[$key]);
			}
		}

		return $tree;

	}

	public function tidyArray($tree)
	{
		if(empty($tree))
			return false;
		if(!empty($tree['doc_id']))
			return $tree;
		foreach($tree as $v)
		{
			//数组重新排序
			if(!empty($v['children']))
			{
				$v['children'] = $this->tidyArray($v['children']);
			}
			$arr[] = $v;
		}
		return $arr;

	}

}
