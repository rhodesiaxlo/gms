<?php


/* 插件目录 */
const APP_ADDON_PATH = './App/Addons/';

/* 检测用户是否登录
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 * Return	：integer(0:未登录,大于0:当前登录用户ID)
 */
function is_login(){
	
	//获取session中的标识Key
    $_Key = session(C('AUTH_KEY'));
	
	//检测Key是否存在
    if (empty($_Key)) {
		
		//不存在返回0
        return 0;
		
    } else {
		
		//存在返回标识Key
        return $_Key;
		
    }

}

/* 检测当前用户是否为超级管理员
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 * Param	: _Uid[integer 用户ID]
 * Return	: boolean(true:管理员,false:非管理员)
 */
function is_admin($_Uid = null){
	
	//判断_Uid是否存在,如果不存在调用is_login函数
    $_Uid = is_null($_Uid) ? is_login() : $_Uid;
	
	//判断当前用户Key是否存在于超管用户组中
	if(in_array($_Uid,C('AUTH_ADMIN' ))){
		
		//存在
		return true;
		
	}else{
		
		//不存
		return false;
		
	}
}

/* 检验用户是否有权限访问当前规则
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 * Param	: Auth_Rule[string 规则] _Uid[integer 用户ID]
 * Return	: boolean(true:有权限,false无权限)
 */
function Is_Auth($_Auth_Rule,$_Uid){
	
	//实例化权限类
	$_Auth = new \Auth();
	
	//判断_Uid是否存在,如果不存在调用is_login函数
    $_Uid = is_null($_Uid) ? is_login() : $_Uid;
	
	//判断当前认证key是否为超级管理,或者当前模块是否为非认证模块
	if ( !is_admin($_Uid) && !in_array( CONTROLLER_NAME, explode ( ",", C ( "NOT_AUTH_MODULE" ) ) )) {
		
		//当前规则表达式
		$_Auth_Rule = MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME;
		
		//调用权限类进行判断
		if (!$_Auth->check( $_Auth_Rule , $_Uid ) ) {
			
			return false;
			
		}else{
			
			return true;
			
		}
	}else{
		
		//有超管权限或者为非认证模块
		return true;
		
	}
}


/* 合并Checkbox表单的数据(当前主要应用于模型中表单类型为Checkbox的数据的获取)
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 * Param	: _Value[array 数据组]
 * Return	: string 合并后的数据
 */
function Get_Checkbox_Value($_Value){
	
	//使用','对数据进行合并
	return implode(',',$_Value);
	
}

 /* 判断模块是否可以安装
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 * param	: _Name[string 模块名称] _Version[string 模块版本]
 * Return	: integer 模块比较结果(1 不存在次模块 2 当前版本低于需求版本 3 需求模块未启用 9 模块对比正常)
 */
function Verify_Module($_Name, $_Version){
	
	//设置模块路径
	$_Path = APP_PATH . $_Name;
	
	//判断是否存在相应模块的配置文件
	if (file_exists($_Path . DIRECTORY_SEPARATOR . 'Install' . DIRECTORY_SEPARATOR . 'Config.inc.php')) {
		//读取配置文件
        @include ($_Path . DIRECTORY_SEPARATOR . 'Install' . DIRECTORY_SEPARATOR . 'Config.inc.php');
		//判断模块的已安装模块的版本和当前需求版本的比较，如果已安装模块的版本低于当前需求模块的版本
		if (!version_compare($version,$_Version,'<')) {
			return 2;
		}else{
			$_Info = M('Module')->where(array('module'=>$_Name))->find();
			if($_Info['version']){
				return 9;
			}else{
				return 3;
			}
		}
	}else{
		return 1;
	}
}

/* 删除规则(当前主要应用)
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 * Param	: AuthRule_arr[array 规则数组]块对比正常)
 */
function del_AuthRule($AuthRule_arr){
	
	//循环所有规则
	foreach($AuthRule_arr as $AuthRule){
		
		//删除
		D("Admin/AuthRule")->where(array("name"=>$AuthRule))->delete();
		//Todo: 待加入 删除同时 清理AuthGroup中的对应规则数据
	}
	
}

