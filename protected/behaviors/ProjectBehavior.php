<?php
class ProjectBehavior extends BaseBehavior
{
	public function iDownload($doc_id,$user_id = 0)
	{
		$model = ProjectDoc::model()->findByPk($doc_id);
		if(!empty($model))
		{
			$bhv = new FilesComponent;
			$new = $model->history();
			if(!empty($new))
			{
				if(isset($_GET['version']))
				{
					if($_GET['version']==0)
						$bhv->downloadById($model->file_id,$model->doc()->name);
					else{
						if($_GET['version'] > count($new))
						{
							$result['errcode'] = 305;
							$result['errmsg'] = '不存在文件版本';
							return $result;
						}
						$bhv->downloadById($new[$_GET['version']-1]->file_id,$model->doc()->name);
					}
				}else
					$bhv->downloadById($new[count($new)-1]->file_id,$model->doc()->name);
			}else{
				$bhv->downloadById($model->file_id,$model->doc()->name);
			}
		}else{
			$result['errcode'] = 303;
			$result['errmsg'] = '文件不存在';
			return $result;
		}
	}


	public function iDelete($doc_id)
	{
		$doc = $this->getProjectDoc($doc_id);
		if(empty($doc))
		{
			$result['errcode'] = 303;
			$result['errmsg'] = '文件不存在';
			return $result;
		}
		$project = $this->getProject($doc->project_id);

		$rules = $doc->rule();
		if(empty($rules))
		{
			$result['errcode'] = 201;
			$result['errmsg'] = '权限问题';
			return $result;
			//$this->controller()->showError(201);
			$this->error = '文件无授权';
			return false;
		}
		foreach($rules as $v)
		{
			if($v->from_agency_category == $project->agency_category)
			{
				$rule[] = $v['to_agency_category'];
			}
		}
		$rule = array_unique($rule);

		//获取要同步的项目库
		$projects = $this->getDocPushProject($doc->project_id , $rule);

		//获取要同步的文件,以文件的初始版本是否相同作为同步条件，不包括文件名称、目录、创建人。
		$criteria = new CDbCriteria;
		$criteria->addInCondition('project_id',$projects);
		$criteria->addCondition('is_deleted = 0');
		$criteria->addCondition('file_id = '.$doc->file_id);
		$docs = ProjectDoc::model()->findAll($criteria);
		foreach($docs as $v)
		{
			$doc_project =  $this->getProject($v->project_id);
			$doc_rules = $v->rule();

			//删除权限
			foreach($doc_rules as $r)
			{
				if(($r->from_agency_category == $project->agency_category) && ($r->to_agency_category == $doc_project->agency_category))
				{
					$r->delete();

					//删除文件
					if(count($doc_rules) == 1)
					{
						$v->is_deleted = 1;
						$v->save();
					}
				}
			}
		}
		$result['errcode'] = 0;
		$result['errmsg'] = 'success';
		return $result;
	}



