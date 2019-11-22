<?php
namespace app\admin\validate;

use think\Validate;
class Admin extends Validate{
	 protected $rule=[
		'username|管理员账户'=>'require',
		'password|密码'=>'require',//验证不为空
		'conpass|确认密码'=>'require|confirm:password',
 		'email|邮箱' => 'require|email',
 		'nickname|昵称' => 'require',
	 	'code|验证码'=>'require',
	 	'conpwd|确认密码'=>'require|confirm:password'
	 	];
	/*  protected $mag=[
	 	'username.require'=>'账户不能为空'
	 ]; */
	//登录验证场景
	protected $scene=[
			'login'=>['username','password'],
			'register'=>['username'=>'unique:admin', 'password', 'conpass', 'email','nickname'],
			//可以在验证场景里附加规则，因为写在全局里其他的操作用不上这个规则，所以写在局部里
			'forget'=>['email'],
			'reset'=>['code'],
			//添加管理员的规则
			'add'=>['username'=>'require|unique:admin', 'password', 'conpwd','nickname', 'email'],
			//管理员编辑
			'edit'=>[ 'password','nickname']
	];
	
	
	
}