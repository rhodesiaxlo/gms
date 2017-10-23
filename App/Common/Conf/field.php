<?php

return array(
	/*模型字段类型*/
	'FIELD_LIST' => array (
			/*
			'字段类型' => array(
				'type' => '字段类型',
				'title' => '类型名称',
				'field' => array(
					'字段预设数据库字段1',
					'字段预设数据库字段2'
				)
			),
			*/
			'num' => array(
				'type' => 'num',
				'title' => '数字',
				'field' => array(
					'int(10) UNSIGNED NOT NULL',
					'decimal(10,2) UNSIGNED NOT NULL'
				)
			),
			'string' => array(
				'type' => 'string',
				'title' => '文本框',
				'field' => array(
					'varchar(255) NOT NULL'
				)
			),
			'textarea' => array(
				'type' => 'textarea',
				'title' => '文本区域',
				'field' => array(
					'text NOT NULL'
				)
			),
			'datetime' => array(
				'type' => 'datetime',
				'title' => '日期时间',
				'field' => array(
					'int(11) UNSIGNED NOT NULL'
				)
			),
			'select' => array(
				'type' => 'select',
				'title' => '下拉框',
				'field' => array(
					'varchar(10) NOT NULL'
				)
			),
			'checkbox' => array(
				'type' => 'checkbox',
				'title' => '选择框',
				'field' => array(
					'varchar(10) NOT NULL'
				)
			),
			'editor' => array(
				'type' => 'editor',
				'title' => '富文本编辑器',
				'field' => array(
					'text NOT NULL'
				)
			),
			'pictures' => array(
				'type' => 'pictures',
				'title' => '图片',
				'field' => array(
					'varchar(80) NOT NULL'
				)
			),
			'files' => array(
				'type' => 'files',
				'title' => '附件',
				'field' => array(
					'varchar(80) NOT NULL'
				)
			)
	),
);