	public function iPreUpload($data)
	{
		$bhv = new FilesComponent;
		$file = $bhv->get($data['hash']);
		if(empty($file))
		{
			$result['exist'] = 0;
		}else{
			$result['exist'] = 1;
		}



		//上传与更新区分	
		if(empty($data['doc_id']))
		{


			//检查项目
			$project = Project::model()->findByPk($data['project_id']);
			if(empty($project))
			{
				$this->error = '没有该项目 '.$data['project_id'];
				$result['errcode'] = 400;
				$result['errmsg'] = '没有该项目 '.$data['project_id'];
				return $result;
			}

			if(empty($data['path']))
			{
				$this->error = '参数错误，缺少path';
				$result['errcode'] = 101;
				$result['errmsg'] = '参数错误，缺少path';
				return $result;
			}


			if(empty($file))
			{
				$result['errcode'] = 0;
				$result['errmsg'] = 'success';
				return $result;
			}else{


				//创建project doc
				$model = new ProjectDoc;
				$model->project_id = $data['project_id'];
				
				//创建文件
				$doc_bhv = new DocumentBehavior;
				$category = $doc_bhv->category($data['path']);

				$doc = $doc_bhv->create($file['id'],$category['id'],$file['name'],$project['category'],$project['agency_id']);


				$criteria = new CDbCriteria;
				$criteria->addCondition('project_id = '.$data['project_id']);
				$criteria->addCondition('doc_id = '.$doc['id']);
				$count = ProjectDoc::model()->count($criteria);
				if($count)
				{
					$result['errcode'] = 304;
					$result['errmsg'] = '文件已经存在';
					return $result;

				}

				$model->doc_id = $doc['id'];
				$model->file_id = $doc['file_id'];
				$model->version = 0;
				$model->current_file_id = $doc['file_id'];
				$model->level = $project['current_level'];
				$model->ctime = time();
				$model->save();
			
				//创建文件权限
				$rule = new ProjectDocRule;
				$rule->project_doc_id =	$model->id;
			
				$agency = Agency::model()->findByPk($project['agency_id']);
				if(empty($agency))
				{
					$this->error = '参数错误，不存在的机构';
					$result['errcode'] = 101;
					$result['errmsg'] = '参数错误，不存在的机构';
					return $result;
				}

				$rule->from_agency_category = $agency['category'];
				$rule->to_agency_category = $agency['category'];
				$rule->type = 6;
				$user_id = Yii::app()->user->getId();
				if(!empty($user_id))
					$rule->user_id = $user_id;
				$rule->save();
			}
		}else{
			//验证更新版本是否是最新的

			$doc = $this->getProjectDoc($data['doc_id']);
			if(empty($doc))
			{
				$this->error = '不存在的文件';
				$result['errcode'] = 101;
				$result['errmsg'] = '参数错误，不存在的文件';
				return $result;
			}


			if(empty($data['comment']))
			{
				$result['errcode'] = 101;
				$result['errmsg'] = '参数错误';
				return $result;
			}
			if(!isset($data['version']))
			{
				$result['errcode'] = 101;
				$result['errmsg'] = '参数错误';
				return $result;
			}

			if($data['version'] != $doc['version'])
			{
				$this->error = "版本冲突，请先更新到最新版";
				$result['errcode'] = 300;
				$result['errmsg'] = '版本冲突，请先更新到最新版';
				return $result;
			}

			if(empty($file))
			{

				$result['errcode'] = 0;
				$result['errmsg'] = 'success';
				return $result;
			}else{

				$this->createHistory($data['doc_id'],$data['version'],$file['id'],$data['comment']);
				$model = $this->getProjectDoc($data['doc_id']);
			}
		}
		$temp['doc_id'] = $model['id'];
		$temp['version'] = $model['version']+1;
		$temp['name'] = $model->doc()->name;
		$temp['size'] = $model->doc()->files()->file_size;
		$temp['type'] = $model->doc()->files()->file_type;
		$temp['extension'] = $model->doc()->files()->file_extension;
		$result['errcode'] = 0;
		$result['errmsg'] = 'success';
		$result['data'] = $temp;
		return $result;
	}



