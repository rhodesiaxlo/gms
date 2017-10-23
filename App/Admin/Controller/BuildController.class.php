<?php
/*
 * 模型管理控制器
 * Auth : Ghj
 * Time : 2015年07月26日
 * QQ : 912524639
 * Email : 912524639@qq.com
 * Site : http://guanblog.sinaapp.com/
 */
namespace Admin\Controller;

class BuildController extends AdminCoreController {
	
	//当前模型ID
	public $Model_ID;
	//当前模型名称
	public $Model_Name;
	//当前模型消息
	public $Model_Info;
	//父模型信息
	public $Parent_Model_Info;
	//数据库表前缀
	public $DB_PREFIX;
	
	/**
	 * 控制器初始化方法
	 */
	protected function _initialize() {
		//继承初始化方法
		parent::_initialize ();
		
		$this->Model_ID = I ( 'param.model_id', 0 );
        $this->Model_ID || $this->error('模型ID必须！');
		//获取系统定义的表前缀
		$this->DB_PREFIX = C("DB_PREFIX");
		//当前模型数据
		$this->Model_Info = D('Model')->Get_Model_Info($this->Model_ID);
		$this->Model_Name = $this->Model_Info['name'];
		$this->assign('Model_Name', $this->Model_Name);
		$this->assign('Model_Title', $this->Model_Info['title']);
		$this->assign('Model_Info', $this->Model_Info);
	}
	
	/*
	 * 生成文件
	 * Auth : Ghj
	 * Time : 2015年10月11日
	 */
	public function index() {
		if (IS_POST) {
			//获取表单提交的生成文件需求信息
			$_Build = I ( 'post.' );
			//生成模型
			if ($_Build ['build_model'] == 1) {$this->build_model ();}
			if($this->Model_Info['is_extend'] != 1 ){
				//生成控制器
				if ($_Build ['build_action'] == 1) {$this->build_action ();}
				//生成菜单
				if ($_Build ['build_rule'] == 1) {$this->build_rule ();}
				if($this->Model_Info['model_build'] < 1 ){
					//生成index页面
					if ($_Build ['build_tpl_index'] == 1) {$this->build_tpl_index ();}
					//生成add页面
					if ($_Build ['build_tpl_add'] == 1) {$this->build_tpl_add ();}
					//生成edit页面
					if ($_Build ['build_tpl_edit'] == 1) {$this->build_tpl_edit ();}
				}
			}
			//过程中无错误返回 成功信息
			$this->success ( '生成文件成功！', U ( 'Model/index' ) );
		} else {
			//变量替换
			$this->assign ( 'model_id', $this->Model_ID );
			//变量替换
			$this->assign ( 'ModelInfo', D ( 'Model' )->where ( array ('id'=>$this->Model_ID))->find ());
			//解析页面
			$this->display ();
		}
	}
	
	
	/*
	 * 生成控制器文件
	 * Auth : Ghj
	 * Time : 2015年10月11日
	 */
	protected function build_action() {
		//设置生成文件的路径 末前支持在Admin模块下的生成
		$file = APP_PATH . "Admin/Controller/" . $this->Model_Name . "Controller.class.php";
		//停止视图布局
		layout ( false );
		
		$_List = D('Model')->Get_Field_List($this->Model_Info['id'],'sort_l');
		//列表显示字段变量替换
		$this->assign ( '_List', $_List );
		//=========================================================================================
		$_Search = D('Model')->Get_Field_List($this->Model_Info['id'],'sort_s');
		//列表显示字段变量替换
		$this->assign ( '_Search', $_Search );
		//=========================================================================================
		$_List = D('Model')->Get_Field_List($this->Model_Info['id'],'sort_a');
		//搜索显示字段变量替换
		$this->assign ( '_Add', $_Add );
		//=========================================================================================
		$_List = D('Model')->Get_Field_List($this->Model_Info['id'],'sort_e');
		//搜索显示字段变量替换
		$this->assign ( '_Edit', $_Edit );
		//=========================================================================================
		
		//模型的配置信息变量替换
		$this->assign ( 'ModelInfo', $this->Model_Info );
		//根据模型的列表结构决定控制器的模版文件
		if ($this->Model_Info ['list_type'] == 0) {//普通表格
			//解析但不输出页面
			$content = $this->fetch ( 'build_controller' );
		} else {
			//解析但不输出页面
			$content = $this->fetch ( 'build_controller' . $this->Model_Info ['list_type'] );//普通表格树形表格
		}
		//将上一步解析的模版文件存至 文件
		file_put_contents ( $file, '<?php ' . $content );
	}
	
	/*
	 * 生成模型文件
	 * Auth : Ghj
	 * Time : 2015年10月11日
	 */
	protected function build_model() {
		//设置生成文件的路径 末前支持在Admin模块下的生成
		$file = APP_PATH . "Admin/Model/" . $this->Model_Name . "Model.class.php";
		//停止视图布局
		layout ( false );
		//模型的配置信息变量替换
		$this->assign ( 'ModelInfo', $this->Model_Info );
		//字段信息变量替换
		$this->assign ( 'ModelField', $this->Model_Info['_Filed_List'] );
		//解析但不输出页面
		$content = $this->fetch ( 'build_model' );
		//将上一步解析的模版文件存至 文件
		file_put_contents ( $file, '<?php ' . $content );
	}
	
