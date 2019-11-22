<?php
namespace app\admin\validate;
use think\Validate;
class Member extends Validate{
    protected $rule=[
    	'username|用户名'=>'require|unique:member',
    	'password|密码'=>'require',
    	'nickname|昵称'=>'require',
    	'email|邮箱'=>'require|email',
    ];
    protected  $scene=[
    	'add'=>['username','password','nickname','email'],
    	'edit'=>['password','nickname']
    ];
}