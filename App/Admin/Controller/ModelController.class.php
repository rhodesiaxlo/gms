<?php
/* 模型管理控制器
 * Auth		: 管侯杰
 * Email	: 912524639@qq.com
 * Describe	: 拥有基本的增删改查，Todo数据导入导出功能
 */
namespace Admin\Controller;

class ModelController extends AdminCoreController {
	
	//系统默认模型
	private $Model = null;
	//模型配置信息
	private $ModelInfo = null;
	//模型字段
	private $ModelField = null;
	
	/* 初始化方法
	 * Auth		: 管侯杰
	 * Email	: 912524639@qq.com
	 * Describe	: 拥有基本的增删改查，Todo数据导入导出功能
	 */
	protected function _initialize() {
		//继承初始化方法
		parent::_initialize ();
		//设置控制器默认模型
		$this->Model = D ( 'Model' );
	}
	
	/*
	 * 列表(默认首页)
	 * Auth : Ghj
	 * Time : 2015年07月26日
	 */
    public function index(){
		if (IS_POST) {
			$post_data = I ( 'post.' );
			$post_data ['first'] = $post_data ['rows'] * ($post_data ['page'] - 1);
			$map = array ();
        	$map = array('status'=>array('gt',-1));
			$total = $this->Model->where ( $map )->count ();
			if ($total == 0) {
				$_list = '';
			} else {
				$_list = $this->Model->where ( $map )->order ( $post_data ['sort'] . ' ' . $post_data ['order'] )->limit ( $post_data ['first'] . ',' . $post_data ['rows'] )->select ();
			}
			$data = array (
					'total' => $total,
					'rows' => $_list 
			);
			$this->ajaxReturn ( $data );
		} else {
			$Main_Nav=$this->Get_Main_Nav('sort_l');
			if(Is_Auth('Admin/Model/generate')){
				$Main_Nav=$Main_Nav.'<dd><a href="JavaScript:void(0);" onclick="GoUrl(\''.U('Admin/Model/generate').'\')"><span>系统化数据模型</span></a></dd>';
			}
			if(Is_Auth('Admin/Model/import')){
				$Main_Nav=$Main_Nav.'<dd><a href="JavaScript:void(0);" onclick="GoUrl(\''.U('Admin/Model/import').'\')"><span>导入模型</span></a></dd>';
			}
			$this->assign ( 'Main_Nav', $Main_Nav);
			$this->display ();
		}
    }

	/*
	 * 添加
	 * Auth : Ghj
	 * Time : 2015年07月26日
	 */
    public function add(){
		if (IS_POST) {
			$post_data = I ( 'post.' );
			$data = $this->Model->create ( $post_data );
			if ($data) {
				$result = $this->Model->update ( $data );
				if ($result) {
					if($data['is_extend']>0){
						D('ModelField')->addField(
							array(
								'model_id'=>$result,
								'name'=>'extend_model_id',
								'field'=>'int(10) UNSIGNED NOT NULL',
								'title'=>'扩展模型ID',
								'value'=>'0',
							)
						);
					}
					$this->Model->cache($result);
					$this->success ( "操作成功！", U ( 'index' ) );
				} else {
					$error = $this->Model->getError ();
					$this->error ( $error ? $error : "操作失败！" );
				}
			} else {
				$error = $this->Model->getError ();
				$this->error ( $error ? $error : "操作失败！" );
			}
		} else {
			//获取所有允许子模型的模型
			$is_extend_list = M('Model')->where(array('is_extend'=>array('neq',0),'status'=>1))->field('id,name,title')->select();
			$this->assign('is_extend_list', $is_extend_list);
			$Main_Nav=$this->Get_Main_Nav('sort_a');
			$this->assign ( 'Main_Nav', $Main_Nav);
			$this->display ();
		}
    }

