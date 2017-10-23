<?php

$From_Return='';

$_Extra=unserialize($Field_One['extra']);
$_Extra_Show="";

if($_Extra['required']==1){//是否必填
	$_Extra_Show=$_Extra_Show.'required:true';
}else{
	$_Extra_Show=$_Extra_Show.'required:false';
}

if($_Extra['style']==''){
	$_Extra['style']='width:300px; height:100px;';
}


if($Field_Type=='sort_a'){
	$From_Return='<textarea name="'.$Field_One['name'].'" id="for_'.$Field_One['name'].'" class="easyui-textbox" data-options="'.$_Extra_Show.',multiline:true" style="'.$_Extra['style'].'">'.$Field_One['value'].'</textarea>';
}elseif($Field_Type=='sort_e'){
	$From_Return='<textarea name="'.$Field_One['name'].'" id="for_'.$Field_One['name'].'" class="easyui-textbox" data-options="'.$_Extra_Show.',multiline:true" style="'.$_Extra['style'].'">{$_info["'.$Field_One['name'].'"]}</textarea>';
}else{
	$From_Return='<input name="s_'.$Field_One['name'].'" id="for_'.$Field_One['name'].'" class="easyui-textbox" style="height:30px;">';
}

return $From_Return;