	public function iUpload()
	{
		$bhv = new FilesComponent;
		$file = $bhv->upload('file');
		if(empty($file))
		{
			$result['errcode'] = 303;
			$result['errmsg'] = '文件不存在';
			return $result;
		}
		$result['errcode'] = 0;
		$result['errmsg'] = 'success';
		$result['data'] = $file;
		return $result;
	}

/*

	public function iUpload($data)
	{
		//检查项目
		$project = Project::model()->findByPk($data['project_id']);
		if(empty($project))
		{
			$this->error = '没有该项目 '.$data['project_id'];
			return false;
		}

		$bhv = new FilesComponent;
		$file = $bhv->get($data['hash']);
		if(empty($file))
			$file = $bhv->upload('file');
		

		//上传与更新区分	
		if(empty($data['doc_id']))
		{
			if(empty($data['path']))
			{
				$result['errcode'] = 101;
				$result['errmsg'] = '参数错误，缺少path';
				return $result;
			}

			//创建project doc
			$model = new ProjectDoc;
			$model->project_id = $data['project_id'];
			
			//创建文件
			$doc_bhv = new DocumentBehavior;
			$category = $doc_bhv->category($path);

			$doc = $doc_bhv->create($file['id'],$category['id'],$_FILES['file']['name'],$project['category'],$data['agency_id']);

			$model->doc_id = $doc['id'];
			$model->file_id = $doc['file_id'];
			$model->version = 0;
			$model->current_file_id = $doc['file_id'];
			$model->level = $project['current_level'];
			$model->save();
			
			//创建文件权限
			$rule = new ProjectDocRule;
			$rule->project_doc_id =	$model->id;
			
			$agency = Agency::model()->findByPk($data['agency_id']);
			if(empty($agency))
			{
				$this->error = '参数错误，不存在的机构';
				$result['errcode'] = 101;
				$result['errmsg'] = '参数错误，不存在的机构';
				return $result;
			}

			$rule->from_agency_category = $agency['category'];
			$rule->to_agency_category = $agency['category'];
			$rule->type = 6;
			$user_id = Yii::app()->user->getState('user_id');
			if(!empty($user_id))
				$rule->user_id = $user_id;
			$rule->save();
			
		}else{
			//验证更新版本是否是最新的
			$this->createHistory($data['doc_id'],$data['version'],$file->id,$data['comment']);
			$model = $this->getProjectDoc($data['doc_id']);

		}
		$temp['doc_id'] = $model['id'];
		$temp['version'] = $model['version']+1;
		$temp['name'] = $model->doc()->name;
		$temp['name'] = $model->doc()->name;
		$temp['size'] = $model->doc()->files()->file_size;
		$temp['type'] = $model->doc()->files()->file_type;
		$temp['extension'] = $model->doc()->files()->file_extension;
		$result['errcode'] = 0;
		$result['errmsg'] = 'success';
		$result['data'] = $temp;
		return $result;
	}



*/


	public function createHistory($doc_id,$version,$file_id,$memo)
	{
		//验证更新版本是否是最新的
		$doc = $this->getProjectDoc($doc_id);	
		if(empty($doc))
		{
			$this->error = '不存在的文件';
			return false;
		}
		if($version != $doc['version'])
		{
			$this->error = "版本冲突，请先更新到最新版";
			return false;
		}

		//检查文件授权情况
		$criteria = new CDbCriteria;
		$criteria->addCondition('project_doc_id = '.$doc_id);
		$rules = ProjectDocRule::model()->findAll($criteria);
		if(empty($rules))
		{
			$this->error = '文件无授权';
			return false;
		}
		foreach($rules as $v)
		{
			$rule[] = $v['to_agency_category'];
		}
		$rule = array_unique($rule);

		//获取要同步的项目库
		$projects = $this->getDocPushProject($doc->project_id , $rule);

		//获取要同步的文件,以文件的初始版本是否相同作为同步条件，不包括文件名称、目录、创建人。
		$criteria = new CDbCriteria;
		$criteria->addInCondition('project_id',$projects);
		$criteria->addCondition('is_deleted = 0');
		$criteria->addCondition('file_id = '.$doc->file_id);
		$docs = ProjectDoc::model()->findAll($criteria);
		foreach($docs as $v)
		{
			$this->setHistory($v->id,$file_id,$memo);
		}
	}


	public function setHistory($doc_id,$file_id,$memo)
	{
		$doc = $this->getProjectDoc($doc_id);

		$history = new ProjectDocHistory;
		$history->project_doc_id = $doc_id;
		$history->file_id = $file_id;
		$history->version = $doc->version+1;
		$history->memo = $memo;
		$history->user_id = Yii::app()->user->getId();
		$history->ctime = time();
		$history->save();
		$doc->version = $doc->version+1;
		$doc->save();
	}

