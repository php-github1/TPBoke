<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
class Index extends Controller
{
    function login(){
    	if(request()->isAjax()){
    		//从login.html点击提交过来的，判断如果是ajax请求来的数据
    		//返回值datatype是json格式的，所以
    		$data=[
    			'username'=>input('post.username'),
    			'password'=>input('post.password')
    		];
    		//写完这步以后创建一个管理员的模型
    	//把这些数据交给模型进行校验,交给模型的方式1、可以引入命名空间2、使用助手函数
    	//1、new \app\model\Admin();
    	//2、model(name:'Admin');
    	//在模型里定义一个login方法，并且把前台数据传输给它
    	$result=model('Admin')->login($data);
    	  if($result==1){
    	  	$this->success('登录成功',"admin/home/index");
    	  }
    	  else{
    	  	$this->error($result);
    	  }
    	}
		return view("login");
	}
	public function showUsersInfo(){
		return $this->fetch("showusersInfo");
	}
	//注册页面
	public function register(){
		if(request()->isAjax()){
			$data=[
				"username"=>input('post.username'),
				"password"=>input('post.password'),
				"conpass"=>input('post.conpass'),
				"nickname"=>input('post.nickname'),
				"email"=>input('post.email')
			];
			$result=model('Admin')->register($data);
			if($result==1){
			   $this->success('注册成功',"admin/index/login");
			}
			else{
				$this->error($result);
			}
		}
	    return $this->fetch("register");
	}
	//忘记密码
	public function forget(){
		if(request()->isAjax()){
			$code=mt_rand(1000, 9999);
			session('code',$code);
			$data=[
				'email'=>input('post.email')
			];
			$result=model('Admin')->forget($data);
			if($result==1){
				$this->success('验证码发送成功');
			}
			else{
				$this->error($result);
			}
		}
		return view("forget");
	}
	//重置密码
	public function reset(){
		$data=[
			'code'=>input('post.code'),
		    'email'=>input('post.email')
		];
		$result=model("Admin")->reset($data);
		
		if($result==1){
			$this->success('密码重置成功，请去邮箱查看新密码','admin/index/login');
		}
		else{
			$this->error($result);
		}
	}
	
}
?>