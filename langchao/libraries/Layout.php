<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout{
    var $obj;
    var $layout;

    function Layout($layout = "default"){
        $this->obj =& get_instance();
        $this->layout = "layouts/".$layout;
    }

    function setLayout($layout){
		$this->layout = $layout;
    }

    function view($view, $data=null, $return=false){
		$data['content_for_layout'] = $this->obj->load->view($view,$data,true);
        if($return){
  			$output = $this->obj->load->view($this->layout,$data, true);
            return $output;
        }
        else{
            $this->obj->load->view($this->layout,$data, false);
        }
    }
}
/* End of file Layout.php */
/* Location: ./app/open/libraries/Layout.php */