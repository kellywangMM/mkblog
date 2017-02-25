<?php 
	namespace Admin\Controller;
	use  Think\Controller;
	/**
	* 判断用户是否登陆
	*/
	class CommonController extends Controller
	{
		
		public function _initialize(){
			$_SESSION['user'];
			if(!isset($_SESSION['user'])){
				$this->redirect('Login/index');
			};
		}
	}
 ?>