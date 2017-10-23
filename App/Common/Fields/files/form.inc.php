<?php

$From_Return='';

$_Extra=unserialize($Field_One['extra']);
$_Extra_Show="";


if($Field_Type=='sort_a'){
	$From_Return='<input id="fields_'.$Field_One['name'].'_box" name="'.$Field_One['name'].'" value="'.$Field_One['value'].'" class="easyui-textbox" data-options="buttonText:\'上传\',buttonIcon:\'iconfont icon-search\',prompt:\'上传文件...\',onClickButton:function(){updata_fields(\'fields_'.$Field_One['name'].'_box\')}" style="width:250px;height:24px;" >';
}elseif($Field_Type=='sort_e'){
	$From_Return='<input id="fields_'.$Field_One['name'].'_box" name="'.$Field_One['name'].'" value="{$_info["'.$Field_One['name'].'"]}" class="easyui-textbox" data-options="buttonText:\'上传\',buttonIcon:\'iconfont icon-search\',prompt:\'上传文件...\',onClickButton:function(){updata_fields(\'fields_'.$Field_One['name'].'_box\')}" style="width:250px;height:24px;" >';
}else{
	$From_Return='<input name="s_'.$Field_One['name'].'" type="text" class="easyui-textbox" style="height:30px;">';
}
return $From_Return;