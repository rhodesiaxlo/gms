<?php

/* 系统核心控制器
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 * Describe	: 判断权限,读取管理菜单
 */
 
namespace Common\Controller;
use Think\Controller;

class CoreController extends Controller {
	
	//全局用户信息
	public $_UserInfo;
	
	
	/* 初始化方法
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 判断权限
	 */
	protected function _initialize() {
		
		//读取可以使用模块的列表
		$_OPEN_MOUDEL_LIST = S ( '_OPEN_MOUDEL_LIST' );
		//如果模块列表为空
		if ($_OPEN_MOUDEL_LIST == NULL) {
			
			//更新模块列表缓存
			D('Admin/Module')->cache();
			
			//将模块列表赋值给配置变量
			$_OPEN_MOUDEL_LIST = S ( '_OPEN_MOUDEL_LIST' );
			
		}
		
		//加入一个空元素,防止array_merge出错
		$_OPEN_MOUDEL_LIST[]='';
		
		//将系统默认模块放入可以使用模块列表中
		$_OPEN_MOUDEL_LIST = array_merge($_OPEN_MOUDEL_LIST,array('Admin'));
		
		//判断当前模块是否可以使用
		if( !in_array( MODULE_NAME , $_OPEN_MOUDEL_LIST ) ){
			
			//模块不可用,弹出错误，并且返回到网站根目录
			$this->error('模块未安装，或未启用',__ROOT__);
			
		}
		
		//判断用户是否登录
		if (is_login()) {
			
			//设置用户信息
			$this->_UserInfo = session ( 'UserInfo' );
			
			//设置模版变量
			$this->assign ( '_UserInfo', $this->_UserInfo );
			
		}
		
		//模块预设模版变量
		$this->Set_TMPL_PARSE();
		
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
				'__IMG__'    => __ROOT__ . '/Public/'.MODULE_NAME.'/images',
				'__CSS__'    => __ROOT__ . '/Public/'.MODULE_NAME.'/css',
				'__JS__'     => __ROOT__ . '/Public/'.MODULE_NAME.'/js',
			)
		
		);
		
		//覆盖模版变量
		C( 'TMPL_PARSE_STRING' , $TMPL_PARSE_STRING );
		
	}
}