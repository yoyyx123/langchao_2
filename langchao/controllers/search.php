<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
header("Content-Type:text/html;charset=utf-8");
class Search extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
        $this->load->model('Member_model');
        $this->load->model('Role_model');
        $this->load->model('Event_model');
        $this->load->model('User_model');
    }

    public function performance_search(){
        $data = $this->security->xss_clean($_GET);
        if(isset($data['is_search']) && $data['is_search']==1){
            $this->data['is_search'] = 1;
            $this->data['user_id'] = $data['user_id'];
            $user = $this->User_model->get_user_info(array('id'=>$data['user_id']));
            if($data['user_id'] == 'all'){
                $this->data['name'] = "全部"; 
            }else{
                $this->data['name'] = $user['name'];                
            }
            $this->data['start_time'] = $data['start_time'];
            $this->data['end_time'] = $data['end_time'];
            $this->data['short_name'] = $data['short_name'];
            $this->data['department_id'] = $data['department_id'];
            $sql = "select * from ldb_event_list where `event_time` >'".$data['start_time']."' and `event_time`<'".$data['end_time']."'";
            if($data['user_id'] != 'all'){
                $sql = $sql." and `user_id` =".$data['user_id'];
            }
            if(isset($data['short_name']) && !empty($data['short_name'])){
                $member = $this->Member_model->get_member_info_like(array("short_name"=>$data['short_name']));
                if($member){
                    $sql = $sql." and `member_id` =".$member['id'];
                }   
            }
            $type_list = explode(",",$data['event_type']);
            $in_sql = " and `event_type_id` in(";
            foreach($type_list as $key=>$val){
                if($val !=""){
                    $in_sql = $in_sql.$val.",";                    
                }
            }
            $in_sql = substr($in_sql,0,-1);
            $sql = $sql.$in_sql.")";
            $res = $this->Event_model->get_event_list_sql($sql);
            $info_list = array();
            foreach ($res as $key => $value) {
                $info_list[$value['short_name']][] = $value;
            }
            $count = 0;
            $info=array();
            foreach ($info_list as $key => $value) {
                $info[$key] = count($value);
                $count += count($value);
            }
            $this->data['info_list'] = $info;
            $this->data['count'] = $count;
        }
        $department_list = $this->Role_model->get_setting_list(array("type"=>"department"));
        $this->data['department_list'] = $department_list['info'];        
        $this->data['user_data'] = $this->session->userdata;        
        $this->layout->view('search/performance_search',$this->data);
    }

    public function get_department_change_result(){
        $data = $this->security->xss_clean($_POST);
        $this->data['user_data'] = $this->session->userdata;
        $where = array('department'=>$data['department_id']);
        $users = $this->User_model->get_user_list($where);
        foreach($users['info'] as $key=>$value){
            if ($this->data['user_data']['position2']=='1' && $this->data['user_data']['id'] !=$value['id']){
                unset($users['info'][$key]);
            }
        }
        $user_list = $users['info'];
        $event_list = $this->Role_model->get_event_list(array('department_id'=>$data['department_id']));
        $event_list2 = $this->Role_model->get_event_list(array('department_id'=>'all'));
        $list = array_merge($event_list['info'],$event_list2['info']);
        $result = array('user_list'=>$user_list,'event_list'=>$list);        
        if($list){
            $result['event_list']=$list;
        }
        echo json_encode($result);
    }

    public function data_search(){
        $data = $this->security->xss_clean($_GET);
        if(isset($data['is_search']) && $data['is_search']==1){
            $this->data['is_search'] = 1;
            $this->data['user_id'] = $data['user_id'];
            $this->data['start_time'] = $data['start_time'];
            $this->data['end_time'] = $data['end_time'];
            $params['user_id'] = $data['user_id'];
            $params['start_time'] = $data['start_time'];
            $params['end_time'] = $data['end_time'];
            if(isset($data['short_name'])&&!empty($data['short_name'])){
                $this->data['short_name'] = $data['short_name'];
                $member = $this->Member_model->get_member_info(array('short_name'=>$data['short_name']));
                if($member){
                    $member_id = $member['id'];
                    $params['member_id'] = $member_id;
                }
            }
            foreach ($params as $key => $value) {
                if(empty($params[$key])){
                    unset($params[$key]);
                }
            }
            $event_list = $this->Event_model->get_event_search_list($params);
            $result = array();
            $info = array();
            if(isset($params['member_id'])&&!empty($params['user_id'])){
                foreach($event_list as $key=>$val){
                    $result[$val['user_id']][] = $val;
                }
            }elseif(isset($params['member_id'])&&empty($params['user_id'])){
                foreach($event_list as $key=>$val){
                    $result[$val['user_id']][] = $val;
                }                
            }elseif(!isset($params['member_id'])&&!empty($params['user_id'])){
                foreach($event_list as $key=>$val){
                    $result[$val['member_id']][] = $val;
                }
                
            }
            foreach ($result as $k=>$v){
                $info[$k]['count'] = count($v);
                $info[$k]['user_name'] = $v[0]['user_name'];
                $info[$k]['short_name'] = $v[0]['short_name'];
                $work_time = 0;
                $road_time = 0;
                $complain_num = 0;
                $check_num = 0;
                foreach($v as $kk=>$vv){
                    if($vv['is_complain']==1){
                     $complain_num +=1;
                    }
                    if($vv['status']==3){
                     $check_num +=1;
                    }
                    foreach($vv['work_order_list'] as $mm => $nn){
                        $work_time = $work_time+(strtotime($nn['back_time'])-strtotime($nn['arrive_time'])) ;
                        foreach($nn['bill_order_list'] as $m => $n){
                            $road_time += (strtotime($n['arrival_time'])-strtotime($n['go_time']));
                        }
                    }
                }
                $info[$k]['work_time'] = $this->trans_to_hour($work_time);
                $info[$k]['road_time'] = $this->trans_to_hour($road_time);
                $info[$k]['complain_num'] = $complain_num;
                $info[$k]['check_num'] = $check_num;
            }
            $this->pages_conf(count($info));
            $info_list = array();
            $i=0;
            foreach ($info as $key => $value) {
                if($i>=$this->per_page && $i<($this->per_page+ROW_SHOW_NUM)){
                    $info_list[$key] = $value;
                }
                $i += 1;
            }
            $this->data['info_list'] = $info_list;
        }
        $user_list = $this->User_model->get_user_list();
        $this->data['user_list'] = $user_list['info'];
        $this->data['user_data'] = $this->session->userdata;        
        $this->layout->view('search/data_search',$this->data);
    }

    public function trans_to_hour($data){
        $int_tmp =  intval($data/3600);
        $less = $data-($int_tmp*3600);
        $less_int =  intval($less/60);
        if ($less_int>45){
            $less_tmp = 1;
        }elseif($less_int<=45 && $less_int>=15){
            $less_tmp = 0.5;
        }else{
            $less_tmp = 0;
        }
        $hour = $int_tmp+$less_tmp;
        return $hour;
    }

    public function data_export(){
        $data = $this->security->xss_clean($_GET);
        if(isset($data['is_search']) && $data['is_search']==1){
            $this->data['is_search'] = 1;
            $this->data['data_type'] = $data['data_type'];
            $this->data['user_id'] = $data['user_id'];
            if($data['user_id'] !='all' && $data['department_id'] !='all'){
                $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));
                $this->data['name'] = $user['name'];
            }
            if($data['department_id'] =='all'){
                $this->data['user_id'] = 'all';
            }
            $this->data['department_id'] = $data['department_id'];
            $this->data['event_month'] = $data['event_month'];

            $where = array('event_month'=>$data['event_month']);
            if($data['user_id'] != "all" && $data['department_id'] !='all'){
                $where['where_in']['value'][] = $data['user_id'];
                $where['where_in']['key'] = 'user_id';
            }else if($data['department_id'] !='all'){
                $user_list = $this->User_model->get_user_list(array('department'=>$data['department_id']));
                foreach ($user_list['info'] as $key => $value) {
                    $where['where_in']['value'][] = $value['id'];
                }
                $where['where_in']['key'] = 'user_id';
            }
            
            $result = array();
            $event_list = $this->Event_model->get_event_list($where);
            foreach($event_list['info'] as $key=>$val){
                $result[$val['user_id']][] = $val;
            }
            if($data['data_type']=="work_time"){
                $info = $this->get_data_export_worktime($result,$data);
            }elseif($data['data_type']=="fee"){
                $info = $this->get_data_export_fee($result,$data);
            }
            $this->pages_conf(count($info));
            $info_list = array();
            $i=1;
            foreach ($info as $key => $value) {
                if($i>=$this->per_page && $i<($this->per_page+ROW_SHOW_NUM)){
                    $info_list[] = $value;
                }
                $i++;
            }            
            $this->data['info_list'] = $info_list;
        }
        $department_list = $this->Role_model->get_setting_list(array("type"=>"department"));      
        $this->data['department_list'] = $department_list['info'];
        $this->data['user_data'] = $this->session->userdata;        
        $this->layout->view('search/data_export',$this->data);
    }

    public function get_data_export_fee($result,$data){
        $info = array();
        foreach($result as $key => $value){
            $transportation_fee = 0;
            $hotel_fee = 0;
            $food_fee = 0;
            $other_fee = 0;
            foreach ($value as $k => $v) {
                list($t_fee,$h_fee,$f_fee,$o_fee) = $this->get_cost_fee($v['id']);
                $transportation_fee += $t_fee;
                $hotel_fee += $h_fee;
                $food_fee += $f_fee;
                $other_fee += $o_fee;
            }
            $info[$key]['transportation_fee'] =  $transportation_fee;
            $info[$key]['hotel_fee'] = $hotel_fee;
            $info[$key]['food_fee'] = $food_fee;
            $info[$key]['other_fee'] = $other_fee;
            $info[$key]['event_month'] = $data['event_month'];
            $info[$key]['user_name'] = $value[0]['user_name'];
            $info[$key]['name'] = $value[0]['name'];
            $info[$key]['user_id'] = $key;
        }
        return $info;
    }

    public function get_cost_fee($event_id){
        $transportation_fee = 0;
        $hotel_fee = 0;
        $food_fee = 0;
        $other_fee = 0;
        $where = array('event_id' => $event_id);
        $work_order_list = $this->Event_model->get_work_order_list($where);
        foreach ($work_order_list as $key => $value) {
            foreach ($value['bill_order_list'] as $k => $val) {
                if($val['status'] == 2){
                    $transportation_fee += $val['transportation_fee'];
                    $hotel_fee += $val['hotel_fee'];
                    $food_fee += $val['food_fee'];
                    $other_fee += $val['other_fee'];
                }
            }
        }
        $result[] = $transportation_fee;
        $result[] = $hotel_fee;
        $result[] = $food_fee;
        $result[] = $other_fee;
        return $result;
    }


    public function get_data_export_worktime($result,$data){
        $info = array();     
        foreach ($result as $key => $value) {
            $week_more = 0;
            $weekend_more = 0;
            $holiday_more = 0;
            $worktime_count = 0;
            $work_time = 0;
            foreach ($value as $k => $v) {
                $more_work = $this->get_event_worktime_more($v);
                $work_time += $more_work['work_time'];
                $week_more += $more_work['week_more'];
                $weekend_more += $more_work['weekend_more'];
                $holiday_more += $more_work['holiday_more'];
                $worktime_count += $more_work['worktime_count'];;
            }            
            $info[$key]['worktime_count'] =  $worktime_count;
            $info[$key]['work_time'] = $work_time;
            $info[$key]['week_more'] = $week_more;
            $info[$key]['weekend_more'] = $weekend_more;
            $info[$key]['holiday_more'] = $holiday_more;
            $info[$key]['event_month'] = $data['event_month'];
            $info[$key]['user_name'] = $value[0]['user_name'];
            $info[$key]['name'] = $value[0]['name'];
            $info[$key]['user_id'] = $key;
        }
        return $info;
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
            $weekend_list = explode('_', WEEKEND);
            if (in_array($arrive_date, $holiday_list)){
                $arrive_tmp = strtotime($arrive_date." 00:00:00") + (3600*24) -strtotime($value['arrive_time']);
                list($arrive_int_tmp,$arrive_less_tmp) = $this->get_time_format($arrive_tmp);
                $holiday_more = $holiday_more+$arrive_int_tmp+$arrive_less_tmp;
                $arrive = False;
            }
            if (in_array($back_date, $holiday_list)){
                $back_tmp = strtotime($value['back_time']) - strtotime($back_date." 00:00:00");
                list($abackint_tmp,$back_less_tmp) = $this->get_time_format($back_tmp);
                $holiday_more = $holiday_more+$back_int_tmp+$back_less_tmp;
                $back = False;
            }            
            if(in_array(date("N",strtotime($back_date)), $weekend_list)){
                $back_tmp = strtotime($value['back_time']) - strtotime($back_date." 00:00:00");
                list($back_int_tmp,$back_less_tmp) = $this->get_time_format($back_tmp);
                $weekend_more = $weekend_more+$back_int_tmp+$back_less_tmp;
                $back = False;
            }
            if(in_array(date("N",strtotime($arrive_date)), $weekend_list)){
                $arrive_tmp = strtotime($arrive_date." 00:00:00") + (3600*24) -strtotime($value['arrive_time']);
                list($arrive_int_tmp,$arrive_less_tmp) = $this->get_time_format($arrive_tmp);
                $weekend_more = $weekend_more+$arrive_int_tmp+$arrive_less_tmp;
                $arrive = False;
            }
            //$tmp_time = $this->Event_model->get_work_time();
            $tmp_where = array("id"=>$event['worktime_id']);
            $tmp_time = $this->Event_model->get_work_time($tmp_where);
            $week_more_tmp = $this->get_work_more_time($value['arrive_time'],$value['back_time'],$arrive,$back,$tmp_time,$day);
            $week_more = $week_more+$week_more_tmp;
            $work_time_tmp = $this->get_work_time($value['arrive_time'],$value['back_time'],$arrive,$back,$tmp_time,$day);
            $work_time = $work_time+$work_time_tmp;
        }
        $res['work_time'] = $work_time;
        $res['week_more'] = $week_more;
        $res['weekend_more'] = $weekend_more;
        $res['holiday_more'] = $holiday_more;
        $worktime_count_tmp = $work_time+$week_more+$weekend_more+$holiday_more;

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
        $worktime_count = $worktime_count_tmp*$performance['name']/100*$date;

        $res['worktime_count'] = $worktime_count;
        return $res;
    }


    public function get_work_time($start,$end,$astatus,$bstatus,$worktime){
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
        }        
        if($astatus && ($start_date ==$end_date) && ($start_time <$work_start) && ($end_time>=$work_start) && ($end_time<=$work_end) ){
            $tmp_int += strtotime($start_date." ".$end_time) - strtotime($start_date." ".$work_start);
        }
        if($astatus && ($start_date ==$end_date) && ($start_time <$work_start) && ($end_time>=$work_start) && ($end_time>$work_end) ){
            $tmp_int += strtotime($start_date." ".$work_end) - strtotime($start_date." ".$work_start);
        }
        if($astatus && ($start_date ==$end_date) && ($start_time >$work_start) && ($start_time<$work_end) && ($end_time<$work_end) ){
            $tmp_int += strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time);
        }
        if($astatus && ($start_date ==$end_date) && ($start_time >$work_start) && ($start_time<$work_end) && ($end_time>$work_end) ){
            $tmp_int += strtotime($start_date." ".$work_end) - strtotime($start_date." ".$start_time);
        }



        if($astatus && ($start_date <$end_date) && ($start_time <$work_start)){
            $tmp_int += strtotime($start_date." ".$work_end) - strtotime($start_date." ".$work_start);
        }

        if($astatus && ($start_date <$end_date) && ($start_time >=$work_start)  && ($start_time <=$work_end)){
            $tmp_int += strtotime($start_date." ".$work_end) - strtotime($start_date." ".$start_time);

        }

        if($bstatus && ($start_date < $end_date) && ($end_time>$work_start)&& ($end_time<$work_end)){
            $tmp_int += strtotime($end_date." ".$end_time) - strtotime($end_date." ".$work_start);
        }elseif($bstatus && ($start_date < $end_date) && ($end_time>$work_end)){
            $tmp_int += strtotime($end_date." ".$work_end) - strtotime($end_date." ".$work_start);
        }
        list($int_tmp,$less_tmp) = $this->get_time_format($tmp_int);  
        return ($int_tmp+$less_tmp);        

    }

    public function get_work_more_time($start,$end,$astatus,$bstatus,$worktime){
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
        if($astatus && ($start_date ==$end_date) && ($start_time <$work_start) && ($end_time>=$work_start) && ($end_time<=$work_end) ){
            $tmp_int += strtotime($start_date." ".$work_start) - strtotime($start_date." ".$start_time);
        }
        if($astatus && ($start_date ==$end_date) && ($start_time <$work_start) && ($end_time<$work_start)){
            $tmp_int += strtotime($start_date." ".$end_time) - strtotime($start_date." ".$start_time);
        }

        if($astatus && ($start_date ==$end_date) && ($start_time <$work_start) && ($end_time>$work_end)){
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

    public function get_event_worktime_count($event){
        $worktime_count = 0;
        $work_order_list = $this->Event_model->get_work_order_list(array('event_id'=>$event['id']));
        foreach ($work_order_list as $key => $value) {
            $tmp = strtotime($value['back_time']) - strtotime($value['arrive_time']);
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
        $time = $worktime_count*$performance['name']/100*$date;
        return $time;
    }


    public function do_data_export_all(){
        $data = $this->security->xss_clean($_GET);

        $this->data['is_search'] = 1;
        $this->data['data_type'] = $data['data_type'];
        $this->data['user_id'] = $data['user_id'];
        $this->data['department_id'] = $data['department_id'];
        $this->data['event_month'] = $data['event_month'];
        
        $where = array('user_id'=>$data['user_id'],'event_month'=>$data['event_month']);
        
        if($data['department_id'] =='all'){
            unset($where['user_id']);
        }else if($data['user_id']=='all'){
            $users = $this->User_model->get_user_list(array('department'=>$data['department_id']));

            foreach ($users['info'] as $key => $value) {
                $user_list[] = $value['id'];
            }
            unset($where['user_id']);
            $where['where_in'] = array('key'=>'user_id','value'=>$user_list);
        }
        $result = array();
        $event_list = $this->Event_model->get_event_list($where);
        foreach ($event_list['info'] as $key => $value) {
            $user = $this->User_model->get_user_info(array("id"=>$value['user_id']));
            $work_order_list = $this->Event_model->get_work_order_list(array('event_id'=>$value['id']));
            foreach ($work_order_list as $k => $val) {
                if($data['data_type']=="work_time"){
                    $result[] = $this->do_data_export_worktime($value,$val,$data,$user['name']);
                }elseif($data['data_type']=="fee"){
                    foreach($val['bill_order_list'] as $m=>$n){
                        $result[] = $this->format_bill_data($n,$user['name']);
                    }
                }
            }
        }
        foreach ($result as $key => $value) {
            $res[$value['user_name']][] = $value;
        }        

        if(isset($data['is_export']) && $data['is_export'] && $data['data_type']=="fee"){
            $title = array("使用人","出发时间","到达时间","起始地","目的地","交通费","住宿费","加班餐费","其他费用","备注","单据编号","交通方式","类型");
            $this->export_xls_all('费用',$res,$title);  
        }elseif(isset($data['is_export']) && $data['is_export'] && $data['data_type']=="work_time"){
            $title = array("使用人","日期","客户简称","事件类型","到场时间","离场时间","事件描述","工时","工作时间工时","平时加班","周末加班","节日加班");
            foreach ($res as $k => $v) {
                $worktime_count = 0;
                $work_time = 0;
                $week_more = 0;
                $weekend_more = 0;
                $holiday_more = 0;                
                foreach ($v as $key => $value) {
                    $worktime_count += $value['worktime_count'];
                    $work_time += $value['work_time'];
                    $week_more += $value['week_more'];
                    $weekend_more += $value['weekend_more'];
                    $holiday_more += $value['holiday_more'];
                }
                $all['user_name'] = '合计';
                $all['date'] = '';
                $all['short_name'] = '';
                $all['event_type_name'] = '';
                $all['arrive_time'] = '';
                $all['back_time'] = '';
                $all['desc'] = '';        
                $all['worktime_count'] = $worktime_count;
                $all['work_time'] = $work_time;
                $all['week_more'] = $week_more;
                $all['weekend_more'] = $weekend_more;
                $all['holiday_more'] = $holiday_more;
                $v[] = $all;
                $res[$k] = $v;
            }
            $this->export_xls_all('工时',$res,$title);  
        }
        $this->pages_conf(count($result));
        $info_list = array();
        foreach ($result as $key => $value) {
            if($key>=$this->per_page && $key<($this->per_page+ROW_SHOW_NUM)){
                $info_list[] = $value;
            }
        }
        $this->data['info_list'] = $info_list;
        $this->data['user_data'] = $this->session->userdata; 
        $this->layout->view('search/do_data_export',$this->data);
    }

    public function do_data_export(){
        $data = $this->security->xss_clean($_GET);
        $this->data['is_search'] = 1;
        $this->data['data_type'] = $data['data_type'];
        $this->data['user_id'] = $data['user_id'];
        $user = $this->User_model->get_user_info(array("id"=>$data['user_id']));
        $this->data['name'] = $user['name'];
        $this->data['department_id'] = $data['department_id'];
        $this->data['event_month'] = $data['event_month'];
        $where = array('user_id'=>$data['user_id'],'event_month'=>$data['event_month']);
        $result = array();
        $event_list = $this->Event_model->get_event_list($where);
        foreach ($event_list['info'] as $key => $value) {
            $work_order_list = $this->Event_model->get_work_order_list(array('event_id'=>$value['id']));
            foreach ($work_order_list as $k => $val) {
                if($data['data_type']=="work_time"){
                    $result[] = $this->do_data_export_worktime($value,$val,$data,$user['name']);
                }elseif($data['data_type']=="fee"){
                    foreach($val['bill_order_list'] as $m=>$n){
                        $result[] = $this->format_bill_data($n,$user['name']);
                    }
                }
            }
        }
        if(isset($data['is_export']) && $data['is_export'] && $data['data_type']=="fee"){
            $msg[$this->data['name']] = $result;
            $title = array("使用人","出发时间","到达时间","起始地","目的地","交通费","住宿费","加班餐费","其他费用","备注","单据编号","交通方式","类型");
            $this->export_xls($this->data['name'],$msg,$title);  
        }elseif(isset($data['is_export']) && $data['is_export'] && $data['data_type']=="work_time"){
            $worktime_count = 0;
            $work_time = 0;
            $week_more = 0;
            $weekend_more = 0;
            $holiday_more = 0;
            foreach ($result as $key => $value) {
                $worktime_count += $value['worktime_count'];
                $work_time += $value['work_time'];
                $week_more += $value['week_more'];
                $weekend_more += $value['weekend_more'];
                $holiday_more += $value['holiday_more'];
            }
            $all['user_name'] = '合计';
            $all['date'] = '';
            $all['short_name'] = '';
            $all['event_type_name'] = '';
            $all['arrive_time'] = '';
            $all['back_time'] = '';
            $all['desc'] = '';        
            $all['worktime_count'] = $worktime_count;
            $all['work_time'] = $work_time;
            $all['week_more'] = $week_more;
            $all['weekend_more'] = $weekend_more;
            $all['holiday_more'] = $holiday_more;
            $result[] = $all;
            $msg[$this->data['name']] = $result;
            $title = array("使用人","日期","客户简称","事件类型","到场时间","离场时间","事件描述","工时","工作日工时","平时加班","周末加班","节日加班");
            $this->export_xls($this->data['name'],$msg,$title);  
        }
        $this->pages_conf(count($result));
        $info_list = array();
        foreach ($result as $key => $value) {
            if($key>=$this->per_page && $key<($this->per_page+ROW_SHOW_NUM)){
                $info_list[] = $value;
            }
        }
        $this->data['info_list'] = $info_list;
        $this->data['user_data'] = $this->session->userdata; 
        $this->layout->view('search/do_data_export',$this->data);
    }

    public function format_bill_data($msg,$user_name){
        $format = array(
            "go_time" => "go_time",
            "arrival_time"=>"arrival_time",
            "start_place" => "start_place",
            "arrival_place"=>"arrival_place",
            "transportation_fee"=>"transportation_fee",
            "hotel_fee" =>"hotel_fee",
            "food_fee"=>"food_fee",
            "other_fee"=>"other_fee",
            "memo"=>"memo",
            "bill_no"=>"bill_no",
            );
        $res['user_name'] = $user_name;
        foreach ($format as $key => $value) {
            $res[$key] = $msg[$value];
        }
        $res['transportation_name'] = $this->Event_model->get_setting_name($msg['transportation']);
        if($msg['type'] == 0){
            $res['type'] = "去程";
        }else{
            $res['type'] = "返程";
        }
        return $res;
    }

    public function export_xls_all($name,$msg,$title){
        require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                                     ->setLastModifiedBy("Maarten Balliauw")
                                     ->setTitle("Office 2007 XLSX Test Document")
                                     ->setSubject("Office 2007 XLSX Test Document")
                                     ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                     ->setKeywords("office 2007 openxml php")
                                     ->setCategory("Test result file");
        $i=0;
        foreach ($msg as $key => $value) {
            $objPHPExcel->createSheet($i);            
            $objPHPExcel->setActiveSheetIndex($i)
                ->fromArray(
                    $title,
                    NULL,
                    'A1'
                );            
            $arrayData = $value;
            $objPHPExcel->setActiveSheetIndex($i)
                ->fromArray(
                    $arrayData,
                    NULL,
                    'A2'
                );
            // Rename worksheet
            //$objPHPExcel->getActiveSheet()->setTitle(iconv("UTF-8", "GB2312//IGNORE", $key) );
            $objPHPExcel->getActiveSheet()->setTitle($key);
            $i++;
        }
        $filename = $name.'.xlsx';

        $objPHPExcel->setActiveSheetIndex(0);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet


        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;        
    }

    public function export_xls($name,$msg,$title){
        require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                                     ->setLastModifiedBy("Maarten Balliauw")
                                     ->setTitle("Office 2007 XLSX Test Document")
                                     ->setSubject("Office 2007 XLSX Test Document")
                                     ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                     ->setKeywords("office 2007 openxml php")
                                     ->setCategory("Test result file");
        $i=0;
        foreach ($msg as $key => $value) {
            $objPHPExcel->createSheet($i);            
            $objPHPExcel->setActiveSheetIndex($i)
                ->fromArray(
                    $title,
                    NULL,
                    'A1'
                );            
            $arrayData = $value;
            $objPHPExcel->setActiveSheetIndex($i)
                ->fromArray(
                    $arrayData,
                    NULL,
                    'A2'
                );
            // Rename worksheet
            //$objPHPExcel->getActiveSheet()->setTitle(iconv("UTF-8", "GB2312//IGNORE", $key) );
            $objPHPExcel->getActiveSheet()->setTitle($key);
            $i++;
        }
        $filename = $name.'.xlsx';

        $objPHPExcel->setActiveSheetIndex(0);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet


        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;        
    }

    public function do_data_export_worktime($event,$work_order,$data,$user_name){
        $work = array();
        $worktime_count = $this->do_data_export_worktime_count($work_order);
        $work['user_name'] = $user_name;
        //$work['date'] = $work_order['date'];
        $work['date'] = $event['event_time'];
        $work['short_name'] = $event['short_name'];
        $work['event_type_name'] = $event['event_type_name'];
        $work['arrive_time'] = $work_order['arrive_time'];
        $work['back_time'] = $work_order['back_time'];
        $work['desc'] = $work_order['desc'];
        //$work['worktime_count'] = $worktime_count;
        list($work_time,$week_more,$weekend_more,$holiday_more) = $this->do_data_export_worktime_more($event,$work_order);
        $worktime_count_tmp = $work_time+$week_more+$weekend_more+$holiday_more;

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
        $worktime_count = $worktime_count_tmp*$performance['name']/100*$date;
        $work['worktime_count'] = $worktime_count;
        $work['work_time'] = $work_time;
        $work['week_more'] = $week_more;
        $work['weekend_more'] = $weekend_more;
        $work['holiday_more'] = $holiday_more;
        return $work;
    }

    public function do_data_export_worktime_count($work_order){
        $worktime_count = 0;
        $tmp = strtotime($work_order['back_time']) - strtotime($work_order['arrive_time']);
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
        return $worktime_count;
    }

/**
    public function do_data_export_worktime_more($event,$work_order){
        $week_more = 0;
        $weekend_more = 0;
        $holiday_more = 0;

        $tmp = strtotime($work_order['back_time']) - strtotime($work_order['arrive_time']);
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
        $date = substr($work_order['back_time'],0,10);
        $holiday_list = $this->Event_model->get_holiday_list();
        $weekend_list = explode('_', WEEKEND);
        if (in_array($date, $holiday_list)){
            $holiday_more = $holiday_more+$int_tmp+$less_tmp;
        }elseif(in_array(date("N",strtotime($date)), $weekend_list)){
            $weekend_more = $weekend_more+$int_tmp+$less_tmp;
        }else{
            $tmp_time = $this->Event_model->get_work_time();
            $week_more_tmp = $this->get_work_more_time($work_order['arrive_time'],$work_order['back_time'],$tmp_time);
            $week_more = $week_more+$week_more_tmp;
        }
        $res[] = $week_more;
        $res[] = $weekend_more;
        $res[] = $holiday_more;
        return $res;
    }
**/

   public function do_data_export_worktime_more($event,$work_order){
        $arrive = True;
        $back = True;
        $week_more = 0;
        $weekend_more = 0;
        $holiday_more = 0;
        $work_time = 0;


        $back_date = substr($work_order['back_time'],0,10);
        $arrive_date = substr($work_order['arrive_time'],0,10);
        $day = (strtotime($back_date." 00:00:00") - strtotime($arrive_date." 00:00:00"))/(3600*24);
        $holiday_list = $this->Event_model->get_holiday_list();
        $weekend_list = explode('_', WEEKEND);
        if (in_array($arrive_date, $holiday_list)){
            $arrive_tmp = strtotime($arrive_date." 00:00:00") + (3600*24) -strtotime($work_order['arrive_time']);
            list($arrive_int_tmp,$arrive_less_tmp) = $this->get_time_format($arrive_tmp);
            $holiday_more = $holiday_more+$arrive_int_tmp+$arrive_less_tmp;
            $arrive = False;
        }
        if (in_array($back_date, $holiday_list)){
            $back_tmp = strtotime($work_order['back_time']) - strtotime($back_date." 00:00:00");
            list($abackint_tmp,$back_less_tmp) = $this->get_time_format($back_tmp);
            $holiday_more = $holiday_more+$back_int_tmp+$back_less_tmp;
            $back = False;
        }            
        if(in_array(date("N",strtotime($back_date)), $weekend_list)){
            $back_tmp = strtotime($work_order['back_time']) - strtotime($back_date." 00:00:00");
            list($back_int_tmp,$back_less_tmp) = $this->get_time_format($back_tmp);
            $weekend_more = $weekend_more+$back_int_tmp+$back_less_tmp;
            $back = False;
        }
        if(in_array(date("N",strtotime($arrive_date)), $weekend_list)){
            $arrive_tmp = strtotime($arrive_date." 00:00:00") + (3600*24) -strtotime($work_order['arrive_time']);
            list($arrive_int_tmp,$arrive_less_tmp) = $this->get_time_format($arrive_tmp);
            $weekend_more = $weekend_more+$arrive_int_tmp+$arrive_less_tmp;
            $arrive = False;
        }
        $tmp_where = array("id"=>$event['worktime_id']);
        $tmp_time = $this->Event_model->get_work_time($tmp_where);
        $week_more_tmp = $this->get_work_more_time($work_order['arrive_time'],$work_order['back_time'],$arrive,$back,$tmp_time,$day);
        $week_more = $week_more+$week_more_tmp;
        $work_time_tmp = $this->get_work_time($work_order['arrive_time'],$work_order['back_time'],$arrive,$back,$tmp_time,$day);
        $work_time = $work_time+$work_time_tmp; 

        
        $res[] = $work_time;        
        $res[] = $week_more;
        $res[] = $weekend_more;
        $res[] = $holiday_more;
        return $res;
    }    

}

?>
