<?php
class Event_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function add_event_info($params){
        $this->db->set($params);
        $res = $this->db->insert('event_list');
        return $res;
    }

    public function get_event_info($where){
        $query = $this->db->get_where('event_list', $where);
        $res = $query->row_array();
        $query3 = $this->db->get_where('event_type_list', array('id'=>$res['event_type_id']));
        $res3 = $query3->row_array();
        $res['event_type_name'] = $res3['name'];

        $query4 = $this->db->get_where('setting_list', array('id'=>$res['worktime_id']));
        $res4 = $query4->row_array();
        $res['worktime_id_value'] = $res4['name'];
        return $res;
    }

    public function delete_event($where){
        $this->db->where($where);
        $res = $this->db->delete('event_list');
        return $res;
    }

    public function get_member_event_list($where,$limit=false){
        $this->db->order_by("event_time", "desc");
        if(isset($limit)){
            $this->db->limit($limit);
        }
        $this->db->from('event_list');
        $this->db->where($where);
        $query = $this->db->get();
        $res = $query->result_array();
        foreach ($res as $key => $value) {
            $query3 = $this->db->get_where('event_type_list', array('id'=>$value['event_type_id']));
            $res3 = $query3->row_array();
            @$value['event_type_name'] = $res3['name'];            
            $query4 = $this->db->get_where('user', array('id'=>$value['user_id']));
            $res4 = $query4->row_array();
            @$value['user_name'] = $res4['username'];
            @$value['name'] = $res4['name'];
            $res[$key] = $value;
        }
        return $res;
    }

    public function get_event_list_sql($sql){
        $query = $this->db->query($sql);
        $res = $query->result_array();
        foreach ($res as $key => $value) {
            $query4 = $this->db->get_where('member', array('id'=>$value['member_id']));
            $res4 = $query4->row_array();
            @$value['short_name'] = $res4['short_name'];
            $res[$key] = $value;
        }        
        return $res;
    }

    public function get_event_list($where,$offset=false,$orderby="asc"){
        $this->db->order_by("event_time", $orderby);
        if(isset($where['where_in'])){
            $this->db->where_in($where['where_in']['key'], $where['where_in']['value']);
            unset($where['where_in']);
        }
        if($offset!==false){
            $query = $this->db->get_where('event_list', $where,ROW_SHOW_NUM,$offset);

        }else{
            $query = $this->db->get_where('event_list', $where);
        }
        $res = $query->result_array();
        foreach ($res as $key => $value) {

            /**
            $time = $value['event_time'];
            $x = strtotime($time);
            $n = strtotime(date("Y-m-d"));
            $r = round(($x+EXPIRE_DATE*24*3600-$n)/(24*3600));
            $value['event_less_time'] = $r;
            **/

            $time = $value['event_time'];
            $x = strtotime($time);
            $work_order = $this->get_work_order_info(array('event_id'=>$value['id']));
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
            $value['event_less_time'] = $r;



            $query2 = $this->db->get_where('work_order_list', array('event_id'=>$value['id']));
            $res2 = $query2->result_array();
            $value['work_order_num'] = count($res2);
            $query3 = $this->db->get_where('event_type_list', array('id'=>$value['event_type_id']));
            $res3 = $query3->row_array();
            @$value['event_type_name'] = $res3['name'];
            $query4 = $this->db->get_where('member', array('id'=>$value['member_id']));
            $res4 = $query4->row_array();
            @$value['short_name'] = $res4['short_name'];
            $query4 = $this->db->get_where('user', array('id'=>$value['user_id']));
            $res4 = $query4->row_array();
            @$value['user_name'] = $res4['username'];
            @$value['name'] = $res4['name'];
            $res[$key] = $value;
        }
        $this->db->where($where);
        $this->db->from('event_list');
        $count = $this->db->count_all_results();
        return array('count'=>$count,"info"=>$res); 
    }

    public function get_event_search_list($where,$offset=false){
        $where_sql = "";
        if(isset($where['user_id'])){
            $where_sql .= " and `user_id`=".$where['user_id'];
        }
        if(isset($where['member_id'])){
            $where_sql .= " and `member_id`=".$where['member_id'];
        }
        if(isset($where['start_time'])){
            $where_sql .= " and `event_time`>='".$where['start_time'];            
        }
        if(isset($where['end_time'])){
            $where_sql .= "' and `event_time`<='".$where['end_time']."'";            
        }        
        $sql = "select * from ldb_event_list where 1=1 ".$where_sql." order by event_time desc";
        if($offset!==false){
            $sql .= " limit ".$offset.",".ROW_SHOW_NUM;
        }
        $res = $this->db->query($sql)->result_array();
        foreach ($res as $key => $value) {
            $time = $value['event_time'];
            $x = strtotime($time);
            $n = strtotime(date("Y-m-d"));
            $r = round(($x+EXPIRE_DATE*24*3600-$n)/(24*3600));
            $value['event_less_time'] = $r;
            $work_order_list = $this->get_work_order_list(array('event_id'=>$value['id']));
            $value['work_order_list'] = $work_order_list;
            $value['work_order_num'] = count($work_order_list);
            $query3 = $this->db->get_where('event_type_list', array('id'=>$value['event_type_id']));
            $res3 = $query3->row_array();
            $value['event_type_name'] = $res3['name'];
            $query4 = $this->db->get_where('member', array('id'=>$value['member_id']));
            $res4 = $query4->row_array();
            $value['short_name'] = $res4['short_name'];
            $query4 = $this->db->get_where('user', array('id'=>$value['user_id']));
            $res4 = $query4->row_array();
            $value['user_name'] = $res4['username'];  
            $res[$key] = $value;
        }
        return $res;       
    }

    public function get_event_simple_list($where){
        $query = $this->db->get_where('event_list', $where);
        $res = $query->result_array();
        return $res;      
    }    

    public function update_event_info($params,$where){
        $this->db->where($where);
        $res = $this->db->update('event_list', $params); 
        return $res;         
    }    

    public function save_work_order_info($params){
        $this->db->set($params);
        $res = $this->db->insert('work_order_list');
        return $res;        
    }

    public function update_work_order_info($params,$where){
        $this->db->where($where);
        $res = $this->db->update('work_order_list', $params); 
        return $res;              
    }

    public function get_work_order_info($where){
        $this->db->order_by("date", "desc"); 
        $query = $this->db->get_where('work_order_list', $where);
        $res = $query->row_array();
        return $res;
    }

    public function delete_work_order($where){
        $this->db->delete('work_order_list', $where); 
    }

    public function get_work_order_list($where){
        $this->db->order_by("arrive_time", "asc");
        $query = $this->db->get_where('work_order_list', $where);
        $res = $query->result_array();
        foreach($res as $key=>$val){
            $where = array('work_order_id'=>$val['id']);
            $bill_list = $this->get_bill_order_list($where);
            $val['bill_order_list'] = $bill_list;
            $res[$key] = $val;
        }
        return $res;       
    }

    public function insert_biil_orderr_info($params){
        $this->db->set($params);
        $res = $this->db->insert('biil_order_list');
        return $res;         
    }

    public function save_biil_orderr_info($params,$where){
        $this->db->where($where);
        $res = $this->db->update('biil_order_list', $params); 
        return $res;         
    }

    public function get_biil_orderr_info($where){
        $this->db->order_by("id", "desc"); 
        $query = $this->db->get_where('biil_order_list', $where);
        $res = $query->row_array();
        return $res;
    }

    public function delete_biil_orderr_info($where){
        $this->db->where($where);
        $res = $this->db->delete('biil_order_list');
        return $res;
    }

    public function get_bill_order_list($where){
        $this->db->order_by("arrival_time", "asc");
        $query = $this->db->get_where('biil_order_list', $where);
        $res = $query->result_array();
        foreach ($res as $key => $value) {
            $value['date2'] = substr($value['date'],0,10);
            $value['transportation_name'] = $this->get_setting_name($value['transportation']);
            $res[$key] = $value;
        }
        return $res;         
    }

    public function get_setting_name($id){
        $where = array('id'=>$id);
        $query = $this->db->get_where('setting_list', $where);
        $res = $query->row_array();
        if($res){
            return $res['name'];             
        }else{
            return $res;
        }
    }

    public function get_work_time($where){
        $query = $this->db->get_where('setting_list',$where);
        $res = $query->row_array();
        if($res){
            return $res['name'];             
        }else{
            return $res;
        }        
    }

    public function insert_check_event_info($params){
        $this->db->set($params);
        $res = $this->db->insert('event_list');
        return $res;          
    }

    public function update_check_event_info($params,$where){
        $this->db->where($where);
        $res = $this->db->update('event_list', $params); 
        return $res;         
    }

    public function get_check_event_info($where){
        $query = $this->db->get_where('event_list', $where);
        $res = $query->row_array();
        return $res;
    }

    public function delete_check_event_info($where){
        
        //$res = $this->db->update('event_list', $params);
        $work_list = $this->get_work_order_list(array("event_id"=>$where['id']));
        foreach($work_list as $key=>$value){
            $bill_list = $this->get_bill_order_list(array('work_order_id'=>$value['id']));
            foreach($bill_list as $k=>$val){
                $this->db->delete('biil_order_list',array('id' => $val['id']));
            }
            $this->db->delete('work_order_list',array('id' => $value['id']));
        }
        $this->db->where($where);
        $res = $this->db->delete('event_list');
        return $res;          
    }
    
    public function update_bill_order_status($params,$where){
        $this->db->where($where);
        $res = $this->db->update('biil_order_list', $params); 
        return $res;       
    }

    public function get_holiday_list(){
        $where = array('type'=>"holiday");
        $query = $this->db->get_where('date_setting', $where);
        $res = $query->result_array();
        foreach ($res as $key => $value) {
            $result[] = $value['value'];
        }
        return $result;        
    }

    public function get_weekend_info(){
        $where = array('type'=>"weekend");
        $query = $this->db->get_where('date_setting', $where);
        $result = $query->row_array();
        return $result;        
    }    

    public function get_event_info_by_bill_id($id){
        $query = $this->db->get_where('biil_order_list', array('id'=>$id));
        $result = $query->row_array();
        $query2 = $this->db->get_where('work_order_list', array('id'=>$result['work_order_id']));
        $result2 = $query2->row_array();
        $query3 = $this->db->get_where('event_list', array('id'=>$result2['event_id']));
        $result3 = $query3->row_array();
        return $result3;

    }

}

?>
