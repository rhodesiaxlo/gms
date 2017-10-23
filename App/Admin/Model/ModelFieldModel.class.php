<?php

/*
 * 字段模型
 * Auth : Ghj
 * Time : 2015-07-26
 * QQ : 912524639
 * Email : 912524639@qq.com
 * Site : http://guanblog.sinaapp.com/
 */
namespace Admin\Model;

use Think\Model;

class ModelFieldModel extends Model {
	
	/* 自动验证规则 */
	protected $_validate = array (
			array (
					'name',
					'require',
					'字段名必须',
					self::MUST_VALIDATE,
					'regex',
					self::MODEL_BOTH 
			),
			array (
					'name',
					'/^[a-zA-Z][\w_]{1,29}$/',
					'字段名不合法',
					self::MUST_VALIDATE,
					'regex',
					self::MODEL_BOTH 
			),
			array (
					'name',
					'checkName',
					'字段名已存在',
					self::MUST_VALIDATE,
					'callback',
					self::MODEL_BOTH 
			),
			array (
					'field',
					'require',
					'字段定义必须',
					self::MUST_VALIDATE,
					'regex',
					self::MODEL_BOTH 
			),
			array (
					'field',
					'1,100',
					'注释长度不能超过100个字符',
					self::VALUE_VALIDATE,
					'length',
					self::MODEL_BOTH 
			),
			array (
					'title',
					'1,100',
					'注释长度不能超过100个字符',
					self::VALUE_VALIDATE,
					'length',
					self::MODEL_BOTH 
			),
			array (
					'remark',
					'1,100',
					'备注不能超过100个字符',
					self::VALUE_VALIDATE,
					'length',
					self::MODEL_BOTH 
			),
			array (
					'model_id',
					'require',
					'未选择操作的模型',
					self::MUST_VALIDATE,
					'regex',
					self::MODEL_BOTH 
			) 
	);
	
	/* 自动完成规则 */
	protected $_auto = array (
			array (
					'status',
					1,
					self::MODEL_INSERT,
					'string' 
			),
			array (
					'create_time',
					'time',
					self::MODEL_INSERT,
					'function' 
			),
			array (
					'update_time',
					'time',
					self::MODEL_BOTH,
					'function' 
			) 
	);
	
	/* 操作的表名 */
	protected $table_name = null;
	
	/**
	 * 新增或更新一个字段
	 */
	public function update($data = null, $create = true, $cache_type = true) {
		/* 获取数据对象 */
		$data = empty ( $data ) ? $_POST : $data;
		$data = $this->create ( $data );
		if (empty ( $data )) {
			return false;
		}
		
		/* 添加或新增属性 */
		if (empty ( $data ['id'] )) { // 新增属性
			
			$id = $this->add ();
			if (! $id) {
				$this->error = '新建字段出错！';
				return false;
			}
			
			if ($create) {
				// 新增表字段
				$this->error = '';
				$res = $this->addField ( $data );
				if (! $res) {
					$error = $this->getError();
					$this->error = $error ? $error : "新建字段出错！";
					// 删除新增数据
					$this->delete ( $id );
					return false;
				}
			}
		} else { // 更新数据
			if ($create) {
				// 更新表字段
				$this->error = '';
				$res = $this->updateField ( $data );
				if (! $res) {
					$error = $this->getError();
					$this->error = $error ? $error : "更新字段出错！";
					return false;
				}
			}
			
			$status = $this->save ();
			if (false === $status) {
				$this->error = '更新字段出错！';
				return false;
			}
		}
		// 删除字段缓存文件
		if($cache_type == true){
			D('Model')->cache($data['model_id']);
		}
		
		// 内容添加或更新完成
		return $data;
	}
	
	/**
	 * 检查同一张表是否有相同的字段
	 */
	protected function checkName() {
		$name = I ( 'post.name' );
		$model_id = I ( 'post.model_id' );
		$id = I ( 'post.id' );
		$map = array (
				'name' => $name,
				'model_id' => $model_id 
		);
		if (! empty ( $id )) {
			$map ['id'] = array (
					'neq',
					$id 
			);
		}
		$res = $this->where ( $map )->find ();
		return empty ( $res );
	}
	
	/**
	 * 检查当前表是否存在
	 */
	protected function checkTableExist($model_id) {
		$Model = M ( 'Model' );
		// 当前操作的表
		$model = $Model->where ( array (
				'id' => $model_id 
		) )->field ( 'name,table_name,extend' )->find ();

		$this->table_name = $table_name = C ( 'DB_PREFIX' ) . strtolower ( $model ['table_name'] );
		$sql = <<<sql
                SHOW TABLES LIKE '{$table_name}';
sql;
		$res = M ()->query ( $sql );
		return count ( $res );
	}
	
