<?php 
/*
 * 文档模型
 * Auth   : Ghj
 * Time   : 2016年07月31日 
 * QQ     : 912524639
 * Email  : 912524639@qq.com
 * Site   : http://guanblog.sinaapp.com/
 */
 
namespace Home\Model;
use Think\Model;

class DocumentModel extends Model{
	
    /*模型中定义的表*/
	protected $tableName = 'document'; 

    /* 自动验证规则 */
	protected $_validate = array(
 
	);

    /* 自动完成规则 */
	protected $_auto = array(
		array("update_time","time",3,"function"),
		array("create_time","time",1,"function"),
		array("position","Get_Checkbox_Value",3,"function"),
		array("username","get_username",3,"function"),
		array("uid","is_login",3,"function"),
	);

/* 扩展数据 开始 */


/* 扩展数据 结束 */
}