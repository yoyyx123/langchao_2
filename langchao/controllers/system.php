<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System extends MY_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
        $this->load->model('Role_model');
    }


	public function role_list()
	{
		$this->data['user_data'] = $this->session->userdata;		
		$where = array();
		$role_list = $this->Role_model->get_roles($where,$this->per_page);
		$this->pages_conf($role_list['count']);
		$this->data['role_list'] = $role_list['info'];
        $this->layout->view('system/role_list',$this->data);
	}

	public function role_add(){
		$ctl_list = $this->Role_model->get_ctl_list();
		$this->data['user_data'] = $this->session->userdata;
		$this->data['ctl_list'] = $ctl_list;
		$this->layout->view('system/role_add',$this->data);
	}

	public function do_role_add(){
		$data = $this->security->xss_clean($_POST);
		if($data['role_name']){
			$permission = serialize($data['ctl']);
			$sql = array("role_name"=>trim($data['role_name']),"position2"=>trim($data['position2']),"role_memo"=>$data['role_memo'],'permission'=>$permission);
			$result = $this->Role_model->add_role($sql);
		}
		$redirect_url = 'ctl=system&act=role_list';
        redirect($redirect_url);
	}

	public function check_role_name(){
		$data = $this->security->xss_clean($_POST);
		$where = array("role_name"=>trim($data['role_name']));
		$role = $this->Role_model->get_role_info($where);
         if($role){
            echo True;
         }else{
            echo False;
         }		
	}

	public function role_delete(){
		$data = $this->security->xss_clean($_GET);
		$where = array("id"=>$data['role_id']);
		$role = $this->Role_model->delete_role($where);
		$redirect_url = 'ctl=system&act=role_list';
        redirect($redirect_url);
	}

	public function role_edit(){
		$data = $this->security->xss_clean($_GET);
		$role_id = $_GET['role_id'];
		$where = array("id"=>trim($role_id));
		$role = $this->Role_model->edit_role($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['role'] = $role;
		$this->load->view('system/role_edit',$this->data);
	}

    public function do_role_edit(){
		$data = $this->security->xss_clean($_POST);
		$role_id = $data['role_id'];
		$permission = serialize($data['ctl']);
		$where = array("id"=>$role_id);
		$data = array("role_name"=>trim($data['role_name']),"position2"=>trim($data['position2']),"role_memo"=>$data['role_memo'],'permission'=>$permission);
		$result = $this->Role_model->update_role($where,$data);
		$redirect_url = 'ctl=system&act=role_list';
        redirect($redirect_url); 	
    }
/**

	public function city_list()
	{		
		$where = array();
		$city_list = $this->Role_model->get_city_list($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['city_list'] = $city_list;
        $this->layout->view('system/city_list',$this->data);
	}

	public function city_add(){
		$this->data['user_data'] = $this->session->userdata;
		//$this->layout->view('system/city_add',$this->data);
		$this->load->view('system/city_add',$this->data);
	}

	public function check_city_name(){
		$data = $this->security->xss_clean($_POST);
		$where = array("name"=>trim($data['name']));
		$role = $this->Role_model->get_city_info($where);
        if($role){
            echo True;
        }else{
            echo False;
        }		
	}

	public function do_city_add(){
		$data = $this->security->xss_clean($_POST);
		if($data['name']){
			$sql = array("name"=>trim($data['name']));
			$result = $this->Role_model->add_city($sql);
		}
		$redirect_url = 'ctl=system&act=city_list';
        redirect($redirect_url);		
	}

	public function city_delete(){
		$data = $this->security->xss_clean($_GET);
		$where = array("id"=>$data['id']);
		$role = $this->Role_model->delete_city($where);
		$redirect_url = 'ctl=system&act=city_list';
        redirect($redirect_url);		
	}

	public function city_edit(){
		$data = $this->security->xss_clean($_GET);
		$id = $_GET['id'];
		$where = array("id"=>trim($id));
		$role = $this->Role_model->get_city_info($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['role'] = $role;
		$this->load->view('system/city_edit',$this->data);
	}

    public function do_city_edit(){
		$data = $this->security->xss_clean($_POST);
		$id = $data['id'];
		$where = array("id"=>$id);
		$data = array("name"=>trim($data['name']));
		$result = $this->Role_model->update_city($where,$data);
		$redirect_url = 'ctl=system&act=city_list';
        redirect($redirect_url); 	
    }


	public function custom_list()
	{		
		$where = array();
		$custom_list = $this->Role_model->get_custom_list($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['list'] = $custom_list;
        $this->layout->view('system/custom_list',$this->data);
	}

	public function custom_add(){
		$this->data['user_data'] = $this->session->userdata;
		//$this->layout->view('system/city_add',$this->data);
		$this->load->view('system/custom_add',$this->data);
	}

	public function check_custom_name(){
		$data = $this->security->xss_clean($_POST);
		$where = array("name"=>trim($data['name']));
		$role = $this->Role_model->get_custom_info($where);
        if($role){
            echo True;
        }else{
            echo False;
        }		
	}

	public function do_custom_add(){
		$data = $this->security->xss_clean($_POST);
		if($data['name']){
			$sql = array("name"=>trim($data['name']));
			$result = $this->Role_model->add_custom($sql);
		}
		$redirect_url = 'ctl=system&act=custom_list';
        redirect($redirect_url);		
	}

	public function custom_delete(){
		$data = $this->security->xss_clean($_GET);
		$where = array("id"=>$data['id']);
		$role = $this->Role_model->delete_custom($where);
		$redirect_url = 'ctl=system&act=custom_list';
        redirect($redirect_url);		
	}

	public function custom_edit(){
		$data = $this->security->xss_clean($_GET);
		$id = $_GET['id'];
		$where = array("id"=>trim($id));
		$role = $this->Role_model->get_custom_info($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['role'] = $role;
		$this->load->view('system/custom_edit',$this->data);
	}

    public function do_custom_edit(){
		$data = $this->security->xss_clean($_POST);
		$id = $data['id'];
		$where = array("id"=>$id);
		$data = array("name"=>trim($data['name']));
		$result = $this->Role_model->update_custom($where,$data);
		$redirect_url = 'ctl=system&act=custom_list';
        redirect($redirect_url); 	
    }
**/


/**
    public function department_list()
	{		
		$where = array();
		$department_list = $this->Role_model->get_department_list($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['list'] = $department_list;
        $this->layout->view('system/department_list',$this->data);
	}

	public function department_add(){
		$this->data['user_data'] = $this->session->userdata;
		//$this->layout->view('system/city_add',$this->data);
		$this->load->view('system/department_add',$this->data);
	}

	public function check_department_name(){
		$data = $this->security->xss_clean($_POST);
		$where = array("name"=>trim($data['name']));
		$role = $this->Role_model->get_department_info($where);
        if($role){
            echo True;
        }else{
            echo False;
        }		
	}

	public function do_department_add(){
		$data = $this->security->xss_clean($_POST);
		if($data['name']){
			$sql = array("name"=>trim($data['name']));
			$result = $this->Role_model->add_department($sql);
		}
		$redirect_url = 'ctl=system&act=department_list';
        redirect($redirect_url);		
	}

	public function department_delete(){
		$data = $this->security->xss_clean($_GET);
		$where = array("id"=>$data['id']);
		$role = $this->Role_model->delete_department($where);
		$redirect_url = 'ctl=system&act=department_list';
        redirect($redirect_url);		
	}

	public function department_edit(){
		$data = $this->security->xss_clean($_GET);
		$id = $_GET['id'];
		$where = array("id"=>trim($id));
		$role = $this->Role_model->get_department_info($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['role'] = $role;
		$this->load->view('system/department_edit',$this->data);
	}

    public function do_department_edit(){
		$data = $this->security->xss_clean($_POST);
		$id = $data['id'];
		$where = array("id"=>$id);
		$data = array("name"=>trim($data['name']));
		$result = $this->Role_model->update_department($where,$data);
		$redirect_url = 'ctl=system&act=department_list';
        redirect($redirect_url); 	
    }

**/


/** 事件**/

    public function event_list()
	{
		$this->data['user_data'] = $this->session->userdata;		
        $data = $this->security->xss_clean($_GET);        
        $where = array();
        if(isset($data['department'])&&!empty($data['department'])){
            $this->data['department'] = $data['department'];
        }else{
            $this->data['department'] = 'all';
        }
        if(isset($data['department'])&&($data['department'] !="all")){
            $where = array("department_id"=>$data['department']);
            $where['where_or'] = array('key'=>'department_id','value'=>'all');
        }        
		$event_list = $this->Role_model->get_event_list($where,$this->per_page);
		$this->pages_conf($event_list['count']);
		$this->data['list'] = $event_list['info'];
		$department_list = $this->Role_model->get_setting_list(array("type"=>"department"));
        $this->data['department_list'] = $department_list['info'];		
        $this->layout->view('system/event_list',$this->data);
	}

	public function event_add(){
		$department_list = $this->Role_model->get_setting_list(array("type"=>"department"));		
		$this->data['department_list'] = $department_list['info'];
		$this->load->view('system/event_add',$this->data);
	}

	public function check_event_name(){
		$data = $this->security->xss_clean($_POST);
		$where = array("name"=>trim($data['name']));
		$role = $this->Role_model->get_event_info($where);
        if($role){
            echo True;
        }else{
            echo False;
        }		
	}

	public function do_event_add(){
		$data = $this->security->xss_clean($_POST);
		if($data['name']){
			$sql = array("name"=>trim($data['name']),"department_id"=>$data['department_id']);
			$result = $this->Role_model->add_event($sql);
		}
		$redirect_url = 'ctl=system&act=event_list';
        redirect($redirect_url);		
	}

	public function event_delete(){
		$data = $this->security->xss_clean($_GET);
		$where = array("id"=>$data['id']);
		$role = $this->Role_model->delete_event($where);
		$redirect_url = 'ctl=system&act=event_list';
        redirect($redirect_url);		
	}

	public function event_edit(){
		$data = $this->security->xss_clean($_GET);
		$id = $_GET['id'];
		$where = array("id"=>trim($id));
		$role = $this->Role_model->get_event_info($where);
		$department_list = $this->Role_model->get_setting_list(array("type"=>"department"));		
		$this->data['department_list'] = $department_list['info'];
		$this->data['user_data'] = $this->session->userdata;
		$this->data['role'] = $role;
		$this->load->view('system/event_edit',$this->data);
	}

    public function do_event_edit(){
		$data = $this->security->xss_clean($_POST);
		$id = $data['id'];
		$where = array("id"=>$id);
		$sql = array("name"=>trim($data['name']),"department_id"=>$data['department_id']);
		$result = $this->Role_model->update_event($where,$sql);
		$redirect_url = 'ctl=system&act=event_list';
        redirect($redirect_url); 	
    }




/** 系统信息配置**/

    public function setting_list()
	{
		$data = $this->security->xss_clean($_GET);
		$this->data['user_data'] = $this->session->userdata;
		$where = array();
		if(isset($data['type'])&&!empty($data['type'])){
			$this->data['type'] = $data['type'];
		}		
		if(isset($data['type'])&&($data['type'] !="all")){
			$where = array("type"=>$data['type']);
		}
		if(isset($data['is_search'])){
			$where['where_like']['value'] = $data['search'];
			$where['where_like']['key'] = 'name';
		}
		$setting_list = $this->Role_model->get_setting_list($where,$this->per_page);
		$this->pages_conf($setting_list['count']);
		$this->data['list'] = $setting_list['info'];
        $this->layout->view('system/setting_list',$this->data);
	}

	public function setting_add(){
		$this->data['user_data'] = $this->session->userdata;
		//$this->layout->view('system/city_add',$this->data);
		$this->load->view('system/setting_add',$this->data);
	}

	public function check_setting_name(){
		$data = $this->security->xss_clean($_POST);
		$where = array("name"=>trim($data['name']),"type"=>trim($data['type']));
		$role = $this->Role_model->get_setting_info($where);
        if($role){
            echo True;
        }else{
            echo False;
        }		
	}

	public function do_setting_add(){
		$data = $this->security->xss_clean($_POST);
		if($data['name']){
			$sql = array("name"=>trim($data['name']),"type"=>trim($data['type']));
			$result = $this->Role_model->add_setting($sql);
		}
		$redirect_url = 'ctl=system&act=setting_list';
        redirect($redirect_url);		
	}

	public function setting_delete(){
		$data = $this->security->xss_clean($_GET);
		$where = array("id"=>$data['id']);
		$role = $this->Role_model->delete_setting($where);
		$redirect_url = 'ctl=system&act=setting_list';
        redirect($redirect_url);		
	}

	public function setting_edit(){
		$data = $this->security->xss_clean($_GET);
		$id = $_GET['id'];
		$where = array("id"=>trim($id));
		$role = $this->Role_model->get_setting_info($where);
		$this->data['user_data'] = $this->session->userdata;
		$this->data['role'] = $role;
		$this->load->view('system/setting_edit',$this->data);
	}

    public function do_setting_edit(){
		$data = $this->security->xss_clean($_POST);
		$id = $data['id'];
		$where = array("id"=>$id);
		$data = array("name"=>trim($data['name']),"type"=>trim($data['type']));
		$result = $this->Role_model->update_setting($where,$data);
		$redirect_url = 'ctl=system&act=setting_list';
        redirect($redirect_url); 	
    }

    public function time_list(){
		$this->data['user_data'] = $this->session->userdata;		
		$where = array();
		$list = $this->Role_model->get_time_list($where,$this->per_page);
		$this->pages_conf($list['count']);
		$this->data['list'] = $list['info'];
        $this->layout->view('system/time_list',$this->data);
    }

	public function time_add(){
		$this->data['user_data'] = $this->session->userdata;
		$this->load->view('system/time_add',$this->data);
	}

	public function do_time_add(){
		$data = $this->security->xss_clean($_POST);
		if($data['name']){
			$sql = array("name"=>trim($data['name']),"type"=>trim($data['type']),"value"=>trim($data['value']));
			$result = $this->Role_model->add_time($sql);
		}
		$redirect_url = 'ctl=system&act=time_list';
        redirect($redirect_url);		
	}

	public function time_delete(){
		$data = $this->security->xss_clean($_GET);
		$where = array("id"=>$data['id']);
		$role = $this->Role_model->delete_time($where);
		$redirect_url = 'ctl=system&act=time_list';
        redirect($redirect_url);		
	}

	public function time_edit(){
		$this->data['user_data'] = $this->session->userdata;		
		$data = $this->security->xss_clean($_GET);
		$id = $_GET['id'];
		$where = array("id"=>trim($id));
		$info = $this->Role_model->get_time_info($where);
		$this->data['info'] = $info;
		$this->load->view('system/time_edit',$this->data);
	}

    public function do_time_edit(){
		$data = $this->security->xss_clean($_POST);
		$id = $data['id'];
		$where = array("id"=>$id);
		$data = array("name"=>trim($data['name']),"type"=>trim($data['type']),"value"=>trim($data['value']));
		$result = $this->Role_model->update_time($where,$data);
		$redirect_url = 'ctl=system&act=time_list';
        redirect($redirect_url); 	
    }

    public function doc_list(){
		$this->data['user_data'] = $this->session->userdata;	
		$data = $this->security->xss_clean($_GET);
		if(isset($data['status'])){
			$this->data['status'] = $data['status'];
		}
		$where = array();
		if(isset($data['department']) && $data['department'] != 'all'){
			$where['department'] = $data['department'];
			$this->data['department'] = $data['department'];
		}
        if($this->data['user_data']['position2'] == '1' || $this->data['user_data']['position2'] == '2'){
            $where = array("department"=>$this->data['user_data']['department']);          
        }		
		$list = $this->Role_model->get_doc_list($where,$this->per_page);
		$this->pages_conf($list['count']);
        if($this->data['user_data']['position2'] == '1' || $this->data['user_data']['position2'] == '2'){
            $where2 = array("id"=>$this->data['user_data']['department']);          
        }else{
        	$where2 = array("type"=>"department");
        }
		$department_list = $this->Role_model->get_setting_list($where2);		
		$this->data['department_list'] = $department_list['info'];
		$list = $list['info'];
		foreach ($list as $key => $value) {
			$department = $this->Role_model->get_setting_info(array('id'=>$value['department']));
			$value['department_name'] = @$department['name'];
			$list[$key] = $value;
		}
		$this->data['list'] = $list;
        $this->layout->view('system/doc_list',$this->data);    	
    }

    public function delete_doc(){
		$data = $this->security->xss_clean($_GET);
		$where = array("id"=>$data['setting_id']);
		$role = $this->Role_model->delete_doc($where);
		$redirect_url = 'ctl=system&act=doc_list&status=删除成功';
        redirect($redirect_url);		
	}

	public function edit_doc(){
        $this->data['user_data'] = $this->session->userdata;        
        $data = $this->security->xss_clean($_GET);
        $id = $data['id'];
        $where = array("id"=>trim($id));
        $doc_info = $this->Role_model->get_doc_info($where);
        $this->data['doc_info'] = $doc_info;
		$department_list = $this->Role_model->get_setting_list(array("type"=>"department"));		
		$this->data['department_list'] = $department_list['info'];        
        $this->load->view('system/edit_doc',$this->data);
	}

	public function do_edit_doc(){
        $data = $this->security->xss_clean($_POST);
        $params = $data;
        $where = array("id"=>$params['id']);
        unset($params['id']);
        $res = $this->Role_model->update_doc($where,$params);
        $redirect_url = 'ctl=system&act=doc_list&status=修改成功';
        redirect($redirect_url);		
	}

	public function doc_add(){
		$data = $this->security->xss_clean($_POST);
		$tp = array("application/msword");
        $path = "./upload/doc";
        $name = $data['name'];
        $department = $data['department'];
        $type = end(explode(".",$_FILES['file']['name']));
        //$filename = iconv("UTF-8", "GBK", ($_FILES['file']['name']));
        $filename = $this->session->userdata['id']."_".time().".".$type;
        $file = $path."/".$filename;
        $result = move_uploaded_file($_FILES["file"]["tmp_name"],$file);
		if($result){
			$sql = array("name"=>trim($name),"path"=>$file,"type"=>$type,"department"=>$department);
			$result = $this->Role_model->add_doc($sql);
		}
		$redirect_url = 'ctl=system&act=doc_list';
        redirect($redirect_url);		
	}

	public function expire_date(){
		$this->data['user_data'] = $this->session->userdata;
		$where = array();
		$tmp = $this->Role_model->get_expire_date();
		if(!$tmp){
			$expire_date = 0;
		}else{
			$expire_date = $tmp['name'];
		}
		$this->data['expire_date'] = $expire_date;
        $this->layout->view('system/expire_date',$this->data);
	}

	public function edit_expire_date(){
		$data = $this->security->xss_clean($_POST);
		$expire_date = $this->Role_model->get_expire_date();
		if($expire_date){
			$where = array("type"=>"expire_date");
			$params = array('name'=>$data['expire_date']);
			$this->Role_model->update_expire_date($where,$params);
		}else{
			$params = array("type"=>"expire_date",'name'=>$data['expire_date']);
			$this->Role_model->add_expire_date($params);
		}
		echo "succ";
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */