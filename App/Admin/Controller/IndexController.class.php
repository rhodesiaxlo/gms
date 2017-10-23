<?php

/* 后台首页控制器
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 * Describe	: 
 */

namespace Admin\Controller;

class IndexController extends AdminCoreController {

    
	/* 首页显示
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 
	 */
    public function index(){
		
		//获取当前用户可见菜单
		$this->assign ( '_Admin_Menu', $this->Get_Menu() );
		
		//显示界面
		$this->display ();
		
    }
	
    
	/* 控制台页面
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 
	 */
    public function main(){
		$Soft_Info = array(
            '产品名称' => '<font color="#FF0000">'.C('SOFT_NAME').'</font>' . "&nbsp;&nbsp;&nbsp; [<a href='".C('SOFT_SITE')."' target='_blank'>访问官网</a>]&nbsp;&nbsp;&nbsp; [<a href='".C('SOFT_BBS')."' target='_blank'>论坛</a>]",
            '产品版本' => '<font color="#FF0000">'.C('SOFT_VERSION').'</font>',
            '产品流水号' => '<font color="#FF0000">'.C('SOFT_SERIAL_VERSION').'</font>',
            '版权所有' => '<a href="'.C('SOFT_SITE').'" target="_blank">'.C('SOFT_NAME').'</a>',
            '负责人/作者' => '<a href="'.C('SOFT_AUTHOR_SITE').'" target="_blank">'.C('SOFT_AUTHOR').'</a>',
            '联系QQ' => '<a href="http://wpa.qq.com/msgrd?v=3&uin='.C('SOFT_AUTHOR_QQ').'&site=qq&menu=yes" target="_blank">'.C('SOFT_AUTHOR_QQ').'</a>',
            '联系邮箱' => C('SOFT_AUTHOR_EMAIL'),
		);
		
        //服务器信息
        $Server_Info = array(
            '操作系统' => PHP_OS,
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式' => php_sapi_name(),
            'MYSQL版本' => mysql_get_server_info(),
            '上传附件限制' => ini_get('upload_max_filesize'),
            '执行时间限制' => ini_get('max_execution_time') . "秒",
            '剩余空间' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
        );
        $this->assign('Soft_Info', $Soft_Info);
        $this->assign('Server_Info', $Server_Info);
		//显示界面
		$this->display ();
    }

	
	/* 缓存更新页面
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 
	 */
    public function cache() {
		
		//判断是否有get数据提交
        if (isset($_GET['type'])) {
			
			//有则证明，正在更新缓存中
			
			//设置Dir文件夹操作类
			$_Dir = new \Dir();
			
			//设置缓存模型
            $_Cache = D('Common/Cache');
			
			//获取当前更新类型
            $_Type = I('get.type');
			
			//设置执行超时
            set_time_limit(0);
			
			//根据更新类型选择执行代码
            switch ($_Type) {
				
				//更新站点数据缓存
                case "site":
				
                    //开始刷新缓存
                    $_Stop = I('get.stop', 0, 'intval');
					
					//如果没有stop，则证明正在执行系统定义缓存的更新
                    if (empty($_Stop)) {
						
						//防止异常终止代码执行
                        try {
							
                            //已经清除过的目录
                            $_Dir_List = explode(',', I('get.dir', ''));
							
                            //删除缓存目录下的文件
							//RUNTIME_PATH 应用运行时目录（默认为 APP_PATH.'Runtime/'）
                            $_Dir->del(RUNTIME_PATH);
							
                            //获取子目录
                            $_Sub_Dir = glob(RUNTIME_PATH . '*', GLOB_ONLYDIR | GLOB_NOSORT);
							
							//如果还有目录存在继续执行
                            if (is_array($_Sub_Dir)) {
								
								//循环所有子目录
                                foreach ($_Sub_Dir as $_Path) {
									
									//获取文件夹名称
                                    $_Dir_Name = str_replace(RUNTIME_PATH, '', $_Path);
									
                                    //忽略目录
                                    if (in_array($dirName, array('Cache', 'Logs'))) {
										
										//跳出本次循环
                                        continue;
										
                                    }
									
									//如果是已经清楚过的目录
                                    if (in_array($_Dir_Name, $_Dir_List)) {
										
										//跳出本次循环,防止陷入死循环(TP每次运行都会出现缓存目录)
                                        continue;
                                    }
									
									//将本次的目录加入到清楚目录中去
                                    $_Dir_List[] = $_Dir_Name;
									
                                    //删除本次循环的目录
                                    $_Dir->delDir($_Path);
									
                                    //为了防止超时，清理一个从新跳转一次
									
									//跳转时间
                                    $this->assign("waitSecond", 1);
									
									//跳转页面显示
                                    $this->success("清理缓存目录[{$_Dir_Name}]成功！", U('Index/cache', array('type' => 'site', 'dir' => implode(',', $_Dir_List))));
									//跳转后防止错误，强制停止执行
                                    exit;
									
                                }
								
                            }
							
                            //更新开启其他方式的缓存
                            \Think\Cache::getInstance()->clear();
							
                        } catch (Exception $exc) {
							
                           //操作出错
						   
                        }
                    }
					
					//执行数据库中的缓存
                    if ($_Stop) {
						
                        $_Modules = $_Cache->getCacheList();
                        //需要更新的缓存信息
                        $_Cache_Info = $_Modules[$_Stop - 1];
						
						//判断数据是否存在
                        if ($_Cache_Info) {
							
							//存在
							
							//更新是否成功
                            if ($_Cache->runUpdate($_Cache_Info) !== false) {
								
								//跳转时间为1秒
                                $this->assign("waitSecond", 1);
								
								//返回成功提示，并且跳转到下一个缓存
                                $this->success('更新缓存：' . $_Cache_Info['name'], U('Index/cache', array('type' => 'site', 'stop' => $_Stop + 1)));
								//终止程序执行，防止误操作
                                exit;
								
                            } else {
								
								//更新失败，返回错误信息，跳转到下一记录
                                $this->error('缓存[' . $_Cache_Info['name'] . ']更新失败！', U('Index/cache', array('type' => 'site', 'stop' => $stop + 1)));
								
                            }
							
                        } else {
							
							//不存在
							
							//跳转时间为3秒
                            $this->assign("waitSecond", 3);
							
							//返回操作完成提示
                            $this->success('缓存更新完毕,请刷新网站！', U('Index/cache'));
							
							//终止程序执行，防止误操作
                            exit;
							
                        }
                    }
					
					//初始化第一次 自定义缓存跳转
                    $this->success("即将更新站点缓存！", U('Admin/Index/cache', array('type' => 'site', 'stop' => 1)));
					
                    break;
					
				//更新站点模板缓存
                case "template":
				
                    //删除缓存目录下的文件
                    $_Dir->del(RUNTIME_PATH);
                    $_Dir->delDir(RUNTIME_PATH . "Cache/");
                    $_Dir->delDir(RUNTIME_PATH . "Temp/");
					
                    //更新开启其他方式的缓存
                    \Think\Cache::getInstance()->clear();
					
					//跳转时间为3秒
					$this->assign("waitSecond", 3);
					
					//返回操作完成提示
					$this->success('缓存更新完毕,请刷新网站！', U('Index/cache'));
					
                    break;
				//清除网站运行日志
                case "logs":
				
				 	//删除日志文件夹
                    $_Dir->delDir(RUNTIME_PATH . "Logs/");
					
					//跳转时间为3秒
					$this->assign("waitSecond", 3);
					
					//返回操作完成提示
					$this->success('缓存更新完毕,请刷新网站！', U('Index/cache'));

                    break;
					
				//未选择更新类型
                default:
				
					//返回错误信息
                    $this->error("请选择清楚缓存类型！");
					
                    break;
            }
			
        } else {
			
			//显示界面
            $this->display();
			
        }
		
    }
	
}