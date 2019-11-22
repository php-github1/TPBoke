<?php
namespace app\admin\controller;
use think\Controller;
class Admin extends Controller{
	//管理员列表
	public function all(){
		$admins=model('Admin')->order('super','desc')->order('status','desc')->paginate(5);
		$this->assign("admins",$admins);
		return view("all");
	}
	//管理员添加
	public function add(){
		if(request()->isAjax()){
			$data=[
				"username"=>input("post.username"),
				"password"=>input("post.password"),
				"conpwd"=>input("post.conpwd"),
				"nickname"=>input("post.nickname"),
				"email"=>input("post.email")
			];
			$result=model('Admin')->add($data);
			if($result==1){
				$this->success("管理员添加成功","admin/admin/all");
			}else{
				$this->error($result);
			}
		}
		return view("adminadd");
	}
	//管理员状态的改变
	public function status(){
		$data=[
			"id"=>input("post.id"),
			"status"=>input("post.status")? 0 : 1
		];
		$result=model('Admin')->status($data);
		if($result==1){
			$this->success("操作成功",'admin/admin/all');
		}else{
			$this->error($result);
		}
	}
	public function edit(){
		$data=[
			"id"=>input("id")
		];
		$adminInfo=model('Admin')->find(input("id"));
		$this->assign("adminInfo",$adminInfo);
		if(request()->isAjax()){
			$data=[
				"id"=>input("post.id"),
				"username"=>input("post.username"),
				"password"=>input("post.password"),
				"nickname"=>input("post.nickname"),
				"email"=>input("post.email")
			];
			$result=model('Admin')->edit($data);
			if($result==1){
				$this->success("管理员编辑成功","admin/admin/all");
			}else{
				$this->error($result);
			}
		}
		return view("adminedit");
	}
	public function del(){
		$AdminInfo=model('Admin')->find(input('post.id'));
		$result=$AdminInfo->delete();
		if($result){
			$this->success("管理员删除成功","admin/admin/all");
		}else{
			$this->error("管理员删除失败");
		}
	}
}