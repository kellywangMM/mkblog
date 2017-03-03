<?php 
	/**
	 * @Author: kelly
	 * @Date:   2017-03-01 13:08:15
	 * @Last Modified by:   kelly
	 * @Last Modified time: 2017-03-02 14:05:13
	 */
	namespace Admin\Controller;
	use Think\Controller;
	use Think\Page;
	/**
	* 分类
	*/
	class CategoryController extends CommonController
	{
		// 分类列表
		public function management()
		{
			# code...
			$userInfo=$_SESSION['Admin'];
			$this->assign('userInfo',$userInfo);

			$category=D('category');
			$page=new Page($category->count(),5);
			$btn=$page->show();
			//模糊查询
			$where['name']=array('like','%'.I('get.name').'%');
			$list=$category->where($where)->order('createTime')->limit($page->firstRow,$page->listRows)->select();
			$listInfo['data']=$list;
			$listInfo['btn']=$btn;
			$this->assign('listInfo',$listInfo);
			$this->assign('list',$list);
			$this->display('management');
		}
		// 添加分类
		public function addCategory(){
			$category=D('category');
			$_category=$category->where(array('name' => I('post.name')))->find();
			if($_category){
				$res['success']=0;
				$res['message']='分类名称已经存在！';
				$this->ajaxReturn($res);
			}else{
				$insert_id=$category->data(I('post.'))->add();
				if($insert_id){
					$res['success']=1;
					$res['message']='保存成功！';
					$this->ajaxReturn($res);
				}else{
					$res['success']=0;
					$res['message']='保存失败！';
					$this->ajaxReturn($res);
				}
			}
		}
		// 获取分类列表
		public function getCategories(){
			$category=D('category');
			$page=new Page($category->count(),5);
			$btn=$page->show();
			//模糊查询
			$where['name']=array('like','%'.I('get.name').'%');
			$list=$category->where($where)->order('createTime')->limit($page->firstRow,$page->listRows)->select();
			$res['success']=1;
			$res['data']=$list;
			$res['btn']=$btn;
			$this->ajaxReturn($res);
		}
	}
 ?>
