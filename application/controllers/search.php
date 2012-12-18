<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
        $this->load->helper('url');
       
        $this->load->model('M_user_base','userbase');       //基础
        $this->load->model('M_talent','talent');            //人才
        $this->load->model('M_topic','topic');              //主体
        $this->load->model('M_medium','medium');            //中介
    }
    
    public function index(){
        if(isset($_GET)){
            $this->step1();
            
            return;
        }
        
//        if($_GET['step'] == 1){
//            $this->step1();
//            
//            return;
//        }
//        
//        if($_GET['step'] == 2){
//            $this->step2();
//            
//            return;
//        }
        
    }
    
    public function step1(){
        $data = array(
            'flag'=>'',
            'zxcode' => 0,
            'com_name' => 'unknown'            
        );
        if($_POST){
            $fooZxcode = $this->input->post('zxcode');
            if($fooZxcode == NULL){  
                $data['flag'] = '请完善信息！';
                $this->load->view('cms/index',$data);
                //$this->load->view('search/step1',$data);
                return;
            }
            $fooUserBase = $this->userbase->search($fooZxcode,1);
            //var_dump($fooUserBase);
            
            if($fooUserBase == FALSE){
                $data['flag'] = '客户不存在！';
                $this->load->view('cms/index',$data);
                return;
            }
            
            $fooType = $fooUserBase['0']['type'];           //被查询客户的征信库类型
            $fooUID = $fooUserBase['0']['id'];              //被查询客户的id
            
            //topic、medium、talent 
            if($fooType == 'topic'){
                $fooResult = $this->topic->searchCertBase($fooUID);
            }
            if($fooType == 'medium'){
                $fooResult = $this->medium->searchCertBase($fooUID);
            }           
            if($fooType == 'talent'){
                $fooResult = $this->talent->searchCertBase($fooUID);
            }           
            
            
            $fooUserBase[0]['com_name'] = $fooResult[0]['com_name'];
            
            $data['userBases'] = $fooUserBase;
            $data['zxcode'] = $fooZxcode;
            $this->load->view('search/step2',$data);
            
            
        }  else {#end of post
            
            $this->load->view('cms/index',$data);
        }
    }
    
    public function step2(){
        $data = array(
            'flag'=>'',
            'zxcode' => 0,
            'com_name' => 'known'
        );
        
        if($_POST){
            $data['zxcode'] = $this->input->post('zxcode');
            $data['sqcode'] = trim($this->input->post('sqcode'));
            
            if($data['sqcode'] == NULL){
                $data['flag'] = '请完善信息！';
                $this->load->view('search/step2',$data);
                return;
            }
            $fooUserBase = $this->userbase->search($data['zxcode'],1);
            
            if($fooUserBase == FALSE){
                redirect(base_url('search/index'));
            }
            $fooSqcode = $fooUserBase[0]['sq_code'];
            $fooType = $fooUserBase['0']['type'];
            $fooUID = $fooUserBase['0']['id'];
            
            if($fooSqcode != $data['sqcode']){
                $data['flag'] = '授权码错误！';
                $this->load->view('search/step2',$data);
                return;
            }
            //topic、medium、talent 
            if($fooType == 'topic'){
                $fooBase = $this->topic->searchCertBase($fooUID);
                $fooContent = $this->topic->searchCertContent($fooUID);
                $fooFile = $this->topic->searchCertFile($fooUID);

            }
            if($fooType == 'medium'){

                $fooBase = $this->medium->searchCertBase($fooUID);
                $fooContent = $this->medium->searchCertContent($fooUID);
                $fooFile = $this->medium->searchCertFile($fooUID);

            }           
            if($fooType == 'talent'){
                $fooBase = $this->talent->searchCertBase($fooUID);
                $fooContent = $this->talent->searchCertContent($fooUID);
                $fooFile = $this->talent->searchCertFile($fooUID);

            }           

            $data['userBases'] = $fooUserBase;
            $data['certBases'] = $fooBase;
            $data['certContents'] = $fooContent;
            $data['certFiles'] = $fooFile;
            
            $this->load->view('search/step2res',$data);
            
        }  else {
            
            redirect(base_url('search/index'));
        }
    }
    
//    public function showUserInfos(){
//        
//        if($fooType == 'topic'){
//            $fooBase = $this->topic->searchCertBase($fooUID);
//            $fooContent = $this->topic->searchCertContent($fooUID);
//            $fooFile = $this->topic->searchCertFile($fooUID);
//
//        }
//        if($fooType == 'medium'){
//
//            $fooBase = $this->medium->searchCertBase($fooUID);
//            $fooContent = $this->medium->searchCertContent($fooUID);
//            $fooFile = $this->medium->searchCertFile($fooUID);
//
//        }           
//        if($fooType == 'talent'){
//            $fooBase = $this->talent->searchCertBase($fooUID);
//            $fooContent = $this->talent->searchCertContent($fooUID);
//            $fooFile = $this->talent->searchCertFile($fooUID);
//
//        }           
//
//        $data['userBases'] = $fooUserBase;
//        $data['certBases'] = $fooBase;
//        $data['certContents'] = $fooContent;
//        $data['certFiles'] = $fooFile;
//
//        $this->load->view('search/step2res',$data);
//    }
    
}

//End of file search.php