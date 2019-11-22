<?php
namespace app\admin\validate;
use think\Validate;
class Cate extends Validate{
	protected $rule=[
		"catename|栏目名称"=>'require|unique:cate',//表示跟cate表比较有唯一性
		"sort|排序"=>'require|number',
	];
	/* protected $msg=[
		'catename.require'=>'栏目名称不能为空哦',
	];不嫌麻烦 可以自己定义提示语句*/
	protected $scene=[
		'add'=>['catename','sort'],
		'sort'=>['sort'],
		'edit'=>['catename']
	];
}
