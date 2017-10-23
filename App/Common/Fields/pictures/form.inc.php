<?php

$From_Return='';

$_Extra=unserialize($Field_One['extra']);
$_Extra_Show="";
if($Field_One['value']==''){
	$Field_One['value']="Uploads/default/hade.jpg";
}
//新增时
if($Field_Type=='sort_a'){
	if($_Extra['updata_type']=='String'){
		$From_Return='<input id="img_'.$Field_One['name'].'_box" name="'.$Field_One['name'].'" value="'.$Field_One['value'].'" class="easyui-textbox" data-options="buttonText:\'选择\',buttonIcon:\'iconfont icon-pic\',prompt:\'上传图片...\',onClickButton:function(){updata_image(\'img_'.$Field_One['name'].'_box\')}" style="width:250px;height:30px;" >';
	}elseif($_Extra['updata_type']=='Blend'){
		$From_Return='<div class="t_img_box"><img id="img_'.$Field_One['name'].'_box_show" src="'.$Field_One['value'].' onclick="updata_image(\'img_'.$Field_One['name'].'_box\')" /></div><input id="img_'.$Field_One['name'].'_box" name="'.$Field_One['name'].'" value="'.$Field_One['value'].'" class="easyui-textbox" data-options="buttonText:\'选择\',buttonIcon:\'iconfont icon-pic\',prompt:\'上传图片...\',onClickButton:function(){updata_image(\'img_'.$Field_One['name'].'_box\')}" style="width:250px;height:30px;" >';
	}elseif($_Extra['updata_type']=='Img'){
		$From_Return='<div class="t_img_box"><img id="img_'.$Field_One['name'].'_box_show" src="'.$Field_One['value'].'" onclick="updata_image(\'img_'.$Field_One['name'].'_box\')" /></div><input id="img_'.$Field_One['name'].'_box" name="'.$Field_One['name'].'" value="'.$Field_One['value'].'" style="display:none;">';
	}
}elseif($Field_Type=='sort_e'){
	if($_Extra['updata_type']=='String'){
		$From_Return='<input id="img_'.$Field_One['name'].'_box" name="'.$Field_One['name'].'" value="{$_info["'.$Field_One["name"].'"]}" class="easyui-textbox" data-options="buttonText:\'选择\',buttonIcon:\'iconfont icon-pic\',prompt:\'上传图片...\',onClickButton:function(){updata_image(\'img_'.$Field_One['name'].'_box\')}" style="width:250px;height:30px;" >';
	}elseif($_Extra['updata_type']=='Blend'){
		$From_Return='<div class="t_img_box"><img id="img_'.$Field_One['name'].'_box_show" src="{$_info["'.$Field_One["name"].'"]}" onclick="updata_image(\'img_'.$Field_One['name'].'_box\')" /></div><input id="img_'.$Field_One['name'].'_box" name="'.$Field_One['name'].'" value="{$_info["'.$Field_One["name"].'"]}" class="easyui-textbox" data-options="buttonText:\'选择\',buttonIcon:\'iconfont icon-pic\',prompt:\'上传图片...\',onClickButton:function(){updata_image(\'img_'.$Field_One['name'].'_box\')}" style="width:250px;height:30px;" >';
	}elseif($_Extra['updata_type']=='Img'){
		$From_Return='<div class="t_img_box"><img id="img_'.$Field_One['name'].'_box_show" src="{$_info["'.$Field_One["name"].'"]}" onclick="updata_image(\'img_'.$Field_One['name'].'_box\')" /></div><input id="img_'.$Field_One['name'].'_box" name="'.$Field_One['name'].'" value="{$_info["'.$Field_One["name"].'"]}" style="display:none;"/>';
	}
}
//查询时
if($Field_Type=='search'){
	$From_Return='<input name="s_'.$Field_One['name'].'" type="text" class="easyui-textbox" style="height:30px;">';
}
return $From_Return;