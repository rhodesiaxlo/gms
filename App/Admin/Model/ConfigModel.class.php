<?php 
/*
 * 配置模型
 * Auth   : Ghj
 * Time   : 2016年07月27日 
 * QQ     : 912524639
 * Email  : 912524639@qq.com
 * Site   : http://guanblog.sinaapp.com/
 */
 
namespace Admin\Model;
use Think\Model;

class ConfigModel extends Model{
	
    /*模型中定义的表*/
	protected $tableName = 'config'; 

    /* 自动验证规则 */
	protected $_validate = array(
 
	);

    /* 自动完成规则 */
	protected $_auto = array(
		array("create_time","time",1,"function"),

		array("update_time","time",3,"function"),

	);

/* 扩展数据 开始 */

    /* 更新配置缓存数据 */
	public function cache(){
		$_Config = $this->where(array('status'=>1))->getField ( 'name,value' );
		file_put_contents( APP_PATH . 'Common/Conf/db_extend.php',"<?php\nreturn " . var_export($_Config, true) . ";\n?>");
	}
/* 扩展数据 结束 */
}