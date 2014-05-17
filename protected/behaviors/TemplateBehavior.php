<?php
class TemplateBehavior extends BaseBehavior
{
	public function createByProject($name,$agency_id,$project_id)
	{
		if(empty($name))
		{
			$this->error = '缺少参数';
			return false;
		}
		$bhv = new ProjectBehavior;
		$project = $bhv->getProject($project_id);

		$template = new AgencyTemplate;
		$template->agency_id = $agency_id;
		$template->project_category = $project->type;
		$template->name = $name;
		$template->save();
		
		$criteria = new CDbCriteria;
		$criteria->addCondition('is_deleted = 0 AND project_id ='.$project_id);
		$docs = ProjectDoc::model()->findAll($criteria);
		if(empty($docs))
		{
			$this->error='项目文件为空';
			return false;
		}
		foreach($docs as $doc)
		{
			$criteria = new CDbCriteria;
			$criteria->addCondition('project_doc_id = '.$project_id.' AND from_agency_category = '.$project->agency_category);
			$rules = ProjectDocRule::model()->findAll($criteria);
			if(!empty($rules))
			{
				$temp_doc = new AgencyTemplateDoc;
				$temp_doc->agency_id = $agency_id;
				$temp_doc->template_id = $template->id;
				$temp_doc->project_level = $doc->level;
				$temp_doc->doc_id = $doc->doc_id;
				$temp_doc->save();

				foreach($rules as $rule)
				{
					$temp_rule =  new AgencyTemplateDocRule;
					$temp_rule->agency_doc_temp_id = $temp_doc->id;
					$temp_rule->to_agency_category = $rule->to_agency_category;
					$temp_rule->type = $rule->type;
					$temp_rule->ctime = time();
					$temp_rule->save();
				}
			}
		}
	}

	public function detail($id)
	{
		return ProjectDocTemplate::model()->findByPk($id);

	}

	public function edit($params = null)
	{
		$model = $this->detail($params['id']);
		$model->project_level = $params['project_level'];
		$model->save();
		
		$rules = $model->rule();
		$agency_rule = $params['agency_rule'];

		foreach($rules as $r)
		{
			if(empty($agency_rule[$r->to_agency_category]))
			{
				$r->delete();
			}else{
				$r->type = $agency_rule[$r->to_agency_category];
				$r->save();
				$rule[$r->to_agency_category] = $r->type;
			}
		}
		foreach($agency_rule as $k=>$v)
		{
			if(!empty($v))
			{
				if(empty($rule[$k]))
				{
					$m = new ProjectDocTemplateRule;
					$m->pro_doc_temp_id = $model->id;
					$m->to_agency_category = $k;
					$m->type = $v;
					$m->save();
				}
			}
		}
		return true;
	}




	public function getRules($id)
	{
		$template = $this->detail($id);
		$rules = $template->rule();
		$arr = array();
		foreach($rules as $v)
		{
			$arr[$v['to_agency_category']] = $v['type'];
		}
		return $arr;
	}
	public function sysTemplateAddFiles($category,$agency_id,$files)
	{
		if(empty($files))
			return false;
		$files = explode(',',$files);

		foreach($files as $v)
		{
			$criteria = new CDbCriteria;
			$criteria->addCondition('agency_category = '.$agency_id.' AND project_category ='.$category.' AND doc_id ='.$v);

			$model = ProjectDocTemplate::model()->find($criteria);
			if(empty($model))
			{

				$model = new ProjectDocTemplate;
				$model->agency_category = $agency_id;
				$model->project_category = $category;
				$model->project_level = 1;
				$model->doc_id = $v;
				$doc = DocumentBehavior::get($v);
				$model->file_id = $doc['file_id'];
				$model->save();
				$this->templateDocRule($model->id,$agency_id,$agency_id);
			}
		}
		return true;
	}


	public function templateDocRule($t_doc_id,$from,$to,$type=6)
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('pro_doc_temp_id = '.$t_doc_id.' AND to_agency_category ='.$to);
		$model = ProjectDocTemplateRule::model()->find($criteria);
		if(empty($model))
		{
				$model = new ProjectDocTemplateRule;
				$model->pro_doc_temp_id = $t_doc_id;
				$model->to_agency_category = $to;
				$model->ctime = time();
		}
		$model->type = $type;
		return $model->save();
	}




	public function getTreeList($params=array())
	{	
		$bhv = new CategoryBehavior;
		$categorys = $bhv->getArrayList();
		if(empty($params['type']))
			$files = $this->getList($params);
		else
			$files = $this->getDocList($params);

		$result = $this->getTreeChildren($categorys,$files);
	
		//绑定顶级文件位置
		if(!empty($files))
		{
			foreach($files as $f)
			{
				if($f['category_id'] == 0)
				{
					$temp['doc_id'] = $f['doc_id'];
					$temp['temp_doc_id'] = $f['id'];
					$temp['name'] = $f['name'];
					$result[] = $temp;
				}
			}
		}
		$bhv = new DocumentBehavior;
		$data = $bhv->tidyTree($result);
		$data = $bhv->tidyArray($data);
		return $data;
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
							$temp['temp_doc_id'] = $f['id'];
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

	public function getDocList($params=array())
	{
		$criteria = new CDbCriteria;
		if(!empty($params['project_category']))
			$criteria->addCondition('type = '.$params['project_category']);
		if(!empty($params['agency_category']))
		{
			$files = $this->getList($params);
			if(!empty($files))
			{
				foreach($files as $v)
					$rm_files[] = $v['doc_id'];
				$criteria->addNotInCondition('id',$rm_files);				
			}
		}
		$criteria->addCondition('is_deleted = 0');
		return Document::model()->findAll($criteria);
	}

	public function getList($params)
	{
		$criteria = new CDbCriteria;
		if(!empty($params['agency_category']))
			$criteria->addCondition('agency_category = '.$params['agency_category']);
		if(!empty($params['project_category']))
			$criteria->addCondition('project_category = '.$params['project_category']);
		$models = ProjectDocTemplate::model()->findAll($criteria);
		$arr = array();
		if(!empty($models))
		{
			foreach($models as $model)
			{
				$temp = $model->getAttributes();
				$temp['name'] = 	$model->doc()->name;
				$temp['category_id'] = 	$model->doc()->category_id;
				$arr[] = $temp;
			}
		}
		return $arr;
	}
}
