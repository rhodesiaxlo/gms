<?php

//清空返回表单内容
$From_Return='';
//解析字段参数
$_Extra=unserialize($Field_One['extra']);
//清空扩展显示内容
$_Extra_Show="";

//判断表单 类型（新增,更改,搜索）
if($Field_Type=='sort_a'){
	$_Extra_Show = $_Extra_Show.'value:\''.$Field_One['value'].'\',';//如果是新增,表单值为填写的默认值
}elseif($Field_Type=='sort_e'){
	$_Extra_Show = $_Extra_Show.'value:\'{$_info["'.$Field_One['name'].'"]}\',';//如果是更改，表单值为{$_info["表单名称"]}
}

//设置表单类型
$combo_type="combobox";//默认为combobox

//如果为表单类型值为1，即普通下拉表单 
if($_Extra['form_type']=='1'){
	if($_Extra['type']=='Option'){//字段配置值
		$_Extra_Show=$_Extra_Show.'url:\'{:U("Admin/Function/get_field_option")}&f_id='.$Field_One['id'].'&r_type=json\'';
	}elseif($_Extra['type']=='Config'){//如果参数的值为3，是获取某一配置的参数
		$_Extra_Show=$_Extra_Show.'url:\'{:U("Admin/Function/get_config")}&cname='.$_Extra['option'].'&r_type=json\'';
	}elseif($_Extra['type']=='Function'){
		$_Extra_option_arr = explode('|',$_Extra['option']);
		$_Extra_Show=$_Extra_Show.'url:\'{:U("'.$_Extra_option_arr[0].'")}&r_type=json\'';
	}
	$_Extra_Show=$_Extra_Show.',valueField:\'id\',textField:\'text\'';
}

//如果为表单类型值为2，即树形下拉
if($_Extra['form_type']=='2'){
	$combo_type="combotree";//设置表单类型为 combotree
	if($_Extra['type']=='Option'){//字段配置值
	}elseif($_Extra['type']=='Config'){//如果参数的值为3，是获取某一配置的参数
	}elseif($_Extra['type']=='Function'){
		$_Extra_Show=$_Extra_Show.'url:\'{:U("'.$_Extra['option'].'")}&r_type=json\'';
	}
}

if($_Extra['multiple']==1){//是否支持多选 1为支持
	$Field_One['name']=$Field_One['name'].'[]';
	$_Extra_Show=$_Extra_Show.',multiple:true,cascadeCheck:false';
}

if($_Extra['required']==1){//是否必填 1为必填
	if($Field_Type!='sort_s'){
		$_Extra_Show=$_Extra_Show.',required:true';
	}
}

if($_Extra['editable']=='1'){//是否允许手写输入 1为允许
	$_Extra_Show=$_Extra_Show.',editable:true';
}

if($_Extra['style']==''){
	$_Extra['style']='height:30px;';
}

if($Field_Type=='sort_a'){
	$From_Return = '<select name="'.$Field_One['name'].'" id="for_'.$Field_One['name'].'" class="easyui-'.$combo_type.'" style="'.$_Extra['style'].'" data-options="'.$_Extra_Show.'"></select>';
}elseif($Field_Type=='sort_e'){
	$From_Return = '<select name="'.$Field_One['name'].'" id="for_'.$Field_One['name'].'" class="easyui-'.$combo_type.'" style="'.$_Extra['style'].'" data-options="'.$_Extra_Show.'"></select>';
}else{
	$From_Return = '<select name="s_'.$Field_One['name'].'" id="for_s_'.$Field_One['name'].'" class="easyui-'.$combo_type.'" style="'.$_Extra['style'].'" data-options="'.$_Extra_Show.',value:null"></select>';
}

return $From_Return;