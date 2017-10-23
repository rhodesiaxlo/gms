
$(function(){
/* 顶部导航选项卡切换
 * Version	: 2.2.0
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 */
//顶部导航选项卡状态
	$('#Main_Ribbon').ribbon({
		onSelect: function(){
			if(Main_Nav_Switch_Status==0){Main_Nav_Switch()}
		}
	});
	
	$('#Main_Ribbon li').click(function(){
		Main_Nav_Switch()
	});
	
/* 顶部导航选项卡内工具面板A被点击
 * Version	: 2.2.0
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 */
//顶部导航选项卡状态
	$('#Main_Ribbon .ribbon-toolbar a').click(function(){
		
		target = $(this).attr('target');
		if(target == '_blank'){
			window.location.href=$(this).attr('href');
			return false;
		}else{
			
			MainTabs($(this).attr('name'),$(this).find('strong').html(),$(this).attr('href'),$(this).find("i").attr('class'));
			Main_Nav_Switch();
			return false;
		}
	});
})


/* 顶部导航显示隐藏
 * Version	: 2.2.0
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 */
//顶部导航显隐状态
var Main_Nav_Switch_Status = 1;
function Main_Nav_Switch(){
	if(Main_Nav_Switch_Status == 1){
		//设置大小
		$('#Main_Layout').layout('panel', 'north').panel('resize',{height:41});
		//重载布局结构
		$('#Main_Layout').layout('resize');
		$('.Main_Nav_Switch').html('<i class="iconfont icon-down" title="展开"></i>');
		//设置共有变量
		Main_Nav_Switch_Status = 0;
	}else{
		//设置大小
		$('#Main_Layout').layout('panel', 'north').panel('resize',{height:165});
		//重载布局结构
		$('#Main_Layout').layout('resize');
		$('.Main_Nav_Switch').html('<i class="iconfont icon-up" title="收缩"></i>');
		//设置共有变量
		Main_Nav_Switch_Status = 1;
	}
}

/* 主选项卡操作
 * Version	: 2.2.0
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 */
function MainTabs(name,tit,url,icon) {
	//新建数组
	var strs= new Array();
	//将name分解为三段（添加链接时注意，第一个为模块，第二个为控制器，第三个为操作，例如Admin/Index/index）
	strs=name.split("/"); //字符分割 
	//设置控制器名称
	var model_name = strs[1];
	//判断选项卡是否存在
	if ($('#tabs_'+model_name).length>0) {
		//如果存在根据控制器名称获取选项卡
		index = $('#MainTabs').tabs('getTabIndex',$('#tabs_'+model_name));
		//选中上一步获取的选项卡
		$('#MainTabs').tabs('select',index)
		//获取选中选项卡的属性
		Selected_tabs=$('#MainTabs').tabs('getSelected')
		//创建一个空的对象，作为选项卡属性的添加对象
		options_s={}
		//设置选项卡的内容（iframe框架的url来自与传递的url参数）
		options_s.content='<iframe scrolling="yes" frameborder="0" src="'+url+'" style="width:100%;height:100%;"></iframe>';
		//设置选项卡样式
		options_s.bodyCls="tabs_box"
		//如果有tit存在，设置选项卡名称为tit的值
		if(tit!=''){
			options_s.title=tit
		}
		//如果有icon存在，设置选项卡图表为前面设置的icon的值
		if(icon!=''){
			options_s.iconCls=icon
		}
		//根据前面的属性设置当前选项卡的参数
		$('#MainTabs').tabs('update', {
			tab:Selected_tabs,//选中选项卡的对象
			options: options_s//前面的参数
		});
		//设置属性完成后更新当前选中的选项卡
		Selected_tabs.panel('refresh');
	} else {
		//创建一个空的对象，作为选项卡属性的添加对象
		options_s={}
		//根据控制器名称，设置选项卡的ID
		options_s.id='tabs_'+model_name
		//如果有tit存在，设置选项卡名称为tit的值
		if(tit!=''){
			options_s.title=tit
		}else{
			options_s.title='未知控制器'//如果tit不存在，设置选项卡title为未知控制器
		}
		//设置选项卡的内容（iframe框架的url来自与传递的url参数）
		options_s.content='<iframe scrolling="yes" frameborder="0" src="'+url+'" style="width:100%;height:100%;"></iframe>';
		//设置选项卡为可以关闭
		options_s.closable=true
		//设置选项卡样式
		options_s.bodyCls="tabs_box"
		//如果有icon存在，设置选项卡图表为前面设置的icon的值，如果不存在设置为默认值
		if(icon!=null){
			options_s.iconCls=icon
		}else{
			options_s.iconCls='iconfont icon-viewlist'
		}
		//设置属性完成后，新建一个选项卡
		$('#MainTabs').tabs('add', options_s);
	}
	
}