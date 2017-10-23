<?php

$From_Return='';

$_Extra=unserialize($Field_One['extra']);
$_Extra_Show="";

if($_Extra['min']!=''){//最小值
	if($_Extra['unsifned']!=''){//是否有符号
		if($_Extra['min']<0){
			$_Extra['min']=0;
		}
		$_Extra_Show=$_Extra_Show.'min:\''.$_Extra['min'].'\',';
	}else{
		$_Extra_Show=$_Extra_Show.'min:\''.$_Extra['min'].'\',';
	}
}

if($_Extra['max']!=''){//最大值
	if($_Extra['unsifned']!=''){//是否有符号
		if($_Extra['max']>0){
			$_Extra_Show=$_Extra_Show.'max:\''.$_Extra['max'].'\',';
		}
	}else{
		$_Extra_Show=$_Extra_Show.'max:\''.$_Extra['max'].'\',';
	}
}

if($_Extra['precision']!=''){//最大精度（只有数据库有小数时才显示最大精度）
	$_Extra_Show=$_Extra_Show.'precision:\''.$_Extra['precision'].'\',';
}

if($_Extra['decimalSeparator']!=''){//小数分隔符
	$_Extra_Show=$_Extra_Show.'decimalSeparator:\''.$_Extra['decimalSeparator'].'\',';
}
if($_Extra['groupSeparator']!=''){//千位分隔符符号
	$_Extra_Show=$_Extra_Show.'groupSeparator:\''.$_Extra['groupSeparator'].'\',';
}
if($_Extra['prefix']!=''){//前缀字符串
	$_Extra_Show=$_Extra_Show.'prefix:\''.$_Extra['prefix'].'\',';
}
if($_Extra['suffix']!=''){//后缀字符串
	$_Extra_Show=$_Extra_Show.'suffix:\''.$_Extra['suffix'].'\',';
}
if($Field_Type!='sort_s'){
	if($_Extra['required']==1){//是否必填
		$_Extra_Show=$_Extra_Show.'required:true';
	}else{
		$_Extra_Show=$_Extra_Show.'required:false';
	}
}

if($_Extra['style']==''){
	$_Extra['style']='height:30px;';
}

if($Field_Type=='sort_a'){
	$From_Return='<input name="'.$Field_One['name'].'" id="for_'.$Field_One['name'].'" value="'.$Field_One['value'].'" type="text" class="easyui-numberbox" style="'.$_Extra['style'].'" data-options="'.$_Extra_Show.'">';
}elseif($Field_Type=='sort_e'){
	$From_Return='<input name="'.$Field_One['name'].'" id="for_'.$Field_One['name'].'" value="{$_info["'.$Field_One['name'].'"]}" type="text" class="easyui-numberbox" style="'.$_Extra['style'].'" data-options="'.$_Extra_Show.'">';
}else{
	$From_Return='<input name="s_'.$Field_One['name'].'" id="for_'.$Field_One['name'].'" type="text" class="easyui-numberbox" style="height:30px;" data-options="'.$_Extra_Show.'required:false">';
}
return $From_Return;