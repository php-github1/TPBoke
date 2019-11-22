<?php
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Article extends Model{
	use SoftDelete;
	//多表查询用到一个关联模型
	//查所属栏目时在article表里只能查到cateid,要查到catename就要用到关联模型
	//关联栏目表
	public function cate(){
		//多对一：一篇文章只能有一个导航，一个导航可以对应多篇文章
		return $this->belongsTo('Cate','cateid','id');
		//参数一：关联Cate模型,参数2：关联的外键cateid,3:关联的主键id
	}
	public function add($data){
		$validate=new \app\admin\validate\Article();
		if(!$validate->scene('add')->check($data)){
			return $validate->getError();
		}
		$result=$this->allowField(true)->save($data);
		if($result)
		{
			return 1;
		}
		else{
			return "文章添加失败";
		}
	} 
	public function top($data){
		$validate=new \app\admin\validate\Article();
		if(!$validate->scene('top')->check($data)){
			return $validate->getError();
		}
		$articleInfo=$this->find($data["id"]);
		$articleInfo->atop=$data["atop"];
		$result=$articleInfo->save();
		if($result)
		{
			return 1;
		}
		else{
			return "操作失败";
		}
	}
	public function edit($data){
		$validate=new \app\admin\validate\Article();
		if(!$validate->scene('edit')->check($data)){
			return $validate->getError();
		}
		$articles=$this->where("id",$data["id"])->find();
		$articles->title=$data["title"];
		$articles->tags = $data['tags'];
		$articles->atop=$data['atop'];
		$articles->cateid = $data['cateid'];
		$articles->desc = $data['desc'];
		$articles->content = $data['content']; 
		$result =$articles->save();
	
		/* $result = $this->isUpdate(true)->save($data); */
		if($result){
			return 1;
		}
		else {
			return "文章修改失败";
		}
	}
	public function Del($data){
		
		$result=$this->find(input("id"))->delete();
		if($result){
			return 1;
		}
		else{
			return "删除文章失败";
		}
	}
}
