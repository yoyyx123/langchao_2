<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
        $this->load->model('Event_model');
    }

	public function index()
	{		
		$expire_count = 0;
		$warning_count = 0;
		$where = array("user_id"=>$this->session->userdata['id'],"status"=>"1");
		$event_list = $this->Event_model->get_event_list($where,$this->per_page);
		$this->pages_conf($event_list['count']);
		$this->data['event_list'] = $event_list['info'];
		$event_all = $this->Event_model->get_event_list($where);
		foreach ($event_all['info'] as $key => $value) {
			if ($value['event_less_time'] < 0){
				$expire_count +=1;
			}
			if ($value['event_less_time'] >= 0 && $value['event_less_time'] <= 2){
				$warning_count +=1;
			}
		}
		$this->data['expire_count'] = $expire_count;
		$this->data['warning_count'] = $warning_count;
		$this->data['user_data'] = $this->session->userdata;
		$this->layout->view('home/index',$this->data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */