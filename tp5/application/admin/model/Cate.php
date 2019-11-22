<?php
  namespace app\admin\model;
  use think\Model;
  use traits\model\SoftDelete;

class Cate extends Model{
  	use SoftDelete;
  	//级联删除，删除栏目时，栏目对应的文章也要删除
  	public function article(){
  		//一对多的关系，一个栏目可以对应多个模型
  		return $this->hasMany('Article','id','cataid');
  		//参数2:关联的外键，参数三：关联的主键
  	}  	
  	public function addlist($data){
  	   $validate = new \app\admin\validate\Cate();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else {
            return 0;
        }
  	}
  	public function sort($data){
  		$validate=new \app\admin\validate\Cate();
  		if(!$validate->scene('sort')->check($data)){
  			$validate->getError();
  		}
  		else{
  			//更新操作要先查询后更新
  			$cateInfo=$this->find($data['id']);
  			$cateInfo->sort=$data['sort'];
  			$result=$cateInfo->save();
  			if($result){
  				return 1;
  			}
  			else{
  				return "排序失败";
  			}
  		}
  	}
  	//栏目编辑
  	public function edit($data){
  		$validate=new \app\admin\validate\Cate();
  		if(!$validate->scene('edit')->check($data)){
  			$validate->getError();
  		}
  		/* $cateInfo=$this->find($data['id']);
  		$cateInfo->catename=$data['catename'];
  		$result=$cateInfo->save(); */
  		$result = $this->isUpdate(true)->save($data);
  		if($result){
  			return 1;
  		}
  		else {
  			return "栏目编辑失败";
  		}
  	}
  
  }