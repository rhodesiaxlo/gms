<?php

/*
 * 模型模型
 * Auth : Ghj
 * Time : 2015-07-26
 * QQ : 912524639
 * Email : 912524639@qq.com
 * Site : http://guanblog.sinaapp.com/
 */
namespace Admin\Model;

use Think\Model;

class ModelModel extends Model {
	
	//字段文件路径
	public $Fields_Path = './App/Common/Fields/';
	
	/*
	 * 自动验证规则
	 * array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
	 * 验证条件 （可选）
	 * self::EXISTS_VALIDATE 或者0 存在字段就验证（默认）
	 * self::MUST_VALIDATE 或者1 必须验证
	 * self::VALUE_VALIDATE或者2 值不为空的时候验证
	 * 验证时间（可选）
	 * self::MODEL_INSERT或者1新增数据时候验证
	 * self::MODEL_UPDATE或者2编辑数据时候验证
	 * self::MODEL_BOTH或者3全部情况下验证（默认）
	 */
	protected $_validate = array (
			array (
					'name',
					'require',
					'标识不能为空',
					self::MUST_VALIDATE,
					'regex',
					self::MODEL_INSERT 
			),
			array (
					'name',
					'/^[a-zA-Z]\w{0,39}$/',
					'标识不合法',
					self::VALUE_VALIDATE,
					'regex',
					self::MODEL_BOTH 
			),
			array (
					'name',
					'',
					'标识已经存在',
					self::VALUE_VALIDATE,
					'unique',
					self::MODEL_BOTH 
			),
			array (
					'table_name',
					'require',
					'表名不能为空',
					self::VALUE_VALIDATE,
					'regex',
					self::MODEL_BOTH 
			),
			array (
					'table_name',
					'/^[a-zA-Z]\w{0,39}$/',
					'表名不合法',
					self::VALUE_VALIDATE,
					'regex',
					self::MODEL_BOTH 
			),
			array (
					'table_name',
					'',
					'表名已经存在',
					self::VALUE_VALIDATE,
					'unique',
					self::MODEL_BOTH 
			),
			array (
					'title',
					'require',
					'名称不能为空',
					self::MUST_VALIDATE,
					'regex',
					self::MODEL_BOTH 
			),
			array (
					'title',
					'1,30',
					'名称长度不能超过30个字符',
					self::MUST_VALIDATE,
					'length',
					self::MODEL_BOTH 
			) 
	);
	
	/*
	 * 自动验证规则
	 * array(完成字段1,完成规则,[完成条件,附加规则])
	 * 验证时间（可选）
	 * self::MODEL_INSERT或者1	新增数据的时候处理（默认）
	 * self::MODEL_UPDATE或者2	更新数据的时候处理
	 * self::MODEL_BOTH或者3	所有情况都进行处理
	 */
	protected $_auto = array (
			array (
					'create_time',
					NOW_TIME,
					self::MODEL_INSERT 
			),
			array (
					'update_time',
					NOW_TIME,
					self::MODEL_BOTH 
			),
			array (
					'status',
					'1',
					self::MODEL_INSERT,
					'string' 
			) 
	);
	
	/**
	 * 更新模型
	 */
	public function update($_post) {
		$data = $this->create ( $_post );
		if (empty ( $data )) {
			return false;
		}
		
		if (empty ( $data ['id'] )) { // 是否存在模型ID。如果存在就是更新模型，如果不存在就是新增模型
			$id = $this->add ($data);
			if (! $id) {
				$this->error = '新增模型出错！';
				return false;
			}else{
				$this->cache($id);
				action_log('Add_Model', 'Model', $id);
				return $id;
			}
		} else {
			$status = $this->where(array('id'=>$data['id']))->save ($data);
			
			if (false === $status) {
				$this->error = '更新模型出错！';
				return false;
			}else{
				$this->cache($data ['id']);
				action_log('Edit_Model', 'Model', $data['id']);
				return $data ['id'];
			}
			
		}
	}
	
	/**
	 * 获取指定数据库的所有表名
	 */
	public function getTables() {
		return $this->db->getTables ();
	}
	