	public function iGetHistory($doc_id)
	{
		$result['errcode'] = 0;
		$result['errmsg'] = 'success';

		$criteria = new CDbCriteria;
		$criteria->addCondition('project_doc_id = '.$doc_id);
		$history = ProjectDocHistory::model()->findAll($criteria);
		if(empty($history))
		{

			$result['data'] = array();
			return $result;

		}

		foreach($history as $v)
		{
			$temp['version'] = $v['version'];
			$temp['user_name'] = $v->user()->name;
			$temp['ctime'] = date('Y-m-d H:i:s',$v['ctime']);
			$temp['memo'] = $v['memo'];
			$result['data'][]=$temp;
		}
		return $result;
	}






	public function iGetComment($doc_id)
	{
		$result['errcode'] = 0;
		$result['errmsg'] = 'success';

		$criteria = new CDbCriteria;
		$criteria->addCondition('project_doc_id = '.$doc_id);
		$comment = ProjectDocComment::model()->findAll($criteria);
		if(empty($comment))
		{

			$result['data'] = array();
			return $result;

		}

		foreach($comment as $v)
		{
			$temp['id'] = $v['id'];
			$temp['version'] = $v['doc_version'];
			$temp['user_name'] = $v->user()->name;
			$temp['ctime'] = date('Y-m-d H:i:s',$v['ctime']);
			$temp['content'] = $v['comment'];
			$result['data'][]=$temp;
		}
		return $result;

	}

	public function iComment($doc_id,$content)
	{
		$doc = $this->getProjectDoc($doc_id);
		if(empty($doc))
		{
			$result['errcode'] = 303;
			$result['errmsg'] = '文件不存在';
			return $result;
		}
		$model = new ProjectDocComment;
		$model->project_doc_id = $doc_id;
		$model->doc_version = $doc->version;
		$model->user_id = Yii::app()->user->getId();
		$model->ctime = time();
		$model->comment = $content;
		$model->save();
		$result['errcode'] = 0;
		$result['errmsg'] = 'success';
		return  $result;
	}



