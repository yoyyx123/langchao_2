<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header("Content-Type:text/html;charset=utf-8");
class Cloud extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('security');
        $this->load->model('Member_model');
        $this->load->model('Role_model');
        $this->load->model('Event_model');
        $this->load->model('Cloud_model');
    }

    public function doc_download(){
        $data = $this->security->xss_clean($_GET);
        if(isset($data['type']) && $data['type']=="download"){
            $doc = $this->Cloud_model->get_doc_info(array("id"=>$data['id']));
            $this->Cloud_model->add_doc_download_num(array("id"=>$data['id']));
            $file = $doc['path'];
            $name = $doc['name'].".".$doc['type'];
            header('Content-type: application/pdf');
            header('Content-Disposition: attachment;filename='.$name);
            readfile($file);
        }
        $this->data['user_data'] = $this->session->userdata;
        $guanlibu = $this->Role_model->get_setting_info(array("type"=>"department","name"=>"管理部"));
        $where = array();
        if($this->data['user_data']['position2'] == '1'){
            $where = array("department"=>$this->data['user_data']['department']);
            if(isset($guanlibu) && !empty($guanlibu)){
                $where['where_or'] = array('key'=>'department','value'=>$guanlibu['id']);
            }            
        }
        $doc_list = $this->Cloud_model->get_doc_list($where,$this->per_page);
        $this->pages_conf($doc_list['count']);
        $this->data['doc_list'] = $doc_list['info'];
        $this->layout->view('cloud/doc_list',$this->data);
    }

    public function doc_look(){
        $data = $this->security->xss_clean($_GET);
         $this->data['id'] = $data['id'];
        $doc = $this->Cloud_model->get_doc_info(array("id"=>$data['id']));
        $file = $doc['path'];
        $this->Cloud_model->add_doc_look_num(array("id"=>$data['id']));
        if($doc['type'] === 'pdf'){
            header('Content-type: application/pdf');
            header('filename='.$file);
            readfile($file);            
        }elseif ($doc['type'] == 'xlsx') {
            require_once dirname(__FILE__) . '/../libraries/PHPExcel/IOFactory.php';
            require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
            //$objPHPExcel = new PHPExcel();
            $objPHPExcel = PHPExcel_IOFactory::load($file);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
            $count = $objPHPExcel->getSheetCount();
            //echo $count;exit;
            $this->pages_conf($count,FALSE,1);
            for($i=0;$i<$count;$i++){
                $objWriter->setSheetIndex($i);
                $f = "_".$i.".htm";
                $objWriter->save(str_replace('.xlsx', $f, $file));
            }
            $this->data['row_num'] = 1;
            if(isset($data['per_page']) && !empty($data['per_page'])){
                $num = $data['per_page'];
                $f = "_".$num.".htm";
                $this->data['path'] = str_replace('.xlsx', $f, $file);
            }else{
                $this->data['path'] = str_replace('.xlsx', '_0.htm', $file);
            }
            $this->load->view('cloud/doc_look',$this->data);
        }

    }

}

?>
