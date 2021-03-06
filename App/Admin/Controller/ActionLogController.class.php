<?php 
/*
 * 行为日志控制器
 * Auth   : Ghj
 * Time   : 2016-07-08
 * QQ     : 912524639
 * Email  : 912524639@qq.com
 * Site   : http://guanblog.sinaapp.com/
 */
 
namespace Admin\Controller;

class ActionLogController extends AdminCoreController {
	
	//系统默认模型
	private $Model = null;

    protected function _initialize() {
		//继承初始化方法
		parent::_initialize ();
		//设置控制器默认模型
        $this->Model = D('ActionLog');
    }
	
    /* 列表(默认首页)
     * Auth   : Ghj
     * Time   : 2016年01月13日 
     **/
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
          	foreach($_list as $list_key=>$list_one){
				$_list[$list_key]['action_id_show']=get_action($_list [$list_key]['action_id'],'title');
            }
			$data = array (
					'total' => $total,
					'rows' => $_list 
			);
			$this->ajaxReturn ( $data );
		} else {
			$this->display ();
		}
	}
	
    /* 搜索
     * Auth   : Ghj
     * Time   : 2016年01月13日 
     **/
	protected function _search() {
		$map = array ();
		$post_data=I('post.');
		/* 名称：行为id 字段：action_id 类型：string*/
		if($post_data['s_action_id']!=''){
			$map['action_id']=array('like', '%'.$post_data['s_action_id'].'%');
		}
		/* 名称：执行用户id 字段：user_id 类型：string*/
		if($post_data['s_user_id']!=''){
			$map['user_id']=array('like', '%'.$post_data['s_user_id'].'%');
		}
		/* 名称：执行行为的时间 字段：create_time 类型：datetime*/
		if($post_data['s_create_time_min']!=''){
			$map['create_time'][]=array('gt',strtotime($post_data['s_create_time_min']));
		}
		if($post_data['s_create_time_max']!=''){
			$map['create_time'][]=array('lt',strtotime($post_data['s_create_time_max']));
		}
		return $map;
	}
	
    /* 编辑
     * Auth   : Ghj
     * Time   : 2016年01月13日 
     **/
	public function look(){
		$_info=I('get.');
		$_info = $this->Model->where(array('id'=>$_info['id']))->find();
		$this->assign('_info', $_info);
		$this->display();
	}
    /* 删除
     * Auth   : Ghj
     * Time   : 2016年01月13日 
     **/
	public function del(){
		$id=I('get.id');
		empty($id)&&$this->error('参数不能为空！');
		$res=$this->Model->delete($id);
		if(!$res){
			$this->error($this->Model->getError());
		}else{
			action_log('Del_ActionLog', 'ActionLog', $id);
			$this->success('删除成功！');
		}
	}
    /* 清空
     * Auth   : Ghj
     * Time   : 2016年01月13日 
     **/
	public function delall(){
		$res=$this->Model->where(('id!=0'))->delete();
		if(!$res){
			$this->error($this->Model->getError());
		}else{
			action_log('DelAll_ActionLog', 'ActionLog', $id);
			$this->success('清空数据成功');
		}
	}
}