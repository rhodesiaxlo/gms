<?php 

/* 自动模型控制器
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 * Describe	: 拥有基本的增删改查，Todo数据导入导出功能
 */
namespace Admin\Controller;

class AccordController extends AdminCoreController {
	
	//当前模型名称
	public $Model_Name;
	//当前模型消息
	public $Model_Info;
	//父模型信息
	public $Parent_Model_Info;
	//数据库表前缀
	public $DB_PREFIX;
	
	/* 初始化方法
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 判断权限
	 */
    protected function _initialize() {
		
		//继承初始化方法
		parent::_initialize ();
		
		//判断继承模型是否定义了Model_Name
        $this->Model_Name || $this->error('模型名标识必须！');
		
		//获取表前缀
		$this->DB_PREFIX = C("DB_PREFIX");
		
		//获取模型信息
		$this->Model_Info = D('Admin/Model')->Get_Model_Info($this->Model_Name);
		$this->_Model = D(MODULE_NAME.'/'.$this->Model_Info['name']);
		if($this->Model_Info['extend']>0){
			$this->_Parent_Model = D(MODULE_NAME.'/'.$this->Model_Info['_Parent_Model_Info']['name']);
		}
		//赋值
		$this->assign('Model_Name', $this->Model_Name);
		$this->assign('Model_Title', $this->Model_Info['title']);
		$this->assign('Model_Info', $this->Model_Info);
		$this->assign('CONTROLLER_NAME', CONTROLLER_NAME);
		
    }
	
