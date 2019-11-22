<?php
namespace app\admin\controller;
use think\Controller;

class Cate extends Controller{
	//栏目列表
	public function catelist(){

	 $cates = model('Cate')->order('sort', 'asc')->paginate(2);
        $viewData = [
            'cates' => $cates
        ];
        $this->assign($viewData);
		return view("catelist");
	}
	//栏目添加
	public function addlist(){
		if(request()->isAjax()){
			$data=[
				'catename'=>input('post.catename'),
				'sort'=>input('post.sort')
			];
			$result=model("Cate")->addlist($data);
			if($result==1){
				$this->success("栏目添加成功","admin/cate/catelist");
			}
			else{
				$this->error($result);
			}
		}
		return view("addlist");
	}
	public function sort(){
		$data=[
			"id"=>input('post.id'),
			"sort"=>input('post.sort')
		];
		$result=model('Cate')->sort($data);
		if($result==1){
			$this->success("排序成功","admin/cate/catelist");
		}
		else{
			$this->error($result);
		}
	}
	public function edit(){
		if(request()->isAjax()){
			$data=[
					'id'=>input('id'),
					'catename'=>input('catename')
					];
			$result=model('Cate')->edit($data);
			if($result==1){
				$this->success("编辑成功","admin/cate/catelist");
			}
			else{
				$this->error($result);
			}
		}
		$cateInfo=model('Cate')->find(input('id'));
		$this->assign("cateInfo",$cateInfo);
		return $this->fetch("edit");
	}
	//栏目删除
	public function Del(){
		//先查询后删除
		//with('article')先找到栏目对应的文章，然后together('article')将对应文章一起删除
	     $cateInfo=model('Cate')->with('article')->find(input('post.id'));
		 $result=$cateInfo->together('article')->delete();
	    if($result){
	    	$this->success("删除成功",'admin/cate/catelist');
	    }
	    else{
	    	$this->error("删除失败");
	    }
	}
}