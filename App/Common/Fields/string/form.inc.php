<?php

$From_Return='';

$_Extra=unserialize($Field_One['extra']);
$_Extra_Show="";

if($_Extra['required']==1){//是否必填
	$_Extra_Show=$_Extra_Show.'required:true,';
}

if($_Extra['is_password']!=1){//是否密码
	$_Extra_Show=$_Extra_Show."type:'text'";
}else{
	$Field_One='';
	$_Extra_Show=$_Extra_Show."type:'password'";
}

if($_Extra['style']==''){
	$_Extra['style']='height:30px;';
}

if($Field_Type=='sort_a'){
	$From_Return='<input name="'.$Field_One['name'].'" id="for_'.$Field_One['name'].'" type="text" value="'.$Field_One['value'].'" class="easyui-textbox" style="'.$_Extra['style'].'" data-options="'.$_Extra_Show.'">';
}elseif($Field_Type=='sort_e'){
	if($_Extra['is_password']!=1){
		$From_Return='<input name="'.$Field_One['name'].'" id="for_'.$Field_One['name'].'" type="text" value="{$_info["'.$Field_One["name"].'"]}" class="easyui-textbox" style="'.$_Extra['style'].'" data-options="'.$_Extra_Show.'">';
	}else{
		$From_Return='<input name="'.$Field_One['name'].'" id="for_'.$Field_One['name'].'" type="text" class="easyui-textbox" style="'.$_Extra['style'].'" data-options="'.$_Extra_Show.'">';
	}
}else{
	$From_Return='<input name="s_'.$Field_One['name'].'"  id="for_'.$Field_One['name'].'"type="text" class="easyui-textbox" style="height:30px;">';
}

return $From_Return;