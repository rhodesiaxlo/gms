<?php

/* Api控制器
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 * Describe	: 判断权限,读取管理菜单
 */
 
namespace Home\Controller;

class ApiController extends HomeCoreController {

	/* 初始化方法
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 
	 */
    protected function _initialize() {

		//继承CoreController的初始化函数
        parent::_initialize();
	}
	
	
	/* 获取允许分类的模型
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: Permit_Category_Model在Home的config中配置
	 */
	public function get_model_id(){
		$Permit_Category_Model = C('Permit_Category_Model');
		$_Map['status'] = 1;
		$_Map['id']=array('in',$Permit_Category_Model);
		$_List = M ( 'Model' )->where ( $_Map )->order ( 'sort asc' )->field ( 'id,title as text' )->select ();
		$r_type = I ( 'get.r_type' );
		if ($r_type == 'json') {
			$this->ajaxReturn ( $_List );
		} elseif ($r_type == 'json_list'){
			$data = M ( 'Model' )->where ( $_Map )->getField ( 'id,title as text' );
			echo "var op_modelid=".json_encode ( $data );
		} else {
			return $_List;
		}
	}
	
	/* 获取允许分类树
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: Permit_Category_Model在Home的config中配置
	 */
	public function get_category() {
		$_Pid = I ( 'get.pid', 0 );
		$_Type = I ( 'get.type', 0 );
		$_Map ['status'] = 1;
		$r_type = I ( 'get.r_type' );
		if ($r_type == 'json') {
			if($_Type == 0){
				$_Map ['child'] = 0;
			}
			$_list = M ( 'Category' )->where ( $_Map )->order ( 'sort asc' )->getField ( 'id,pid,title as text' );
			$_list [] = array (
				'id' => '0',
				'pid' => '-1',
				'text' => '根分类'
			);
			$data = list_to_tree ( $_list, 'id', 'pid', 'children', '-1' );
			echo json_encode ( $data );
		} elseif ($r_type == 'json_list'){
			$data = M ( 'Category' )->getField ( 'id,title as text' );
			if($_Type == 1){
				echo "op_category_id=".json_encode ( $data );
			}else{
				echo "op_pid=".json_encode ( $data );
			}
			
		} else{
			return $data;
		}
	}
}