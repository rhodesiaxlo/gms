<?php

$From_Return='';

$_Extra=unserialize($Field_One['extra']);
$_Extra_Show="";

if($_Extra['from_type']=='datebox'){
	$class='easyui-datebox';
	$date_Ymd='Y-m-d';
}else{
	$class='easyui-datetimebox';
	$date_Ymd='Y-m-d H:i:s';
}

if($_Extra['required']==1){//是否必填
	$_Extra_Show=$_Extra_Show.'required:true';
}

if($_Extra['style']==''){
	$_Extra['style']='height:30px;';
}

if($Field_Type=='sort_a'){
	if($_Extra['add_time']==1){//是否必填
		$Field_One['value']=date($date_Ymd,time());
	}else{
		$Field_One['value']=date($date_Ymd,$Field_One['value']);
	}
	$From_Return='<input name="'.$Field_One['name'].'" value="'.$Field_One['value'].'" type="text" class="'.$class.'" style="'.$_Extra['style'].'" data-options="'.$_Extra_Show.'">';
}elseif($Field_Type=='sort_e'){
	$From_Return='<input name="'.$Field_One['name'].'" value="{$_info["'.$Field_One['name'].'"]|date=\''.$date_Ymd.'\',###}" type="text" class="'.$class.'"style="'.$_Extra['style'].'" data-options="'.$_Extra_Show.'">';
}else{
	$From_Return='<input name="s_'.$Field_One['name'].'_min" type="text" class="'.$class.'" style="height:30px;"> - <input name="s_'.$Field_One['name'].'_max" type="text" class="'.$class.'" style="height:30px;">';
}

return $From_Return;