	/*
	 * 生成菜单
	 * Auth : Ghj
	 * Time : 2015年10月11日
	 */
	protected function build_rule() {
		//这只是一个为了方便写完模型后不用手动添加重复菜单的函数 实际上 他还待扩
		//获取在BULID函数中设置的模型
		$ModelInfo = $this->Model_Info;
		$id = M ( 'AuthRule' )->add ( array ('pid' => 4,'name' => 'Admin/' . $ModelInfo ['name'] . '/index','title' => $this->Model_Info['title'].'管理','hide' => 0,'sort' => 1) );
		M ( 'AuthRule' )->add ( array ('pid' => $id,'name' => 'Admin/' . $this->Model_Info['name'] . '/add','title' => '新增','hide' => 0,'sort' => 1) );
		M ( 'AuthRule' )->add ( array ('pid' => $id,'name' => 'Admin/' . $this->Model_Info['name'] . '/edit','title' => '编辑','hide' => 0,'sort' => 2) );
		M ( 'AuthRule' )->add ( array ('pid' => $id,'name' => 'Admin/' . $this->Model_Info['name'] . '/del','title' => '删除','hide' => 1,'sort' => 3) );
	}
	
	/**
	 * 生成模型列表页面
	 */
	protected function build_tpl_index() {
		//设置生成文件的路径 末前支持在Admin模块下的生成
		$path = APP_PATH . "Admin/View/" . $this->Model_Name . "/";
		//查看目录路径是否存在 不存在就创建一个文件夹
		if (! file_exists ( $path )) {
			mkdir ( $path );
		}
		//停止视图布局
		layout ( false );
		//获取在BULID函数中设置的字段信息
		$_List = D('Model')->Get_Field_List($this->Model_Info['id'],'sort_l');
		//列表显示字段变量替换
		$this->assign ( '_List', $_List );
		//=========================================================================================
		$_Search = D('Model')->Get_Field_List($this->Model_Info['id'],'sort_s');
		//列表显示字段变量替换
		$this->assign ( '_Search', $_Search );
		//=========================================================================================
		//模型的配置信息变量替换
		$this->assign ( 'ModelInfo', $this->Model_Info );
		//根据模型的列表结构决定控制器的模版文件
		if ($this->Model_Info ['list_type'] == 0) {//普通表格
			//解析但不输出页面
			$content = $this->fetch ( 'build_index' );
		} else {//普通表格树形表格
			//解析但不输出页面
			$content = $this->fetch ( 'build_index' . $this->Model_Info ['list_type'] );
		}
		//将上一步解析的模版文件存至 文件
		file_put_contents ( $path . 'index.html', '<extend name="Public/base"/><block name="body">'.$content.'</block>' );
	}
	
	/**
	 * 生成模型新增页面
	 */
	protected function build_tpl_add() {
		$path = APP_PATH . "Admin/View/" . $this->Model_Name . "/";
		if (! file_exists ( $path )) {
			mkdir ( $path );
		}
		layout ( false );
		$_Form = D('Model')->Get_Field_List($this->Model_Info['id'],'sort_a');
		//列表显示字段变量替换
		$this->assign ( '_Form', $_Form );
		//=========================================================================================
		$this->assign ( 'ModelInfo', $this->Model_Info ); // 将模型的配置信息载入
		
		//获取字段分组
		$FIELD_GROUP_1=model_field_attr($this->Model_Info['field_group']);
		if($this->Model_Info['extend']>0){
			$FIELD_GROUP_2=model_field_attr($this->Model_Info['_Parent_Model_Info']['field_group']);
			$FIELD_GROUP=$FIELD_GROUP_1+$FIELD_GROUP_2;
		}else{
			$FIELD_GROUP=$FIELD_GROUP_1;
		}
		$this->assign ( 'FIELD_GROUP', $FIELD_GROUP ); // 将模型的配置信息载入
		
		// 渲染模版但不输出
		$content = $this->fetch ( 'build_add' );
		// 将渲染结果存入文件
		file_put_contents ( $path . 'add.html', '<extend name="Public/base"/><block name="body">'.$content.'</block>' );
	}
	
	/**
	 * 生成模型更改页面
	 */
	protected function build_tpl_edit() {
		$path = APP_PATH . "Admin/View/" . $this->Model_Name . "/";
		if (! file_exists ( $path )) {
			mkdir ( $path );
		}
		layout ( false );
		$_Form = D('Model')->Get_Field_List($this->Model_Info['id'],'sort_e');
		//列表显示字段变量替换
		$this->assign ( '_Form', $_Form );
		//=========================================================================================
		$this->assign ( 'ModelInfo', $this->Model_Info ); // 将模型的配置信息载入
		
		
		//获取字段分组
		$FIELD_GROUP_1=model_field_attr($this->Model_Info['field_group']);
		if($this->Model_Info['extend']>0){
			$FIELD_GROUP_2=model_field_attr($this->Model_Info['_Parent_Model_Info']['field_group']);
			$FIELD_GROUP=$FIELD_GROUP_1+$FIELD_GROUP_2;
		}else{
			$FIELD_GROUP=$FIELD_GROUP_1;
		}
		$this->assign ( 'FIELD_GROUP', $FIELD_GROUP ); // 将模型的配置信息载入
		
		// 渲染模版但不输出
		$content = $this->fetch ( 'build_edit' );
		// 将渲染结果存入文件
		file_put_contents ( $path . 'edit.html', '<extend name="Public/base"/><block name="body">'.$content.'</block>' );
	}
}