    /* 自动列表
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 根据模型的信息（主要为列表状态,独立模型）生成列表返回数据
	 */
	public function index(){
		
		//判断是否有Post数据提交
		if (IS_POST) {
			
			//有提交，证明是Ajax获取数据内容
			$_Post_Data = I ( 'post.' );
			
			//如果是树形模型，不进行分页和搜索
			if( $this->Model_Info['list_type'] == 0){
				
				//分页数据的起始数据的设置
				$_Post_Data ['first'] = $_Post_Data ['rows'] * ($_Post_Data ['page'] - 1);
				
				//初始化搜索条件
				$_Map = array ();
				
				//调用搜索方法赋值
				$_Map = $this->_search($_Post_Data);
			
			}
			
			//判断模型是否为独立模型
			if($this->Model_Info['extend']>0){
				
				//非独立模型
				
				//模型表名
				$_Table_Name = $this->Model_Info['table_name'];
				
				//父模型表名
				$_Parent_Table_Name = $this->Model_Info['_Parent_Model_Info']['table_name'];
				
				//获取数据总数
				$_Total = M($_Parent_Table_Name)
						->join("INNER JOIN {$this->DB_PREFIX}{$_Table_Name} ON {$this->DB_PREFIX}{$_Parent_Table_Name}.id = {$this->DB_PREFIX}{$_Table_Name}.id")
						->where($_Map)
						->count();
				
				//判断数据总数是否为0
				if ($_Total == 0) {
					
					//设置列表为空，防止返回null导致，前端JS解析错误
					$_List = '';
					
						//返回数据
						$_Data = array (
							'total' => $_Total,
							'rows' => $_List 
						);
				} else {
					
					//判断排序字段是否为ID
					if($_Post_Data ['sort'] == 'id'){
						
						//如果是ID,设置排序语句，仿制ID数据冲突
						$_Post_Data ['sort'] = "{$this->DB_PREFIX}{$_Parent_Table_Name}.".$_Post_Data ['sort'];
						
					}
						
					//如果是树形模型，不进行查询排序 分页
					if( $this->Model_Info['list_type'] == 0){
						
						//读取列表数据
						$_List = M($_Parent_Table_Name)
							->join("INNER JOIN {$this->DB_PREFIX}{$_Table_Name} ON {$this->DB_PREFIX}{$_Parent_Table_Name}.id = {$this->DB_PREFIX}{$_Table_Name}.id")
							// 查询条件
							->where($_Map)
							/* 默认通过id逆序排列 */
							->order($_Post_Data ['sort'] . ' ' . $_Post_Data ['order'])//$_Post_Data ['sort'] . ' ' 动态排序条件
							/* 数据分页 */
							->limit ( $_Post_Data ['first'] . ',' . $_Post_Data ['rows'] )
							/* 执行查询 */
							->select();
						
						//设置返回数据
						$_Data = array (
							'total' => $_Total,
							'rows' => $_List 
						);
			
					}else{
						
						//读取列表数据
						$_List = M($_Parent_Table_Name)
							->join("INNER JOIN {$this->DB_PREFIX}{$_Table_Name} ON {$this->DB_PREFIX}{$_Parent_Table_Name}.id = {$this->DB_PREFIX}{$_Table_Name}.id")
							/* 默认通过id逆序排列 */
							->order($_Post_Data ['sort'] . ' ' . $_Post_Data ['order'])
							/* 执行查询 */
							->select();
						//树形列表
						
						$_Data = list_to_tree($_List, 'id', 'pid','children');
					}
				}
				
			}else{
				
				//独立模型
				$_Table_Name = $this->Model_Info['table_name'];
				
				//查询记录总数
				$_Total = M($_Table_Name)->where ( $_Map )->count ();
				
				//判断返回数据总数
				if ($_Total == 0) {
					
					//设置列表为空，防止返回null导致，前端JS解析错误
					$_List = '';
					
						//返回数据
						$_Data = array (
							'total' => $_Total,
							'rows' => $_List 
						);
				} else {
					
					//如果是树形模型，不进行查询排序 分页
					if( $this->Model_Info['list_type'] == 0){
						
						//读取列表数据
						$_List = $this->Model->where ( $_Map )->order ( $_Post_Data ['sort'] . ' ' . $_Post_Data ['order'] )->limit ( $_Post_Data ['first'] . ',' . $_Post_Data ['rows'] )->select ();
						
						//返回数据
						$_Data = array (
							'total' => $_Total,
							'rows' => $_List 
						);
					}else{
						
						//读取列表数据
						$_List = $this->Model->order ( $_Post_Data ['sort'] . ' ' . $_Post_Data ['order'] )->select ();
						
						$_Data = list_to_tree($_List, 'id', 'pid','children');
						
					}
					
					
				}
				
			}
			
			//返回数据
			$this->ajaxReturn ( $_Data );
		} else {
			
			//无提交，证明是获取普通界面
			
			//获取列表显示字段
			$_List = D('Admin/Model')->Get_Field_List($this->Model_Info['id'],'sort_l');
			$this->assign('_List', $_List);
			
			//获取搜索显示字段
			$_Search = D('Admin/Model')->Get_Field_List($this->Model_Info['id'],'sort_s');
			$this->assign('_Search', $_Search);
			
			//赋值列表的主菜单
			$this->assign('Main_Nav', $this->Get_Main_Nav('sort_l'));
			
			
			
			if( $this->Model_Info['list_type'] == 0){
				//将解析的模版显示出来
				$this->show($this->fetch('Admin@Accord/index'));
			}else{
				//将解析的模版显示出来
				$this->show($this->fetch('Admin@Accord/index1'));
			}
		}
	}
	
    /* 搜索
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 子模型可重构
	 */
	protected function _search($_Post_Data) {
		
		//创建查询条件数组
		$_Map = array ();
		
		//获取搜索字段数据
		$_Search = D('Admin/Model')->Get_Field_List($this->Model_Info['id'],'sort_s');
		//循环查询字段
		foreach ($_Search as $_Key => $_Field ) {
			
			//判断查询字段类型
			if($_Field['type'] == 'datetime'){
				
				//日期时间类型
				
				//判断下限查询时间是否存在
				if($_Post_Data['s_'.$_Field['name'].'_min']!= ''){
					
					//设置下限查询时间（通过strtotime转换为时间戳）
					$_Map[$_Field['name']][] = array('gt',strtotime($_Post_Data['s_'.$_Field['name'].'_min']));
					
				}
				
				//判断上限查询时间是否存在
				if($_Post_Data['s_'.$_Field['name'].'_max']!= ''){
					
					//设置上限查询时间（通过strtotime转换为时间戳）
					$_Map[$_Field['name']][] = array('lt',strtotime($_Post_Data['s_'.$_Field['name'].'_max']));
					
				}
				
			}elseif($_Field['type'] == 'string' || $_Field['type'] == 'textarea'){
				
				//字符串 或者 文本域类型
				
				//判断查询数据是否存在
				if($_Post_Data['s_'.$_Field['name']]!= ''){
					
					//设置查询数据
					$_Map[$_Field['name']] = array('like', '%'.$_Post_Data['s_'.$_Field['name']].'%');
					
				}
				
			}else{
				
				//其他所有类型的字段
				
				//判断查询数据是否存在
				if($_Post_Data['s_'.$_Field['name']]!= ''){
					
					//设置查询数据
					$_Map[$_Field['name']] = array('like', '%'.$_Post_Data['s_'.$_Field['name']].'%');
					
				}
				
			}
			
		}
		
		//返回查询数据
		return $_Map;
		
	}
    
