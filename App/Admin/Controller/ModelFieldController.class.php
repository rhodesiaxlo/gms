<?php

/*
 * 字段属性控制器
 * Auth : Ghj
 * Time : 2015年4月11日
 * QQ : 912524639
 * Email : 912524639@qq.com
 * Site : http://guanblog.sinaapp.com/
 */
namespace Admin\Controller;

use Common\Controller\AdminCore;

class ModelFieldController extends AdminCoreController {
	
	//系统默认模型
	private $Model = null;
	//模型配置信息
	private $ModelInfo = null;
	//模型字段
	private $ModelField = null;
	//模型字段生成文件存储路径
	private $fiepath = null;
	
	/**
	 * 控制器初始化方法
	 */
	protected function _initialize() {
		//继承初始化方法
		parent::_initialize ();
		//设置控制器默认模型
		$this->Model = D ( 'ModelField' );
        //字段类型存放目录
        $this->fields = APP_PATH . 'Common/Fields/';
        //获取默认ID
        $modelid = I('get.modelid', 0, 'intval');
	}
	
	/*
	 * 列表(默认首页)
	 * Auth : Ghj
	 * Time : 2015年07月26日
	 */
	public function index() {
		if (IS_POST) {
			$post_data = I ( 'post.' );
			$post_data ['first'] = $post_data ['rows'] * ($post_data ['page'] - 1);
			$map = array ();
			$map ['model_id'] = I ( 'get.model_id' );
			$total = $this->Model->where ( $map )->count ();
			if ($total == 0) {
				$_list = '';
			} else {
				$_list = $this->Model->where ( $map )->order ( $post_data ['sort'] . ' ' . $post_data ['order'] )->limit ( $post_data ['first'] . ',' . $post_data ['rows'] )->select ();
			}
			$data = array (
					'total' => $total,
					'rows' => $_list 
			);
			$this->ajaxReturn ( $data );
		} else {
			$model_id = I ( 'get.model_id' );
			//获取字段分组
			$DQ_Model = M('Model')->where ( array ('id' => $model_id) )->find();
			$FIELD_GROUP_1=model_field_attr($DQ_Model['field_group']);
			if($DQ_Model['extend']>0){
				$Extend_Model = M('Model')->where ( array ('id' => $DQ_Model['extend']) )->find();
				$FIELD_GROUP_2=model_field_attr($Extend_Model['field_group']);
				$FIELD_GROUP=$FIELD_GROUP_1+$FIELD_GROUP_2;
			}else{
				$FIELD_GROUP=$FIELD_GROUP_1;
			}
			$this->assign ( 'FIELD_GROUP', $FIELD_GROUP);
			$Main_Nav=$this->Get_Main_Nav('sort_l');
			$this->assign ( 'Main_Nav', $Main_Nav);
			$this->display ();
		}
	}
	public function add() {
		if (IS_POST) {
			$post_data = I ( 'post.' );
			$post_data ['extra'] = I ( 'post.extra' );
			$post_data ['extra'] = serialize ( $post_data ['extra'] );
			if (empty ( $post_data ['id'] ) && empty ( $post_data ['model_id'] )) {
				$this->error ( '参数缺失！' );
			}
			$res = $this->Model->update ( $post_data );
			if (! $res) {
				$this->error ( $this->Model->getError () );
			} else {
				D('Model')->cache($post_data['model_id']);
				action_log('Add_ModelField', 'ModelField', $result);
				$this->success ( "操作成功！", U('index',array('model_id'=>I('get.model_id'))));
			}
		} else {
			$model_id = I ( 'get.model_id' );
			//获取字段总数
			$field_sort = $this->Model->where ( array ('model_id' => $model_id) )->count ();
			$this->assign ( 'field_sort', $field_sort + 1 );
			
			//获取字段分组
			$DQ_Model = M('Model')->where ( array ('id' => $model_id) )->find();
			$FIELD_GROUP_1=model_field_attr($DQ_Model['field_group']);
			if($DQ_Model['extend']>0){
				$Extend_Model = M('Model')->where ( array ('id' => $DQ_Model['extend']) )->find();
				$FIELD_GROUP_2=model_field_attr($Extend_Model['field_group']);
				$FIELD_GROUP=$FIELD_GROUP_1+$FIELD_GROUP_2;
			}else{
				$FIELD_GROUP=$FIELD_GROUP_1;
			}
			$this->assign ( 'FIELD_GROUP', $FIELD_GROUP);
			$this->assign ( 'model_id', $model_id );
			$Main_Nav=$this->Get_Main_Nav('sort_a');
			$this->assign ( 'Main_Nav', $Main_Nav);
			$this->display ();
		}
	}
	public function edit() {
		if (IS_POST) {
			$id = I ( 'post.id' );
			$model_id = I ( 'post.model_id' );
			if (empty ( $id ) && empty ( $model_id )) {
				$this->error ( '参数缺失！' );
			}
			$post_data = I ( 'post.' );
			$post_data ['extra'] = I ( 'post.extra' );
			$post_data ['extra'] = serialize ( $post_data ['extra'] );
			$res = $this->Model->update ( $post_data );
			if (! $res) {
				$this->error ( $this->Model->getError () );
			} else {
				D('Model')->cache($post_data['model_id']);
				action_log('Edit_ModelField', 'ModelField', $post_data ['id']);
				$this->success ( "操作成功！", U('index',array('model_id'=>I('get.model_id'))));
			}
		} else {
			$id = I ( 'get.id' );
			$model_id = I ( 'get.model_id' );
			if (empty ( $id ) && empty ( $model_id )) {
				$this->error ( '参数缺失！' );
			}
			$_info = I ( 'get.' );
			$_info = $this->Model->where ( array (
					'id' => $id 
			) )->find ();
			
			$_Extra = unserialize ( $_info ['extra'] );
			$fiepath = $this->fields . $_info ['type'] . '/';
			
			ob_start ();
			include $fiepath . "field_edit_form.inc.php";
			$form_data = ob_get_contents ();
			ob_end_clean ();
			
			$this->assign ( '_info', $_info );
			$this->assign ( 'form_data', $form_data );
			
			//获取字段分组
			$DQ_Model = M('Model')->where ( array ('id' => $model_id) )->find();
			$FIELD_GROUP_1=model_field_attr($DQ_Model['field_group']);
			if($DQ_Model['extend']>0){
				$Extend_Model = M('Model')->where ( array ('id' => $DQ_Model['extend']) )->find();
				$FIELD_GROUP_2=model_field_attr($Extend_Model['field_group']);
				$FIELD_GROUP=$FIELD_GROUP_1+$FIELD_GROUP_2;
			}else{
				$FIELD_GROUP=$FIELD_GROUP_1;
			}
			$this->assign ( 'FIELD_GROUP', $FIELD_GROUP);
			
			$Main_Nav=$this->Get_Main_Nav('sort_e');
			$this->assign ( 'Main_Nav', $Main_Nav);
			$this->display ();
		}
	}
	public function del() {
		$id = I ( 'get.id' );
		empty ( $id ) && $this->error ( '参数错误！' );
		$Model = D ( 'ModelField' );
		$info = $Model->getById ( $id );
		empty ( $info ) && $this->error ( '该字段不存在！' );
		// 删除属性数据
		$res = $Model->delete ( $id );
		// 删除表字段
		$Model->deleteField ( $info );
		if (! $res) {
			$this->error ( D ( 'ModelField' )->getError () );
		} else {
			D('Model')->cache($info['model_id']);
			action_log('Del_ModelField', 'ModelField', $id);
			$this->success ( "操作成功" );
		}
	}
}
