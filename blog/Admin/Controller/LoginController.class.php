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
		$name=htmlspecialchars(I('post.name'));
		$person=$accounts->where(array('name'=>$name))->find();
		//存在再判断密码是否存在
		if(!empty($person)){
		//获取表单输入的密码,进行加密后比对
			$inputPwd=$this->doEncrypt($this->key,I('post.password'));
			if($person['password']==$inputPwd){
				//除密码之外的用户信息都存入session中
				unset($person['password']);
				$_SESSION['Admin']=$person;
				$res['success']=1;
				$res['message']='登录成功!';
    			$this->ajaxReturn($res);
			}else{
				$res['success']=0;
				$res['message']='用户名或密码错误!';
    			$this->ajaxReturn($res);
			}
		}else{
				$res['success']=0;
				$res['message']='用户名不存在!';
    			$this->ajaxReturn($res);
		}
    }
    //登出处理
    public function doLogout(){
        //清除用户session
        $_SESSION['Admin']=null;
        $this->redirect('Login/index');
    }
    //注册处理
    public function doRegister(){
    	$accounts=D('accounts');
    	if(I('post.password')!=I('post.rpassword')){
    		$res['success']=0;
			$res['message']='重复密码不正确!';
    		$this->ajaxReturn($res);
    	}
    	$name=htmlspecialchars(I('post.name'));
    	$person=$accounts->where(array('name'=>$name))->find();
    	if($person){
    		$res['success']=0;
			$res['message']='用户名已经被注册!';
    		$this->ajaxReturn($res);
    	}
    	$email=$accounts->where(array('email'=>I('post.email')))->find();
    	if($email){
    		$res['success']=0;
			$res['message']='邮箱已经被注册!';
    		$this->ajaxReturn($res);
    	}
    	//删除确认密码
    	unset($_POST['rpassword']);
    	$_POST['password']=$this->doEncrypt($this->key,$_POST['password']);
    	$insert_id=$accounts->data(I('post.'))->add();
    	if($insert_id){
    		$res['success']=1;
			$res['message']='注册成功!';
    		$this->ajaxReturn($res);
    	}else{
    		$res['success']=0;
			$res['message']='注册失败!';
    		$this->ajaxReturn($res);
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
    //忘记密码处理 通过邮箱找回密码
    public function doForgetPwd(){
    	//$email=I('post.email');
    	$email="1104935178@qq.com";
    	$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
    	if(!preg_match($pattern,$email)){
    		$this->error('请输入合法的邮箱!');
    		exit;
    	}
    	$person=$accounts=D('accounts')->where(array('email'=>$email))->find();
    	if(!$person){
    		$this->error('邮箱未注册!');
    		exit;
    	}
        sendMail($email, '小妞','123');
    }
    public function verifyCode(){

    }
}