<?php
namespace app\admin\controller;
use think\Controller;
class Home extends Controller{
	//后台首页
	public function index(){
		
		return $this->fetch("index");
	}
	//退出登录
	public function loginout(){
		session(null);
		if(session('?admin.id')){
			$this->error("退出失败");
		}
		else{
		$this->success("退出成功","admin/index/login");
		}
	}
}