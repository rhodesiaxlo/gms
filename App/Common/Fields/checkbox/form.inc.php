<?php

$From_Return='';

$_Extra=unserialize($Field_One['extra']);
$_Extra_Show="";

if($_Extra['multiple']==1){
	$input_type="radio";
	$Field_Name=$Field_One['name'];
}else{
	$input_type="checkbox";
	$Field_Name=$Field_One['name']."[]";
}

//新增时
if($Field_Type=='sort_a'){
	$ops = model_field_attr($_Extra['option']);
	foreach ($ops as $opkey=>$opkeyval){
		$From_Return=$From_Return.'<label for="'.$Field_One['name'].'_'.$opkey.'"><input name="'.$Field_Name.'" id="'.$Field_One['name'].'_'.$opkey.'" type="'.$input_type.'" value="'.$opkey.'"';
		if($Field_One['value']==$opkey){
			$From_Return=$From_Return.' checked="checked"';
		}
		$From_Return=$From_Return.'/> '.$opkeyval.'</label>';
	}
}elseif($Field_Type=='sort_e'){
	$ops = model_field_attr($_Extra['option']);
	foreach ($ops as $opkey=>$opkeyval){
		$From_Return=$From_Return.'<label for="'.$Field_One['name'].'_'.$opkey.'"><input name="'.$Field_Name.'" id="'.$Field_One['name'].'_'.$opkey.'" type="'.$input_type.'" value="'.$opkey.'"<?php if($_info["'.$Field_One['name'].'"]=='.$opkey.'){ ?> checked="checked"<?php }?>/> '.$opkeyval.'</label>';
	}
}else{
	$ops = model_field_attr($_Extra['option']);
	foreach ($ops as $opkey=>$opkeyval){
		$From_Return=$From_Return.'<label for="'.$Field_One['name'].'_'.$opkey.'"><input name="'.$Field_Name.'" id="'.$Field_One['name'].'_'.$opkey.'" type="'.$input_type.'" value="'.$opkey.'"/> '.$opkeyval.'</label>';
	}
}
return $From_Return;