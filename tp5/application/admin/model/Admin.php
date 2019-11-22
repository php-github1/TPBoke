<?php

namespace app\admin\model;

use think\Model;

use traits\model\SoftDelete;

class Admin extends Model
{
    use SoftDelete;
    public function login($data)
    {
        $validate = new \app\admin\validate\Admin();
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        }
        $result = $this->where($data)->find();
        if ($result) {
            if ($result['status'] != 1) {
                return '此账户被禁用！';
            }
            session('admin', ['id' => $result['id'],
                'nickname' => $result['nickname'],
                'super' => $result['super']]);
            return 1;
        }else {
            return '用户名或者密码错误！';
        }
    }
    public function register($data){
    	$validate=new \app\admin\validate\Admin();
    	if(!$validate->scene('register')->check($data)){
    		return $validate->getError();
    	}
    	$result=$this->allowField(true)->save($data);//allowFiled(true)只会保存数据表中有的字段
    	if($result){
    		mailto($data['email'],'注册管理员','注册管理员账户成功');
    		return "1";
    	}
    	else {
    		return "注册失败";
    	}
    }
    public function forget($data){
    	$validate=new \app\admin\validate\Admin();
    	if(!$validate->scene('forget')->check($data)){
    		return $validate->getError();
    	}
    	$result=$this->where($data)->find();
    	
    	if($result){
    		
    		mailto($data['email'], "重置密码验证码--梦中程序员", "您的重置密码验证码是：". session('code'));
    		return 1;
    	}
    	else{
    		return "发送验证码失败";
    	}
    }
    //重置密码
    public function reset($data){
    	$validate=new \app\admin\validate\Admin();
    	if(!$validate->scene("reset")->check($data)){
    		return $validate->getError();
    	}
    	if(session('code')!=$data['code']){
    		return "验证码不正确";
    	}
    	//进行更新和删除工作永远是先查询后更新
    	//先把管理员信息查询出来
    	$adminInfo=$this->where('email',$data["email"])->find();
    	$newpwd=mt_rand(100000,999999);
    	$adminInfo->password=$newpwd;
    	$result=$adminInfo->save();
    	if($result){
    		$subject="恭喜您，密码重置成功";
    		$content='您好，' . $adminInfo['nickname'] . '！<br>' . '您的密码已重置成功。<br>' .
                '用户名：' . $adminInfo['username'] . '<br>' . '新密码：' . $newpwd;
    		mailto($data['email'], $adminInfo['nickname'], $content);
    		return 1;
    	}
    	else{
    		return "重置密码失败";
    	}
    }
    //管理员启用禁用的模型
    public function status($data){
    	$adminInfo=$this->find($data["id"]);
    	$adminInfo->status=$data["status"];
    	$result=$adminInfo->save();
    	if($result){
    		return 1;
    	}else {
    		return "操作失败";
    	}
    }
    //管理员添加
    public function add($data){
    	$validate=new \app\admin\validate\Admin();
    	if(!$validate->scene('add')->check($data)){
    		return $validate->getError();
    	}
    	$result=$this->allowField(true)->save($data);
    	if($result)
    	{
    		return 1;
    	}else{
    		return "管理员添加失败";
    	}
    }
    public function edit($data){
    	$validate=new \app\admin\validate\Admin();
    	if(!$validate->scene('edit')->check($data)){
    		return $validate->getError();
    	}
    	$adminInfo=$this->find($data["id"]);
    	$adminInfo->nickname=$data["nickname"];
    	$adminInfo->password=$data["password"];
    	$result=$adminInfo->save();
    	if($result){
    		return 1;
    	}else{
    		return "管理员编辑失败";
    	}
    }
}
