<?php 
	namespace Admin\Controller;
	use  Think\Controller;
	/**
	* 判断用户是否登陆
	*/
	class CommonController extends Controller
	{
		public function _initialize(){
			if(!isset($_SESSION['Admin'])){
				$this->redirect('Login/index');
			}
		}
	}
 ?>