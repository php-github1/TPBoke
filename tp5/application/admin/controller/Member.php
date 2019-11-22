<?php
namespace app\admin\controller;
use think\Controller;
class Member extends Controller{
	public function memberlist(){
		$members=model('Member')->paginate(5);
		$this->assign("members",$members);
		return view("memberlist");
	}
	public function memberadd(){
		if (request()->isAjax()){
			$data=[
				"username"=>input('post.username'),
				"password"=>input('post.password'),
			    "nickname"=>input('post.nickname'),
				"email"=>input('post.email')
			];
			$result=model('Member')->add($data);
			if($result==1){
				$this->success('会员添加成功','admin/member/memberlist');
			}
			else{
				$this->error($result);
			}
		}
		return view("memberadd");
	}
	//会员编辑
	public function edit(){
		
		$memberInfo=model('Member')->find(input("id"));
		$this->assign("memberInfo",$memberInfo);
		if(request()->isAjax()){
			$data=[
					"id"=>input("id"),
					"password"=>input("post.password"),
					"nickname"=>input("post.nickname")
					];
			$result=model('Member')->edit($data);
			if($result==1){
				$this->success("修改会员成功","admin/member/memberlist");
			}
			else{
				$this->error($result);
			}
		}
		return view("memberedit");
	}
	//会员删除
	public function del(){
		if(request()->isAjax()){
			$data=[
				"id"=>input("post.id")
			];
			$memberInfo=model("Member")->with("comments")->find($data["id"]);
			$result=$memberInfo->together("comments")->delete();
			if($result){
				$this->success("会员删除成功","admin/member/memberlist");
			}else{
				$this->error("会员删除失败");
			}
		}
	}
}