	/**
	 * 系统化表
	 */
	public function generate($table, $name = '', $title = '') {
		if (empty ( $name )) {
			$name = substr ( $table, strlen ( C ( 'DB_PREFIX' ) ) );
		}
		if (empty ( $title )) {
			$title = substr ( $table, strlen ( C ( 'DB_PREFIX' ) ) );
		}
		$data = array (
				'name' => $name,
				'title' => $title,
				'table_name' => substr ( $table, strlen ( C ( 'DB_PREFIX' ) ) ) 
		);
		$data = $this->create ( $data );
		if ($data) {
			// 新增模型数据
			$res = $this->add ( $data );
			if (! $res) {
				$this->error = $this->getError ();
				return false;
			}
			action_log('Generate_Model', 'Model', $res);
		} else {
			$this->error = $this->getError ();
			return false;
		}
		
		// 新增字段数据
		$fields = M ()->query ( 'SHOW FULL COLUMNS FROM ' . $table );
		$i=1;
		foreach ( $fields as $key => $value ) {
			$value = array_change_key_case ( $value );
			// 不新增id字段
			if (in_array ( $value ['field'], array('id','extend_model_id') )) {
				continue;
			}
			
			// 生成属性数据
			$data = array ();
			$data ['name'] = $value ['field'];
			$data ['title'] = $value ['comment'];
			$data ['type'] = 'string'; // TODO:根据字段定义生成合适的数据类型
			$data ['extra'] = 'a:1:{s:8:"required";s:1:"0";}'; // string字符串的默认配置
			$is_null = strcmp ( $value ['null'], 'NO' ) == 0 ? ' NOT NULL ' : ' NULL ';
			$data ['field'] = $value ['type'] . $is_null;
			$data ['value'] = $value ['default'] == null ? '' : $value ['default'];
            $data['sort_l'] = $i;
            $data['sort_s'] = $i;
            $data['sort_a'] = $i;
            $data['sort_e'] = $i;
			$data ['model_id'] = $res;
			$_POST = $data; // 便于自动验证
			$i++;
			D ( 'ModelField' )->update ( $data, false );
		}
		return $res;
	}
	
	/**
	 * 删除一个模型
	 */
	public function del($id) {
		// 获取表名
		$model = $this->field ( 'table_name,extend' )->find ( $id );
		$table_name = C ( 'DB_PREFIX' ) . strtolower ( $model ['table_name'] );
		
		$_Count = $this->where(array('extend'=>$id))->count ();
		
		if($_Count>1){
			$this->error = '此模型有子模型禁止删除';
			return false;
			exit;
		}
		// 删除模型数据
		$this->delete ( $id );
		action_log('Del_Model', 'Model', $id);
		// 删除该表
		$sql = <<<sql
                DROP TABLE {$table_name};
sql;
		M ()->execute ( $sql );
		$this->delete ( $id );
		// 删除属性数据
		M ( 'ModelField' )->where ( array ('model_id' => $id ) )->delete ();
		$this->del_cache($id);
		return true;
	}
	
    /**
     * 模型导出
     * @param type $_ID 模型ID
     * @return boolean
     */
    public function export($_ID) {
        if (empty($_ID)) {
            $this->error = '请指定需要导出的模型！';
            return false;
        }
        //取得模型信息
        $_Info = $this->where(array('id' => $_ID))->find();
        if (empty($_Info)) {
            $this->error = '该模型不存在，无法导出！';
            return false;
        }
        unset($_Info['id']);
        //数据
        $_Data = array();
        $_Data['model'] = $_Info;
        //取得对应模型字段
        $_Field_List = M('ModelField')->where(array('model_id' => $_ID))->select();
        if (empty($_Field_List)) {
            $_Field_List = array();
        }
        //去除fieldid，modelid字段内容
        foreach ($_Field_List as $k => $v) {
            unset($_Field_List[$k]['id'], $_Field_List[$k]['model_id']);
        }
        $_Data['field'] = $_Field_List;
        return base64_encode(json_encode($_Data));
    }
	
	
    /**
     * 模型导入
     * @param type $data 数据
     * @param type $tablename 导入的模型表名
     * @param type $name 模型名称
     * @return int|boolean
     */
    public function import($_Data, $tablename = '', $name = '') {
        if (empty($_Data)) {
            $this->error = '没有导入数据！';
            return false;
        }
        //解析
        $_Data = json_decode(base64_decode($_Data), true);
        if (empty($_Data)) {
            $this->error = '解析数据失败，无法进行导入！';
            return false;
        }
        //取得模型数据
        $_Model_Info = $_Data['model'];
        if (empty($_Model_Info)) {
            $this->error = '解析数据失败，无法进行导入！';
            return false;
        }
        if ($name) {
            $_Model_Info['name'] = $name;
        }
        if ($tablename) {
            $_Model_Info['table_name'] = $tablename;
        }
        //导入
        $_ID = $this->update($_Model_Info);
        if ($_ID) {
            if (!empty($_Data['field'])) {
				$ModelField = D('ModelField');
                foreach ($_Data['field'] as $value) {
                    $value['model_id'] = $_ID;
                    if ($ModelField->update($value,true,false) == false) {
                        $ModelField->where(array('model_id' => $_ID, 'name' => $value['name']))->save($value);
                    }
					$this->cache($_ID);
                }
            }
            return $_ID;
        } else {
            return false;
        }
    }
	/**
	 * 更新模型缓存
	 */
	public function cache($id) {
		if($id){
			$this->del_cache($id);
			$_Model_Info = $this->Get_Model_Info($id,1);
			$this->Get_Field_List($id);
			//获取所有子模型信息
			$_Model_List = $this->where(array('extend'=>$_Model_Info['id']))->select();
			foreach($_Model_List as $_Model_One){
				//更新子模型
				$this->cache($_Model_One['id']);
			}
		}else{
			$_Model_List = $this->select();
			foreach($_Model_List as $_Model_One){
				$this->cache($_Model_One['id']);
			}
		}
	}
	
	
	public function del_cache($id) {
		F('Model/Model_'.$id,null);
		F('Model/Model_'.$id.'_sort_l',null);
		F('Model/Model_'.$id.'_sort_a',null);
		F('Model/Model_'.$id.'_sort_e',null);
		F('Model/Model_'.$id.'_sort_s',null);
	}
	

