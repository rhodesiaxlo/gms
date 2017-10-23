<?php

/* 后台核心控制器
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 * Describe	: 判断权限,读取管理菜单
 */
 
namespace Admin\Controller;
use Common\Controller\CoreController;

class AdminCoreController extends CoreController {

	/* 初始化方法
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 判断权限
	 */
    protected function _initialize() {

		//继承CoreController的初始化函数
        parent::_initialize();

		//获取session中的认证Key
		$_AUTH_KEY = session(C('AUTH_KEY'));

		//判断认证Key, 如果小于1即为未登录状态
		if( $_AUTH_KEY < 1 ) {

			//跳转到当前模块配置中的登录网关
			redirect(U(C('AUTH_USER_GATEWAY')));

		}else{

			//判断是否为超级管理员
			if(!is_admin($_AUTH_KEY)){

				//如果不是超级管理员,进行当前操作的权限验证

				//拼装节点
				$_Auth_Rule = MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME;

				//通过Is_Auth进行权限判断
				if (!Is_Auth($_Auth_Rule)) {
	
					//验证失败返回错误信息
					$this->error ( '你没有权限进行 ' . $_Auth_Rule . ' 操作！' );
	
				}
			}
		}
	}

	/* 后台菜单
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 获取当前有权限的菜单树
	 */
	protected function Get_Menu(){

		//获取后台菜单缓存
		$_Admin_Menu = session('_Admin_Menu');

		//如果缓存菜单数量小于1，或者运行状态（RUN_STA）不为1（生产环境），即读取菜单
		if(count($_Admin_Menu) < 1 || C('RUN_STA') != 1){

			//获取session中的认证Key
			$_AUTH_KEY = session(C('AUTH_KEY'));

			//判断当前用户，是否是超级用户中的用户
			if (in_array ( $_AUTH_KEY , C ( 'AUTH_ADMIN' ) )) {

				//是超级用户,设置查询条件为，非隐藏和启用的菜单
				$_Map = array (
						'hide' => 0,
						'status' => 1 
				);

			} else {

				//非超级用户

				//实例化Auth权限管理类
				$_Auth = new \Auth();

				//获取当前用户 所在的所有组（即一个用户可以存在于多个用户组中）
				$_Group_List = $_Auth -> getGroups( $_AUTH_KEY );

				//规则ID数组
				$_Rule_List = array ();

				//判断当前用户所在组的数量是否小于1
				if( count($_Group_List) < 1 ){
	
					//没有任何用户组权限，返回错误
					$this->error ( '你没有系统的任何权限！',U('Public/logout'));
	
				}

				//循环所有的用户组返回数据
				foreach ( $_Group_List as $_Group_One ) {
	
					//分解用户组规则号，并且与原有规则ID进行合并
					$_Rule_List = array_merge ( $_Rule_List, explode ( ',', trim ( $_Group_One ['rules'], ',' ) ) );
	
				}

				//移除重复的规则ID
				$_Rule_List = array_unique ( $_Rule_List );

				//设置查询条件为，非隐藏和启用的菜单，ID在规则ID数组中
				$_Map = array (
						'id' => array ( 'in' , $_Rule_List ),
						'hide' => 0,
						'status' => 1 
				);

			}

			//根据前面生成的查询条件 读取用户组所有权限规则
			$_Rule_Arr = M ( 'AuthRule' )->where ( $_Map )->field ( 'id,pid,name,title,icon' )->order ( 'sort asc' )->select ();

			//循环所有规则
			foreach ( $_Rule_Arr as $_Rid=>$_Rule_One ) {

				//设置规则解析后的URL
				$_Rule_Arr[$_Rid]['url'] = U($_Rule_One['name']);

			}

			//对规则进行 有键值的树状化
			$_Admin_Menu = list_to_tree2 ( $_Rule_Arr, $_Pk = 'id', $_Pid = 'pid', 'children' );

			//清空原有规则数据
			session ( '_Admin_Menu', null );

			//对Session中的缓存进行覆盖
			session('_Admin_Menu',$_Admin_Menu);

		}
		return $_Admin_Menu;
	}

