<?php

$From_Return='';

$_Extra=unserialize($Field_One['extra']);

if($Field_Type=='sort_a'){
	$From_Return='<textarea id="editor_'.$Field_One['name'].'" name="'.$Field_One['name'].'" config_date="'.$_Extra['config'].'" style="width:'.$_Extra['width'].';height:'.$_Extra['height'].';" class="easyui-kindeditor">'.$Field_One['value'].'</textarea>';
}elseif($Field_Type=='sort_e'){
	$From_Return='<textarea id="editor_'.$Field_One['name'].'" name="'.$Field_One['name'].'" config_date="'.$_Extra['config'].'" style="width:'.$_Extra['width'].';height:'.$_Extra['height'].';" class="easyui-kindeditor">{$_info["'.$Field_One['name'].'"]}</textarea>';
}else{
	$From_Return='<input name="s_'.$Field_One['name'].'" type="text" class="easyui-textbox" style="height:30px;">';
}

return $From_Return;