	/*
	 * 获取需要生成代码的模型
	 * @Model_ID $Model_ID 模型标识
	 */
	 public function Get_Model_Info($Model_ID,$GetType=0){
		//判断标识符类型
		if(is_numeric($Model_ID)){
			//判断模型ID是否为正常数字
			if($Model_ID<1){
				$this->error = '模型ID不能为空';
				return false;
			}
			$Model_ID_Type='id';
		}elseif(is_string($Model_ID)){
			$Model_ID_Type='name';
		}else{
			$this->error = '模型标识符不正确';
			return false;
		}
		
		//获取模型信息
		$Model_Info = $this->where(array($Model_ID_Type=>$Model_ID))->find();
		//读取模型缓存
		$Return_Model_Info = F('Model/Model_'.$Model_Info['id']);
		
		//判断缓存是否存在
		if($Return_Model_Info['id'] < 1 || $GetType != 0){
			//无缓存
			if($Model_Info['id']<0){
				$this->error = '模型标识符不正确,未找到此模型';
				return false;
			}
			
			//读取当前模型字段
			$Model_Info['_Filed_List'] =
				M('ModelField')
				->where(array('model_id'=>$Model_Info['id'],'status'=>1))
				->getField('name,id,title,type,value,group_id,extra,sort_l,sort_a,sort_e,sort_s,is_sort,l_width,is_fixed,validate_rule,auto_rule,remark');
			
			//判断是否存在父级模型
			if($Model_Info['extend']>0){
				
				//获取父级模型信息
				$Model_Info['_Parent_Model_Info'] = $this->Get_Model_Info($Model_Info['extend']);
				$this->Get_Field_List($Model_Info['extend']);
			}
			//缓存当前模型信息
			F('Model/Model_'.$Model_Info['id'],$Model_Info);
			//设置返回数据
			$Return_Model_Info = $Model_Info;
		}
		return $Return_Model_Info;
	 }
	 
	 
    /* 获取模型的字段数据
	 * @Model_ID 模型标识
	 * @Field_Type 获取字段类型
     **/
	public function Get_Field_List($Model_ID,$Field_Type='all',$GetType=0){
		
		//读取模型
		$Model_Info = $this->Get_Model_Info($Model_ID);
		
		//判断模型是否正确
		if($Model_Info['id'] < 1){
			$this->error = '不存在此模型';
			return false;
		}
		
		if($Field_Type=='all'){
			$this->Get_Field_List($Model_ID,'sort_l');
			$this->Get_Field_List($Model_ID,'sort_a');
			$this->Get_Field_List($Model_ID,'sort_e');
			$this->Get_Field_List($Model_ID,'sort_s');
			return true;
			exit;
		}
		//读取模型字段缓存
		$_Filed_List = F('Model/Model_'.$Model_Info['id'].'_'.$Field_Type);
		
		if(count($_Filed_List)<2 || $GetType != 0){
			
			//判断当前模型是否为独立模型
			if($Model_Info['extend']>0){
				
				//非独立模型，合并父模型和当前模型字段，然后调用Get_Field_Sort
				$_Filed_List = $this->Get_Field_Sort(array_merge($Model_Info['_Parent_Model_Info']['_Filed_List'],$Model_Info['_Filed_List']),$Field_Type);
				
			}else{
				//独立模型，直接调用Get_Field_Sort
				$_Filed_List = $this->Get_Field_Sort($Model_Info['_Filed_List'],$Field_Type);
				
			}
			//缓存当前数据
			F('Model/Model_'.$Model_Info['id'].'_'.$Field_Type,$_Filed_List);
		}
		return $_Filed_List;
	}
	

    /* 字段排序，获取表单
	 * @Model_ID 模型标识
	 * @Field_Type 获取字段类型
     **/
	public function Get_Field_Sort($Field_List,$Field_Type){
		//对当前模型字段排序 根据$Field_Type和id 来排序
		$sort = array ();
		$ids = array ();
		foreach ( $Field_List as $_One ) {
			$_Sort [] = $_One [$Field_Type];
			$_IDs [] = $_One ['id'];
		}
		array_multisort ( $_Sort, SORT_ASC, $_IDs, SORT_ASC, $Field_List );
		foreach ( $Field_List as $key => $Field_One ) {
			if ($Field_One [$Field_Type] > 0) {
				if(in_array($Field_Type,array('sort_a','sort_e'))){
					$Model_Filed_List[$Field_One['group_id']][$key] = $Field_One;
					$Model_Filed_List[$Field_One['group_id']][$key]['form'] = include $this->Fields_Path . $Field_One ['type'] . "/form.inc.php";
				}else{
					$Model_Filed_List[$key] = $Field_One;
					$Model_Filed_List[$key]['form'] = include $this->Fields_Path . $Field_One ['type'] . "/form.inc.php";
				}
			}
		}
		return $Model_Filed_List;
	}
}
