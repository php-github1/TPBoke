<?php
use think\Route;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::group('admin',function(){
	Route::rule('/','admin/index/login','get|post');
	Route::rule('register','admin/index/register','get|post');
	Route::rule('forget','admin/index/forget','get|post');
	Route::rule('reset','admin/index/reset','get|post');
});