function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
	// 创建Tree
	$tree = array();
	if(is_array($list)) {
		// 创建基于主键的数组引用
		$refer = array();
		foreach ($list as $key => $data) {
			$refer[$data[$pk]] =& $list[$key];
		}
		foreach ($list as $key => $data) {
			// 判断是否存在parent
			$parentId =  $data[$pid];
			if ($root == $parentId) {
				$tree[] =& $list[$key];
			}else{
				if (isset($refer[$parentId])) {
					$parent =& $refer[$parentId];
					$parent[$child][] =& $list[$key];
				}
			}
		}
	}
	return $tree;
}

/**
* 对查询结果集进行排序
* @access public
* @param array $list 查询结果
* @param string $field 排序的字段名
* @param array $sortby 排序类型
* asc正向排序 desc逆向排序 nat自然排序
* @return array
*/
function list_sort_by($list,$field, $sortby='asc') {
   if(is_array($list)){
       $refer = $resultSet = array();
       foreach ($list as $i => $data)
           $refer[$i] = &$data[$field];
       switch ($sortby) {
           case 'asc': // 正向排序
                asort($refer);
                break;
           case 'desc':// 逆向排序
                arsort($refer);
                break;
           case 'nat': // 自然排序
                natcasesort($refer);
                break;
       }
       foreach ( $refer as $key=> $val){
           $resultSet[] = &$list[$key];
	   }
       return $resultSet;
   }
   return false;
}
/**
 * 字符串转换为数组，主要用于把分隔符调整到第二个参数
 * @param  string $str  要分割的字符串
 * @param  string $glue 分割符
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function str2arr($str, $glue = ','){
    return explode($glue, $str);
}

/**
 * 数组转换为字符串，主要用于把分隔符调整到第二个参数
 * @param  array  $arr  要连接的数组
 * @param  string $glue 分割符
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function arr2str($arr, $glue = ','){
    return implode($glue, $arr);
}
/**
 * 获取用户昵称
 * @param string $id 行为id
 */
function get_username($id = null){
    if(empty($id) && !is_numeric($id)){
        $id = is_login();
    }
    if($id<1){
		return false;
    }
	else{
		$username = M('User')->where(array('id'=>$id))->getField('username');
		return $username?$username:'未知用户';
	}
}
/**
 * 根据时间戳获取一个标准格式的时间
 * @param string $id 行为id
 */
function time_format($time = null){
    if(empty($time)){
        $time = time();
    }
	return date('Y-m-d H:i:s',$time);
}

/**
 * 获取行为数据
 * @param string $id 行为id
 * @param string $field 需要获取的字段
 */
function get_action($id = null, $field = null){
    if(empty($id) && !is_numeric($id)){
        return false;
    }
    $list = S('action_list');
    if(empty($list[$id])){
		D('Action')->cache();
		$list = S('action_list');
    }
    return empty($field) ? $list[$id]['title'] : $list[$id][$field];
}

/**
 * 记录行为日志，并执行该行为的规则
 * @param string $action 行为标识
 * @param string $model 触发行为的模型名
 * @param int $record_id 触发行为的记录id
 * @param int $user_id 执行行为的用户id
 * @return boolean
 * @author huajie <banhuajie@163.com>
 */
