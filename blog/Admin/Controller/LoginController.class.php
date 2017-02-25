<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
	//用于加密的秘钥
	protected $key='Mona';
    public function index(){
    	$this->display('login');
    }
    //登录处理
    public function doLogin(){
		$accounts=D('accounts');
		//查找是否存在用户名
		$person=$accounts->find(I('post.name'));
		//存在再判断密码是否存在
		if(!empty($person)){
		//获取表单输入的密码,进行加密后比对
			$inputPwd=$this->doEncrypt($this->key,I('post.password'));
			if($person['password']==$inputPwd){
				unset($person['password']);
				$_SESSION['Admin']=$person;
			}else{
				$this->ajaxReturn('用户名或密码错误!','json');
			}
		}
    }
    //加密函数
    protected function doEncrypt($key,$str){
    	//秘钥md5加密,从索引为5取出8位
    	$prev=substr(md5($this->$key),5,8);
    	//输入的密码md5加密,从索引为8取出10位
    	$next=substr(md5($str),8,10);
    	return md5($prev.$next);
    }
    //忘记密码处理
    public function doForgetPwd(){

    }
    //注册处理
    public function doRegister(){
    	$accounts=D('accounts');
    	if(I('post.password')!=I('post.rpassword')){
    		$this->error('重复密码不正确');
    		exit;
    	}
    	//删除确认密码
    	unset($_POST['rpassword']);
    	$accounts->data(I('post.'))->add();
    }
    public function verifyCode(){

    }
}