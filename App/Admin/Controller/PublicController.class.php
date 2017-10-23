<?php

/* 后台公共控制器
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 * Describe	: 判断权限,读取管理菜单
 */

namespace Admin\Controller;
use Common\Controller\CoreController;

class PublicController extends CoreController {
	
	/* 登录
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 判断权限
	 */
    public function login( $_Map = '' ){
		
		//判断请求类型 和 是否为内部调用
        if(IS_POST || $_Map!=''){
			
			//判断传递参数是否为空
			if($_Map==''){
				
				//不为空则证明是页面提交
				
				//获取提交数据
				$username = I ( "post.username", "", "trim" );
				$password = md5(I ( "post.password", "", "trim" ));
				
				//对提交数据进行判断
				if (empty ( $username ) || empty ( $password )) {
					
					//提交数据错误，返回登录网关
					$this->error ( "用户名或者密码不能为空，请重新输入！", U ( C ( 'AUTH_USER_GATEWAY' ) ) );
					
				}
				
				//进行查询数据拼装
				$_Map = array (
						'username' => $username,
						'password' => $password,
						'status' => 1 
				);
				
			}
			
			//对数据库中的User表数据进行读取
			$_UserInfo = M ( 'User' )->where ( $_Map )->find ();
			
			//判断返回的登录数据
			if ($_UserInfo) {
				
				//读取返回数据中的用户组信息
				$_Auth_Group_Data=M('AuthGroup')->where (array('id'=>array( 'in' , $_UserInfo['group_ids'] )))->find ();
				
				//设置默认用户组名称
				$_UserInfo['group_title']=$_Auth_Group_Data['title'];
				
				//对用户标识Key进行赋值
				session(C('AUTH_KEY'),$_UserInfo['id']);
				
				//对用户信息进行赋值
				session('UserInfo',$_UserInfo);
				
				//判断是否有记住登录的数据
				if( I("post.rember_password") ){
					
					//记住登录
					
					//判断是否设置了，登录时间的功能
					if(C('?ADMIN_REME')){
						
						//如果有，则使用配置中的设置
						$admin_reme=C('ADMIN_REME');
						
					}else{
						//没有，则使用默认的3600秒，即1小时
						$admin_reme=3600;
						
					}
					
					//存储登录信息
					cookie( 'rember_user' , $_Map , $admin_reme );
					
				}else{
					
					//清除Cookie中的缓存登录信息
					cookie( 'rember_user' , NULL );
				
				}
				
				//行为，记录登录操作
				action_log('Admin_Login', 'User', $_UserInfo ['id']);
				
				//返回登录成功信息
				$this->success ( "登录成功！", U ( C ( 'AUTH_USER_INDEX' ) ) );
				
			} else {
				
				//登录失败
				
				//清除Cookie中的缓存登录信息
				cookie( 'rember_user' , NULL );
				
				//返回登录失败信息
				$this->error ( "用户名密码错误或者此用户已被禁用！", U ( C ( 'AUTH_USER_GATEWAY' ) ) );
				
			}
        } else {
			
			//为获取到登录数据，且不是内部调用
			
			//判断是否已经登录系统
            if(is_login()){
				
				//已经登录系统，跳转到默认网关
                $this->redirect(U ( C ( 'AUTH_USER_INDEX' ) ));
				
            }else{
				
				//未登录
				
				//读取记住登录数据
				$_Map = cookie('rember_user');
				
				//判断登录数据是否存在
				if( count($_Map) > 0 ){
					
					//存在登录数据，通过内部调用，直接登录
                	$this->login($_Map);
					
				}else{
					
					//不存在登录数据，显示登录界面
                	$this->display();
					
				}
            }
        }
    }

	/* 退出登录
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 判断权限
	 */
    public function logout(){
		
		//获取登录数据
		$Login_Sta = is_login();
		
		//判断当前用户是否登录
		if (!$Login_Sta) {
			
			//未登录，返回错误，并且跳转到登录网关
			$this->error ( "尚未登录", U ( C ( 'AUTH_USER_GATEWAY' ) ) );
			
		}else{
			
			//登录状态
			
			//清空Session中的缓存
			session ( null );
			
			//清除Cookie中的缓存登录信息
			cookie( 'rember_user' , NULL );
			
			//判断登录数据是否存在
			if ( is_login() ) {
				
				//存在证明登录失败，返回错误信息，并且跳转到默认网关
				$this->error ( "退出失败", U ( C ( 'AUTH_USER_INDEX' ) ) );
				
			}else{
				
				//不存在证明退出成功
				
				//日志，记录用户退出记录
				action_log('Admin_Logout', 'User', $Login_Sta, $Login_Sta);
				
				//返回成功信息，并且跳转到登录网关
				$this->success ( "退出成功！", U ( C ( 'AUTH_USER_GATEWAY' ) ) );
				
				
			}
		
		}
	
    }

}
