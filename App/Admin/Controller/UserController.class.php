<?php 
/*
 * 用户控制器
 * Auth   : Ghj
 * Time   : 2016年07月05日 
 * QQ     : 912524639
 * Email  : 912524639@qq.com
 * Site   : http://guanblog.sinaapp.com/
 */
 
namespace Admin\Controller;

class UserController extends AdminCoreController {

    protected function _initialize() {
		//继承初始化方法
		parent::_initialize ();
    }
	
	public function updatepassword(){
		if(IS_POST){
			$_Post = I('post.');
			
			if($_Post['password'] != $_Post['repassword']){
				$this->error('重复密码不正确');
				exit;
			}
			
			$User_Info=M('User')->where(array('id'=>is_login()))->find();
			
			if(md5($_Post['old']) != $User_Info['password']){
				$this->error('原密码不正确');
				exit;
			}
			$return=M('User')->where(array('id'=>is_login()))->save(array('password'=>md5($_Post['password'])));
			if($return){
				$this->success('修改成功！');
			}else{
				$this->error('修改密码失败');
			}
		}else{
			$this->display();
		}
	}
	
	public function updateuserinfo(){
		if(IS_POST){
			$_Post = I('post.');
			
			$_Updata = array(
				'nickname' => $_Post['nickname'],
			); 
			
			$return=D('User')->where(array('id'=>is_login()))->save($_Updata);
			if($return){
				$this->success('修改成功！');
			}else{
				$this->error('修改失败');
			}
		}else{
			$UserInfo=M('User')->where(array('id'=>is_login()))->find();
			$this->assign ( 'UserInfo', $UserInfo);
			$this->display();
		}
	}
	
}