function action_log($action = null, $model = null, $record_id = null, $user_id = null){

    //参数检查
    if(empty($action) || empty($model) || empty($record_id)){
        return '参数不能为空';
    }
    if(empty($user_id)){
        $user_id = is_login();
    }

    //查询行为,判断是否执行
    $action_info = M('Action')->where(array('name'=>$action))->find();
    if($action_info['status'] != 1){
        return '该行为被禁用或删除';
    }

    //插入行为日志
    $data['action_id']      =   $action_info['id'];
    $data['user_id']        =   $user_id;
    $data['action_ip']      =   get_client_ip();
    $data['model']          =   $model;
    $data['record_id']      =   $record_id;
    $data['create_time']    =   NOW_TIME;

    //解析日志规则,生成日志备注
    if(!empty($action_info['log'])){
        if(preg_match_all('/\[(\S+?)\]/', $action_info['log'], $match)){
            $log['user']    =   $user_id;
            $log['record']  =   $record_id;
            $log['model']   =   $model;
            $log['time']    =   NOW_TIME;
            $log['data']    =   array('user'=>$user_id,'model'=>$model,'record'=>$record_id,'time'=>NOW_TIME);
            foreach ($match[1] as $value){
                $param = explode('|', $value);
                if(isset($param[1])){
                    $replace[] = call_user_func($param[1],$log[$param[0]]);
                }else{
                    $replace[] = $log[$param[0]];
                }
            }
            $data['remark'] =   str_replace($match[0], $replace, $action_info['log']);
        }else{
            $data['remark'] =   $action_info['log'];
        }
    }else{
        //未定义日志规则，记录操作url
        $data['remark']     =   '操作url：'.$_SERVER['REQUEST_URI'];
    }

    M('ActionLog')->add($data);

    if(!empty($action_info['rule'])){
        //解析行为
        $rules = parse_action($action, $user_id);

        //执行行为
        $res = execute_action($rules, $action_info['id'], $user_id);
    }
}

/**
 * 根据ID和PID返回一个树形结构
 */
function list_to_tree2($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
	// 创建Tree
	$tree = array();
	if(is_array($list)) {
		// 创建基于主键的数组引用
		$refer = array();
		foreach ($list as $key => $data) {
			$refer[$data[$pk]] =& $list[$key];
		}
		foreach ($list as $key => $data) {
			// 判断是否存在parent
			$parentId =  $data[$pid];
			if ($root == $parentId) {
				$tree[$data['id']] =& $list[$key];
			}else{
				if (isset($refer[$parentId])) {
					$parent =& $refer[$parentId];
					$parent[$child][$data['id']] =& $list[$key];
				}
			}
		}
	}
	return $tree;
}
/**
 * 解析模型中选项字段的分解
 */
function model_field_attr($str,$estr1="\r\n",$estr2=':') {
	$arr1=array();
	$arr1 = explode($estr1,$str);
	if(count($arr1)>0){
		foreach ($arr1 as $arr1_one) {
			$arr2=array();
			$arr2 = explode($estr2,$arr1_one);
			if(count($arr2)>0){
				$strarr[$arr2[0]]=$arr2[1];
			}
		}
	}
	return $strarr;
}
/**
 * 处理插件钩子
 * @param string $hook   钩子名称
 * @param mixed $params 传入参数
 * @return void
 */
function hook($hook,$params=array()){
    \Think\Hook::listen($hook,$params);
}

/**
 * 获取插件类的类名
 * @param strng $name 插件名
 */
function get_addon_class($name){
    $class = "Addons\\{$name}\\{$name}Addon";
    return $class;
}
/**
 * 获取插件类的配置文件数组
 * @param string $name 插件名
 */
function get_addon_config($name){
    $class = get_addon_class($name);
    if(class_exists($class)) {
        $addon = new $class();
        return $addon->getConfig();
    }else {
        return array();
    }
}

/**
 * 插件显示内容里生成访问插件的url
 * @param string $url url
 * @param array $param 参数
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function addons_url($url, $param = array()){
    $url        = parse_url($url);
    $case       = C('URL_CASE_INSENSITIVE');
    $addons     = $case ? parse_name($url['scheme']) : $url['scheme'];
    $controller = $case ? parse_name($url['host']) : $url['host'];
    $action     = trim($case ? strtolower($url['path']) : $url['path'], '/');

    /* 解析URL带的参数 */
    if(isset($url['query'])){
        parse_str($url['query'], $query);
        $param = array_merge($query, $param);
    }

    /* 基础参数 */
    $params = array(
        '_addons'     => $addons,
        '_controller' => $controller,
        '_action'     => $action,
    );
    $params = array_merge($params, $param); //添加额外参数

    return U('Addons/execute', $params);
}


/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}
