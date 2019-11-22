<?php
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Comment extends Model{
	use SoftDelete;
	//定义一个关联模型，只知道评论用户的ID，需要知道用户名
	//关联文章
	public function article(){
		//多对一的关系，一篇文章可以有多条评论
		return $this->belongsTo("Article","articleid","id");
	}
	//关联用户
	public function member(){
		//多对一的关系
		return $this->belongsTo("Member","memberid","id");
	}
}