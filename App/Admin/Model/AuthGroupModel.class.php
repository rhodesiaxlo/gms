<?php 
/*
 * 用户组模型
 * Auth   : Ghj
 * Time   : 2016年07月27日 
 * QQ     : 912524639
 * Email  : 912524639@qq.com
 * Site   : http://guanblog.sinaapp.com/
 */
 
namespace Admin\Model;
use Think\Model;

class AuthGroupModel extends Model{
	
    /*模型中定义的表*/
	protected $tableName = 'auth_group'; 

    /* 自动验证规则 */
	protected $_validate = array(
 
	);

    /* 自动完成规则 */
	protected $_auto = array(
		array("rules","Get_Checkbox_Value",3,"function"),

	);

/* 扩展数据 开始 */


/* 扩展数据 结束 */
}