/* 时间戳转日期*/
function u_to_ymd(dateNum){
	if(dateNum>0){
		var date=new Date(dateNum*1000);
		return date.getFullYear()+"-"+fixZero(date.getMonth()+1,2)+"-"+fixZero(date.getDate(),2);
	}else{
		return '';
	}
}
/* 时间戳转时间*/
function u_to_ymdhis(dateNum){
	if(dateNum>0){
		var date=new Date(dateNum*1000);
		return date.getFullYear()+"-"+fixZero(date.getMonth()+1,2)+"-"+fixZero(date.getDate(),2)+" "+fixZero(date.getHours(),2)+":"+fixZero(date.getMinutes(),2)+":"+fixZero(date.getSeconds(),2);
	}else{
		return '';
	}
}
/* 格式化时间 */
function fixZero(num,length){
	var str=""+num;
	var len=str.length;
	var s="";
	for(var i=length;i-->len;){
	s+="0";
	}
	return s+str;
}

function GoUrl(Url){
	window.location.href=Url
}
/*表单验证提交*/
function Sub_Form(Form_Name) {
	$.post(
		$(this).attr('action'),
		$(Form_Name).serialize(),
		function(data,status){
			if(data['status'] == 1){
				$.messager.alert('成功提示',data['info'],'info');
				window.setTimeout("location.href='"+data['url']+"'",1000);
			}else{
				$.messager.alert('警告',data['info']);
			}
		}
	);
}

/*列表页面搜索*/
var Search_From_w;//搜索框的宽度
var Search_From_h;//搜索框的高度
function Data_Search(Search_From,Datagrid_data){
	if(Search_From_w<20 || Search_From_w==null){
		Search_From_w=$('#'+Search_From).width();
		Search_From_h=$('#'+Search_From).height();
		if(Search_From_w<20){Search_From_w=600}
		if(Search_From_h<20){Search_From_h=350}
	}
	$('#'+Search_From).dialog({
		width:Search_From_w,   
		height:Search_From_h,  
		title : '搜索',
		modal:true,
		cache: false,
		buttons : [{
				text : '搜索',
				iconCls : 'iconfont icon-search',
				handler : function () {
					var queryParams = $('#'+Datagrid_data).datagrid('options').queryParams;
					$.each($('#'+Search_From).serializeArray(), function() {
						queryParams[this['name']] = this['value'];
					});
					$('#'+Datagrid_data).datagrid('reload');
				},
			}],
	})
}

//弹窗编辑
var Updata_From_w;//弹窗编辑框的宽度
var Updata_From_h;//弹窗编辑框的高度
/*
Updata_From			编辑框ID
Updata_From_Url		编辑框加载URL
Updata_From_Title	编辑框的标题
Datagrid_data		编辑保存后刷新的框架
*/
function From_Data_Updata(Updata_From,Updata_From_Url,Updata_From_Title,Datagrid_data){
	//设置弹出框的宽度与高度
	if(Updata_From_w<20 || Updata_From_w==null){
		Updata_From_w=$('#'+Updata_From).width();
		Updata_From_h=$('#'+Updata_From).height();
		if(Updata_From_w<20){Updata_From_w=600}
		if(Updata_From_h<20){Updata_From_h=350}
	}
	//设置页面提交的URL
	Data_From_action=$('#'+Updata_From).attr('url');
	$('#'+Updata_From).dialog({
		width:Updata_From_w,
		height:Updata_From_h,
		href:Updata_From_Url,
		title : '数据处理',
		modal:true,
		cache: false,
		buttons : [{
				text : '提交',
				iconCls : 'iconfont icon-success',
				handler : function () {
					$.post(Updata_From_Url, $('#'+Updata_From).serialize(), function(res){
						if(!res.status){
							$.messager.show({title:'错误提示',msg:res.info,timeout:2000,showType:'slide'});
						}else{
							$('#'+Updata_From).dialog('close');
							$.messager.show({title:'成功提示',msg:res.info,timeout:1000,showType:'slide'});
							Data_Reload(Datagrid_data);
						}
					})
				},
			}],
	})
}

/* 列表AJAX处理数据 */
/*
Data_from_url	要进行的操作
Datagrid_data	操作执行后就行的处理
*/