	public function iRule($doc_id,$rules)
	{
		$doc = $this->getProjectDoc($doc_id);
		if(empty($doc))
		{
			$result['errcode'] = 303;
			$result['errmsg'] = '文件不存在';
			return $result;
		}
		foreach($rules as $v)
		{
			if($v['type'] != 0)
				$arr[$v['agency_category']] = $v['type'];
		}

		var_dump($arr);
		$rule = $doc->rule();
		var_dump(CJSON::decode(CJSON::encode($rule)));
		$project = $this->getProject($doc->project_id);
		//检查是否有权限
		$criteria = new CDbCriteria;
		$criteria->addCondition('project_doc_id = '.$doc_id);
		$criteria->addCondition('to_agency_category = '.$project['agency_category']);
		$criteria->addCondition('type = 6');
		$count = ProjectDocRule::model()->count($criteria);
		if(empty($count))
		{
			$result['errcode'] = 201;
			$result['errmsg'] = '没有权限修改';
			return $result;
		}

		//修改权限
		foreach($rule as $r)
		{
			echo $r->from_agency_category.'=<br>';
			if($r->from_agency_category == $project->agency_category)
			{
				echo $r->to_agency_category.'<br>';

				if(empty($arr[$r->to_agency_category]))
				{
					//删除权限
					$relation_project = $this->getDocPushProject($doc->project_id,array($r->to_agency_category));
					var_dump($relation_project);
					if(!empty($relation_project))
					{
						$criteria = new CDbCriteria;
						$criteria->addCondition('project_id = '.$relation_project[0]);
						$criteria->addCondition('file_id = '.$doc->file_id);
						$criteria->addCondition('is_deleted = 0');
						$docs = ProjectDoc::model()->findAll($criteria);
						if(!empty($docs))
						{
							foreach($docs as $d)
							{
								$criteria = new CDbCriteria;
								$criteria->addCondition('project_doc_id = '.$d->id);
								$criteria->addCondition('from_agency_category = '.$project->agency_category);
								$criteria->addCondition('to_agency_category = '.$r->to_agency_category);
								$del_rule = ProjectDocRule::model()->find($criteria);
								if(!empty($del_rule))
								{
									$del_rule->delete();
								}else{
									$this->errorLog('纳尼，怎么可能没找到');
								}
								//......如果文件没有权限了，处理成自身文件。
								$other_rule = $d->rule();
								if(empty($other_rule))
								{
									$other = new ProjectDocRule;
									$other->project_doc_id = $d->id;
									$other->from_agency_category = $r->to_agency_category;
									$other->to_agency_category = $r->to_agency_category;
									$other->type = 6;
									$other->ctime = time();
									$other->save();
								}
							}
						}
					}
					$r->delete();
				}else{
					if($arr[$r->to_agency_category] != $r->type)
					{
						//修改权限
						$relation_project = $this->getDocPushProject($doc->project_id,array($r->to_agency_category));
						if(!empty($relation_project))
						{
							$criteria = new CDbCriteria;
							$criteria->addCondition('project_id = '.$relation_project[0]);
							$criteria->addCondition('file_id = '.$doc->file_id);
							$criteria->addCondition('is_deleted = 0');
							$docs = ProjectDoc::model()->findAll($criteria);
							if(!empty($docs))
							{
								foreach($docs as $d)
								{
									$criteria = new CDbCriteria;
									$criteria->addCondition('project_doc_id = '.$d->id);
									$criteria->addCondition('from_agency_category = '.$project->agency_category);
									$criteria->addCondition('to_agency_category = '.$r->to_agency_category);
									$del_rule = ProjectDocRule::model()->find($criteria);
									if(!empty($del_rule))
									{
										$del_rule->type = $arr[$r->to_agency_category];
										$del_rule->save();
									}else{
										$this->errorLog('纳尼，怎么可能没找到');
									}
								}
							}
						}
						$r->type = $arr[$r->to_agency_category];
						$r->save();
					}
				}

			}

		}
		//添加权限
		foreach($arr as $k=>$a)
		{
			$criteria = new CDbCriteria;
			$criteria->addCondition('project_doc_id = '.$doc->id);
			$criteria->addCondition('from_agency_category = '.$project->agency_category);
			$criteria->addCondition('to_agency_category = '.$k);
			$model = ProjectDocRule::model()->find($criteria);
			if(empty($model))
			{
				$model = new ProjectDocRule;
				$model->project_doc_id = $doc->id;
				$model->from_agency_category = $project->agency_category;
				$model->to_agency_category = $k;
				$model->type = $a;
				$model->user_id = Yii::app()->user->getId();
				$model->ctime = time();
				$model->save();
				//给关联库添加文件和权限；
				$relation_project = $this->getDocPushProject($doc->project_id,array($k));
				if(!empty($relation_project))
				{
					$criteria = new CDbCriteria;
					$criteria->addCondition('project_id = '.$relation_project[0]);
					$criteria->addCondition('file_id = '.$doc->file_id);
					$criteria->addCondition('is_deleted = 0');
					$docs = ProjectDoc::model()->findAll($criteria);
					if(!empty($docs))
					{
						foreach($docs as $d)
						{
							/*
							$criteria = new CDbCriteria;
							$criteria->addCondition('project_doc_id = '.$d->id);
							$criteria->addCondition('from_agency_category = '.$project->agency_category);
							$criteria->addCondition('to_agency_category = '.$r->to_agency_category);
							$del_rule = ProjectDocRule::model()->find($criteria);
							if(empty($del_rule))
							{
							*/
								$model = new ProjectDocRule;
								$model->project_doc_id = $d->id;
								$model->from_agency_category = $project->agency_category;
								$model->to_agency_category = $k;
								$model->type = $a;
								$model->user_id = Yii::app()->user->getId();
								$model->ctime = time();
								$model->save();
							/*
							}else{
								$this->errorLog('纳尼，怎么可能已经有了');
							}
							*/
						}
					}else{
						$p = new ProjectDoc;
						$p->project_id = $relation_project[0];
						$p->doc_id = $doc->doc_id;
						$p->file_id = $doc->file_id;
						$p->version = 0;
						$p->current_file_id = $doc->current_file_id;
						$p->level = $doc->level;
						$p->memo = $doc->memo;
						$p->ctime = time();
						$p->save();

						$model = new ProjectDocRule;
						$model->project_doc_id = $p->id;
						$model->from_agency_category = $project->agency_category;
						$model->to_agency_category = $k;
						$model->type = $a;
						$model->user_id = Yii::app()->user->getId();
						$model->ctime = time();
						$model->save();
					}
				}
			}
		}

		$result['errcode'] = 0;
		$result['errmsg'] = 'success';
		return  $result;
	}




