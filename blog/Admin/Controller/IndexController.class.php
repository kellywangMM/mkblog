<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
    	$userInfo=$_SESSION['Admin'];
    	$this->assign('userInfo',$userInfo);
        $this->display('index');
    }
}