	/**
	 * 检测模型是否存在此字段
	 */
	protected function checkTableField($model_id,$Field_Name) {
		$Model = M ( 'Model' );
		// 查看当前模型
		$model_extend = $Model->where ( array ('id' => $model_id ) )->getField ('extend');
		if($model_extend>0){
			$Field_count = M('ModelField')->where ( array ('name' => $Field_Name,'model_id' => $model_extend ) )->count ();
			if($Field_count>0){
				$this->error = '主表中存在字段' . $Field_Name . ',禁止重复！';
				return false;
			}
		}else{
			$Model_List = M('Model')->where ( array ('extend' => $model_id ) )->select ();
			foreach($Model_List as $Model_One){
				$Field_count=0;
				$Field_count = M('ModelField')->where ( array ('name' => $Field_Name,'model_id' => $Model_One['id'] ) )->count ();
				if($Field_count>0){
					$this->error = '子表 ' . $Model_One['table_name'] .'中存在字段' . $Field_Name . ',禁止重复！';
					return false;
					break;
				}
			}
		}
		return true;
	}
	
	/**
	 * 新建表字段
	 */
	public function addField($field) {
		// 检查表是否存在
		$table_exist = $this->checkTableExist ( $field ['model_id'] );
		
		if(!$this->checkTableField ( $field ['model_id'] , $field ['name'] )){
			$this->error="字段重复";
			return false;
		}
		
		// 获取默认值
		if ($field ['value'] === '') {
			$default = '';
		} elseif (is_numeric ( $field ['value'] )) {
			$default = ' DEFAULT ' . $field ['value'];
		} elseif (is_string ( $field ['value'] )) {
			$default = ' DEFAULT \'' . $field ['value'] . '\'';
		} else {
			$default = '';
		}
		if ($table_exist) {
			$sql = <<<sql
                ALTER TABLE `{$this->table_name}`
ADD COLUMN `{$field['name']}`  {$field['field']} {$default} COMMENT '{$field['title']}';
sql;
		} else {
			if($field['extend'] == 0){
				$Id_Field="`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键' ,";
			}else{
				$Id_Field="`id` int(10) UNSIGNED NOT NULL COMMENT '主键' ,";
			}
            $sql = <<<sql
            CREATE TABLE IF NOT EXISTS `{$this->table_name}` (
			{$Id_Field}
            `{$field['name']}`  {$field['field']} {$default} COMMENT '{$field['title']}' ,
            PRIMARY KEY (`id`)
            )
            ENGINE=MyISAM
            DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
            CHECKSUM=0
            ROW_FORMAT=DYNAMIC
            DELAY_KEY_WRITE=0
            ;
sql;
		}
		$res = M ()->execute ( $sql );
		return $res !== false;
	}
	
	/**
	 * 更新表字段
	 */
	protected function updateField($field) {
		// 检查表是否存在
		$table_exist = $this->checkTableExist ( $field ['model_id'] );
		
		if(!$this->checkTableField ( $field ['model_id'] , $field ['name'] )){
			return false;
		}
		
		// 获取原字段名
		$last_field = $this->getFieldById ( $field ['id'], 'name' );
		
		// 获取默认值
		if ($field ['value'] === '') {
			$default = '';
		} elseif (is_numeric ( $field ['value'] )) {
			$default = ' DEFAULT ' . $field ['value'];
		} elseif (is_string ( $field ['value'] )) {
			$default = ' DEFAULT \'' . $field ['value'] . '\'';
		} else {
			$default = '';
		}
		
		$sql = <<<sql
            ALTER TABLE `{$this->table_name}`
CHANGE COLUMN `{$last_field}` `{$field['name']}`  {$field['field']} {$default} COMMENT '{$field['title']}' ;
sql;
		$res = M ()->execute ( $sql );
		return $res !== false;
	}
	
	/**
	 * 删除一个字段
	 */
	public function deleteField($field) {
		// 检查表是否存在
		$table_exist = $this->checkTableExist ( $field ['model_id'] );
		
		$sql = <<<sql
            ALTER TABLE `{$this->table_name}`
DROP COLUMN `{$field['name']}`;
sql;
		$res = M ()->execute ( $sql );
		return $res !== false;
	}
}
