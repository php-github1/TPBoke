<?php
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Member extends Model{
	use SoftDelete;
	//只读字段
	protected $readonly=['username','email'];
	//关联评论，用户删除时对应的评论也删除
	public function comments(){
		//一对多
		return $this->hasMany("Comment","memberid","id");
	}
	public function add($data){
		$validate=new \app\admin\validate\Member();
		if(!$validate->scene('add')->check($data)){
			return $validate->getError();
		}
		$result=$this->allowField(true)->save($data);
		if($result){
			return 1;
		}
		else {
			return "会员添加失败";
		}
	}
	public function edit($data){
		$validate=new \app\admin\validate\Member();
		if(!$validate->scene('edit')->check($data)){
			return $validate->getError();
		}
		$memberInfo=$this->find($data["id"]);
		$memberInfo->password=$data["password"];
		$memberInfo->nickname=$data['nickname'];
		$result=$memberInfo->save();
		if($result){
			return 1;
		}
		else{
			return "会员修改失败";
		}
	}
}