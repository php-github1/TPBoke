<?php
namespace app\admin\controller;
use think\Controller;
class Article extends Controller{
	//文章列表
	public function articlelist(){
		$articles=model('Article')->with('cate')->order(['atop'=>'asc','create_time'=>'desc'])->paginate(5);
		$this->assign("articles",$articles);
		return view("articlelist");
	}
	//文章添加
	public function articleadd(){
		if(request()->isAjax()){
			$data=[
				'title'=>input('post.title'),//文章标题
				'tags'=>input('post.tags'),//文章标签
				'atop'=>input('post.is_top',0),//是否推荐
				//复选框有个特殊的情况，不选择的话值是传不过去的，所以需要判断值有没有传过来
				//如果有值的话就是它本身，没有值默认为0
				'cateid'=>input('post.cateid'),//所属栏目
				'desc'=>input('post.desc'),//文章概要
				'content'=>input('post.content')//文章内容
			];
			$result=model('Article')->add($data);
			if($result==1)
			{
				$this->success("添加文章成功","admin/article/articlelist");
			}else{
				$this->error($result);
			}
		}
		//添加文章需要先知道属于哪个导航，先查导航
		$cates=model('Cate')->select();
		$this->assign("cates",$cates);
		return view("articleadd");
	}
	//推荐操作
	public function articletop(){
		$data=[
			"id"=>input("post.id"),
			"atop"=>input("post.atop")?0:1,//指atop有的话记为0没有记为1
		];
		$result=model('Article')->top($data);
		if($result==1){
			$this->success("操作成功","admin/article/articlelist");
		}
		else{
			$this->error($result);
		}
	}
	//文章编辑
	public function edit(){
		if(request()->isAjax()){
			$data=[
				'id'=>input('post.id'),
				'title'=>input('post.title'),
				'tags'=>input('post.tags'),
				'atop'=>input('post.atop',0),
				'cateid'=>input('post.cateid'),
				'desc'=>input('post.desc'),
				'content'=>input('post.content')
			];
			$result=model('Article')->edit($data);
			if($result==1)
			{
				$this->success("文章编辑成功","admin/article/articlelist" );
			}else{
				$this->error($result);
			}
		}
		$articleInfo=model('Article')->find(input('id'));
		$cates=model('Cate')->select();
		$this->assign("articleInfo",$articleInfo);
		$this->assign("cates",$cates);
		return view("edit");
	}
	//文章删除
	public function articleDel(){
			 $AtricleInfo=model('Article')->find(input('post.id'));
		    $result=$AtricleInfo->delete();
			if($result){
				$this->success("删除成功","admin/article/articlelist");
			}else{
				$this->error("删除失败");	
		}
	}
};