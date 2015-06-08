<?php
class User_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }


    public function get_user_mobile($user){
        $query = $this->db->get_where('user', array('username' => $user));
        $res = $query->row_array();
        return $res;
    }

    public function get_user_info($where){
        $query = $this->db->get_where('user', $where);
        $res = $query->row_array();
        if($res){
            $res['department_name'] = $this->get_setting_name($res['department']);
            $res['position_name'] = $this->get_setting_name($res['position']);
            $query2 = $this->db->get_where('user_roles', array("id"=>$res['roles']));
            $rs = $query2->row_array();
            $res['position2'] = $rs['position2'];
            $res['act'] = unserialize($rs['permission']);
        }
        return $res;       
    }

    public function get_user_list($where=array(),$offset=false){
        $this->db->order_by("id", "desc");
        if($offset!==false){
            $query = $this->db->get_where('user', $where,ROW_SHOW_NUM,$offset);

        }else{
            $query = $this->db->get_where('user', $where);
        }        
        $res = $query->result_array();
        foreach ($res as $key => $value) {
            $value['department_name'] = $this->get_setting_name($value['department']);
            $value['position_name'] = $this->get_setting_name($value['position']);
            $value['addr_name'] = $this->get_setting_name($value['addr']);
            $value['roles_name'] = $this->get_roles_name($value['roles']);
            $res[$key] = $value;
        }
        $this->db->where($where);
        $this->db->from('user');
        $count = $this->db->count_all_results();
        return array('count'=>$count,"info"=>$res); 
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

    public function get_roles_name($id){
        $where = array('id'=>$id);
        $query = $this->db->get_where('user_roles', $where);
        $res = $query->row_array();
        return $res['role_name'];        
    }

    public function check_captcha_msg($uid,$captcha){
        $this->db->order_by("created", "desc");
        $query = $this->db->get_where('sms_captcha', array('uid' =>$uid ,'status'=>'1' ));
        $res = $query->row_array();
        if ($res['captcha'] == $captcha && (time()- 60*30 <= $res['created'])){
            return $res;
        }else{
            return False;
        }
    }

    public function get_sms_info(){
        $query = $this->db->get_where('sms_setting', array('status' => '1'));
        $res = $query->row_array();
        return $res;
    }

    public function get_sms_setting(){
        $query = $this->db->get_where('sms_setting',array('id'=>1));
        $res = $query->row_array();
        return $res;
    }

    public function update_sms_info($data){
        $res = $this->db->update('sms_setting', $data,array("id"=>1)); 
        return $res;
    }

    public function save_sms_captcha($uid,$captcha,$task_id){
        $data = array(
               'uid' => $uid,
               'captcha' => $captcha,
               'task_id' => $task_id,
               'created' => time(),
        );
        $this->db->insert('sms_captcha', $data); 
    }

    public function edit_user_info($where,$params){
        $res = $this->db->update('user', $params,$where); 
        return $res;
    }

    public function save_user_info($params){
        $this->db->set($params);
        $res = $this->db->insert('user');
        return $res;
    }

    public function delete_user($where){
        $this->db->where($where);
        $res = $this->db->delete('user');
        return $res;        
    }

    public function update_user_info($where,$params){
        $this->db->where($where);
        $res = $this->db->update('user', $params); 
        return $res;
    }

    public function search_user_info($where){
        $this->db->like('name', $where); 
        $this->db->or_like('short_num', $where); 
        $query = $this->db->get('user');
        $res = $query->row_array();
        return $res;
    }
}

?>