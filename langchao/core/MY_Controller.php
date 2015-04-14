<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
/**
 * 每个控制器的基类
 *
 * @package Controller
 * @category Controller
 * @author yoyyx123@126.com
 * @link 
 */
class MY_Controller extends CI_Controller {

	/**
	 * 时间名词
	 * @access private
	 */
	private $_period_array = array('today'=>'1', 'yesterday'=>'2', 'last7days'=>'7', 'last15days'=>'15', 'last30days'=>'30');

	/**
	 *
	 * 传入模板的数据
	 * @access protected
	 */
	protected $data = array();

	/**
	 * GET的数据
	 * @access protected
	 */
	protected $getdata = array();

	/**
	 * POST的数据
	 * @access protected
	 */
	protected $postdata = array();

	/**
	 *
	 * 开始时间
	 * @access protected
	 */
	protected $start_date = '';

	/**
	 *
	 * 结束时间
	 * @access protected
	 */
	protected $end_date = '';

	/**
	 *
	 * 开始时间INT型
	 * @access protected
	 */
	protected $start_date_int = '';

	/**
	 *
	 * 结束时间INT型
	 * @access protected
	 */
	protected $end_date_int = '';

	/**
	 *
	 * 开始时间戳
	 * @access protected
	 */
	protected $start_time = '';

	/**
	 *
	 * 结束时间戳
	 * @access protected
	 */
	protected $end_time = '';

	/**
	 *
	 * 显示方式
	 * @access protected
	 */
	protected $scale = 'day';

	/**
	 *
	 * 分组方式
	 * @access protected
	 */
	protected $group = 'ymd';

	/**
	 * 节点类型
	 * @access protected
	 */
	protected $node_type = 'all';

	/**
	 * 显示个数
	 * @access protected
	 */
	protected $limit = '';

	/**
	 * 分类列表
	 * @access protected
	 */
	protected $api_category_kv = array();

	/**
	 * 应用列表
	 * @access protected
	 */
	protected $user_info = array();

    protected $username = '';

	/**
	 * 构造函数
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
        $this->load->library('pagination');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Role_model');
		$this->getdata = $_GET;
		$this->postdata = $_POST;
		$this->data['getdata'] = $this->security->xss_clean($this->getdata);
        $username = $this->session->userdata('username');
        $expire_date = $this->Role_model->get_expire_date();
        if(!$expire_date){
        	$expire_date = array('name'=>0);
        }
        define('EXPIRE_DATE', $expire_date['name']); // 事件过期时间


		/**
        $username = $this->session->userdata('username');
		if(!isset($this->getdata['act'])){
            redirect('ctl=home&act=index');
			exit();
		}
	    if (!isset($this->getdata['act'])||empty($username) && !in_array($this->getdata['act'], array('login', 'do_login','check_login','send_captcha',''))) {
		    redirect('ctl=user&act=login');
 	        exit();
	    }
		**/
		if (!isset($this->getdata['act'])||empty($username) && !in_array($this->getdata['act'], array('login', 'do_login','check_login','send_captcha',''))) {
			    redirect('ctl=user&act=login');
	 	        exit();
		    }
		if(!empty($username)){
			$menu_list = $this->get_menu_list();
			$this->data['menu_list'] = $menu_list;
		}        
/**
		if(!empty($username)){

			$user_info =  $this->session->all_userdata();
			print_r($user_info);
			if($user_info['act']!='all'){
				$user_info['act'] = explode(',',$user_info['act']);
			}
			$this->data['user_info'] = $user_info;
		}
		
**/
		$per_page = !empty($this->getdata['per_page']) ? $this->getdata['per_page'] : 0;
		$this->per_page = $per_page;
		$this->limit = $per_page . ',' . ROW_SHOW_NUM;
	}

	public function get_menu_list(){
		$role_id = $this->session->userdata('roles');
		//print_r(array("id"=>$role_id));
		$role_info = $this->Role_model->get_role_info(array("id"=>$role_id));
		$permission = unserialize($role_info['permission']);
		//print_r($permission);
		$top_list = $this->Role_model->get_top_list();
		$permission_list = $this->Role_model->get_permission_list(array("type"=>"ctl"));
		foreach ($permission as $key => $value) {
			if (in_array($value, $top_list)){
				$res[$value] = $permission_list[$value];
				//$child_list = $this->Role_model->get_child_list(array('pid'=>$value));
				unset($permission[$key]);
			}
		}
		foreach ($res as $key => $value) {
			$child_list = $this->Role_model->get_child_list(array('pid'=>$key));
			foreach ($permission as $k => $val) {
				if(in_array($val, $child_list)){
					$res[$key]['child'][] = $permission_list[$val];
					unset($permission[$k]);
				}
			}
		}
		//print_r($res);
		return $res;
	}

	public function request_post($url,$params){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}

	/**
	 * 分页设置
	 *
	 */
	public function pages_conf($total_rows,$id=FALSE,$row_num=FALSE) {
		/*分页处理*/
		$tmp = $this->getdata;
		unset($tmp['per_page']);
        if($id != FALSE){
		    $tmp['id'] = $id;
        }
		$config['base_url'] = site_url(http_build_query($tmp, '', '&'));
		$config['total_rows'] = $total_rows;
		$config['first_link'] = '首页';
		$config['last_link'] = '未页';
		$config['next_link'] = '下页';
		$config['prev_link'] = '上页';
		if(isset($row_num)&& !empty($row_num)){
			$config['per_page'] = $row_num;		
			$this->data['page_count'] = ceil($total_rows / $row_num);
		}else{
			$config['per_page'] = ROW_SHOW_NUM;		
			$this->data['page_count'] = ceil($total_rows / ROW_SHOW_NUM);
		}
		$this->data['total_rows'] = $total_rows;
		$this->pagination->initialize($config);
	}

/**
    public function write_admin_log($get,$post){
        $log_msg['do'] = $get;
        $log_msg['msg'] = $post;
        $logs['userid'] = $this->session->userdata('id');
        $logs['username'] = $this->session->userdata('username');
        $logs['dotime'] = date('Y-m-d H:i:s');
        $logs['action'] = serialize($log_msg);
        $res = $this->Admin_model->write_admin_logs($logs);
    }
**/
    public function check_power($key){
       if (!@in_array($key,@unserialize($this->session->userdata('action')))){
            exit('no power! <a href="javascript:history.go(-1);">back</a>');
       }
    }
}

?>