<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header("Content-Type:text/html;charset=utf-8");
class Member extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
        $this->load->model('Member_model');
        $this->load->model('Role_model');
        $this->load->model('Event_model');
        
    }
	
	public function index()
	{
		$this->load->view('welcome_message');
	}

    public function add(){
        $city_list = $this->Role_model->get_setting_list(array("type"=>"city"));      
        $this->data['city_list'] = $city_list['info'];
        $member_type = $this->Role_model->get_setting_list(array("type"=>"membertype"));      
        $this->data['member_type'] = $member_type['info'];  
        $this->data['user_data'] = $this->session->userdata;
        $last_member = $this->Member_model->get_last_member();
        if($last_member){
            $last_num = intval($last_member['code']);
            $code = $last_num+1;
            $len = strlen(intval($code));
            if($len<3){
                for($i=0;$i<(3-$len);$i++){
                    $code = "0".$code;
                }
            }
        }else{
            $code = '001';
        }
        $this->data['code'] = $code;
        $this->layout->view('member/add',$this->data);
    }

    public function do_add(){
        $data = $this->security->xss_clean($_POST);
        $params = $data;
        $res = $this->Member_model->save_member_info($params);            
        $redirect_url = 'ctl=member&act=manage';
        redirect($redirect_url);
    }

    public function check_code(){
         $data = $this->security->xss_clean($_POST);
         $where['code'] = $data['code'];
         $user = $this->Member_model->get_member_info($where);
         if($user){
            echo True;
         }else{
            echo False;
         }
    }

    public function manage(){
        $data = $this->security->xss_clean($_GET);        
        $where = array();
        if(isset($data['member_type'])&&!empty($data['member_type'])){
            $this->data['member_type'] = $data['member_type'];
        }else{
            $this->data['member_type'] = 'all';
        }
        if(isset($data['city'])&&!empty($data['city'])){
            $this->data['city'] = $data['city'];
        }else{
            $this->data['city'] = 'all';
        }
        if(isset($data['member_type'])&&($data['member_type'] !="all")){
            $where = array("member_type"=>$data['member_type']);
        }
        if(isset($data['city'])&&($data['city'] !="all")){
            $where = array("city"=>$data['city']);
        }        
        if(isset($data['is_search'])){
            $where['where_like']['value'] = $data['search'];
            $where['where_like']['key'] = 'short_name';
            $this->data['search'] = $data['search'];
        }
        $member_type_list = $this->Role_model->get_setting_list(array("type"=>"membertype"));
        $this->data['member_type_list'] = $member_type_list['info'];
        $city_list = $this->Role_model->get_setting_list(array("type"=>"city"));
        $this->data['city_list'] = $city_list['info'];
        $member = $this->Member_model->get_member_list($where,$this->per_page);
        $this->pages_conf($member['count']);
        $this->data['member_list'] = $member['info'];
        if(!$this->data['member_list']){
            $this->data['result'] = 'false';
        }
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('member/manage',$this->data);
    }

    public function do_delete(){
        $data = $this->security->xss_clean($_GET);
        $where = array("id"=>$data['id']);
        $role = $this->Member_model->delete_member($where);
        $redirect_url = 'ctl=member&act=manage';
        redirect($redirect_url);        
    }

    public function edit(){
        $data = $this->security->xss_clean($_GET);
        $id = $data['id'];
        $where = array("id"=>trim($id));
        $member = $this->Member_model->get_member_info($where);
        $this->data['user_data'] = $this->session->userdata;
        $this->data['member'] = $member;
        $city_list = $this->Role_model->get_setting_list(array("type"=>"city"));      
        $this->data['city_list'] = $city_list['info'];
        $member_type = $this->Role_model->get_setting_list(array("type"=>"membertype"));      
        $this->data['member_type'] = $member_type['info'];
        $this->load->view('member/edit',$this->data);
    }

    public function do_member_edit(){
        $data = $this->security->xss_clean($_POST);
        $id = $data['id'];
        $where = array("id"=>$id);
        unset($data['id']);
        $result = $this->Member_model->edit_member_info($where,$data);
        $redirect_url = 'ctl=member&act=manage';
        redirect($redirect_url);    
    }

    public function search(){
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('member/search',$this->data);        
    }

    public function do_search(){
        $data = $this->security->xss_clean($_POST);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            unset($data['is_event']);
        }
        $where = array();        
        foreach($data as $k =>$v){
            if(empty($data[$k])){
                unset($data[$k]);
            }else{
              $where[$k] = trim($v);  
            }
        }
        if(isset($where['city'])){
            $city = $this->Role_model->get_setting_like(array('type'=>'city'),array('key'=>'name','value'=>$where['city']));
            $where['city'] = @$city['id'];
        }
        if(isset($where['member_type'])){
            $member_type = $this->Role_model->get_setting_like(array('type'=>'membertype'),array('key'=>'name','value'=>$where['member_type']));
            $where['member_type'] = @$member_type['id'];
        }        
        $member = $this->Member_model->get_member_info_like($where);
        $this->data['member'] = $member;
        $event_time = date("Y-m-d",time()-7*24*3600);
        $ww = array("member_id ="=>$member['id'], 'event_time >=' => $event_time);
        $event_list = $this->Event_model->get_member_event_list($ww);
        $this->data['event_list'] = $event_list;
        $this->load->view('member/do_search',$this->data);
    }

    public function do_look(){
        $this->data['user_data'] = $this->session->userdata;
        $data = $this->security->xss_clean($_GET);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            unset($data['is_event']);
        }
        $where = array('id'=>$data['id']);    
        $member = $this->Member_model->get_member_info_like($where);
        $this->data['member'] = $member;
        //$event_time = date("Y-m-d",time()-7*24*3600);
        //$ww = array("member_id ="=>$member['id'], 'event_time >=' => $event_time);
        $ww = array("member_id ="=>$member['id']);
        $event_list = $this->Event_model->get_member_event_list($ww,7);
        $this->data['event_list'] = $event_list;
        $this->layout->view('member/do_look',$this->data);
    }    
}

?>