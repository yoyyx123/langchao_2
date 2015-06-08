<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header("Content-Type:text/html;charset=utf-8");
class User extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
        $this->load->model('User_model');
         $this->load->model('Role_model');
    }
	
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function login(){
		$this->load->view('user/login');
	}

	public function do_login() {
        $data = $this->security->xss_clean($_POST);
    	$where = array('username' => $data['user_name'], 'password' => do_hash($data['password'],'md5'),'mobile' => $data['mobile'],);
    	$user = $this->User_model->get_user_info($where);
    	if(!$user){
            $redirect_url = 'ctl=user&act=login';
    	}
    	//$status = $this->User_model->check_captcha_msg($user['id'],$data['sms_captcha']);
        $status = True;//临时去掉验证码
    	if (!$status){
            $redirect_url = 'ctl=user&act=login';
    	}else{
    		$this->session->set_userdata($user);
            $ww = array("id"=>$user['id']);
            $params = array("login_time"=>date("Y-m-d h:i:s"));
            $this->User_model->edit_user_info($ww,$params);
    		$redirect_url = 'ctl=home&act=index';
    	}
        redirect($redirect_url);
	}	

	public function logout(){
        $this->session->sess_destroy();
        $redirect_url = 'ctl=user&act=login';
        redirect($redirect_url);
    }

    public function check_login(){
    	$data = $this->security->xss_clean($_POST);
    	$where = array('username' => $data['user_name'], 'password' => do_hash($data['password'],'md5'),'mobile' => $data['mobile'],);
    	$user = $this->User_model->get_user_info($where);
    	if(!$user){
    		echo 'fail';
    	}
        $sms_info = $this->User_model->get_sms_info();
        if($sms_info){
            $status = $this->User_model->check_captcha_msg($user['id'],$data['sms_captcha']);            
        }else{
            $status = True;//不需要验证码
        }
    	if ($status){
    		echo 'succ';
    	}else{
    		echo 'fail';
    	}
    }

    public function send_captcha(){
    	$data = $this->security->xss_clean($_POST);
        $sms_info = $this->User_model->get_sms_info();        
    	$u_info = $this->check_mobile($data['mobile'],$data['user_name']);

    	if (!$u_info){
    		echo "error";exit;
    	}
        if($sms_info){
            $status = $this->send_captcha_sms($u_info,$sms_info);            
        }else{
            echo "close";exit;
        }
    	if ($status){
    		echo 'succ';
    	}else{
    		echo 'fail';
    	}
    }

    public function check_mobile($mobile,$user){
    	$u_info = $this->User_model->get_user_mobile($user);
        if(isset($u_info['mobile']) && $mobile==$u_info['mobile']){
            return $u_info;
        }else{
            return False;
        }
    }

    public function send_captcha_sms($u_info,$sms_info){
        $captcha = $this->get_captcha();
        $content = "您的验证码是 ".$captcha.", 请于30分钟内输入, 请勿泄漏. 【浪潮工贸】";
        $params['userid'] = $sms_info['userid'];
        $params['account'] = $sms_info['account'];
        $params['password'] = $sms_info['passwd'];
        $params['mobile'] = $u_info['mobile'];
        $params['content'] = $content;
        $params['sendTime'] = "";
        $params['action'] = "send";
        $params['extno'] = "";
        $result = $this->request_post($sms_info['url'],$params);
        $xml = simplexml_load_string($result);
        $status = (string) $xml->returnstatus;
        if($status != 'Success'){
            return False;
        }else{
            $task_id = (string) $xml->taskID;
            $this->User_model->save_sms_captcha($u_info['id'],$captcha,$task_id);
        }
    	return 1;
    }

    public function get_captcha(){
        return rand(100000,999999);
    }

    public function info(){
        $this->data['user_data'] = $this->session->userdata;
        //$this->data['user_data']['password'] = substr($this->data['user_data']['password'],-2);
        $this->layout->view('user/info',$this->data);
    }

    public function check_passwd(){
        $data = $this->security->xss_clean($_POST);
        $password = do_hash($data['passwd'],'md5');
        $username = $this->session->userdata['username'];
        $where = array('username' => $username, 'password' => $password);
        $user = $this->User_model->get_user_info($where);
        if($user){
            echo 'succ';
        }else{
            echo 'fail';
        }
    }

    public function edit_passwd(){
        $data = $this->security->xss_clean($_POST);
        $password = do_hash($data['old_password'],"md5");
        $username = $this->session->userdata['username'];
        $where = array('username' => $username, "password" => $password);
        $new_pass = do_hash($data['new_password'],'md5');
        $params = array('password'=>$new_pass);
        $res = $this->User_model->edit_user_info($where,$params);
        if($res){
            echo 'succ';
        }else{
            echo 'fail';
        }
    }

    public function edit_user_img(){
        $tp = array("image/gif","image/pjpeg","image/jpeg");
        $path = "./upload/img/userlogo";
        if(!in_array($_FILES["img"]["type"],$tp)) { 
            //文件格式不对
            $status = 'fail';
            $msg = '文件格式不对';
        }
        if($_FILES["img"]["size"]>1024*1024){
            $status = 'fail';
            $msg = '文件格式不对';
        }
        $type = end(explode(".",$_FILES['img']['name']));
        $filename = 'user_'.$this->session->userdata['username'].".".$type;
        $file = $path."/".$filename;
        $result = move_uploaded_file($_FILES["img"]["tmp_name"],$file);
        $where = array('id' => $this->session->userdata['id']);
        $params = array("img"=>$filename);
        if ($result){
            $res = $this->User_model->edit_user_info($where,$params);
            $status = 'succ';
            $msg = '上传成功';
        }else{
            $status = 'fail';
            $msg = '上传失败';            
        }
        echo json_encode(array('status'=>$status,'msg'=>$msg));
    }

    public function add(){
        $city_list = $this->Role_model->get_setting_list(array("type"=>"city"));      
        $this->data['city_list'] = $city_list['info'];
        $department_list = $this->Role_model->get_setting_list(array("type"=>"department"));      
        $this->data['department_list'] = $department_list['info'];
        $position_list = $this->Role_model->get_setting_list(array("type"=>"position"));      
        $this->data['position_list'] = $position_list['info'];           
        $worktime_list = $this->Role_model->get_setting_list(array("type"=>"worktime"));      
        $this->data['worktime_list'] = $worktime_list['info'];        
        $role_list = $this->Role_model->get_roles(array());
        $this->data['role_list'] = $role_list['info'];
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('user/add',$this->data);
    }

    public function do_add(){
        $data = $this->security->xss_clean($_POST);
        $params = $data;
        $params['password'] = do_hash($params['password'],"md5");
        $res = $this->save_user_img($params['username']);
        if ('succ'==$res['status']){
            $params['img'] = $res['filename'];
            $res = $this->User_model->save_user_info($params);            
        }
        $redirect_url = 'ctl=user&act=manage&status=添加成功';
        redirect($redirect_url);
    }

    public function save_user_img($username){
        $tp = array("image/gif","image/pjpeg","image/jpeg");
        $path = "./upload/img/userlogo";
        if(!in_array($_FILES["img"]["type"],$tp)) { 
            //文件格式不对
            $status = 'fail';
            $msg = '文件格式不对';
        }
        if($_FILES["img"]["size"]>1024*1024){
            $status = 'fail';
            $msg = '文件格式不对';
        }
        $type = end(explode(".",$_FILES['img']['name']));
        $filename = 'user_'.$username.".".$type;
        $file = $path."/".$filename;
        $result = move_uploaded_file($_FILES["img"]["tmp_name"],$file);
        if ($result){
            $res['status'] = 'succ';
        }else{
            $res['status'] = 'fail';
        }
        $res['filename'] = $filename;
        return $res;
    }

    public function check_username(){
         $data = $this->security->xss_clean($_POST);
         $where['username'] = $data['username'];
         $user = $this->User_model->get_user_info($where);
         if($user){
            echo True;
         }else{
            echo False;
         }
    }

    public function manage(){
        $data = $this->security->xss_clean($_GET);
        $where = array();        
        if(isset($data['status'])){
            $this->data['status'] = $data['status'];
        }
        if(isset($data['department'])&&!empty($data['department'])){
            $this->data['department'] = $data['department'];
        }else{
            $this->data['department'] = 'all';
        }
        if(isset($data['department'])&&($data['department'] !="all")){
            $where = array("department"=>$data['department']);
        }                
        $users = $this->User_model->get_user_list($where,$this->per_page);
        $this->pages_conf($users['count']);        
        $this->data['user_list'] = $users['info'];
        $department_list = $this->Role_model->get_setting_list(array("type"=>"department"));
        $this->data['department_list'] = $department_list['info'];        
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('user/manage',$this->data);
    }

    public function get_user_list(){
        $data = $this->security->xss_clean($_POST);
        $this->data['user_data'] = $this->session->userdata;
        $where = array('department'=>$data['department_id']);
        $users = $this->User_model->get_user_list($where);
        foreach($users['info'] as $key=>$value){
            if ($this->data['user_data']['position2']=='1' && $this->data['user_data']['id'] !=$value['id']){
                unset($users['info'][$key]);
            }
        }
        echo json_encode($users['info']);
    }

    public function delete_user(){
        $data = $this->security->xss_clean($_GET);
        $where = array('id'=>$data['user_id']);
        $users = $this->User_model->delete_user($where);
        $redirect_url = 'ctl=user&act=manage&status=删除成功';
        redirect($redirect_url);        
    }

    public function edit(){
        $this->data['user_data'] = $this->session->userdata;        
        $data = $this->security->xss_clean($_GET);
        $id = $data['id'];
        $where = array("id"=>trim($id));
        $user = $this->User_model->get_user_info($where);
        $this->data['user'] = $user;
        $city_list = $this->Role_model->get_setting_list(array("type"=>"city"));      
        $this->data['city_list'] = $city_list['info'];
        $department_list = $this->Role_model->get_setting_list(array("type"=>"department"));      
        $this->data['department_list'] = $department_list['info'];
        $position_list = $this->Role_model->get_setting_list(array("type"=>"position"));      
        $this->data['position_list'] = $position_list['info'];        
        $worktime_list = $this->Role_model->get_setting_list(array("type"=>"worktime"));      
        $this->data['worktime_list'] = $worktime_list['info'];        
        $role_list = $this->Role_model->get_roles(array());
        $this->data['role_list'] = $role_list['info'];
        if(isset($data['is_search'])&&!empty($data['is_search'])){
            $this->layout->view('user/edit',$this->data);
        }else{
            $this->load->view('user/edit',$this->data);
        }

    }

    public function do_edit(){
        $data = $this->security->xss_clean($_POST);
        $params = $data;
        if (isset($params['password'])&&!empty($params['password'])){
            $params['password'] = do_hash($params['password'],"md5");
        }else{
            unset($params['password']);
        }
        if($_FILES['img']['size'] !=0){
            $res = $this->save_user_img($params['username']);
            if ('succ'==$res['status']){
                $params['img'] = $res['filename'];           
            }
        }
        $where = array("id"=>$params['id']);
        unset($params['id']);
        $res = $this->User_model->update_user_info($where,$params);         
        $redirect_url = 'ctl=user&act=manage&status=修改成功';
        redirect($redirect_url);
    }

    public function do_search(){
        $data = $this->security->xss_clean($_GET);
        $where = $data['where'];
        $res = $this->User_model->search_user_info($where);
        if($res){
            $redirect_url = 'ctl=user&act=edit&is_search=1&id='.$res['id'];
        }else{
            $redirect_url = 'ctl=user&act=manage';
        }
        redirect($redirect_url);
    }
}

?>