	public function getDocPushProject($project_id,$agencys)
	{
		$project = $this->getProject($project_id);
		if($project->agency_category == 1)
		{
			$criteria = new CDbCriteria;
			$criteria->addCondition('is_deleted = 0 AND relation_project = '.$project_id);
			$projects = Project::model()->findAll($criteria);
			$projects[] = $project;
		}else{
			if($project->relation_project != 0)
			{
				$criteria = new CDbCriteria;
				$criteria->addCondition('is_deleted = 0 AND relation_project = '.$project->relation_project);
				$projects = Project::model()->findAll($criteria);
			}else{
				$projects[] = $project;
			}
		}
		foreach($projects as $v)
		{
			if(in_array($v->agency_category,$agencys))
			{
				$result[] = $v->id; 
			}
		}
		return $result;
	}






	public function iGetDocList($params)
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('project_id = '.$params['project_id']);
		$criteria->order = 'mtime  ASC';
		if(empty($params['utime']))
		{
			$criteria->addCondition('is_deleted = 0');
		}else{
			$criteria->addCondition('mtime > '.$utime);
		}
		$models = ProjectDoc::model()->findAll($criteria);
		$cpt = new FilesComponent;
		
		$result['errcode'] = 0;
		$result['errmsg'] = 'success';
		$result['utime'] = 0;
		$result['data'] = array();

		if(!empty($models))
		{
			foreach($models as $v)
			{
				$arr['doc_id'] = $v->id;
				$arr['version'] = $v->version;
				$doc = DocumentBehavior::get($v->doc_id);
				$arr['name'] = $doc->name;
				$file = $cpt->getById($v->current_file_id);
				$arr['size'] = $file->file_size;
				$arr['path'] = CategoryBehavior::getPath($v->doc()->category_id);
				$arr['level'] = $v->level;
				$arr['owner'] = $v->owner;
				$arr['memo'] = $v->memo;
				$rules = $v->rule();
				$rule = array();
				foreach($rules as $r)
				{
					$rule[] = $r['to_agency_category'];
				}
				$arr['share'] = array_unique($rule);
				if($v->is_deleted == 1)
					$arr['type'] = 'D';
				else
					$arr['type'] = 'M';
				$data[] = $arr;
			}
			$result['utime'] = $v->mtime;
			$result['data'] = $data;
		}

