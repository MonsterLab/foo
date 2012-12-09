<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
        $this->load->helper('url');
       
        $this->load->model('M_user_base','jc');     //基础
        $this->load->model('M_talent','rc');        //人才
        $this->load->model('M_topic','zt');         //主体
        $this->load->model('M_medium','zj');         //中介
    }
    
    public function index(){
        if(isset($_GET)){
            $this->step1();
            
            return;
        }
        
        if($_GET['step'] == 1){
            $this->step1();
            
            return;
        }
        
        if($_GET['step'] == 2){
            $this->step2();
            
            return;
        }
        
    }
    
    public function step1(){
        $data = array(
            'zxcode' => 0,
            'com_name' => 'unknown'            
        );
        
        if($_POST){
            $data['zxcode'] = $this->input->post('zxcode');
            $fooUserBase = $this->jc->search($data['zxcode'],1);
            
            if($fooUserBase == FALSE){
                redirect(base_url('search/index'));
            }
            
            /*TODOs
             * search 方法不返回type，数据库中无type字段
             */
            
            //var_dump($fooUserBase);
            
            $fooType = $fooUserBase['0']['type'];
            $fooUID = $fooUserBase['0']['id'];
            
            //topic、medium、talent 
            if($fooType == 'topic'){
                $fooTopic = $this->zt->searchCertBase($fooUID);
                $data['com_name'] = $fooTopic['com_name'];
            }
            if($fooType == 'medium'){
                $fooTopic = $this->zt->searchCertBase($fooUID);
                $data['com_name'] = $fooTopic['com_name'];
            }           
            if($fooType == 'talent'){
                $fooTopic = $this->zt->searchCertBase($fooUID);
                $data['com_name'] = $fooTopic['cert_name'];
            }           
            
            $this->load->view('search/step2',$data);
            
            return;
        }
        
        $this->load->view('search/step1');
    }
    
    public function step2(){
        $data = array(
            'zxcode' => 0,
            'com_name' => 'known'            
        );
        
        if($_POST){
            $data['zxcode'] = $this->input->post('zxcode');
            $data['sqcode'] = $this->input->post('sqcode');
            
            $fooUserBase = $this->jc->search($data['zxcode'],1);
            
            if($fooUserBase == FALSE){
                redirect(base_url('search/index'));
            }
            
            /*TODOs
             * search 方法不返回type，数据库中无type字段
             */
            
            $fooType = $fooUserBase['0']['type'];
            $fooUID = $fooUserBase['0']['id'];
            
            //topic、medium、talent 
            if($fooType == 'topic'){
                $fooTopic = $this->zt->searchCertBase($fooUID);
                $data['com_name'] = $fooTopic['com_name'];
                $data['test'] = $fooTopic;
            }
            if($fooType == 'medium'){
                $fooTopic = $this->zt->searchCertBase($fooUID);
                $data['com_name'] = $fooTopic['com_name'];
            }           
            if($fooType == 'talent'){
                $fooTopic = $this->zt->searchCertBase($fooUID);
                $data['com_name'] = $fooTopic['cert_name'];
            }           
            
            $this->load->view('search/step2res',$data);
            
            return;
        }
        
            $this->load->view('search/step2');
        }
        
        
    
    
    
    
    
    
}

//End of file search.php