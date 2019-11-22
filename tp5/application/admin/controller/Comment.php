<?php
namespace app\admin\controller;
use think\Controller;
class Comment extends Controller{
	public function commentlist(){
		$comments=model('Comment')->with("article,member")->paginate(10);
		$this->assign("comments",$comments);
		return view("commentlist");
	}
	public function commentread(){
		return view("commentadd");
	}
	//删除评论
	public function del(){
		$commentInfo=model('Comment')->find(input("post.id"));
		$result=$commentInfo->delete();
		if($result){
			$this->success("评论删除成功","admin/comment/commentlist");
		}else{
			$this->error("评论删除失败");
		}
	}
}