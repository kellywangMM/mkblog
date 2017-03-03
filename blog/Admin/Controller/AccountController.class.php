<?php 
	/**
	 * @Author: kelly
	 * @Date:   2017-03-01 20:40:02
	 * @Last Modified by:   kelly
	 * @Last Modified time: 2017-03-01 22:59:47
	 */
	namespace Admin\Controller;
	use Think\Controller;
	use Think\Page;
	/**
	* 分类
	*/
	class AccountController extends CommonController
	{
		// 账号列表
		public function management()
		{
			# code...
			$userInfo=$_SESSION['Admin'];
			$this->assign('userInfo',$userInfo);
			$this->display('management');
		}
		// 获取账号列表
		public function getAccounts(){
			$category=D('category');
			$categories=$category->where(array('name' => I('post.name')))->find();
			$res['success']=1;
			$res['data']=$categories;
			$this->ajaxReturn($res);
		}
	}
