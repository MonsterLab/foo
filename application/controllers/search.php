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
        $this->load->model('M_cms','cms');
        $this->load->library('Page');
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
        $nav = $this->echoMenu();
        $data['nav'] = $nav['subPage'];
        $data['footer'] = '版权所有&copy中国经济网';
        
        if($_POST){
            $fooZxcode = $this->input->post('zxcode');
            if($fooZxcode == NULL){  
                $data['flag'] = '请完善信息！';
                $this->load->view('cms/index',$data);
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
            
            
            $this->load->view('cms/v_header', $data);
            $this->load->view('search/step2',$data);
            $this->load->view('cms/v_footer', $data);
            
            
            
            
        }  else {#end of post
            
            redirect(base_url('cms/index/'));
        }
    }
    
    public function step2(){
        $data = array(
            'flag'=>'',
            'zxcode' => 0,
            'com_name' => 'unknown'
        );
         $nav = $this->echoMenu();
        $data['nav'] = $nav['subPage'];
        $data['footer'] = '版权所有&copy中国经济网';
        
        if($_POST){
            $data['zxcode'] = $this->input->post('zxcode');
            $data['sqcode'] = trim($this->input->post('sqcode'));
            
            if($data['sqcode'] == NULL){
                $data['flag'] = '请完善信息！';
                $this->load->view('cms/v_header', $data);
                $this->load->view('search/step2',$data);
                $this->load->view('cms/v_footer', $data);
                return;
            }
            $fooUserBases = $this->userbase->search($data['zxcode'],1);
            
            if($fooUserBases == FALSE){
                redirect(base_url('cms/index'));
            }
            $fooSqcode = $fooUserBases[0]['sq_code'];
            $uid = $fooUserBases['0']['id'];
            
            if($fooSqcode != $data['sqcode']){
                $data['flag'] = '授权码错误！';
                $this->load->view('cms/v_header', $data);
                $this->load->view('search/step2',$data);
                $this->load->view('cms/v_footer', $data);
                return;
            }
            
            $this->showUserInfos($uid);
            
            
        }  else {
            
            redirect(base_url('cms/index'));
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
            foreach ($_array as $array){
                $id = $array['industry_id'];
                $fooIndustrys = $this->zxpool->searchIndustry($id,2);
                $array['industry_name'] = $fooIndustrys[0]['industry_name'];
                     
                $fooResult[] = $array;
            }
            
            return $fooResult;
        } 
        
    }
    
    
    public function showUserInfos($uid){
        $data = array(
            'flag'=>'',
            'zxcode' => 0,
            'com_name' => 'unknown'
        );
        
        $fooUserBases = $this->userbase->search($uid,3);
        $type = $fooUserBases[0]['type'];
        //topic、medium、talent 
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

        $data['type'] = $type;
        $data['uid'] = $uid;
        $data['userBases'] = $fooUserBases;
        $data['certBases'] = $fooCertBases;
        $data['certFiles'] = $fooCertFiles;
        $data['certContents'] = $fooCertContent;

        $nav = $this->echoMenu();
        $data['nav'] = $nav['subPage'];
        $data['footer'] = '版权所有&copy中国经济网';

        $this->load->view('cms/v_header', $data);
        $this->load->view('search/step2res',$data);
        $this->load->view('cms/v_footer', $data);
        
    }
    
    public function showContent($type,$uid){
        if($type == 'topic'){
            $fooCertContent = $this->topic->searchCertContent($uid);
        }
        if($type == 'medium'){
            $fooCertContent = $this->medium->searchCertContent($uid);
        }
        if($type == 'talent'){
            $fooCertContent = $this->talent->searchCertContent($uid);
        }
        $data['title'] = $fooCertContent[0]['title'];
        $data['content'] = $fooCertContent[0]['content'];
        $data['uid'] = $uid;
        
        $nav = $this->echoMenu();
        $data['nav'] = $nav['subPage'];
        $data['footer'] = '版权所有&copy中国经济网';

        $this->load->view('cms/v_header', $data);
        $this->load->view('search/v_showContent',$data);
        $this->load->view('cms/v_footer', $data);
        
    }
    
    private function getGuide($gid, $groups){
        $guide = '<ul class="sub">';
        foreach ($groups as $father){
            if($father['groupfather_id'] == $gid){
                $guide .= '<li><a href="'.  base_url('cms/showList/'.$father['group_url'].'/'.$father['gid']).'">'.$father['group_name'].'</a></li>';
                $this->getGuide($father['gid'], $groups);
            }
        }
        $guide .= '</ul>';
        if($guide == '<ul></ul>'){
            return '';
        }
        
        return $guide;
    }
    private function echoMenu(){
        $uid = 0;
        $status = 1;
        $groups = $this->cms->getAllGroups($uid, $status);
        $fatherGid = 0;
        // search for father 
        foreach ($groups as $father){
            if($father['group_name'] == '首页'){
                $fatherGid = $father['gid'];
                break;
            }
        }
        
        //添加相反了之后把数组倒置
        $groupsCopy;
        for($i = count($groups) - 1; $i >= 0; $i--){
            $groupsCopy[] = $groups[$i];
        }
        $groups = $groupsCopy;
        $guideIndex = '';
        $guideSub = '';  
        $indexguideHead = '<ul id="guide">';
        $subguideHead = '<ul class="daohang">';
        foreach ($groups as $father){
            if($father['groupfather_id'] == $fatherGid){
                $guideIndex .= '<li><a href="'.base_url('cms/showList/'.$father['group_url'].'/'.$father['gid']).'">'.$father['group_name'].'</a></li>';
                $guideSub .= '<li class="main"><a href="'.base_url('cms/showList/'.$father['group_url'].'/'.$father['gid']).'">'.$father['group_name'].'</a>';
                $guideSub .= $this->getGuide($father['gid'], $groups);
                $guideSub .= '</li>';
            }
        }
        $guideEnd = '<li><a href="'.base_url('space/login').'">用户登录</a></li>';
        $guideEnd .='<li class="returnI"><a href="'.base_url('cms/index').'">返回平台首页</a></li>';
        $guideEnd .= '</ul>';
        
        $indexPage = $indexguideHead.$guideIndex.$guideEnd;
        $subPage = $subguideHead.$guideSub.$guideEnd;
        $data = array(
            'index' => $indexPage,
            'subPage' => $subPage
        );
        
        return $data;
    }
    
}

//End of file search.php