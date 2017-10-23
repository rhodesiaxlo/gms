<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title> <?php echo C('SOFT_NAME');?> | <?php echo C('SOFT_NAME');?></title>
	<link rel="stylesheet" type="text/css" href="/Public/Static/Easyui/themes/ThinkGMS/easyui.css">
	<link rel="stylesheet" type="text/css" href="/Public/Static/Easyui/Exten/Ribbon/ribbon.css">
    <link rel="stylesheet" type="text/css" href="/Public/Static/kindeditor/themes/default/default.css" />
    <link rel="stylesheet" href="/Public/Static/IconFont/iconfont.css">
	<link href="/Public/Admin/css/base.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="/Public/Static/Jquery/jquery.min.js"></script>
	<script type="text/javascript" src="/Public/Static/Easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="/Public/Static/Easyui/locale/easyui-lang-zh_CN.js"></script>
	<script type="text/javascript" src="/Public/Static/Easyui/Exten/Ribbon/jquery.ribbon.js"></script>
    <script charset="utf-8" src="/Public/Static/kindeditor/kindeditor-min.js"></script>
    <script charset="utf-8" src="/Public/Static/kindeditor/lang/zh_CN.js"></script>
    <script charset="utf-8" src="/Public/Static/Echarts/echarts.js"></script>
	<script type="text/javascript" src="/Public/Admin/js/base.js"></script>
    <script>
	var ke_pasteType=2;
	var ke_fileManagerJson="<?php echo U('Admin/FilesUpdata/filemanager');?>";
	var ke_uploadJson="<?php echo U('Admin/FilesUpdata/upload');?>";
	var ke_Uid='<?php echo session(C("AUTH_KEY"));;?>';
	var Root='';
	</script>
</head>
<body>
<div class="Tool_Bar" id="Hooks_Bar">
<dl>
	<dt>钩子管理</dt>
    <?php echo ($Main_Nav); ?>
</dl>
</div>
<div style="display: none">
<form id="Hooks_Search_From" >
<fieldset class="Form_1 Form_2">
<div class="formitm">
	<label class="lab" for="for_name">钩子名称 ：</label>
	<div class="ipt"><input name="s_name"  id="for_name"type="text" class="easyui-textbox" style="height:30px;"></div>
</div><div class="formitm">
	<label class="lab" for="for_type">类型 ：</label>
	<div class="ipt"><select name="s_type" id="for_s_type" class="easyui-combobox" style="height:30px;" data-options="url:'<?php echo U("Admin/Function/get_field_option");?>&f_id=56&r_type=json',valueField:'id',textField:'text',value:null"></select></div>
</div><div class="formitm">
	<label class="lab" for="for_update_time">更新时间 ：</label>
	<div class="ipt"><input name="s_update_time_min" type="text" class="easyui-datebox" style="height:30px;"> - <input name="s_update_time_max" type="text" class="easyui-datebox" style="height:30px;"></div>
</div><div class="formitm">
	<label class="lab" for="for_status">状态 ：</label>
	<div class="ipt"><select name="s_status" id="for_s_status" class="easyui-combobox" style="height:30px;" data-options="url:'<?php echo U("Admin/Function/get_field_option");?>&f_id=59&r_type=json',valueField:'id',textField:'text',value:null"></select></div>
</div></fieldset>
</form>
</div>
<table id="Hooks_Data_List"></table>
<script charset="utf-8" src="<?php echo U('Admin/Function/get_field_option',array('f_id'=>'56','r_type'=>'json_list'));?>"></script>
<script charset="utf-8" src="<?php echo U('Admin/Function/get_field_option',array('f_id'=>'59','r_type'=>'json_list'));?>"></script>
<script type="text/javascript">
$(function() {
	$("#Hooks_Data_List").datagrid({
		url : "<?php echo U('Hooks/index');?>",
		fit : true,
		striped : true,
		border : false,
		pagination : true,
		pageSize : 20,
		pageList : [ 10, 20, 50 ],
		pageNumber : 1,
		sortName : 'id',
		sortOrder : 'desc',
		toolbar : '#Hooks_Bar',
		singleSelect : true,
		frozenColumns:[[
			{field : 'id',title : 'ID',width : 40,sortable:true}
,
			{field : "name",title : "钩子名称",width :180}
				
		]],
		columns : [[

			{field : "type",title : "类型",width :50,formatter: function (value, row, index) {
					return op_type[value];
			}},
			
			{field : "update_time",title : "更新时间",width :100,formatter: function (value, row, index) {
				return u_to_ymd(value)
			}},
			
			{field : "status",title : "状态",width :100,formatter: function (value, row, index) {
					return op_status[value];
			}},
				

			{field : "operate",title : "操作",width : 200,formatter: function (value, row, index) {
				operate_menu='';
				
				<?php if(Is_Auth('Admin/Hooks/edit')): ?>operate_menu = operate_menu+"<a href='<?php echo U('edit'); ?>&id="+row.id+"' >编辑</a>";<?php endif; ?>

				<?php if(Is_Auth('Admin/Hooks/del')): ?>operate_menu = operate_menu+" | <a href='#' onclick=\"Data_Ajax('<?php echo U('del'); ?>&id="+row.id+"','Hooks_Data_List');\">删除</a>";<?php endif; ?>

				return operate_menu;
			}}
		]]
	});
})
<!-- 扩展数据 starp-->
<!-- 扩展数据 end-->
</script>
</body>
</html>