		return $result;
	}









	public function getProjectDoc($pro_doc_id)
	{
		return ProjectDoc::model()->findByPk($pro_doc_id);
	}










	//项目载入模板
	public function initTemplate($project_id,$template_id = 0)
	{
		$project = $this->getProject($project_id);

		if(empty($project))
		{
			$this->error = 'project不存在，参数错误';
			return false;
		}
		if($project->template_id !== NULL)
		{
			$this->error = '项目模板已经存在';
			return false;
		}

		//导出文件
		if($template_id == 0)
		{
			$criteria = new CDbCriteria;
			$criteria->addCondition('agency_category = '.$project['agency_category']);
			$criteria->addCondition('project_category = '.$project['category']);
			$docs = ProjectDocTemplate::model()->findAll($criteria);
			foreach($docs as $v)
			{
				//生成文件
				$criteria = new CDbCriteria;
				$criteria->addCondition('project_id = '.$project_id);
				$criteria->addCondition('doc_id = '.$v->doc_id);
				$project_doc = ProjectDoc::model()->find($criteria);
				if(empty($project_doc))
				{
					$project_doc = new ProjectDoc;
					$project_doc->project_id = $project_id;
					$project_doc->doc_id = $v->doc_id;
					//获取文档信息
					$doc_bhv = new DocumentBehavior;
					$doc = $doc_bhv->get($v->doc_id);

					$project_doc->file_id = $doc->file_id;
					$project_doc->version = 0;
					$project_doc->current_file_id = $doc->file_id;
					$project_doc->level = $v->project_level;
					$project_doc->memo = $doc->memo;
					$project_doc->ctime = time();
					$project_doc->save();
				}
				//生成文件权限
				$criteria = new CDbCriteria;
				$criteria->addCondition('pro_doc_temp_id = '.$v->id);
				$rules = ProjectDocTemplateRule::model()->findAll($criteria);
				foreach($rules as $value)
				{
					$criteria = new CDbCriteria;
					$criteria->addCondition('project_doc_id = '.$project_doc->id);
					$criteria->addCondition('from_agency_category = '.$project['agency_category']);
					$criteria->addCondition('to_agency_category = '.$value->to_agency_category);
					$rule = ProjectDocRule::model()->find($criteria);
					if(empty($rule))
					{
						$rule = new ProjectDocRule;
						$rule->project_doc_id = $project_doc->id;
						$rule->from_agency_category = $project['agency_category']; 
						$rule->to_agency_category = $value->to_agency_category;
					}
					$rule->type = $value->type;
					$user_id = Yii::app()->user->getId();
					if(!empty($user_id))
						$rule->user_id = $user_id;
					$rule->ctime = time();
					//$rule->is_deleted = 0;
					$rule->save();
				}
			
			}
		
		}else{
			$criteria = new CDbCriteria;
			$criteria->addCondition('template_id ='.$template_id);
			$docs = AgencyTemplateDoc::model()->findAll($criteria);
			foreach($docs as $v)
			{
				//生成文件
				$criteria = new CDbCriteria;
				$criteria->addCondition('project_id = '.$project_id);
				$criteria->addCondition('doc_id = '.$v->doc_id);
				$project_doc = ProjectDoc::model()->find($criteria);
				if(empty($project_doc))
				{
					$project_doc = new ProjectDoc;
					$project_doc->project_id = $project_id;
					$project_doc->doc_id = $v->doc_id;
					//获取文档信息
					$doc_bhv = new DocumentBehavior;
					$doc = $doc_bhv->get($v->doc_id);

					$project_doc->file_id = $doc->file_id;
					$project_doc->version = 0;
					$project_doc->current_file_id = $doc->file_id;
					$project_doc->level = $v->project_level;
					$project_doc->memo = $doc->memo;
					$project_doc->ctime = time();
					$project_doc->save();
				}
				//生成文件权限
				$criteria = new CDbCriteria;
				$criteria->addCondition('agency_doc_temp_id = '.$v->id);
				$rules = AgencyTemplateDocRule::model()->findAll($criteria);
				foreach($rules as $value)
				{
					$criteria = new CDbCriteria;
					$criteria->addCondition('pro_doc_id = '.$project_doc->id);
					$criteria->addCondition('from_agency_category = '.$project['agency_category']);
					$criteria->addCondition('to_agency_category = '.$value->to_agency_category);
					$rule = ProjectDocRule::model()->find($criteria);
					if(empty($rule))
					{
						$rule = new ProjectDocRule;
						$rule->project_doc_id = $project_doc->id;
						$rule->from_agency_category = $project['agency_category']; 
						$rule->to_agency_category = $value->to_agency_category;
					}
					$rule->type = $value->type;
					$user_id = Yii::app()->user->getId();
					if(!empty($user_id))
						$rule->user_id = $user_id;
					$rule->ctime = time();
					//$rule->is_deleted = 0;
					$rule->save();
				}
			}

				
		}



		$project->template_id = $template_id;
		$project->save();
		//合并文件
		if($project->relation_project!=0)
		{
			$this->mergerProject($project->relation_project,$project->id);
		}
	}


	//合并项目
	public function mergerProject($enterprise_project_id,$project_id)
	{
		$model = $this->getProject($project_id);
		$model->relation_project = $enterprise_project_id;
		$model->save();
		$criteria = new CDbCriteria;
		$criteria->addCondition('is_deleted = 0');
		$criteria->addCondition('relation_project = '.$enterprise_project_id);
		$projects = Project::model()->findAll($criteria);
	
		//关联项目
		$ids[] = $enterprise_project_id;
		foreach($projects as $v)
		{
			$ids[] = $v->id;	
		}
		foreach($projects as $v)
		{
			$criteria = new CDbCriteria;
			$criteria->addCondition('is_deleted = 0');
			$criteria->addCondition('project_id ='.$v->id);
			$docs = ProjectDoc::model()->findAll($criteria);
			foreach($docs as $doc)
			{
				$criteria = new CDbCriteria;
				$criteria->addCondition('project_doc_id = '.$doc->id);
				$criteria->addCondition('from_agency_category = '.$v->agency_category);
				$criteria->addCondition('to_agency_category != '.$v->agency_category);
				$rules = ProjectDocRule::model()->findAll($criteria);
				foreach($rules as $rule)
				{
					$criteria = new CDbCriteria;
					$criteria->addInCondition('id',$ids);
					$criteria->addCondition('agency_category = '.$rule->to_agency_category);
					$project = Project::model()->find($criteria);
					//如果关联机构项目已经存在
					if(!empty($project))
					{
						$criteria = new CDbCriteria;
						$criteria->addCondition('project_id = '.$project->id);
						$criteria->addCondition('doc_id = '.$doc->doc_id);
						$new_doc = ProjectDoc::model()->find($criteria);
						if(empty($new_doc))
						{
							$new_doc = new ProjectDoc;
							$new_doc->project_id = $project->id;
							$new_doc->doc_id = $doc->doc_id;
							$new_doc->file_id = $doc->file_id;
							$new_doc->version = 0;
							$new_doc->current_file_id = $doc->current_file_id;
							$new_doc->level = $doc->level;
							$new_doc->memo = $doc->memo;
							$new_doc->ctime = time();
							$new_doc->is_deleted = 0;
							$new_doc->save();
						}
						//查询添加权限
						$criteria = new CDbCriteria;
						$criteria->addCondition('project_doc_id = '.$new_doc->id);
						$criteria->addCondition('from_agency_category = '.$v->agency_category);
						$criteria->addCondition('to_agency_category = '.$rule->to_agency_category);
						$new_rule = ProjectDocRule::model()->find($criteria);
						if(empty($new_rule))
						{
							$new_rule = new ProjectDocRule;
							$new_rule->project_doc_id = $new_doc->id;
							$new_rule->from_agency_category = $v->agency_category;
							$new_rule->to_agency_category = $rule->to_agency_category;
						}
						$new_rule->type = $rule->type;
						$new_rule->save();

					}

				}
			}
		
		}
	
	}

	public function getProject($id)
	{
		return Project::model()->findByPk($id);
	}



}