function Data_Ajax(Data_from_url,Datagrid_data){
	$.messager.confirm('确定操作', '您确认继续当前操作吗？', function (flag) {
		if (flag){
			$.post(Data_from_url,{},function(res){
				if(!res.status){
					$.messager.show({title:'错误提示',msg:res.info,timeout:2000,showType:'slide'});
				}else{
					$.messager.show({title:'成功提示',msg:res.info,timeout:1000,showType:'slide'});
					Data_Reload(Datagrid_data);
				}
			})
		}
	})
}

/* 刷新 */
function Data_Reload(Data_Box){
	$('#'+Data_Box).datagrid('reload');
	$('#'+Data_Box).treegrid('reload');
}



KindEditor.ready(function(K) {});


/* 上传附件 */

function updata_fields(file_box){
	KindEditor.ready(function(K) {
		updata_fields_editor = K.editor({
			allowFileManager : true,
			pasteType:ke_pasteType,
			fileManagerJson: ke_fileManagerJson,
			uploadJson: ke_uploadJson,
			extraFileUploadParams: {
				uid: ke_Uid
			}
		});
		updata_fields_editor.loadPlugin('insertfile', function() {
			updata_fields_editor.plugin.fileDialog({
				fileUrl : $('#'+file_box).textbox('getValue'),
				clickFn : function(url, title) {
					$('#'+file_box).textbox('setValue',url);
					updata_fields_editor.hideDialog();
				}
			});			
		});
	});
}


/* 上传图片 */

function updata_image(image_box){
	KindEditor.ready(function(K) {
		var updata_image_editor = K.editor({
			allowFileManager : true,
			pasteType:ke_pasteType,
			fileManagerJson: ke_fileManagerJson,
			uploadJson: ke_uploadJson,
			extraFileUploadParams: {
				uid: ke_Uid
			}
		});
		updata_image_editor.loadPlugin("image", function() {
			var img_value = ''
			try{img_value = $('#'+image_box).textbox('getValue')}
			catch(err){}
			if(img_value == ''){
				img_value = $('#'+image_box).val()
				img_t = 2
			}
			updata_image_editor.plugin.imageDialog({
				imageUrl : img_value,
				clickFn : function(url, title, width, height, border, align) {
					if(img_t==2){
						$('#'+image_box).val(url);
						
						$('#'+image_box+'_show').attr('src',url);
					}else{
						$('#'+image_box).textbox('setValue',url);
					}
					updata_image_editor.hideDialog();
				}
			});
		});
	});
}

(function($, K) {
	if (!K) throw "KindEditor未定义!";
	
	function create(target) {
		var opts = $.data(target, 'kindeditor').options;
		var editor = K.create(target, opts);
		$.data(target, 'kindeditor').options.editor = editor;
	}

	$.fn.kindeditor = function(options, param) {
		if (typeof options == 'string') {
			var method = $.fn.kindeditor.methods[options];
			if (method) {
				return method(this, param);
			}
		}
		options = options || {};
		return this.each(function() {
			
			if($(this).attr('config_date')==0){
				config_date=['fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline', 'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist', 'insertunorderedlist', '|', 'emoticons', 'image', 'link'];
			}else if($(this).attr('config_date')==1){
				config_date=[
		'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
		'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
		'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
		'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
		'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
		'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
		'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
		'anchor', 'link', 'unlink', '|', 'about'
	];
			}else{
				config_date=['fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline', 'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist', 'insertunorderedlist', '|', 'emoticons', 'image', 'link'];
			}
			
			var state = $.data(this, 'kindeditor');
			if (state) {
				$.extend(state.options, options);
			} else {
				state = $.data(this, 'kindeditor', {
					options: $.extend(
					{},
					{
						resizeType: 1,
						allowPreviewEmoticons: false,
						allowImageUpload: false,
						items: config_date,
						allowFileManager : true,
						pasteType:ke_pasteType,
						fileManagerJson: ke_fileManagerJson,
						uploadJson: ke_uploadJson,
						extraFileUploadParams: {
							uid: ke_Uid
						},
						afterChange: function() {
							this.sync();
						},
						afterBlur: function() {
							this.sync();
						}
					},
					$.fn.kindeditor.parseOptions(this), options)
				});
			}
			create(this);
		});
	}

	$.fn.kindeditor.parseOptions = function(target) {
		return $.extend({},
		$.parser.parseOptions(target, []));
	};

	$.fn.kindeditor.methods = {
		editor: function(jq) {
			return $.data(jq[0], 'kindeditor').options.editor;
		}
	};
	$.parser.plugins.push("kindeditor");
})(jQuery, KindEditor);