    /* 添加
     * Auth   : Ghj
     * Time   : 2016年07月03日 
     **/
	public function add(){
		if(IS_POST){
			$_Post_Data = I('post.');
			if($this->Model_Info['extend']>0){
 				$_Parent_Model = $this->_Parent_Model;
				$_Parent_Data = $_Parent_Model->create($_Post_Data);
				$_Data = $this->_Model->create($_Post_Data);
				if($_Parent_Data && $_Data){
					$_Parent_R = $_Parent_Model->add($_Parent_Data);
					if($_Parent_R){
						$_Data['id'] = $_Parent_R;
						$_R = $this->_Model->add($_Data);
						if($_R){
							action_log('Add_'.$this->Model_Info['_Parent_Model_Info']['name'], $this->Model_Info['_Parent_Model_Info']['name'], $_Parent_R);
							action_log('Add_'.$this->Model_Info['name'], $this->Model_Info['name'], $_R);
							$this->success ( "操作成功！",U('index'));
						}else{
							$_Parent_Model->delete($_Parent_R);
							$error = $this->_Model->getError();
							$this->error($error ? $error : $this->Model_Info['title']."更新数据失败！");
						}
					}else{
						$error = $_Parent_Model->getError();
						$this->error($error ? $error : $this->Model_Info['_Parent_Model_Info']['title']."更新数据失败！");
					}
				}else{
					$error = $this->_Model->getError()
							? $this->_Model->getError()
							: $_Parent_Model->getError();
					$this->error($error ? $error : "操作失败！");
				}
			}else{
				$_Data = $this->_Model->create($_Post_Data);
				if($_Data){
					$result = $this->_Model->add($_Data);
					if($result){
						action_log('Add_'.$this->Model_Info['name'], $this->Model_Info['name'], $result);
						$this->success ( "操作成功！",U('index'));
					}else{
						$error = $this->_Model->getError();
						$this->error($error ? $error : "操作失败！");
					}
				}else{
					$error = $this->_Model->getError();
					$this->error($error ? $error : "操作失败！");
				}
			}
		}else{
			$_Form = D('Admin/Model')->Get_Field_List($this->Model_Info['id'],'sort_a');
			$this->assign('_Form', $_Form);
			
			
			//获取字段分组
			$FIELD_GROUP_1 = model_field_attr($this->Model_Info['field_group']);
			if($this->Model_Info['extend']>0){
				$FIELD_GROUP_2 = model_field_attr($this->Model_Info['_Parent_Model_Info']['field_group']);
				$FIELD_GROUP = $FIELD_GROUP_1+$FIELD_GROUP_2;
			}else{
				$FIELD_GROUP = $FIELD_GROUP_1;
			}
			$this->assign ( 'FIELD_GROUP', $FIELD_GROUP);
			$this->assign('Main_Nav', $this->Get_Main_Nav('sort_a'));
			
			$this->show($this->fetch('Admin@Accord:add'));
		}
	}
	
