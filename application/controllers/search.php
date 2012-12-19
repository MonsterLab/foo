<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
        $this->load->helper('url');
       
        $this->load->model('M_user_base','userbase');       //基础
        $this->load->model('M_zxpool','zxpool');            //
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
            $fooIsAudit = $fooUserBase['0']['audit'];       //用户是否通过审核
            
            //topic、medium、talent 
            if($fooType == 'topic'){
                $fooResult = $this->topic->searchCertBase($fooUID);
                $fooUserBase[0]['cert_name'] = $fooResult[0]['com_name'];
            }
            if($fooType == 'medium'){
                $fooResult = $this->medium->searchCertBase($fooUID);
                $fooUserBase[0]['cert_name'] = $fooResult[0]['com_name'];
            }           
            if($fooType == 'talent'){
                $fooResult = $this->talent->searchCertBase($fooUID);
                $fooUserBase[0]['cert_name'] = $fooResult[0]['cert_name'];
            }           
            
            
            
            
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
            $type = $fooUserBase['0']['type'];
            $uid = $fooUserBase['0']['id'];
            
            if($fooSqcode != $data['sqcode']){
                $data['flag'] = '授权码错误！';
                $this->load->view('search/step2',$data);
                return;
            }
            //topic、medium、talent 
            $fooUserBases = $this->userbase->search($uid,3);                    //按id搜索,获得客户基本信息
            if($type == 'topic'){
                $fooCertBase = $this->topic->searchCertBase($uid);             //获得认证基本信息
                $fooCertBases = $this->turnIndustryidtoName($fooCertBase);

                $fooCertFile = $this->topic->searchCertFile($uid);             //获得认证扫描信息
                $fooCertFiles = $this->turnFileTypeidtoName($fooCertFile);

                $fooCertContent = $this->topic->searchCertContent($uid);        //获得认证文字类信息
            }
            if($type == 'medium'){
                $fooCertBase = $this->medium->searchCertBase($uid);             //获得认证基本信息
                $fooCertBases = $this->turnIndustryidtoName($fooCertBase);

                $fooCertFile = $this->medium->searchCertFile($uid);             //获得认证扫描信息
                $fooCertFiles = $this->turnFileTypeidtoName($fooCertFile);

                $fooCertContent = $this->medium->searchCertContent($uid);
            }
            if($type == 'talent'){
                $fooCertBases = $this->talent->searchCertBase($uid);             //获得认证基本信息

                $fooCertFile = $this->talent->searchCertFile($uid);             //获得认证扫描信息
                $fooCertFiles = $this->turnFileTypeidtoName($fooCertFile);

                $fooCertContent = $this->talent->searchCertContent($uid);
            }
    //        echo $type;
    //        
    //        echo "<pre>";
    //        print_r($fooUserBases);
    //        echo "</pre>";
    //        
    //        echo "<pre>";
    //        print_r($fooCertBases);
    //        echo "</pre>";
    //        
    //        echo "<pre>";
    //        print_r($fooCertFiles);
    //        echo "</pre>";
    //        
    //        echo "<pre>";
    //        print_r($fooCertContent);
    //        echo "</pre>";
    //        
    //        exit();


            $data['userBases'] = $fooUserBases;
            $data['certBases'] = $fooCertBases;
            $data['certFiles'] = $fooCertFiles;
            $data['certContents'] = $fooCertContent;
            
            $this->load->view('search/step2res',$data);
            
        }  else {
            
            redirect(base_url('search/index'));
        }
    }
    
    /**
     * 认证扫描件中的FileTypeid转换为name
     * @param type $_array
     * @return type
     * 
     * $certBases
     */
    private function turnFileTypeidtoName($_array){
        //
        if($_array){
            foreach ($_array as $array){
                $id = $array['file_type_id'];
                $fooFiletype = $this->zxpool->searchFileType($id,2);
                $array['file_type_name'] = $fooFiletype[0]['file_name'];
                     
                $fooResult[] = $array;
            }
            
            return $fooResult;
        } 
        
    }
    
    /**
     * 将认证基本信息中的Industryid转换为name
     * @param type $_array
     * @return type
     * 
     * $certBases
     */
    private function turnIndustryidtoName($_array){
        //
        if($_array){
            echo '<pre>';
            print_r($_array);
            echo '</pre>';
            foreach ($_array as $array){
                $id = $array['industry_id'];
                $fooIndustrys = $this->zxpool->searchIndustry($id,2);
                $array['industry_name'] = $fooIndustrys[0]['industry_name'];
                     
                $fooResult[] = $array;
            }
            
            return $fooResult;
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