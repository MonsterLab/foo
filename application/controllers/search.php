<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller{
    public function __construct() {
        parent::__construct();
       
        $this->load->model('M_talent','rc');        //人才
        $this->load->model('M_topic','zt');         //主体
        $this->load->model('M_medium','zj');         //中介
    }
    
    public function index(){
        if($_POST){           
            $this->step1();
            return;
        }
        
        $this->load->view('search/index');
    }
    
    public function step1($zxcode=0){
        if($_POST){
            $zxcode = $this->input->post('zxcode');
            var_dump($zxcode);
            
            return;
        }
        
        $this->load->view('search/index');
    }
    
    public function step2(){
        if($_POST){
            $sqcode = $this->input->post('sqcode');
            var_dump($sqcode);
            
            return;
        }
        
        
    }
    
    
    
    
    
}

//End of file search.php