    /* 编辑
     * Auth   : Ghj
     * Time   : 2016年07月03日 
     **/
	public function edit(){
		if(IS_POST){
			$_Post_Data = I('post.');
			if($this->Model_Info['extend']>0){
 				$_Parent_Model = $this->_Parent_Model;
				$_Parent_Data = $_Parent_Model->create($_Post_Data);
				$_Data = $this->_Model->create($_Post_Data);
				if($_Parent_Data && $_Data){
					$_Parent_R = $_Parent_Model->where(array('id' =>$_Post_Data['id']))->save($_Parent_Data);
					$_R = $this->_Model->where(array('id' =>$_Post_Data['id']))->save($_Data);
					if($_Parent_R || $_R){
						action_log('Edit_'.$this->Model_Info['_Parent_Model_Info']['name'], $this->Model_Info['_Parent_Model_Info']['name'], $_Parent_R);
						action_log('Edit_'.$this->Model_Info['name'], $this->Model_Info['name'], $_R);
						$this->success ( "操作成功！",U('index'));
					}else{
						$error = $this->_Model->getError()
								? $this->_Model->getError()
								: $_Parent_Model->getError();
						$this->error($error ? $error : $this->Model_Info['_Parent_Model_Info']['title']."更新数据失败！");
					}
				}else{
					$error = $this->_Model->getError()
							? $this->_Model->getError()
							: $_Parent_Model->getError();
					$this->error($error ? $error : "操作失败！");
				}
			}else{
				$_Data = $this->_Model->create($_Post_Data);
				if($_Data){
					$result = $this->_Model->where(array('id' =>$_Post_Data['id']))->save($_Data);
					if($result){
						action_log('Edit_'.$this->Model_Info['name'], $this->Model_Info['name'], $result);
						$this->success ( "操作成功！",U('index'));
					}else{
						$error = $this->_Model->getError();
						$this->error($error ? $error : "操作失败！");
					}
				}else{
					$error = $this->_Model->getError();
					$this->error($error ? $error : "操作失败！");
				}
			}
		}else{
			$_info = I('get.');
			
			if($this->Model_Info['extend']>0){
				$_info = $this->_Parent_Model
						->join("INNER JOIN {$this->DB_PREFIX}{$this->Model_Info['table_name']} ON {$this->DB_PREFIX}{$this->Model_Info['_Parent_Model_Info']['table_name']}.id = {$this->DB_PREFIX}{$this->Model_Info['table_name']}.id")
						// 查询条件
						->where(array($this->DB_PREFIX.$this->Model_Info['table_name'].'.id' =>$_info['id']))
						/* 执行查询 */
						->find();
			}else{
				$_info = $this->Model->where(array('id' =>$_info['id']))->find();
			}
			$this->assign('_info', $_info);
			
			$_Form = D('Admin/Model')->Get_Field_List($this->Model_Info['id'],'sort_e');
			$this->assign('_Form', $_Form);
			
			
			//获取字段分组
			$FIELD_GROUP_1 = model_field_attr($this->Model_Info['field_group']);
			if($this->Model_Info['extend']>0){
				$FIELD_GROUP_2 = model_field_attr($this->Model_Info['_Parent_Model_Info']['field_group']);
				$FIELD_GROUP = $FIELD_GROUP_1+$FIELD_GROUP_2;
			}else{
				$FIELD_GROUP = $FIELD_GROUP_1;
			}
			$this->assign ( 'FIELD_GROUP', $FIELD_GROUP);
			$this->assign('Main_Nav', $this->Get_Main_Nav('sort_e'));
			
			
			$this->show($this->fetch('Admin@Accord:edit'));
		}
	}
	
    /* 删除
     * Auth   : Ghj
     * Time   : 2016年07月03日 
     **/
	public function del(){
		$id = I('get.id');
		empty($id)&&$this->error('参数不能为空！');
		$res = $this->Model->delete($id);
		if(!$res){
			$this->error($this->Model->getError());
		}else{
			$res = $this->_Parent_Model->delete($id);
			if(!$res){
				$this->error($this->_Parent_Model->getError());
			}else{
				$res = $this->_Parent_Model->delete($id);
				action_log('Del_'.$this->Model_Info['_Parent_Model_Info']['name'], $this->Model_Info['_Parent_Model_Info']['name'], $id);
				action_log('Del_'.$this->Model_Info['name'], $this->Model_Info['name'], $id);
				$this->success('删除成功！');
			}
		}
	}
	
	
}