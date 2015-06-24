<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header("Content-Type:text/html;charset=utf-8");
class Event extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
        $this->load->model('Member_model');
        $this->load->model('Role_model');
        $this->load->model('Event_model');
        $this->load->model('User_model');

    }

    public function index(){
        $where = array();
        $member = $this->Member_model->get_member_list($where,$this->per_page);
        $this->pages_conf($member['count']);
        $this->data['member_list'] = $member['info'];
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('event/index',$this->data);
    }

    public function add_event(){
        $data = $this->security->xss_clean($_POST);
        $where = array("id"=>trim($data['id']));
        $member = $this->Member_model->get_member_info($where);
        $this->data['user_data'] = $this->session->userdata;
        $this->data['member'] = $member;
        $department_list = $this->Role_model->get_setting_list(array("type"=>"department"));
        $this->data['department_list'] = $department_list['info'];
        $worktime_list = $this->Role_model->get_setting_list(array("type"=>"worktime"));
        $this->data['worktime_list'] = $worktime_list['info'];
        $event_list = $this->Role_model->get_event_list(array("display"=>"1"));
        $this->data['event_list'] = $event_list['info'];
        $this->load->view('event/add_event',$this->data);
    }

    public function get_info_by_department(){
        $data = $this->security->xss_clean($_POST);
        $this->data['user_data'] = $this->session->userdata;
        $where = array('department'=>$data['department_id']);
        $users = $this->User_model->get_user_list($where);
        foreach($users['info'] as $key=>$value){
            if ($this->data['user_data']['position2']=='1' && $this->data['user_data']['id'] !=$value['id']){
                unset($users['info'][$key]);
            }
        }
        $result['user'] = $users['info'];
        $sql = array('department_id'=>$data['department_id']);
        $event = $this->Role_model->get_event_list($sql);
        $sql2 = array('department_id'=>'all');
        $event2 = $this->Role_model->get_event_list($sql2);
        $result['event'] = array_merge($event['info'],$event2['info']);
        echo json_encode($result);
    }

    public function edit_event(){
        $this->data['user_data'] = $this->session->userdata;
        $data = $this->security->xss_clean($_POST);
        $this->data['event_month'] = $data['event_month'];
        $where = array("id"=>trim($data['id']));
        $event = $this->Event_model->get_event_info($where);
        $this->data['event'] = $event;
        $member = $this->Member_model->get_member_info(array('id'=>$event['member_id']));
        $this->data['member'] = $member;
        $user = $this->User_model->get_user_info(array("id"=>$event['user_id']));
        $this->data['user'] = $user;
        $department_list = $this->Role_model->get_setting_list(array("type"=>"department"));
        $this->data['department_list'] = $department_list['info'];
        $worktime_list = $this->Role_model->get_setting_list(array("type"=>"worktime"));
        $this->data['worktime_list'] = $worktime_list['info'];
        $event_list = $this->Role_model->get_event_list(array("display"=>"1"));
        $this->data['event_list'] = $event_list['info'];
        $this->load->view('event/edit_event',$this->data);
    }

    public function do_edit_event(){
        $data = $this->security->xss_clean($_POST);
        $where = array("id"=>trim($data['id']));
        $params = $data;
        unset($params['id']);
        unset($params['event_month']);
        $event = $this->Event_model->update_event_info($params,$where);

        $redirect_url = 'ctl=event&act=event_list&is_event=1&user_id='.$data['user_id']."&department_id=".$data['department_id']."&event_month=".$data['event_month']."&status=1&res_status=修改成功";
        redirect($redirect_url);
    }

    public function do_add_event(){
        $data = $this->security->xss_clean($_POST);
        $params = $data;
        unset($params['is_all']);
        unset($params['event_time_start']);
        unset($params['event_time_end']);
        if (isset($data['is_all']) && !empty($data['is_all'])){
            $start =  strtotime($data['event_time_start']);
            $end = strtotime($data['event_time_end']);
            $num = ($end - $start)/(3600*24);
            for ($i=0; $i <= $num; $i++) {
                $event_time =  date('Y-m-d', ($start + $i*24*3600));
                if($this->is_valid_date($event_time)){
                    $params['event_time'] = $event_time;
                    $event_month = substr($params['event_time'],0,7);
                    $params['event_month'] = $event_month;
                    $res = $this->Event_model->add_event_info($params);
                }
            }
        }else{

            $event_month = substr($params['event_time'],0,7);
            $params['event_month'] = $event_month;
            $res = $this->Event_model->add_event_info($params);
        }
        $redirect_url = 'ctl=event&act=index';
        redirect($redirect_url);
    }

    public function is_valid_date($date){
        $holiday_list = $this->Event_model->get_holiday_list();
        $h_weekend_list = $this->Event_model->get_h_weekend_list();
        $weekend_list = explode('_', WEEKEND);
        if (in_array($date, $holiday_list)){
            return false;
        }elseif (in_array($date, $h_weekend_list)){
            return false;
        }elseif(in_array(date("N",strtotime($date)), $weekend_list)){
            return false;
        }else{
            return true;
        }
    }

    public function delete_event(){
        $data = $this->security->xss_clean($_GET);
        $event_id = $data['event_id'];
        $this->Event_model->delete_event(array('id'=>$event_id));
        $redirect_url = 'ctl=event&act=event_list&is_event='.$data['is_event']."&user_id=".$data['user_id']."&event_month=".$data['event_month']."&status=".$data['status']."&res_status=删除成功";
        redirect($redirect_url);
    }

    public function event_list(){
        $data = $this->security->xss_clean($_GET);
        $this->data['back_url'] = "index.php?".http_build_query($data);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            if(isset($data['res_status'])){
                $this->data['res_status'] = $data['res_status'];
                unset($data['res_status']);
            }
            unset($data['is_event']);
            unset($data['ctl']);
            unset($data['act']);
            unset($data['per_page']);
            $this->data['user_id'] = $data['user_id'];
            $this->data['event_month'] = $data['event_month'];
            $this->data['status'] = $data['status'];
            $this->data['department_id'] = $data['department_id'];
            unset($data['department_id']);
            $where = array();
            foreach($data as $k =>$v){
                if(!empty($data[$k])){
                    $where[$k] = trim($v);
                }
            }
            if($where['status'] == 'all'){
                unset($where['status']);
            }
            $event_list = $this->Event_model->get_event_list($where,$this->per_page);
            foreach ($event_list['info'] as $key => $value) {
                $cost_fee = $this->get_event_cost_fee($value);
                $value['cost_fee'] = $cost_fee;
                $event_list['info'][$key] = $value;
            }
            $this->pages_conf($event_list['count']);
            $this->data['event_list'] = $event_list['info'];
            $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));
            $this->data['user'] = $user;
        }
        $department_list = $this->Role_model->get_setting_list(array("type"=>"department"));
        $this->data['department_list'] = $department_list['info'];
        //$where = array();
        //$work_order = $this->Event_model->get_event_list($where);
        $user = $this->User_model->get_user_list();
        $this->data['user_list'] = $user['info'];
        //$this->data['work_order_list'] = $work_order;
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('event/event_list',$this->data);
    }

    public function get_event_cost_fee($event){
        $cost_fee = 0;
        $work_order_list = $this->Event_model->get_work_order_list(array('event_id'=>$event['id']));
        foreach ($work_order_list as $key => $value) {
            foreach ($value['bill_order_list'] as $k => $val) {
                $cost_fee = $cost_fee + $val['transportation_fee']+$val['hotel_fee']+$val['food_fee']+$val['other_fee'];
            }
        }
        return $cost_fee;
    }

    public function do_search(){
        $data = $this->security->xss_clean($_GET);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            unset($data['is_event']);
        }
        unset($data['ctl']);
        unset($data['act']);
        unset($data['per_page']);
        $this->data['user_id'] = $data['user_id'];
        $this->data['event_month'] = $data['event_month'];
        $this->data['status'] = $data['status'];
        $where = array();
        foreach($data as $k =>$v){
            if(!empty($data[$k])){
                $where[$k] = trim($v);
            }
        }
        $event_list = $this->Event_model->get_event_list($where);
        $this->pages_conf($event_list['count']);
        $this->data['event_list'] = $event_list['info'];
        $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));
        $this->data['user'] = $user;
        $this->load->view('event/do_search',$this->data);
    }

    public function add_work_order(){
        $this->data['user_data'] = $this->session->userdata;
        $data = $this->security->xss_clean($_GET);
        if(isset($data['back_url'])&&!empty($data['back_url'])){
            $back_url = $_GET['back_url'];
        }else{
            $back_url = site_url(array('ctl'=>'event', 'act'=>'event_list'));
        }
        if(isset($data['status'])&&!empty($data['status'])){
            $this->data['status'] = $data['status'];
        }
        $this->data['back_url'] = $back_url;
        $where = array("id"=>trim($data['event_id']));
        $event = $this->Event_model->get_event_info($where);
        $this->data['event'] = $event;
        $this->layout->view('event/add_work_order',$this->data);
    }

    public function do_add_work_order(){
        $this->data['user_data'] = $this->session->userdata;
        //$data = $this->security->xss_clean($_POST);
        $data = $_POST;
        if(isset($data['back_url'])&&!empty($data['back_url'])){
            $back_url = $data['back_url'];
            unset($data['back_url']);
        }else{
            $back_url = site_url(array('ctl'=>'event', 'act'=>'index'));
        }
        $event_id = $data['event_id'];
        $res = $this->Event_model->save_work_order_info($data);
        $this->change_event_status($event_id,2);
        $redirect_url = 'ctl=event&act=edit_work_order&event_id='.$event_id."&back_url=".urlencode($back_url)."&status=succ";
        redirect($redirect_url);
    }

    public function edit_work_order(){
        $this->data['user_data'] = $this->session->userdata;
        //$data = $this->security->xss_clean($_GET);
        $data = $_GET;
        if(isset($data['back_url'])&&!empty($data['back_url'])){
            //$back_url = urlencode($_GET['back_url']);
            $back_url = $_GET['back_url'];
        }else{
            $back_url = site_url(array('ctl'=>'event', 'act'=>'event_list'));
        }
        $this->data['back_url'] = $back_url;
        if(isset($data['work_order_id'])){
            $this->data['work_order_id'] = $data['work_order_id'];
        }
        $where = array("id"=>trim($data['event_id']));
        $event = $this->Event_model->get_event_info($where);
        $this->data['event'] = $event;
        $where = array("event_id"=>trim($data['event_id']));
        if(isset($data['work_order_id'])&&!empty($data['work_order_id'])){
            $where['id'] = $data['work_order_id'];
        }
        $work_order_list = $this->Event_model->get_work_order_list($where);
        $this->data['work_order_list'] = $work_order_list;
        if(!isset($this->data['work_order_id'])){
            $tmp_order = end($work_order_list);
            $this->data['work_order_id'] = $tmp_order['id'];
        }
        if(isset($data['status'])){
            $this->data['status'] = $data['status'];
        }
        $traffic_list = $this->Role_model->get_setting_list(array("type"=>"traffic"));
        $this->data['traffic_list'] = $traffic_list['info'];
        $this->layout->view('event/edit_work_order',$this->data);
    }

    public function look_work_order(){
        $this->data['user_data'] = $this->session->userdata;
        $data = $this->security->xss_clean($_GET);
        if(isset($data['back_url'])&&!empty($data['back_url'])){
            $back_url = $_GET['back_url'];
        }else{
            $back_url = site_url(array('ctl'=>'event', 'act'=>'event_list'));
        }
        $this->data['back_url'] = $back_url;
        if(isset($data['work_order_id'])){
            $this->data['work_order_id'] = $data['work_order_id'];
        }
        $where = array("id"=>trim($data['event_id']));
        $event = $this->Event_model->get_event_info($where);
        $this->data['event'] = $event;
        $where = array("event_id"=>trim($data['event_id']));
        if(isset($data['work_order_id'])&&!empty($data['work_order_id'])){
            $where['id'] = $data['work_order_id'];
        }
        $work_order_list = $this->Event_model->get_work_order_list($where);
        $this->data['work_order_list'] = $work_order_list;
        if(!isset($this->data['work_order_id'])){
            $tmp_order = end($work_order_list);
            $this->data['work_order_id'] = $tmp_order['id'];
        }
        if(isset($data['status'])){
            $this->data['status'] = $data['status'];
        }
        $traffic_list = $this->Role_model->get_setting_list(array("type"=>"traffic"));
        $this->data['traffic_list'] = $traffic_list['info'];
        $this->layout->view('event/look_work_order',$this->data);
    }

    public function do_edit_work_order(){
        $this->data['user_data'] = $this->session->userdata;
        //$data = $this->security->xss_clean($_POST);
        $data = $_POST;
        $back_url = $data['back_url'];
        unset($data['back_url']);
        $event_id = $data['event_id'];
        $work_order_id = $data['work_order_id'];
        unset($data['work_order_id']);
        $where = array("id"=>$work_order_id);
        $res = $this->Event_model->update_work_order_info($data,$where);
        $redirect_url = 'ctl=event&act=edit_work_order&event_id='.$event_id."&status=succ&back_url=".urlencode($back_url);
        redirect($redirect_url);
    }

    public function delete_work_order(){
        $data = $this->security->xss_clean($_GET);
        $work_order_id = $data['work_order_id'];
        $event_id = $data['event_id'];
        $where = array('id'=>$work_order_id);
        $this->Event_model->delete_work_order($where);
        $work_order = $this->Event_model->get_work_order_info(array("event_id"=>$event_id));
        if(!$work_order){
            $this->Event_model->update_check_event_info(array('status'=>'1'),array('id'=>$event_id));
        }
        $redirect_url = 'ctl=event&act=add_work_order&event_id='.$event_id."&status=succ";
        redirect($redirect_url);
    }

    public function add_biil_order(){
        $this->data['user_data'] = $this->session->userdata;
        $data = $this->security->xss_clean($_POST);
        unset($data['id']);
        $data['rel_transportation'] = $data['transportation_fee'];
        $data['rel_hotel'] = $data['hotel_fee'];
        $data['rel_food'] = $data['food_fee'];
        $data['rel_other'] = $data['other_fee'];
        if(isset($data['bill_id']) && !empty($data['bill_id'])){
            $where = array('id'=>$data['bill_id']);
            unset($data['bill_id']);
            $res = $this->Event_model->save_biil_orderr_info($data,$where);
        }else{
            unset($data['bill_id']);
            $res = $this->Event_model->insert_biil_orderr_info($data);
            $where = array('work_order_id'=>$data['work_order_id']);
        }
        $result = $this->Event_model->get_biil_orderr_info($where);
        if($result && $result['bill_no']==$data['bill_no']){
            echo json_encode(array("status"=>"succ","id"=>$result["id"]));
        }else{
            echo json_encode(array('status'=>'fail'));
        }
    }

    public function delete_biil_order(){
        $data = $this->security->xss_clean($_POST);
        $where = array('id'=>$data['bill_id']);
        $res = $this->Event_model->delete_biil_orderr_info($where);
        if ($res){
            echo 'succ';
        }else{
            echo 'fail';
        }
    }

    public function event_check(){
        $data = $this->security->xss_clean($_GET);
        if(isset($data['is_status']) && !empty($data['is_status'])){
            $this->data['is_status'] = $data['is_status'];
            unset($data['is_status']);
        }
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            unset($data['is_event']);
            unset($data['ctl']);
            unset($data['act']);
            unset($data['per_page']);
            $this->data['user_id'] = $data['user_id'];
            $this->data['event_month'] = $data['event_month'];
            $this->data['status'] = $data['status'];
            $this->data['department_id'] = $data['department_id'];
            unset($data['department_id']);
            if(empty($data['event_time'])){
                unset($data['event_time']);
            }
            if(empty($data['status'])){
                unset($data['status']);
            }
            $where = array();
            foreach($data as $k =>$v){
                if(!empty($data[$k])){
                    $where[$k] = trim($v);
                }
            }
            $event_list = $this->Event_model->get_event_list($where,$this->per_page);
            $this->pages_conf($event_list['count']);
            foreach ($event_list['info'] as $key => $value) {
                $tmp_work = $this->get_event_worktime_more($value);
                //$worktime_count = $this->get_event_worktime_count($value);
                //$value['worktime_count'] = $worktime_count;
                $value['worktime_count'] = $tmp_work['work_time']+ $tmp_work['week_more']+ $tmp_work['weekend_more']+ $tmp_work['holiday_more'];
                $event_list['info'][$key] = $value;
            }
            $this->data['event_list'] = $event_list['info'];
            $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));
            $this->data['user'] = $user;
        }

        $department_list = $this->Role_model->get_setting_list(array("type"=>"department"));
        $this->data['department_list'] = $department_list['info'];
        $user_list = $this->User_model->get_user_list();
        $this->data['user_list'] = $user_list['info'];
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('event/event_check',$this->data);
    }

    //6-23 zhushi
    /**
    public function get_event_worktime_count($event){
        $worktime_count = 0;
        $tmp_where = array("id"=>$event['worktime_id']);
        $worktime = $this->Event_model->get_work_time($tmp_where);
        $work_order_list = $this->Event_model->get_work_order_list(array('event_id'=>$event['id']));
        foreach ($work_order_list as $key => $value) {
            $astatus = True;
            $bstatus = True;

            $tmp = strtotime($value['back_time']) - strtotime($value['arrive_time']);
            
            $tmpx = explode("_",$worktime);
            $work_start = $tmpx[0];
            $work_end = $tmpx[1];
            $start_date = substr($value['arrive_time'],0,10);
            $start_time = substr($value['arrive_time'],11);
            $end_date = substr($value['back_time'],0,10);
            $end_time = substr($value['back_time'],11);
            $day = (strtotime($end_date." 00:00:00") - strtotime($start_date." 00:00:00"))/(3600*24);
            $holiday_list = $this->Event_model->get_holiday_list();
            $h_weekend_list = $this->Event_model->get_h_weekend_list();
            $weekend_list = explode('_', WEEKEND);
            if (in_array($start_date, $holiday_list) && !in_array($end_date, $holiday_list)){
                $astatus = False;
            }elseif (!in_array($start_date, $holiday_list) && in_array($end_date, $holiday_list)){
                $bstatus = False;
            }elseif (in_array($start_date, $holiday_list) && in_array($end_date, $holiday_list)){
                $astatus = False;
                $bstatus = False;
            }
            if(in_array(date("N",strtotime($end_date)), $weekend_list) && !in_array(date("N",strtotime($start_date)), $weekend_list)){
                $bstatus = False;
            }elseif(in_array(date("N",strtotime($start_date)), $weekend_list) && !in_array(date("N",strtotime($end_date)), $weekend_list)){
                $astatus = False;
            }elseif (in_array(date("N",strtotime($start_date)), $weekend_list) && in_array(date("N",strtotime($end_date)), $weekend_list)) {
                $astatus = False;
                $bstatus = False;
            }
            if (in_array($start_date, $h_weekend_list) && !in_array($end_date, $h_weekend_list)){
                $astatus = False;
            }elseif (!in_array($start_date, $h_weekend_list) && in_array($end_date, $h_weekend_list)){
                $bstatus = False;
            }elseif (in_array($start_date, $h_weekend_list) && in_array($end_date, $h_weekend_list)){
                $astatus = False;
                $bstatus = False;
            }            
            if($day>1){
                if($worktime==="08:30:00_17:00:00"){
                    $int_tmp = $int_tmp - ($day-1)*(0.5*3600);
                }
                if($worktime==="08:30:00_17:30:00"){
                    $int_tmp = $int_tmp - ($day-1)*(1*3600);
                }
                if($worktime==="09:30:00_18:00:00"){
                    $int_tmp = $int_tmp - ($day-1)*(0.5*3600);
                }
            }

            if($astatus && ($start_date ==$end_date) && ($start_time <= $work_start) && ($end_time>=$work_start) && ($end_time<=$work_end) ){
                if($worktime==="08:30:00_17:00:00" && $end_time>"12:00:00"){
                    $tmp = $tmp - (0.5*3600);
                }elseif($worktime==="08:30:00_17:00:00" && $end_time>="11:30:00"&& $end_time<="12:00:00"){
                    $tmp = $tmp - (strtotime($start_date." ".$end_time) - strtotime($start_date." 11:30:00"));
                }elseif($worktime==="08:30:00_17:30:00" && $end_time>"12:30:00"){
                    $tmp = $tmp - (1*3600);
                }elseif($worktime==="08:30:00_17:30:00" && $end_time>="11:30:00"&& $end_time<="12:30:00"){
                   $tmp = $tmp - (strtotime($start_date." ".$end_time) - strtotime($start_date." 11:30:00"));
                }elseif($worktime==="09:30:00_18:00:00" && $end_time>"13:00:00"){
                    $tmp = $tmp - (0.5*3600);
                }elseif($worktime==="09:30:00_18:00:00" && $end_time>="12:00:00"&& $end_time<="13:00:00"){
                   $tmp = $tmp - (strtotime($start_date." ".$end_time) - strtotime($start_date." 12:00:00"));
                }
            }
            if($astatus && ($start_date ==$end_date) && ($start_time <= $work_start) && ($end_time>=$work_start) && ($end_time>$work_end) ){
                if($worktime==="08:30:00_17:00:00"){
                    $tmp = $tmp - (0.5*3600);
                }
                if($worktime==="08:30:00_17:30:00"){
                    $tmp = $tmp - (1*3600);
                }
                if($worktime==="09:30:00_18:00:00"){
                    $tmp = $tmp - (0.5*3600);
                }
            }
            if($astatus && ($start_date ==$end_date) && ($start_time >$work_start) && ($start_time<$work_end) && ($end_time<=$work_end) ){
                if($worktime==="08:30:00_17:00:00" && $start_time<="11:30:00" && $end_time>"12:00:00"){
                    $tmp = $tmp - (0.5*3600);
                }elseif($worktime==="08:30:00_17:00:00" && $start_time<="11:30:00" && $end_time>"11:30:00"&& $end_time<="12:00:00"){
                    $tmp = $tmp - (strtotime($start_date." ".$end_time) - strtotime($start_date." 11:30:00"));
                }elseif($worktime==="08:30:00_17:00:00" && $start_time>"11:30:00" && $start_time<="12:00:00"&& $end_time<="12:00:00"){
                    $tmp = $tmp - (strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time));
                }elseif($worktime==="08:30:00_17:00:00" && $start_time>"11:30:00" && $start_time<="12:00:00"&& $end_time>"12:00:00"){
                    $tmp = $tmp - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
                }elseif($worktime==="08:30:00_17:30:00" && $start_time<="11:30:00" && $end_time>"12:30:00"){
                    $tmp = $tmp - (1*3600);
                }elseif($worktime==="08:30:00_17:30:00" && $start_time<="11:30:00" && $end_time>"11:30:00"&& $end_time<="12:30:00"){
                   $tmp = $tmp - (strtotime($start_date." ".$end_time) - strtotime($start_date." 11:30:00"));
                }elseif($worktime==="08:30:00_17:30:00" && $start_time>"11:30:00" && $start_time<="12:30:00"&& $end_time<="12:30:00"){
                    $tmp = $tmp - (strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time));
                }elseif($worktime==="08:30:00_17:30:00" && $start_time>"11:30:00" && $start_time<="12:30:00"&& $end_time>"12:30:00"){
                    $tmp = $tmp - (strtotime($start_date." 12:30:00") - strtotime($start_date." ".$start_time));
                }elseif($worktime==="09:30:00_18:00:00" && $start_time<="12:00:00" && $end_time>"13:00:00"){
                    $tmp = $tmp - (0.5*3600);
                }elseif($worktime==="09:30:00_18:00:00" && $start_time<="12:00:00"  && $end_time>="12:00:00"&& $end_time<="13:00:00"){
                   $tmp = $tmp - (strtotime($start_date." ".$end_time) - strtotime($start_date." 12:00:00"));
                }elseif($worktime==="09:30:00_18:00:00" && $start_time>"12:00:00" && $start_time<="13:00:00"&& $end_time<="13:00:00"){
                    $tmp = $tmp - (strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time));
                }elseif($worktime==="09:30:00_18:00:00" && $start_time>"12:00:00" && $start_time<="13:00:00"&& $end_time>"13:00:00"){
                    $tmp = $tmp - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
                }            

            }
            if($astatus && ($start_date ==$end_date) && ($start_time >$work_start) && ($start_time<$work_end) && ($end_time>$work_end) ){
                if($worktime==="08:30:00_17:00:00" && $start_time<"12:00:00" && $start_time>="11:30:00"){
                    $tmp = $tmp - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
                }elseif($worktime==="08:30:00_17:00:00" && $start_time<"11:30:00"){
                    $tmp = $tmp - (0.5*3600);
                }elseif($worktime==="08:30:00_17:30:00" && $start_time<"11:30:00"){
                    $tmp = $tmp - (1*3600);
                }elseif($worktime==="08:30:00_17:30:00" && $start_time>="11:30:00" && $start_time < "12:30:00"){
                     $tmp = $tmp - (strtotime($start_date." 12:30:00") - strtotime($start_date." ".$start_time));
                }elseif ($worktime==="09:30:00_18:00:00" && $start_time<"12:00:00") {
                    $tmp = $tmp - (0.5*3600);
                }elseif($worktime==="09:30:00_18:00:00" && $start_time>="12:00:00"&& $start_time<="13:00:00"){
                   $tmp = $tmp - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
                }            
            }

            if($astatus && ($start_date <$end_date) && ($start_time <$work_start)){
                if($worktime==="08:30:00_17:00:00"){
                    $tmp = $tmp - (0.5*3600);
                }elseif($worktime==="08:30:00_17:30:00"){
                    $tmp = $tmp - (1*3600);
                }elseif($worktime==="09:30:00_18:00:00"){
                    $tmp = $tmp - (0.5*3600);
                }
            }

            if($astatus && ($start_date <$end_date) && ($start_time >=$work_start)  && ($start_time <=$work_end)){
                if($worktime==="08:30:00_17:00:00" && $start_time<"12:00:00" && $start_time>="11:30:00"){
                    $tmp = $tmp - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
                }elseif($worktime==="08:30:00_17:00:00" && $start_time<"11:30:00"){
                    $tmp = $tmp - (0.5*3600);
                }elseif($worktime==="08:30:00_17:30:00" && $start_time<"11:30:00"){
                    $tmp = $tmp - (1*3600);
                }elseif($worktime==="08:30:00_17:30:00" && $start_time>="11:30:00" && $start_time < "12:30:00"){
                     $tmp = $tmp - (strtotime($start_date." 12:30:00") - strtotime($start_date." ".$start_time));
                }elseif ($worktime==="09:30:00_18:00:00" && $start_time<"12:00:00") {
                    $tmp = $tmp - (0.5*3600);
                }elseif($worktime==="09:30:00_18:00:00" && $start_time>="12:00:00"&& $start_time<="13:00:00"){
                   $tmp = $tmp - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
                }             

            }

            if($bstatus && ($start_date < $end_date) && ($end_time>$work_start)&& ($end_time<$work_end)){
                if($worktime==="08:30:00_17:00:00" && $start_time<="11:30:00" && $end_time>"12:00:00"){
                    $tmp = $tmp - (0.5*3600);
                }elseif($worktime==="08:30:00_17:00:00" && $start_time<="11:30:00" && $end_time>"11:30:00"&& $end_time<="12:00:00"){
                    $tmp = $tmp - (strtotime($start_date." ".$end_time) - strtotime($start_date." 11:30:00"));
                }elseif($worktime==="08:30:00_17:00:00" && $start_time>"11:30:00" && $start_time<="12:00:00"&& $end_time<="12:00:00"){
                    $tmp = $tmp - (strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time));
                }elseif($worktime==="08:30:00_17:00:00" && $start_time>"11:30:00" && $start_time<="12:00:00"&& $end_time>"12:00:00"){
                    $tmp = $tmp - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
                }elseif($worktime==="08:30:00_17:30:00" && $start_time<="11:30:00" && $end_time>"12:30:00"){
                    $tmp = $tmp - (1*3600);
                }elseif($worktime==="08:30:00_17:30:00" && $start_time<="11:30:00" && $end_time>"11:30:00"&& $end_time<="12:30:00"){
                   $tmp = $tmp - (strtotime($start_date." ".$end_time) - strtotime($start_date." 11:30:00"));
                }elseif($worktime==="08:30:00_17:30:00" && $start_time>"11:30:00" && $start_time<="12:30:00"&& $end_time<="12:30:00"){
                    $tmp = $tmp - (strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time));
                }elseif($worktime==="08:30:00_17:30:00" && $start_time>"11:30:00" && $start_time<="12:30:00"&& $end_time>"12:30:00"){
                    $tmp = $tmp - (strtotime($start_date." 12:30:00") - strtotime($start_date." ".$start_time));
                }elseif($worktime==="09:30:00_18:00:00" && $start_time<="12:00:00" && $end_time>"13:00:00"){
                    $tmp = $tmp - (0.5*3600);
                }elseif($worktime==="09:30:00_18:00:00" && $start_time<="12:00:00"  && $end_time>="12:00:00"&& $end_time<="13:00:00"){
                   $tmp = $tmp - (strtotime($start_date." ".$end_time) - strtotime($start_date." 12:00:00"));
                }elseif($worktime==="09:30:00_18:00:00" && $start_time>"12:00:00" && $start_time<="13:00:00"&& $end_time<="13:00:00"){
                    $tmp = $tmp - (strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time));
                }elseif($worktime==="09:30:00_18:00:00" && $start_time>"12:00:00" && $start_time<="13:00:00"&& $end_time>"13:00:00"){
                    $tmp = $tmp - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
                }             
            }elseif($bstatus && ($start_date < $end_date) && ($end_time>$work_end)){
                if($worktime==="08:30:00_17:00:00" && $start_time<"12:00:00" && $start_time>="11:30:00"){
                    $tmp = $tmp - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
                }elseif($worktime==="08:30:00_17:00:00" && $start_time<"11:30:00"){
                    $tmp = $tmp - (0.5*3600);
                }elseif($worktime==="08:30:00_17:30:00" && $start_time<"11:30:00"){
                    $tmp = $tmp - (1*3600);
                }elseif($worktime==="08:30:00_17:30:00" && $start_time>="11:30:00" && $start_time < "12:30:00"){
                     $tmp = $tmp - (strtotime($start_date." 12:30:00") - strtotime($start_date." ".$start_time));
                }elseif ($worktime==="09:30:00_18:00:00" && $start_time<"12:00:00") {
                    $tmp = $tmp - (0.5*3600);
                }elseif($worktime==="09:30:00_18:00:00" && $start_time>="12:00:00"&& $start_time<="13:00:00"){
                   $tmp = $tmp - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
                }            
            }


            $int_tmp =  intval($tmp/3600);
            $less = $tmp-($int_tmp*3600);
            $less_int =  intval($less/60);
            if ($less_int>45){
                $less_tmp = 1;
            }elseif($less_int<=45 && $less_int>=15){
                $less_tmp = 0.5;
            }else{
                $less_tmp = 0;
            }
            $worktime_count = $worktime_count+$int_tmp+$less_tmp;
        }
        $time = $event['event_time'];
        $x = strtotime($time);
        $work_order = $this->Event_model->get_work_order_info(array('event_id'=>$event['id']));
        if($work_order){
            $n = strtotime($work_order['date']);
        }else{
            $n = strtotime(date("Y-m-d"));
        }
        $tmp = $this->Role_model->get_expire_date();
        if(!$tmp){
            $m = 0;
        }else{
            $m = $tmp['name'];
        }
        $r = round(($x+$m*24*3600-$n)/(24*3600));
        if($r>=0){
            $date = 1;
        }else{
            $date = 1 +(0.1*$r);
        }
        if($date<=0.5){
            $date = 0.5;
        }
        $performance = $this->Role_model->get_setting_info(array("id"=>$event['performance_id']));
        if($performance && $performance['name'] || $performance['name']!=0){
            $time = $worktime_count*$performance['name']/100*$date;
        }else{
            $time = $worktime_count*$date;
        }
        $time = round($time,1);
        return $time;
    }
    **/

    public function do_check_search(){
        $data = $this->security->xss_clean($_POST);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            unset($data['is_event']);
        }
        if(empty($data['event_time'])){
            unset($data['event_time']);
        }
        if(empty($data['status'])){
            unset($data['status']);
        }
        $where = array();
        foreach($data as $k =>$v){
            $where[$k] = trim($v);
        }
        $event_list = $this->Event_model->get_event_list($where);
        $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));
        $this->data['user'] = $user;
        $this->data['event_list'] = $event_list['info'];
        $this->load->view('event/do_check_search',$this->data);
    }

    public function check_work_order(){
        $this->data['user_data'] = $this->session->userdata;
        $data = $this->security->xss_clean($_GET);
        //$back_url = site_url('ctl=event&act=event_check')."&is_event=1";
        $back_url = '&is_event=1';
        if(isset($data['user_id']) && !empty($data['user_id'])){
            $back_url.= "&user_id=".$data['user_id'];
        }
        if(isset($data['event_month']) && !empty($data['event_month'])){
            $back_url.= "&event_month=".$data['event_month'];
        }
        if(isset($data['status']) && !empty($data['status'])){
            $back_url.= "&status=".$data['status'];
        }
        if(isset($data['department_id']) && !empty($data['department_id'])){
            $back_url.= "&department_id=".$data['department_id'];
        }
        $this->data['back_url'] = $back_url;

        if(isset($data['work_order_id'])){
            $this->data['work_order_id'] = $data['work_order_id'];
        }
        $where = array("id"=>trim($data['event_id']));
        $event = $this->Event_model->get_event_info($where);
        
        $more_work = $this->get_event_worktime_more($event);
        $event['work_time'] = $more_work['work_time'];
        $event['week_more'] = $more_work['week_more'];
        $event['weekend_more'] = $more_work['weekend_more'];
        $event['holiday_more'] = $more_work['holiday_more'];
        

        //6-23 xiugai
        //$worktime_count = $this->get_event_worktime_count($event);
        //$event['worktime_count'] =  round($worktime_count,1);

        $time = $event['event_time'];
        $x = strtotime($time);
        $work_order = $this->Event_model->get_work_order_info(array('event_id'=>$event['id']));
        if($work_order){
            $n = strtotime($work_order['date']);
        }else{
            $n = strtotime(date("Y-m-d"));
        }
        $tmp = $this->Role_model->get_expire_date();
        if(!$tmp){
            $m = 0;
        }else{
            $m = $tmp['name'];
        }
        $r = round(($x+$m*24*3600-$n)/(24*3600));
        $this->data['event_less_time'] = $r;
        /**
        if($r>=0){
            $this->data['event_less_time'] = 1;
        }else{
            $this->data['event_less_time'] = 0;
        }
        **/
        //$event['event_less_time'] = $r;
        $this->data['event'] = $event;
        $check = $this->Event_model->get_check_event_info(array('id'=>$data['event_id']));
        if($check['work_performance_id'] !=0||$check['workmore_performance_id'] !=0||$check['weekend_performance_id'] !=0||$check['holiday_performance_id'] !=0){
            $this->data['check'] = $check;
        }
        $where = array("event_id"=>trim($data['event_id']));
        $work_order_list = $this->Event_model->get_work_order_list($where);
        $this->data['work_order_list'] = $work_order_list;
        $this->data['work_order_num'] = count($work_order_list);
        $performance_list = $this->Role_model->get_setting_list(array("type"=>"performance"));
        $this->data['performance_list'] = $performance_list['info'];
        $this->layout->view('event/check_work_order',$this->data);
    }

   public function get_event_worktime_more($event){
        $arrive = True;
        $back = True;
        $week_more = 0;
        $weekend_more = 0;
        $holiday_more = 0;
        $work_time = 0;
        $work_order_list = $this->Event_model->get_work_order_list(array('event_id'=>$event['id']));
        foreach ($work_order_list as $key => $value) {
            $back_date = substr($value['back_time'],0,10);
            $arrive_date = substr($value['arrive_time'],0,10);
            $day = (strtotime($back_date." 00:00:00") - strtotime($arrive_date." 00:00:00"))/(3600*24);
            $holiday_list = $this->Event_model->get_holiday_list();
            $h_weekend_list = $this->Event_model->get_h_weekend_list();
            $weekend_list = explode('_', WEEKEND);
            if (in_array($arrive_date, $holiday_list) && !in_array($back_date, $holiday_list)){
                $arrive_tmp = strtotime($arrive_date." 00:00:00") + (3600*24) -strtotime($value['arrive_time']);
                list($arrive_int_tmp,$arrive_less_tmp) = $this->get_time_format($arrive_tmp);
                $holiday_more = $holiday_more+$arrive_int_tmp+$arrive_less_tmp;
                $arrive = False;
            }elseif (!in_array($arrive_date, $holiday_list) && in_array($back_date, $holiday_list)){
                $back_tmp = strtotime($value['back_time']) - strtotime($back_date." 00:00:00");
                list($back_int_tmp,$back_less_tmp) = $this->get_time_format($back_tmp);
                $holiday_more = $holiday_more+$back_int_tmp+$back_less_tmp;
                $back = False;
            }elseif (in_array($arrive_date, $holiday_list) && in_array($back_date, $holiday_list)){
                $back_tmp = strtotime($value['back_time']) - strtotime($value['arrive_time']);
                list($back_int_tmp,$back_less_tmp) = $this->get_time_format($back_tmp);
                $holiday_more = $holiday_more+$back_int_tmp+$back_less_tmp;
                $arrive = False;
                $back = False;
            }elseif (in_array($arrive_date, $h_weekend_list) && !in_array($back_date, $h_weekend_list)){
                $arrive_tmp = strtotime($arrive_date." 00:00:00") + (3600*24) -strtotime($value['arrive_time']);
                list($arrive_int_tmp,$arrive_less_tmp) = $this->get_time_format($arrive_tmp);
                $weekend_more = $weekend_more+$arrive_int_tmp+$arrive_less_tmp;
                $arrive = False;
            }elseif (!in_array($arrive_date, $h_weekend_list) && in_array($back_date, $h_weekend_list)){
                $back_tmp = strtotime($value['back_time']) - strtotime($back_date." 00:00:00");
                list($back_int_tmp,$back_less_tmp) = $this->get_time_format($back_tmp);
                $weekend_more = $weekend_more+$back_int_tmp+$back_less_tmp;
                $back = False;
            }elseif (in_array($arrive_date, $h_weekend_list) && in_array($back_date, $h_weekend_list)){
                $back_tmp = strtotime($value['back_time']) - strtotime($value['arrive_time']);
                list($back_int_tmp,$back_less_tmp) = $this->get_time_format($back_tmp);
                $weekend_more = $weekend_more+$back_int_tmp+$back_less_tmp;
                $arrive = False;
                $back = False;
            }elseif(in_array(date("N",strtotime($back_date)), $weekend_list) && !in_array(date("N",strtotime($arrive_date)), $weekend_list)){
                $back_tmp = strtotime($value['back_time']) - strtotime($back_date." 00:00:00");
                list($back_int_tmp,$back_less_tmp) = $this->get_time_format($back_tmp);
                $weekend_more = $weekend_more+$back_int_tmp+$back_less_tmp;
                $back = False;
            }elseif(in_array(date("N",strtotime($arrive_date)), $weekend_list) && !in_array(date("N",strtotime($back_date)), $weekend_list)){
                $arrive_tmp = strtotime($arrive_date." 00:00:00") + (3600*24) -strtotime($value['arrive_time']);
                list($arrive_int_tmp,$arrive_less_tmp) = $this->get_time_format($arrive_tmp);
                $weekend_more = $weekend_more+$arrive_int_tmp+$arrive_less_tmp;
                $arrive = False;
            }elseif(in_array(date("N",strtotime($arrive_date)), $weekend_list) && in_array(date("N",strtotime($back_date)), $weekend_list)) {
                $arrive_tmp = strtotime($value['back_time']) -strtotime($value['arrive_time']);
                list($arrive_int_tmp,$arrive_less_tmp) = $this->get_time_format($arrive_tmp);
                $weekend_more = $weekend_more+$arrive_int_tmp+$arrive_less_tmp;
                $arrive = False;
                $back = False;
            }
            $tmp_where = array("id"=>$event['worktime_id']);
            $tmp_time = $this->Event_model->get_work_time($tmp_where);
            $week_more_tmp = $this->get_work_more_time($value['arrive_time'],$value['back_time'],$arrive,$back,$tmp_time,$day);
            $week_more = $week_more+$week_more_tmp;
            $work_time_tmp = $this->get_work_time($value['arrive_time'],$value['back_time'],$arrive,$back,$tmp_time,$day);
            $work_time = $work_time+$work_time_tmp;
        }
            
        $time = $event['event_time'];
        $x = strtotime($time);
        $work_order = $this->Event_model->get_work_order_info(array('event_id'=>$event['id']));
        if($work_order){
            $n = strtotime($work_order['date']);
        }else{
            $n = strtotime(date("Y-m-d"));
        }
        $tmp = $this->Role_model->get_expire_date();
        if(!$tmp){
            $m = 0;
        }else{
            $m = $tmp['name'];
        }
        $r = round(($x+$m*24*3600-$n)/(24*3600));
        if($r>=0){
            $date = 1;
        }else{
            $date = 1 +(0.1*$r);
        }
        if($date<=0.5){
            $date = 0.5;
        }
        $work_performance = $this->Role_model->get_setting_info(array("id"=>$event['work_performance_id']));
        $workmore_performance = $this->Role_model->get_setting_info(array("id"=>$event['workmore_performance_id']));
        $weekend_performance = $this->Role_model->get_setting_info(array("id"=>$event['weekend_performance_id']));
        $holiday_performance = $this->Role_model->get_setting_info(array("id"=>$event['holiday_performance_id']));
        if($work_performance['name'] || $work_performance['name']!=0){
            $work_time = $work_time*$work_performance['name']/100*$date;
            $week_more = $week_more*$workmore_performance['name']/100*$date;
            $weekend_more = $weekend_more*$weekend_performance['name']/100*$date;
            $holiday_more = $holiday_more*$holiday_performance['name']/100*$date;
        }else{
            $work_time = $work_time*$date;
            $week_more = $week_more*$date;
            $weekend_more = $weekend_more*$date;
            $holiday_more = $holiday_more*$date;
        }
        $res['work_time'] = round($work_time,1);
        $res['week_more'] = round($week_more,1);
        $res['weekend_more'] = round($weekend_more,1);
        $res['holiday_more'] = round($holiday_more,1);
        //如果是调休，加班为 工作日工时和工作日加班和的负值
        if($event['event_type_name'] == "调休"){
            $res['week_more'] = -($res['work_time']+$res['week_more']);
        }
        return $res;
    }

    public function get_work_time($start,$end,$astatus,$bstatus,$worktime,$day){
        $tmp_int = 0;
        $tmp = explode("_",$worktime);
        $work_start = $tmp[0];
        $work_end = $tmp[1];
        $start_date = substr($start,0,10);
        $start_time = substr($start,11);
        $end_date = substr($end,0,10);
        $end_time = substr($end,11);
        if($day>1){
            $tmp_int += ($day-1)*(strtotime($start_date." ".$work_end) - strtotime($start_date." ".$work_start));
            if($worktime==="08:30:00_17:00:00"){
                $tmp_int = $tmp_int - ($day-1)*(0.5*3600);
            }
            if($worktime==="08:30:00_17:30:00"){
                $tmp_int = $tmp_int - ($day-1)*(1*3600);
            }
            if($worktime==="09:30:00_18:00:00"){
                $tmp_int = $tmp_int - ($day-1)*(0.5*3600);
            }
        }
        if($astatus && ($start_date ==$end_date) && ($start_time <= $work_start) && ($end_time>=$work_start) && ($end_time<=$work_end) ){
            $tmp_int += strtotime($start_date." ".$end_time) - strtotime($start_date." ".$work_start);
            if($worktime==="08:30:00_17:00:00" && $end_time>"12:00:00"){
                $tmp_int = $tmp_int - (0.5*3600);
            }elseif($worktime==="08:30:00_17:00:00" && $end_time>="11:30:00"&& $end_time<="12:00:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." ".$end_time) - strtotime($start_date." 11:30:00"));
            }elseif($worktime==="08:30:00_17:30:00" && $end_time>"12:30:00"){
                $tmp_int = $tmp_int - (0.5*3600);
            }elseif($worktime==="08:30:00_17:30:00" && $end_time>="11:30:00"&& $end_time<="12:30:00"){
               $tmp_int = $tmp_int - (strtotime($start_date." ".$end_time) - strtotime($start_date." 11:30:00"));
            }elseif($worktime==="09:30:00_18:00:00" && $end_time>"13:00:00"){
                $tmp_int = $tmp_int - (0.5*3600);
            }elseif($worktime==="09:30:00_18:00:00" && $end_time>="12:00:00"&& $end_time<="13:00:00"){
               $tmp_int = $tmp_int - (strtotime($start_date." ".$end_time) - strtotime($start_date." 12:00:00"));
            }
        }
        if($astatus && ($start_date ==$end_date) && ($start_time <= $work_start) && ($end_time>=$work_start) && ($end_time>$work_end) ){
            $tmp_int += strtotime($start_date." ".$work_end) - strtotime($start_date." ".$work_start);
            if($worktime==="08:30:00_17:00:00"){
                $tmp_int = $tmp_int - (0.5*3600);
            }
            if($worktime==="08:30:00_17:30:00"){
                $tmp_int = $tmp_int - (1*3600);
            }
            if($worktime==="09:30:00_18:00:00"){
                $tmp_int = $tmp_int - (0.5*3600);
            }
        }
        if($astatus && ($start_date ==$end_date) && ($start_time >$work_start) && ($start_time<$work_end) && ($end_time<=$work_end) ){
            $tmp_int += strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time);
            if($worktime==="08:30:00_17:00:00" && $start_time<="11:30:00" && $end_time>"12:00:00"){
                $tmp_int = $tmp_int - (0.5*3600);
            }elseif($worktime==="08:30:00_17:00:00" && $start_time<="11:30:00" && $end_time>"11:30:00"&& $end_time<="12:00:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." ".$end_time) - strtotime($start_date." 11:30:00"));
            }elseif($worktime==="08:30:00_17:00:00" && $start_time>"11:30:00" && $start_time<="12:00:00"&& $end_time<="12:00:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time));
            }elseif($worktime==="08:30:00_17:00:00" && $start_time>"11:30:00" && $start_time<="12:00:00"&& $end_time>"12:00:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
            }elseif($worktime==="08:30:00_17:30:00" && $start_time<="11:30:00" && $end_time>"12:30:00"){
                $tmp_int = $tmp_int - (1*3600);
            }elseif($worktime==="08:30:00_17:30:00" && $start_time<="11:30:00" && $end_time>"11:30:00"&& $end_time<="12:30:00"){
               $tmp_int = $tmp_int - (strtotime($start_date." ".$end_time) - strtotime($start_date." 11:30:00"));
            }elseif($worktime==="08:30:00_17:30:00" && $start_time>"11:30:00" && $start_time<="12:30:00"&& $end_time<="12:30:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time));
            }elseif($worktime==="08:30:00_17:30:00" && $start_time>"11:30:00" && $start_time<="12:30:00"&& $end_time>"12:30:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." 12:30:00") - strtotime($start_date." ".$start_time));
            }elseif($worktime==="09:30:00_18:00:00" && $start_time<="12:00:00" && $end_time>"13:00:00"){
                $tmp_int = $tmp_int - (0.5*3600);
            }elseif($worktime==="09:30:00_18:00:00" && $start_time<="12:00:00"  && $end_time>="12:00:00"&& $end_time<="13:00:00"){
               $tmp_int = $tmp_int - (strtotime($start_date." ".$end_time) - strtotime($start_date." 12:00:00"));
            }elseif($worktime==="09:30:00_18:00:00" && $start_time>"12:00:00" && $start_time<="13:00:00"&& $end_time<="13:00:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time));
            }elseif($worktime==="09:30:00_18:00:00" && $start_time>"12:00:00" && $start_time<="13:00:00"&& $end_time>"13:00:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
            }            

        }
        if($astatus && ($start_date ==$end_date) && ($start_time >$work_start) && ($start_time<$work_end) && ($end_time>$work_end) ){
            $tmp_int += strtotime($start_date." ".$work_end) - strtotime($start_date." ".$start_time);
            if($worktime==="08:30:00_17:00:00" && $start_time<"12:00:00" && $start_time>="11:30:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
            }elseif($worktime==="08:30:00_17:00:00" && $start_time<"11:30:00"){
                $tmp_int = $tmp_int - (0.5*3600);
            }elseif($worktime==="08:30:00_17:30:00" && $start_time<"11:30:00"){
                $tmp_int = $tmp_int - (1*3600);
            }elseif($worktime==="08:30:00_17:30:00" && $start_time>="11:30:00" && $start_time < "12:30:00"){
                 $tmp_int = $tmp_int - (strtotime($start_date." 12:30:00") - strtotime($start_date." ".$start_time));
            }elseif ($worktime==="09:30:00_18:00:00" && $start_time<"12:00:00") {
                $tmp_int = $tmp_int - (0.5*3600);
            }elseif($worktime==="09:30:00_18:00:00" && $start_time>="12:00:00"&& $start_time<="13:00:00"){
               $tmp_int = $tmp_int - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
            }            
        }

        if($astatus && ($start_date <$end_date) && ($start_time <$work_start)){
            $tmp_int += strtotime($start_date." ".$work_end) - strtotime($start_date." ".$work_start);
            if($worktime==="08:30:00_17:00:00"){
                $tmp_int = $tmp_int - (0.5*3600);
            }elseif($worktime==="08:30:00_17:30:00"){
                $tmp_int = $tmp_int - (1*3600);
            }elseif($worktime==="09:30:00_18:00:00"){
                $tmp_int = $tmp_int - (0.5*3600);
            }
        }

        if($astatus && ($start_date <$end_date) && ($start_time >=$work_start)  && ($start_time <=$work_end)){
            $tmp_int += strtotime($start_date." ".$work_end) - strtotime($start_date." ".$start_time);
            if($worktime==="08:30:00_17:00:00" && $start_time<"12:00:00" && $start_time>="11:30:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
            }elseif($worktime==="08:30:00_17:00:00" && $start_time<"11:30:00"){
                $tmp_int = $tmp_int - (0.5*3600);
            }elseif($worktime==="08:30:00_17:30:00" && $start_time<"11:30:00"){
                $tmp_int = $tmp_int - (1*3600);
            }elseif($worktime==="08:30:00_17:30:00" && $start_time>="11:30:00" && $start_time < "12:30:00"){
                 $tmp_int = $tmp_int - (strtotime($start_date." 12:30:00") - strtotime($start_date." ".$start_time));
            }elseif ($worktime==="09:30:00_18:00:00" && $start_time<"12:00:00") {
                $tmp_int = $tmp_int - (0.5*3600);
            }elseif($worktime==="09:30:00_18:00:00" && $start_time>="12:00:00"&& $start_time<="13:00:00"){
               $tmp_int = $tmp_int - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
            }             

        }

        if($bstatus && ($start_date < $end_date) && ($end_time>$work_start)&& ($end_time<$work_end)){
            $tmp_int += strtotime($end_date." ".$end_time) - strtotime($end_date." ".$work_start);
            if($worktime==="08:30:00_17:00:00" && $start_time<="11:30:00" && $end_time>"12:00:00"){
                $tmp_int = $tmp_int - (0.5*3600);
            }elseif($worktime==="08:30:00_17:00:00" && $start_time<="11:30:00" && $end_time>"11:30:00"&& $end_time<="12:00:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." ".$end_time) - strtotime($start_date." 11:30:00"));
            }elseif($worktime==="08:30:00_17:00:00" && $start_time>"11:30:00" && $start_time<="12:00:00"&& $end_time<="12:00:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time));
            }elseif($worktime==="08:30:00_17:00:00" && $start_time>"11:30:00" && $start_time<="12:00:00"&& $end_time>"12:00:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
            }elseif($worktime==="08:30:00_17:30:00" && $start_time<="11:30:00" && $end_time>"12:30:00"){
                $tmp_int = $tmp_int - (1*3600);
            }elseif($worktime==="08:30:00_17:30:00" && $start_time<="11:30:00" && $end_time>"11:30:00"&& $end_time<="12:30:00"){
               $tmp_int = $tmp_int - (strtotime($start_date." ".$end_time) - strtotime($start_date." 11:30:00"));
            }elseif($worktime==="08:30:00_17:30:00" && $start_time>"11:30:00" && $start_time<="12:30:00"&& $end_time<="12:30:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time));
            }elseif($worktime==="08:30:00_17:30:00" && $start_time>"11:30:00" && $start_time<="12:30:00"&& $end_time>"12:30:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." 12:30:00") - strtotime($start_date." ".$start_time));
            }elseif($worktime==="09:30:00_18:00:00" && $start_time<="12:00:00" && $end_time>"13:00:00"){
                $tmp_int = $tmp_int - (0.5*3600);
            }elseif($worktime==="09:30:00_18:00:00" && $start_time<="12:00:00"  && $end_time>="12:00:00"&& $end_time<="13:00:00"){
               $tmp_int = $tmp_int - (strtotime($start_date." ".$end_time) - strtotime($start_date." 12:00:00"));
            }elseif($worktime==="09:30:00_18:00:00" && $start_time>"12:00:00" && $start_time<="13:00:00"&& $end_time<="13:00:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time));
            }elseif($worktime==="09:30:00_18:00:00" && $start_time>"12:00:00" && $start_time<="13:00:00"&& $end_time>"13:00:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
            }             
        }elseif($bstatus && ($start_date < $end_date) && ($end_time>$work_end)){
            $tmp_int += strtotime($end_date." ".$work_end) - strtotime($end_date." ".$work_start);
            if($worktime==="08:30:00_17:00:00" && $start_time<"12:00:00" && $start_time>="11:30:00"){
                $tmp_int = $tmp_int - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
            }elseif($worktime==="08:30:00_17:00:00" && $start_time<"11:30:00"){
                $tmp_int = $tmp_int - (0.5*3600);
            }elseif($worktime==="08:30:00_17:30:00" && $start_time<"11:30:00"){
                $tmp_int = $tmp_int - (1*3600);
            }elseif($worktime==="08:30:00_17:30:00" && $start_time>="11:30:00" && $start_time < "12:30:00"){
                 $tmp_int = $tmp_int - (strtotime($start_date." 12:30:00") - strtotime($start_date." ".$start_time));
            }elseif ($worktime==="09:30:00_18:00:00" && $start_time<"12:00:00") {
                $tmp_int = $tmp_int - (0.5*3600);
            }elseif($worktime==="09:30:00_18:00:00" && $start_time>="12:00:00"&& $start_time<="13:00:00"){
               $tmp_int = $tmp_int - (strtotime($start_date." 12:00:00") - strtotime($start_date." ".$start_time));
            }            
        }
        list($int_tmp,$less_tmp) = $this->get_time_format($tmp_int);
        return ($int_tmp+$less_tmp);

    }
    public function get_work_more_time($start,$end,$astatus,$bstatus,$worktime,$day){
        $tmp_int = 0;
        $tmp = explode("_",$worktime);
        $work_start = $tmp[0];
        $work_end = $tmp[1];
        $start_date = substr($start,0,10);
        $start_time = substr($start,11);
        $end_date = substr($end,0,10);
        $end_time = substr($end,11);
        if($day>1){
            $tmp_int += ($day-1)*(strtotime($start_date." ".$work_start) - strtotime($start_date." 00:00:00"));
            $tmp_int += ($day-1)*(3600*24 + strtotime($start_date." 00:00:00") - strtotime($start_date." ".$work_end));
        }
        if($astatus && ($start_date ==$end_date) && ($start_time <=$work_start) && ($end_time>=$work_start) && ($end_time<=$work_end) ){
            $tmp_int += strtotime($start_date." ".$work_start) - strtotime($start_date." ".$start_time);
        }
        if($astatus && ($start_date ==$end_date) && ($start_time <=$work_start) && ($end_time<$work_start)){
            $tmp_int += strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time);
        }

        if($astatus && ($start_date ==$end_date) && ($start_time <=$work_start) && ($end_time>$work_end)){
            $tmp_int += strtotime($start_date." ".$work_start) - strtotime($start_date." ".$start_time);
            $tmp_int += strtotime($start_date." ".$end_time) - strtotime($start_date." ".$work_end);
        }

        if($astatus && ($start_date ==$end_date) && ($start_time >$work_start) && ($start_time <=$work_end) && ($end_time >$work_end)){
            $tmp_int += strtotime($start_date." ".$end_time) - strtotime($start_date." ".$work_end);
        }
        if($astatus && ($start_date ==$end_date) && ($start_time >$work_end)){
            $tmp_int += strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time);
        }


        if($astatus && ($start_date <$end_date) && ($start_time <$work_start)){
            $tmp_int += strtotime($start_date." ".$work_start) - strtotime($start_date." ".$start_time);
            $tmp_int += 24*3600 + strtotime($start_date." 00:00:00") - strtotime($start_date." ".$work_end);

        }

        if($astatus && ($start_date <$end_date) && ($start_time >=$work_start)  && ($start_time <=$work_end)){
            $tmp_int += 24*3600 + strtotime($start_date." 00:00:00") - strtotime($start_date." ".$work_end);

        }
        if($astatus && ($start_date <$end_date) &&($start_time >$work_end)){
            $tmp_int += 24*3600 + strtotime($start_date." 00:00:00") - strtotime($start_date." ".$start_time);
        }

        if($bstatus && ($start_date < $end_date) && ($end_time<=$work_start)){
            $tmp_int += strtotime($end_date." ".$end_time) - strtotime($end_date." 00:00:00");
        }elseif($bstatus && ($start_date < $end_date) && ($end_time>$work_start) && ($end_time<=$work_end)){
            $tmp_int += strtotime($end_date." ".$work_start) - strtotime($end_date." 00:00:00");
        }
        if($bstatus && ($start_date < $end_date) && ($end_time>$work_end)){
            $tmp_int += strtotime($end_date." ".$work_start) - strtotime($end_date." 00:00:00");
            $tmp_int += strtotime($end_date." ".$end_time) - strtotime($end_date." ".$work_end);
        }
        list($int_tmp,$less_tmp) = $this->get_time_format($tmp_int);
        return ($int_tmp+$less_tmp);
    }


    public function get_time_format($tmp){
        $res = array();
        $int_tmp =  intval($tmp/3600);
        $less = $tmp-($int_tmp*3600);
        $less_int =  intval($less/60);
        if ($less_int>45){
            $less_tmp = 1;
        }elseif($less_int<=45 && $less_int>=15){
            $less_tmp = 0.5;
        }else{
            $less_tmp = 0;
        }
        $res[] = $int_tmp;
        $res[] = $less_tmp;
        return $res;
    }

    public function add_check_event_info(){
        $this->data['user_data'] = $this->session->userdata;
        $data = $this->security->xss_clean($_POST);
        $event_id = $data['event_id'];
        $status = $data['status'];
        $where = array("id"=>$event_id);
        unset($data['check_id']);
        unset($data['event_id']);
        unset($data['status']);
        $work_order_list = $this->Event_model->update_check_event_info($data,$where);
        $this->change_event_status($event_id,$status);
        //$redirect_url = 'ctl=event&act=check_work_order&event_id='.$event_id;
        //redirect($redirect_url);
        echo json_encode(array("status"=>"succ"));
    }

    public function delete_check_event(){
        $this->data['user_data'] = $this->session->userdata;
        $data = $this->security->xss_clean($_GET);
        if(isset($data['event_id'])&&!empty($data['event_id'])){
            $where = array('id'=>$data['event_id']);
            $this->Event_model->delete_check_event_info($where);
            //$redirect_url = 'ctl=event&act=check_work_order&event_id='.$data['event_id'];
            //$this->change_event_status($data['event_id'],2);
        }
        $redirect_url = 'ctl=event&act=event_check&is_event=1&user_id='.$data['user_id'].'&event_month='.$data['event_month'].'&status='.$data['status'].'&department_id='.$data['department_id'];
        redirect($redirect_url);
    }

    public function change_event_status($event_id,$status){
        $where = array('id'=>$event_id);
        $params = array('status'=>$status);
        $this->Event_model->update_event_info($params,$where);
    }

    public function event_search(){
        $data = $this->security->xss_clean($_GET);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            $this->data['back_url'] = "index.php?".http_build_query($data);
            unset($data['is_event']);
            unset($data['is_event']);
            unset($data['ctl']);
            unset($data['act']);
            unset($data['per_page']);
            $this->data['user_id'] = $data['user_id'];
            $this->data['event_month'] = $data['event_month'];
            $this->data['short_name'] = $data['short_name'];
            $this->data['title'] = 'member';
            $this->data['department_id'] = $data['department_id'];
            unset($data['department_id']);
            foreach($data as $key=>$value){
                if(empty($data[$key])){
                    unset($data[$key]);
                }
            }
            if(isset($data['short_name']) && !empty($data['short_name'])){
                $this->data['title'] = 'member';
                $member = $this->Member_model->get_member_info(array("short_name"=>trim($data['short_name'])));
                unset($data['short_name']);
                if($member){
                    $data['member_id'] = $member['id'];
                    $this->data['member'] = $member;
                }
            }
            if(isset($data['user_id']) && !empty($data['user_id'])){
                $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));
                if($user){
                    $this->data['user'] = $user;
                }
                $this->data['title'] = 'user';
            }
            $where = array();
            foreach($data as $k =>$v){
                $where[$k] = trim($v);
            }
            $event_list = $this->Event_model->get_event_list($where,$this->per_page);
            $this->pages_conf($event_list['count']);
            $this->data['event_list'] = $event_list['info'];
        }
        $department_list = $this->Role_model->get_setting_list(array("type"=>"department"));
        $this->data['department_list'] = $department_list['info'];
        $user_list = $this->User_model->get_user_list();
        $this->data['user_list'] = $user_list['info'];
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('event/event_search',$this->data);
    }

    public function do_event_search(){
        $data = $this->security->xss_clean($_POST);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            unset($data['is_event']);
        }
        foreach($data as $key=>$value){
            if(empty($data[$key])){
                unset($data[$key]);
            }
        }
        if(isset($data['short_name']) && !empty($data['short_name'])){
            $this->data['title'] = 'member';
            $member = $this->Member_model->get_member_info(array("short_name"=>trim($data['short_name'])));
            unset($data['short_name']);
            if($member){
                $data['member_id'] = $member['id'];
                $this->data['member'] = $member;
            }
        }
        if(isset($data['user_id']) && !empty($data['user_id'])){
            $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));
            if($user){
                $this->data['user'] = $user;
            }
            $this->data['title'] = 'user';
        }
        $where = array();
        foreach($data as $k =>$v){
            $where[$k] = trim($v);
        }
        $event_list = $this->Event_model->get_event_list($where);
        $this->data['event_list'] = $event_list['info'];
        $this->load->view('event/do_event_search',$this->data);
    }

    public function cost_check(){
        $data = $this->security->xss_clean($_GET);
        if(isset($data['is_event']) && $data['is_event']==1){
            $this->data['is_event'] = 1;
            $per_page = $data['per_page'];
            unset($data['is_event']);
            unset($data['ctl']);
            unset($data['act']);
            unset($data['per_page']);
            $this->data['user_id'] = $data['user_id'];
            $this->data['event_month'] = $data['event_month'];
            $this->data['cost_status'] = $data['cost_status'];
            $this->data['department_id'] = $data['department_id'];
            unset($data['department_id']);
            $where = $data;
            foreach($where as $key=>$value){
                if(empty($where[$key])){
                    unset($where[$key]);
                }
            }
            unset($where['is_event']);
            $month_list = array();
            $event_list = $this->Event_model->get_event_list($where);
            //$this->pages_conf($event_list['count']);
            foreach($event_list['info'] as $key => $value){
                list($total,$rel_total) = $this->get_cost_fee($value['id']);
                $value['total'] = $total;
                $value['rel_total'] = $rel_total;
                $month_list[$value['event_month']][] = $value;
            }
            $this->pages_conf(count($month_list));
            if(!$per_page){
                $per_page = 0;
            }
            $i = 1;
            foreach ($month_list as $key => $value) {
                if($i>$per_page && $i<=($per_page+ROW_SHOW_NUM)){
                    $info = array();
                    $total_fee = 0;
                    $rel_total_fee = 0;
                    foreach($value as $k => $v) {
                        $total_fee += $v['total'];
                        $rel_total_fee += $v['rel_total'];
                    }
                    $info = array(
                        'name' =>$v['name'],
                        'user_name' =>$v['user_name'],
                        'user_id' =>$v['user_id'],
                        'cost_status'=>$v['cost_status'],
                        'total_fee' =>$total_fee,
                        'rel_total_fee' => $rel_total_fee,
                        );
                    $month_list[$key] = $info;                    
                }
                $i++;
                
            }
            $this->data['month_list'] = $month_list;
        }

        $where = array();
        $department_list = $this->Role_model->get_setting_list(array("type"=>"department"));
        $this->data['department_list'] = $department_list['info'];
        $user_list = $this->User_model->get_user_list();
        $this->data['user_list'] = $user_list['info'];
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('event/cost_check',$this->data);
    }

    public function do_event_cost_search(){
        $data = $this->security->xss_clean($_POST);
        $where = $data;
        foreach($where as $key=>$value){
            if(empty($where[$key])){
                unset($where[$key]);
            }
        }
        unset($where['is_event']);
        $month_list = array();
        $event_list = $this->Event_model->get_event_list($where);
        foreach($event_list['info'] as $key => $value){
            list($total,$rel_total) = $this->get_cost_fee($value['id']);
            $value['total'] = $total;
            $value['rel_total'] = $rel_total;
            $month_list[$value['event_month']][] = $value;
        }
        foreach ($month_list as $key => $value) {
            $info = array();
            $total_fee = 0;
            $rel_total_fee = 0;
            foreach($value as $k => $v) {
                $total_fee += $v['total'];
                $rel_total_fee += $v['rel_total'];
            }
            $info = array(
                'user_name' =>$v['user_name'],
                'user_id' =>$v['user_id'],
                'cost_status'=>$v['cost_status'],
                'total_fee' =>$total_fee,
                'rel_total_fee' => $rel_total_fee,
                );
            $month_list[$key] = $info;
        }
        $this->data['month_list'] = $month_list;
        $this->load->view('event/do_event_cost_search',$this->data);
    }

    public function get_cost_fee($event_id){
        $total = 0;
        $rel_total = 0;
        $where = array('event_id' => $event_id);
        $work_order_list = $this->Event_model->get_work_order_list($where);
        foreach ($work_order_list as $key => $value) {
            foreach ($value['bill_order_list'] as $k => $val) {
                $total = $total + $val['transportation_fee']+$val['hotel_fee']+$val['food_fee']+$val['other_fee'];
                if($val['status'] == 2){
                    if($val['rel_transportation'] && $val['rel_transportation']>=0){
                        $rel_total += $val['rel_transportation'];
                    }else{
                        $rel_total += $val['transportation_fee'];
                    }
                    if($val['rel_hotel'] && $val['rel_hotel']>=0){
                        $rel_total += $val['rel_hotel'];
                    }else{
                        $rel_total += $val['hotel_fee'];
                    }
                    if($val['rel_food'] && $val['rel_food']>=0){
                        $rel_total += $val['rel_food'];
                    }else{
                        $rel_total += $val['food_fee'];
                    }
                    if($val['rel_other'] && $val['rel_other']>=0){
                        $rel_total += $val['rel_other'];
                    }else{
                        $rel_total += $val['other_fee'];
                    }
                }
            }
        }
        $result[] = $total;
        $result[] = $rel_total;
        return $result;
    }

    public function get_event_biil_list(){
        $is_verify = 'yes';
        $total = 0;
        $bill_list = array();
        $is_cost = 1;
        $data = $this->security->xss_clean($_GET);
        $where = array('event_month'=>$data['event_month'],'user_id'=>$data['user_id']);
        $event_list = $this->Event_model->get_event_simple_list($where);
        foreach ($event_list as $key => $value) {
            list($total_tmp,$biil_list_tmp) = $this->get_biil_list($value['id']);
            $total += $total_tmp;
            foreach ($biil_list_tmp as $key => $val) {
                $val['event_id'] = $value['id'];
                $bill_list[] = $val;
            }
            if($value['cost_status'] !=3){
                $is_cost = 0;
            }
        }
        $this->pages_conf(count($bill_list));
        $per_page = $data['per_page'];
        if(!$per_page){
                $per_page = 0;
            }
        $i = 1;
        $bill_list = $this->bubble_sort($bill_list);  
        $n_bill_list = array();
        foreach ($bill_list as $key => $value) {
            if($value['status'] == "1"){
                $is_verify = 'no';
            }
            if($i>$per_page && $i<=($per_page+ROW_SHOW_NUM)){
                $n_bill_list[$key] = $value;
            }
            $i++;
        }
        $user_info = $this->User_model->get_user_info(array('id'=>$data['user_id']));
        $this->data['is_cost'] = $is_cost;
        $this->data['is_verify'] = $is_verify;
        $this->data['total'] = $total;
        $this->data['bill_list'] = $n_bill_list;
        $this->data['event_month'] = $data['event_month'];
        $this->data['user_info'] = $user_info;
        $this->data['user_data'] = $this->session->userdata;
        $this->layout->view('event/get_event_biil_list',$this->data);
    }

    public function bubble_sort($array){
        for($i = 0; $i < count($array) - 1; $i++) {
            for($j = 0; $j < count($array) - 1 - $i; $j++) {    //$j为需要排序的元素个数,用总长减去$i
                if($array[$j]['arrival_time'] > $array[$j + 1]['arrival_time']) {    //按升序排序
                    $temp = $array[$j];
                    $array[$j] = $array[$j + 1];
                    $array[$j + 1] = $temp;
                }
            }
        }
        return $array;        
    }

    public function check_all_bill_order(){
        $status = '';
        $data = $this->security->xss_clean($_POST);
        $where = array('event_month'=>$data['event_month'],'user_id'=>$data['user_id']);
        $event_list = $this->Event_model->get_event_simple_list($where);
        foreach ($event_list as $key => $value) {
            $sql = array('event_id' => $value['id']);
            $sql2 = array('id' => $value['id']);
            $event_info = $this->Event_model->get_event_info($sql2);
            if ($event_info['status'] != '3'){
                $status = 'status_error';
                break;
            }
            $work_order_list = $this->Event_model->get_work_order_list($sql);
            foreach ($work_order_list as $k => $val) {
                $ww = array("work_order_id"=>$val['id']);
                $data = array("status"=>$data['status']);
                $this->Event_model->update_bill_order_status($data,$ww);
            }
            $ew = array('id'=>$value['id']);
            $ep = array('cost_status'=>'2');
            $this->Event_model->update_event_info($ep,$ew);
        }
        if($status == 'status_error'){
            echo json_encode(array('status'=>'error'));
        }else{
            echo json_encode(array('status'=>'succ'));
        }
        

    }

    public function get_biil_list($event_id){
        $total = 0;
        $bill_list = array();
        $where = array('event_id' => $event_id);
        $work_order_list = $this->Event_model->get_work_order_list($where);
        foreach ($work_order_list as $key => $value) {
            foreach ($value['bill_order_list'] as $k => $val) {
                $transportation_info = $this->Role_model->get_setting_info(array("id"=>$val['transportation']));
                $val['transportation_name'] = $transportation_info['name'];

                if($val['rel_transportation'] && $val['rel_transportation']>=0){
                    $total += $val['rel_transportation'];
                }else{
                    $total += $val['transportation_fee'];
                }
                if($val['rel_hotel'] && $val['rel_hotel']>=0){
                    $total += $val['rel_hotel'];
                }else{
                    $total += $val['hotel_fee'];
                }
                if( $val['rel_food']>=0){
                    $total += $val['rel_food'];
                }else{
                    $total += $val['food_fee'];
                }
                if($val['rel_other'] && $val['rel_other']>=0){
                    $total += $val['rel_other'];
                }else{
                    $total += $val['other_fee'];
                }
                /**
                if(floatval($val['rel_fee'])){
                    $total += $val['rel_fee'];
                }else{
                    $total = $total+$val['transportation_fee']+$val['hotel_fee']+$val['food_fee']+$val['other_fee'];
                }
                **/
                $bill_total = 0;
                if($val['rel_transportation'] && $val['rel_transportation']>=0){
                    $bill_total += $val['rel_transportation'];
                }else{
                    $bill_total += $val['transportation_fee'];
                }
                if($val['rel_hotel'] && $val['rel_hotel']>=0){
                    $bill_total += $val['rel_hotel'];
                }else{
                    $bill_total += $val['hotel_fee'];
                }
                if($val['rel_food'] && $val['rel_food']>=0){
                    $bill_total += $val['rel_food'];
                }else{
                    $bill_total += $val['food_fee'];
                }
                if($val['rel_other'] && $val['rel_other']>=0){
                    $bill_total += $val['rel_other'];
                }else{
                    $bill_total += $val['other_fee'];
                }                
                $val['bill_total'] = $bill_total;
                $bill_list[] = $val;
            }
        }
        $result[] = $total;
        $result[] = $bill_list;
        return $result;
    }

    public function change_event_cost_status(){
        $data = $this->security->xss_clean($_POST);
        $where = array('event_month'=>$data['event_month'],"user_id"=>$data['user_id']);
        $params = array('cost_status'=>$data['status']);
        $this->Event_model->update_event_info($params,$where);
        echo "succ";
    }

    public function update_bill_order_status(){
        $data = $this->security->xss_clean($_POST);
        $id = $data['id'];
        unset($data['id']);
        $where = array('id'=>$id);
        $event = $this->Event_model->get_event_info_by_bill_id($id);
        if($event['status'] == "3" || $data['status'] == 1){
            foreach ($data as $key => $value) {
                if(empty($data[$key]) && $value !== "0"){
                    unset($data[$key]);
                }
            }
            $this->Event_model->update_bill_order_status($data,$where);
            if($data['status'] == 2){
                $cost_status = 2;
                /**

                $event_list = $this->Event_model->get_event_search_list(array("id"=>$event['id']));
                foreach ($event_list as $key => $value) {
                    foreach ($value['work_order_list'] as $ke => $val) {
                        foreach ($$val['bill_order_list'] as $k => $v) {
                            if($v['status']==1){
                                $cost_status = 1;
                            }
                        }
                    }
                }
                **/

                $work_list = $this->Event_model->get_work_order_list(array("event_id"=>$event['id']));
                foreach ($work_list as $ke => $val) {
                    foreach ($$val['bill_order_list'] as $k => $v) {
                        if($v['status']==1){
                            $cost_status = 1;
                        }
                    }
                }
                $this->Event_model->update_event_info(array("cost_status"=>$cost_status),array('id'=>$event['id']));
            }
            if($data['status'] == 1){
                $this->Event_model->update_event_info(array("cost_status"=>'1'),array('id'=>$event['id']));
            }
            echo "succ";        
        }else{
            echo "error";
        }        

    }

    public function do_check_all_view(){
        $data = $this->security->xss_clean($_GET);
        $performance_list = $this->Role_model->get_setting_list(array("type"=>"performance"));
        $this->data['performance_list'] = $performance_list['info'];
        $this->data['department_id'] = $data['department_id'];
        $this->data['user_id'] = $data['user_id'];
        $this->data['event_month'] = $data['event_month'];
        $this->data['status'] = $data['status'];
        $this->data['check_status'] = $data['check_status'];
        $this->load->view('event/do_check_all_view',$this->data);
    }

    public function do_check_all(){
        $data = $this->security->xss_clean($_POST);
        //$where['department_id'] = $data['department_id'];
        $where['user_id'] = $data['user_id'];
        $where['event_month'] = $data['event_month'];
        $where['status'] = $data['status'];
        $params['status'] = $data['check_status'];
        $params['is_complain'] = $data['is_complain'];
        $params['event_status'] = $data['event_status'];
        $params['work_performance_id'] = $data['work_performance_id'];
        $params['workmore_performance_id'] = $data['workmore_performance_id'];
        $params['weekend_performance_id'] = $data['weekend_performance_id'];
        $params['holiday_performance_id'] = $data['holiday_performance_id'];
        $params['memo'] = $data['memo'];
        foreach($where as $key=>$value){
            if(!$value){
                unset($where[$key]);
            }
        }
        $res = $this->Event_model->update_event_info($params,$where);
        $redirect_url = 'ctl=event&act=event_check';
        if($res == 1){
            $redirect_url .= '&is_status=succ';
        }else{
            $redirect_url .= '&is_status=fail';
        }
        redirect($redirect_url);        
    }
}

?>