	/* 获取CURD中的主导航
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 可以在继承的控制器中，重构，继承和修改
	 */
	public function Get_Main_Nav($_Type){

		//对获取导航的类型进行判断
		if($_Type=='sort_l'){

			//列表界面的主导航

			//对返回数据进行拼装
			$_Return_Data = '<dd><a class="current" href="JavaScript:void(0);" onclick="Data_Reload(\''.CONTROLLER_NAME.'_Data_List\');"><span>列表</span></a></dd>
				<dd><a href="JavaScript:void(0);" onclick="Data_Search(\''.CONTROLLER_NAME.'_Search_From\',\''.CONTROLLER_NAME.'_Data_List\');"><span>搜索</span></a></dd>';

			//进行权限判断
			if(Is_Auth(MODULE_NAME.'/'.CONTROLLER_NAME.'/add')){

				$_Return_Data = $_Return_Data.'<dd><a href="JavaScript:void(0);" onclick="GoUrl(\''.U(MODULE_NAME.'/'.CONTROLLER_NAME.'/add').'\')"><span>新增</span></a></dd>';

			}

		}elseif($_Type=='sort_a'){

			//新增界面的主导航

			//进行权限判断
			if(Is_Auth(MODULE_NAME.'/'.$this->Model_Name.'/index')){

				$_Return_Data = $_Return_Data.'<dd><a href="JavaScript:void(0);" onclick="GoUrl(\''.U(MODULE_NAME.'/'.CONTROLLER_NAME.'/index').'\')"><span>列表</span></a></dd>';

			}

			$_Return_Data = $_Return_Data.'<dd><a class="current" href="JavaScript:void(0);" onclick="GoUrl(\''.U(MODULE_NAME.'/'.CONTROLLER_NAME.'/add').'\')"><span>新增</span></a></dd>';

		}elseif($_Type=='sort_e'){

			//更新界面的主导航

			//进行权限判断
			if(Is_Auth(MODULE_NAME.'/'.$this->Model_Name.'/index')){

				$_Return_Data = $_Return_Data.'<dd><a href="JavaScript:void(0);" onclick="GoUrl(\''.U(MODULE_NAME.'/'.CONTROLLER_NAME.'/index').'\')"><span>列表</span></a></dd>';

			}
			
			//进行权限判断
			if(Is_Auth(MODULE_NAME.'/'.CONTROLLER_NAME.'/add')){

				$_Return_Data = $_Return_Data.'<dd><a href="JavaScript:void(0);" onclick="GoUrl(\''.U(MODULE_NAME.'/'.CONTROLLER_NAME.'/add').'\')"><span>新增</span></a></dd>';

			}

			$_Return_Data = $_Return_Data.'<dd><a class="current" href="JavaScript:void(0);"><span>更新</span></a></dd>';

		}elseif($_Type=='extend'){
			
			//列表界面的主导航

			//进行权限判断
			if(Is_Auth(MODULE_NAME.'/'.$this->Model_Name.'/index')){

				$_Return_Data = $_Return_Data.'<dd><a href="JavaScript:void(0);" onclick="GoUrl(\''.U(MODULE_NAME.'/'.CONTROLLER_NAME.'/index').'\')"><span>列表</span></a></dd>';

			}
			
			//进行权限判断
			if(Is_Auth(MODULE_NAME.'/'.CONTROLLER_NAME.'/add')){

				$_Return_Data = $_Return_Data.'<dd><a href="JavaScript:void(0);" onclick="GoUrl(\''.U(MODULE_NAME.'/'.CONTROLLER_NAME.'/add').'\')"><span>新增</span></a></dd>';

			}
		}else{

			//如果没有传递正确的参数

			//返回错误信息
			$_Return_Data = "数据错误";

		}

		//返回数据
		return $_Return_Data;

	}


	/* 模块预设模版变量
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 
	 */
	protected function Set_TMPL_PARSE() {
		
		//获取原有模版预设
		$TMPL_PARSE_STRING = C('TMPL_PARSE_STRING');
		
		$TMPL_PARSE_STRING['__STATIC__'] = __ROOT__ . '/Public/Static';
		
		//合并原有变量和当前模块变量
		$TMPL_PARSE_STRING = array_merge ( $TMPL_PARSE_STRING ,
				
			//设置当前模块变量
			array(
				'__STATIC__' => __ROOT__ . '/Public/Static',
				'__IMG__'    => __ROOT__ . '/Public/Admin/images',
				'__CSS__'    => __ROOT__ . '/Public/Admin/css',
				'__JS__'     => __ROOT__ . '/Public/Admin/js',
			)
		
		);
		
		//覆盖模版变量
		C( 'TMPL_PARSE_STRING' , $TMPL_PARSE_STRING );
		
	}
}