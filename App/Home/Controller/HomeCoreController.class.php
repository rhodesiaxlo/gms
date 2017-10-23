<?php

/* Home核心控制器
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 * Describe	: 判断权限,读取管理菜单
 */
 
namespace Home\Controller;
use Common\Controller\CoreController;

class HomeCoreController extends CoreController {

	/* 初始化方法
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 判断权限
	 */
    protected function _initialize() {

		//继承CoreController的初始化函数
        parent::_initialize();
	}
}