	/*
	 * 编辑
	 * Auth : Ghj
	 * Time : 2015年07月26日
	 */
    public function edit(){
		if (IS_POST) {
			$post_data = I ( 'post.' );
			
			$data = $this->Model->create ( $post_data );
			if ($data) {
				$result = $this->Model->update ( $data );
				if ($result) {
					$this->Model->cache($post_data['id']);
					$this->success ( "操作成功！", U ( 'index' ) );
				} else {
					$error = $this->Model->getError ();
					$this->error ( $error ? $error : "操作失败！" );
				}
			} else {
				$error = $this->Model->getError ();
				$this->error ( $error ? $error : "操作失败！" );
			}
		} else {
			$id = I ( 'get.id' );
			$_info = $this->Model->where ( array ('id' => $id ) )->find ();
			$this->assign ( '_info', $_info );
			//获取所有允许子模型的模型
			$is_extend_list = M('Model')->where(array('is_extend'=>array('neq',0),'status'=>1))->field('id,name,title')->select();
			$this->assign('is_extend_list', $is_extend_list);
			$Main_Nav=$this->Get_Main_Nav('sort_e');
			$this->assign ( 'Main_Nav', $Main_Nav);
			$this->display ();
		}
    }

	/*
	 * 删除
	 * Auth : Ghj
	 * Time : 2015年07月26日
	 */
	public function del() {
		$id = I ( 'get.id' );
		if(empty ( $id )){
			$this->error ( '参数不能为空！' );
			exit;
		}
		$total = $this->Model->where ( array ('extend'=>$id ))->count ();
		if( $total>0 ){
			$this->error ( '此模型有子模型，不能删除！' );
			exit;
		}
		$res = $this->Model->del ( $id );
		if (! $res) {
			$this->error ( $this->Model->getError () );
		} else {
			$this->Model->cache($id);
			$this->success ( '删除成功！' );
		}
	}
	
	/*
	 * 系统化数据模型
	 * Auth : Ghj
	 * Time : 2015年10月11日
	 */
	public function generate() {
		if (! IS_POST) {
			// 获取所有的数据表
			$tables = D ( 'Model' )->getTables ();
			$this->assign ( 'tables', $tables );
			$Main_Nav=$this->Get_Main_Nav('sort_a');
			if(Is_Auth('Admin/Model/generate')){
				$Main_Nav=$Main_Nav.'<dd><a class="current" href="'.U('Admin/Model/generate').'"><span>系统化数据模型</span></a></dd>';
			}
			$this->assign ( 'Main_Nav', $Main_Nav);
			$this->display ();
		} else {
			$table = I ( 'post.table' );
			empty ( $table ) && $this->error ( '请选择要生成的数据表！' );
			$res = D ( 'Model' )->generate ( $table, I ( 'post.name' ), I ( 'post.title' ) );
			if ($res) {
				$this->success ( '生成模型成功！', U ( 'index' ) );
			} else {
				$this->error ( D ( 'Model' )->getError () );
			}
		}
	}
	
	//模型导出
    public function export() {
        //需要导出的模型ID
        $_ID = I('get.id', 0, 'intval');
        if (empty($_ID)) {
            $this->error('请指定需要导出的模型！');
        }
        C('SHOW_PAGE_TRACE',false);
        //导出模型
        $_Status = $this->Model->export($_ID);
        if ($_Status) {
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=ThinkGMS_model_" . $_ID . '.txt');
            echo $_Status;
        } else {
			$_Error = $this->Model->getError();
            $this->error($_Error ? $_Error : '模型导出失败！');
        }
    }
	
	
    //模型导入
    public function import() {
        if (IS_POST) {
			$_Post = I('post.');
            if (empty($_Post['import_file'])) {
                $this->error("请选择上传文件！");
            }
            if (strtolower(substr($_Post['import_file'], -3, 3)) != 'txt') {
                $this->error("上传的文件格式有误！");
            }
            //读取文件
            $_Data = file_get_contents($_Post['import_file']);
            //导入
            $_Status = $this->Model->import($_Data, $_Post['tablename'], $_Post['name']);
            if ($_Status) {
                $this->success("模型导入成功，请及时更新缓存！");
            } else {
				$_Error = $this->Model->getError();
				$this->error($_Error ? $_Error : '模型导入失败！');
            }
        } else {
			$Main_Nav=$this->Get_Main_Nav('extend');
			if(Is_Auth('Admin/Model/generate')){
				$Main_Nav=$Main_Nav.'<dd><a href="JavaScript:void(0);" onclick="GoUrl(\''.U('Admin/Model/generate').'\')"><span>系统化数据模型</span></a></dd>';
			}
			$Main_Nav=$Main_Nav.'<dd><a class="current" href="JavaScript:void(0);" onclick="GoUrl(\''.U('Admin/Model/import').'\')"><span>导入模型</span></a></dd>';
			$this->assign ( 'Main_Nav', $Main_Nav);
            $this->display();
        }
    }
}
