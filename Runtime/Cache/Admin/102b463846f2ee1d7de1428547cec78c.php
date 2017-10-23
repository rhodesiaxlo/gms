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
<form id="Hooks_Form" class="easyui-tabs Updata_Form" data-options="fit:true,tools:'#Hooks_Bar',toolPosition:'left',tabHeight:40,border:false" action="<?php echo U('Admin/Hooks/edit');?>" method="post">
<div title="基础" style="padding:20px;">
    <fieldset class="Form_1">
    	<div class="formitm">
            <label class="lab"  for="for_name">钩子名称：</label>
            <div class="ipt">
                <input name="name" id="for_name" type="text" value="<?php echo ($_info["name"]); ?>" class="easyui-textbox" style="height:30px;" data-options="type:'text'">                <p></p>
            </div>
        </div><div class="formitm">
            <label class="lab"  for="for_description">描述：</label>
            <div class="ipt">
                <textarea name="description" id="for_description" class="easyui-textbox" data-options="required:false,multiline:true" style="width:300px; height:100px;"><?php echo ($_info["description"]); ?></textarea>                <p></p>
            </div>
        </div><div class="formitm">
            <label class="lab"  for="for_type">类型：</label>
            <div class="ipt">
                <select name="type" id="for_type" class="easyui-combobox" style="height:30px;" data-options="value:'<?php echo ($_info["type"]); ?>',url:'<?php echo U("Admin/Function/get_field_option");?>&f_id=56&r_type=json',valueField:'id',textField:'text'"></select>                <p></p>
            </div>
        </div><div class="formitm">
            <label class="lab"  for="for_addons">插件：</label>
            <div class="ipt">
                <textarea name="addons" id="for_addons" class="easyui-textbox" data-options="required:false,multiline:true" style="width:300px; height:100px;"><?php echo ($_info["addons"]); ?></textarea>                <p>以“,”分割</p>
            </div>
        </div><div class="formitm">
            <label class="lab"  for="for_status">状态：</label>
            <div class="ipt">
                <select name="status" id="for_status" class="easyui-combobox" style="height:30px;" data-options="value:'<?php echo ($_info["status"]); ?>',url:'<?php echo U("Admin/Function/get_field_option");?>&f_id=59&r_type=json',valueField:'id',textField:'text'"></select>                <p></p>
            </div>
        </div>        <div class="formitm formitm-1"><a class="easyui-linkbutton" href="JavaScript:void(0);" onclick="Sub_Form('#Hooks_Form');" data-options="iconCls:'iconfont icon-edit'"><span style="font-size: 14px; font-weight: 600;">提交</span></a></div>
    </fieldset>
    </div><input name="id" type="hidden" value="<?php echo I('get.id');?>" />
<!-- 扩展数据 starp-->
<!-- 扩展数据 end-->
</form>
</body>
</html>