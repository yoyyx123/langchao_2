<?php
class Role_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_roles($where,$offset=false){
        $this->db->order_by("id", "desc");
        if($offset!==false){
            $query = $this->db->get_where('user_roles', $where,ROW_SHOW_NUM,$offset);

        }else{
            $query = $this->db->get_where('user_roles', $where);
        }        
        $res = $query->result_array();
        $this->db->where($where);
        $this->db->from('user_roles');
        $count = $this->db->count_all_results();
        return array('count'=>$count,"info"=>$res);  
    }


    public function get_ctl_list() {
    	$where = array("pid"=>0,"type"=>"ctl");
    	$query = $this->db->get_where('ctl_list', $where);
        $rs = $query->result_array();
        for($i = 0; $i < count($rs); $i++) {
        	$where = array("pid"=>"{$rs[$i]['id']}","type"=>"ctl");
        	$query2 = $this->db->get_where('ctl_list', $where);
            $rs2 = $query2->result_array();
            $rs[$i]['ctl_child'] = $rs2;
        }
        //print_r($rs);exit;
        return $rs;
    }

    public function get_permission_list($where){
        $query = $this->db->get_where('ctl_list', $where);
        $rs = $query->result_array();
        foreach ($rs as $key => $value) {
            $result[$value['id']] = $value;
        }
        return $result;
    }

    public function get_top_list(){
        $where = array("pid"=>0,"type"=>"ctl");
        $query = $this->db->get_where('ctl_list', $where);
        $rs = $query->result_array();
        foreach ($rs as $key => $value) {
            $result[] = $value['id'];
        }
        return $result;
    }

    public function get_child_list($where){
        $query = $this->db->get_where('ctl_list', $where);
        $rs = $query->result_array();
        foreach ($rs as $key => $value) {
            $result[] = $value['id'];
        }
        return $result;        
    }

    public function add_role($data){
    	$this->db->insert('user_roles', $data); 
    }

    public function get_role_info($where){
        $query = $this->db->get_where('user_roles', $where);
        $res = $query->row_array();
        return $res;       
    }

    public function delete_role($data){
    	if (is_array($data)){
    		$res = $this->db->delete('user_roles', $data); 
    		return $res;
    	}else{
    		return false;
    	}
    }

    public function update_role($where,$data){
    	$res = $this->db->update('user_roles', $data,$where); 
        return $res;
    }

    public function edit_role($where){
    	$query = $this->db->get_where('user_roles', $where);
        $rs = $query->row_array();
        $ctl_arr = unserialize(stripcslashes($rs['permission']));
        $query2 = $this->db->get_where('ctl_list', array("pid"=>0,"type"=>"ctl"));
        $rs2 = $query2->result_array();
        for($i = 0; $i < count($rs2); $i++) {
        	$query3 = $this->db->get_where('ctl_list', array("pid"=>"{$rs2[$i]['id']}","type"=>"ctl"));
        	$rs3 = $query3->result_array();
            for($j = 0; $j < count($rs3); $j++) {
                if(in_array($rs3[$j]['id'], $ctl_arr)) {
                    $rs3[$j]['sel'] = 1;
                } else {
                    $rs3[$j]['sel'] = 0;
                }
            }
            $rs2[$i]['ctl_child'] = $rs3;
            if(in_array($rs2[$i]['id'], $ctl_arr)) {
                $rs2[$i]['sel'] = 1;
            } else {
                $rs2[$i]['sel'] = 0;
            }
        }
        $rs['ctl'] = $rs2;
        return $rs;    	
    }

    public function get_city_list($where){
        $query = $this->db->get_where('city_list', $where);
        $res = $query->result_array();
        return $res;    	
    }

    public function get_city_info($where){
        $query = $this->db->get_where('city_list', $where);
        $res = $query->row_array();
        return $res;        	
    }
    
    public function add_city($data){
    	$this->db->insert('city_list', $data);     	
    }

    public function delete_city($data){
    	if (is_array($data)){
    		$res = $this->db->delete('city_list', $data); 
    		return $res;
    	}else{
    		return false;
    	}    	
    }

    public function update_city($where,$data){
    	$res = $this->db->update('city_list', $data,$where); 
        return $res;
    }

    public function get_custom_list($where){
        $query = $this->db->get_where('custom_type_list', $where);
        $res = $query->result_array();
        return $res;       	
    }

    public function get_custom_info($where){
        $query = $this->db->get_where('custom_type_list', $where);
        $res = $query->row_array();
        return $res;        	
    }
    
    public function add_custom($data){
    	$this->db->insert('custom_type_list', $data);     	
    }

    public function delete_custom($data){
    	if (is_array($data)){
    		$res = $this->db->delete('custom_type_list', $data); 
    		return $res;
    	}else{
    		return false;
    	}    	
    }

    public function update_custom($where,$data){
    	$res = $this->db->update('custom_type_list', $data,$where); 
        return $res;
    }    



    public function get_department_list($where){
        $query = $this->db->get_where('department_list', $where);
        $res = $query->result_array();
        return $res;       	
    }

    public function get_department_info($where){
        $query = $this->db->get_where('department_list', $where);
        $res = $query->row_array();
        return $res;        	
    }
    
    public function add_department($data){
    	$this->db->insert('department_list', $data);     	
    }

    public function delete_department($data){
    	if (is_array($data)){
    		$res = $this->db->delete('department_list', $data); 
    		return $res;
    	}else{
    		return false;
    	}    	
    }

    public function update_department($where,$data){
    	$res = $this->db->update('department_list', $data,$where); 
        return $res;
    }

    public function get_event_list($where,$offset=false){
        $this->db->order_by("id", "desc");
        if(isset($where['where_or'])){
            $where_or = $where['where_or'];
            unset($where['where_or']);
        }        
        if($offset!==false){
            //$query = $this->db->get_where('event_type_list', $where,ROW_SHOW_NUM,$offset);
            $this->db->where($where,ROW_SHOW_NUM,$offset);
        }else{
            //$query = $this->db->get_where('event_type_list', $where);
            $this->db->where($where);
        }
        if(isset($where_or)){
            $this->db->or_where($where_or['key'], $where_or['value']);
        }          
        $query = $this->db->get('event_type_list');
        $res = $query->result_array();
        foreach ($res as $key => $value) {
            if($value['department_id'] !='all'){
                $department_info = $this->get_setting_info(array('id'=>$value['department_id']));
                $value['department_name'] = $department_info['name'];
                $res[$key] = $value;
            }else{
                $value['department_name'] = '全部部门';
                $res[$key] = $value;                
            }

        }
        $this->db->where($where);
        if(isset($where_or) && !empty($where_or)){
            $this->db->or_where($where_or['key'], $where_or['value']);
        }
        $this->db->from('event_type_list');
        $count = $this->db->count_all_results();
        return array('count'=>$count,"info"=>$res);
    }

    public function get_event_info($where){
        $query = $this->db->get_where('event_type_list', $where);
        $res = $query->row_array();
        return $res;        	
    }
    
    public function add_event($data){
    	$this->db->insert('event_type_list', $data);     	
    }

    public function delete_event($data){
    	if (is_array($data)){
    		$res = $this->db->delete('event_type_list', $data); 
    		return $res;
    	}else{
    		return false;
    	}    	
    }

    public function update_event($where,$data){
    	$res = $this->db->update('event_type_list', $data,$where); 
        return $res;
    }

    public function get_setting_list($where,$offset=false){
        $this->db->order_by("id", "desc");
        if(isset($where['where_like'])){
            $this->db->like($where['where_like']['key'], $where['where_like']['value']);
            $where_like = $where['where_like'];
            unset($where['where_like']);
        }
        if($offset!==false){
            $query = $this->db->get_where('setting_list', $where,ROW_SHOW_NUM,$offset);

        }else{
            $query = $this->db->get_where('setting_list', $where);
        }
        $res = $query->result_array();
        $this->db->where($where);
        if(isset($where_like) && !empty($where_like)){
            $this->db->like($where_like['key'], $where_like['value']);
        }
        $this->db->from('setting_list');
        $count = $this->db->count_all_results();
        return array('count'=>$count,"info"=>$res);
    }

    public function get_setting_info($where){
        $query = $this->db->get_where('setting_list', $where);
        $res = $query->row_array();
        return $res;
    }

    public function get_setting_like($where,$where_like){
        $this->db->like($where_like['key'], $where_like['value']);
        $query = $this->db->get_where('setting_list', $where);
        $res = $query->row_array();
        return $res;
    }
    
    public function add_setting($data){
    	$this->db->insert('setting_list', $data);
    }

    public function delete_setting($data){
    	if (is_array($data)){
    		$res = $this->db->delete('setting_list', $data); 
    		return $res;
    	}else{
    		return false;
    	}    	
    }

    public function update_setting($where,$data){
    	$res = $this->db->update('setting_list', $data,$where); 
        return $res;
    }

    public function get_time_list($where,$offset=false){
        $this->db->order_by("id", "desc");
        if($offset!==false){
            $query = $this->db->get_where('date_setting', $where,ROW_SHOW_NUM,$offset);

        }else{
            $query = $this->db->get_where('date_setting', $where);
        }
        $res = $query->result_array();
        $this->db->where($where);
        $this->db->from('date_setting');
        $count = $this->db->count_all_results();
        return array('count'=>$count,"info"=>$res);
    }

    public function add_time($data){
        $this->db->insert('date_setting', $data);
    }

    public function delete_time($data){
        if (is_array($data)){
            $res = $this->db->delete('date_setting', $data); 
            return $res;
        }else{
            return false;
        }       
    }

    public function update_time($where,$data){
        $res = $this->db->update('date_setting', $data,$where); 
        return $res;
    }

    public function get_time_info($where){
        $query = $this->db->get_where('date_setting', $where);
        $res = $query->row_array();
        return $res;            
    }

    public function get_doc_list($where,$offset=false){
        $this->db->order_by("id", "desc");
        if($offset!==false){
            $query = $this->db->get_where('doc_list', $where,ROW_SHOW_NUM,$offset);

        }else{
            $query = $this->db->get_where('doc_list', $where);
        }
        $res = $query->result_array();
        $this->db->where($where);
        $this->db->from('doc_list');
        $count = $this->db->count_all_results();
        return array('count'=>$count,"info"=>$res);
    }

    public function add_doc($data){
        $this->db->insert('doc_list', $data);
    }

    public function delete_doc($data){
        if (is_array($data)){
            $res = $this->db->delete('doc_list', $data); 
            return $res;
        }else{
            return false;
        }       
    }

    public function update_doc($where,$data){
        $res = $this->db->update('doc_list', $data,$where); 
        return $res;
    }

    public function get_doc_info($where){
        $query = $this->db->get_where('doc_list', $where);
        $res = $query->row_array();
        return $res;            
    }

    public function get_expire_date(){
        $query = $this->db->get_where('setting_list', array('type'=>'expire_date'));
        $res = $query->row_array();
        return $res;
    }

    public function update_expire_date($where,$params){
        $res = $this->db->update('setting_list', $params,$where); 
    }

    public function add_expire_date($params){
        $this->db->insert('setting_list', $params);
    }


}


?>