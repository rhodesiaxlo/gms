<?php 
/*
 * 管理用户控制器
 * Auth   : Ghj
 * Time   : 2016年07月29日 
 * QQ     : 912524639
 * Email  : 912524639@qq.com
 * Site   : http://guanblog.sinaapp.com/
 */
 
namespace Admin\Controller;

class UserAdminController extends AccordController {

	//系统默认模型
	public $Model = null;
	//当前模型名称
	public $Model_Name;

    protected function _initialize() {
		//设置控制器名称
		$this->Model_Name='UserAdmin';
		//继承初始化方法
		parent::_initialize ();
    }
/* 扩展数据 开始 */



/* 扩展数据 结束 */
}
