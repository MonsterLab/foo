<?php
class Space extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('M_space', 'space');
        $this->load->model('M_user_base', 'userbase');
        $this->load->model('M_medium','medium');
        $this->load->model('M_talent','talent');
        $this->load->model('M_topic','topic');
        $this->load->library('Page');
    }
    
    public function index($uid =0){
        if($uid <= 0){
            redirect(base_url('space/login/'));
        }
        $column = $this->getContentOfColumn($uid);
        $nav = $this->echoMenu($uid);
        $username = $this->getUsername($uid);
        
        $data['uid'] = $uid;
        $data['username'] = $username;
        $data['nav'] = $nav['subPage'];
        $data['column'] = $column;
        $data['footer'] = '版权所有&copy;中国经济网';
        
        $this->load->view('space/v_header', $data);
        $this->load->view('space/index', $data);
        $this->load->view('space/v_footer', $data);
        
    }
    
    private function getUsername($uid){
        $fooUserBases = $this->userbase->search($uid,3);            //按id查询
        $fooType = $fooUserBases[0]['type'];
        $username = '';
        if($fooType == 'topic'){
            $fooCertBases = $this->topic->searchCertBase($uid);             //获得认证基本信息
            $username = $fooCertBases[0]['com_name'];
        }
        if($fooType == 'medium'){
            $fooCertBases = $this->medium->searchCertBase($uid);
            $username = $fooCertBases[0]['com_name'];
        }
        if($fooType == 'talent'){
            $fooCertBases = $this->talent->searchCertBase($uid);
            $username = $fooCertBases[0]['cert_name'];
        }
        
        return $username;
    }


    private function getContentOfColumn($uid){
        $data = array();
        $space_uid = $uid;
        $uid = 0;
        $status = 1;
        $groups = $this->space->getAllSGroups($uid, $status);
        $fatherGid = 0;
        // search for father 
        $gszsGid = 0;       //公司展示
        $qyjsGid = 0;       //企业介绍
        $qywhGid = 0;       //企业文化
        $rlzyGid = 0;       //人力资源
        $zxbdGid = 0;       //最新报导
        foreach ($groups as $father){
            if($father['space_group_name'] == '公司展示'){
                $gszsGid = $father['space_gid'];
            }
            if($father['space_group_name'] == '企业介绍'){
                $qyjsGid = $father['space_gid'];
            }
            if($father['space_group_name'] == '企业文化'){
                $qywhGid = $father['space_gid'];
            }
            if($father['space_group_name'] == '人力资源'){
                $rlzyGid = $father['space_gid'];
            }
            if($father['space_group_name'] == '最新报导'){
                $zxbdGid = $father['space_gid'];
            }
        }
        //first 公司展示
        $groupids = $this->getChildGid($space_uid, $gszsGid);

        $groupids[] = $gszsGid;     //add own gid 
        $method = 2;        //the method si getSArticlesOfGroup()
        $limit = 'start';
        $offset = 'end';
        $status = 1;
        //$key,$method,$space_status = 1,$limit=0,$offset = 5 , $space_audit = 0
        $space_audit = 1;
        $aritcles = $this->space->searchS($groupids, $method, $status, $limit, $offset, $space_audit, $space_uid);

        $gszs = '<ul>';
        foreach ($aritcles as $aritcle){
            $gszs .= '<li><a href="'.base_url('space/article/'.$space_uid.'/'.$aritcle['space_groupid'].'/'.$aritcle['space_aid']).'">'.$aritcle['space_title'].'</a></li>';
        }
        $gszs .= '</ul>';
        
        $data['gszs'] = $gszs;
        
        
        //second 企业介绍
        $groupids = $this->getChildGid($space_uid, $qyjsGid);

        $groupids[] = $qyjsGid;     //add own gid 
        $aritcles = $this->space->searchS($groupids, $method, $status, $limit, $offset, $space_audit, $space_uid);
        
        $qyjs = '<ul>';
        foreach ($aritcles as $aritcle){
            $qyjs .= '<li><a href="'.base_url('space/article/'.$space_uid.'/'.$aritcle['space_groupid'].'/'.$aritcle['space_aid']).'">'.$aritcle['space_title'].'</a></li>';
        }
        $qyjs .= '</ul>';
        $data['qyjs'] = $qyjs;
        
        //third 企业文化
        $groupids = $this->getChildGid($space_uid, $qywhGid);

        $groupids[] = $qywhGid;     //add own gid 
        $aritcles = $this->space->searchS($groupids, $method, $status, $limit, $offset, $space_audit, $space_uid);
        
        $qywh = '<ul>';
        foreach ($aritcles as $aritcle){
            $qywh .= '<li><a href="'.base_url('space/article/'.$space_uid.'/'.$aritcle['space_groupid'].'/'.$aritcle['space_aid']).'">'.$aritcle['space_title'].'</a></li>';
        }
        $qywh .= '</ul>';
        $data['qywh'] = $qywh;
        
        //forth 人力资源
        $groupids = $this->getChildGid($space_uid, $rlzyGid);

        $groupids[] = $rlzyGid;     //add own gid 
        $aritcles = $this->space->searchS($groupids, $method, $status, $limit, $offset, $space_audit, $space_uid);
        
        $rlzy = '<ul>';
        foreach ($aritcles as $aritcle){
            $rlzy .= '<li><a href="'.base_url('space/article/'.$space_uid.'/'.$aritcle['space_groupid'].'/'.$aritcle['space_aid']).'">'.$aritcle['space_title'].'</a></li>';
        }
        $rlzy .= '</ul>';
        $data['rlzy'] = $rlzy;
        
        //fifth 最新报导
        $groupids = $this->getChildGid($space_uid, $zxbdGid);

        $groupids[] = $zxbdGid;     //add own gid 
        $aritcles = $this->space->searchS($groupids, $method, $status, $limit, $offset, $space_audit, $space_uid);
        
        $zxbd = '<ul>';
        foreach ($aritcles as $aritcle){
            $zxbd .= '<li><a href="'.base_url('space/article/'.$space_uid.'/'.$aritcle['space_groupid'].'/'.$aritcle['space_aid']).'">'.$aritcle['space_title'].'</a></li>';
        }
        $zxbd .= '</ul>';
        $data['zxbd'] = $zxbd;
        
        return $data;
        
    }

    /**
     * 用户空间登录
     * @return type
     */
    public function login(){
        $data['flag'] = ''; 
        
        if($_POST){
            $uid = 0;
            print_r($_POST);
                //echo '<script> alert("'.base_url("space/index/".$uid).'");</script>';
            $username = trim($this->input->post('username'));
            $userpassword = trim($this->input->post('password'));
            
            if($username == NULL || $userpassword == NULL){
                $data['flag'] = '请完善信息!';
                $this->load->view('space/login',$data);
                return;
            }
            
            $fooLogin = $this->userbase->login($username,$userpassword);

            if($fooLogin == -1){
                $data['flag'] = '不存在此用户!';
                $this->load->view('space/login',$data);
                return;
            }
            if($fooLogin == 0){
                $data['flag'] = '密码错误!';
                $this->load->view('space/login',$data);
                return;
            }
            if($fooLogin == 1){
                
                $uid = $_SESSION['user']['id'];
                
                redirect(base_url("space/index/".$uid));
            } 
            
            return;
        }
        
        $this->load->view('space/login',$data);
       
        
    }

    /**
     * 登出
     */
    public function logout(){
        $this->userbase->logout();
        redirect(base_url('space/login/'));
    }
    
    private function echoMenu($uid){
        $space_uid = $uid;
        $uid = 0;
        $status = 1;
        $groups = $this->space->getAllSGroups($uid, $status);
        $fatherGid = 0;
        // search for father 
        foreach ($groups as $father){
            if($father['space_group_name'] == '首页'){
                $fatherGid = $father['space_gid'];
                break;
            }
        }
        
        //添加相反了之后把数组倒置
//        $groupsCopy;
//        for($i = count($groups) - 1; $i >= 0; $i--){
//            $groupsCopy[] = $groups[$i];
//        }
//        $groups = $groupsCopy; 
        $guideIndex = '';
        $guideSub = '';  
        $indexguideHead = '<ul id="guide">';
        $subguideHead = '<ul class="daohang">';
        foreach ($groups as $father){
            if($father['space_groupfather_id'] == $fatherGid){
                $guideIndex .= '<li><a href="'.base_url('space/showList/'.$space_uid.'/'.$father['space_group_url'].'/'.$father['space_gid']).'">'.$father['space_group_name'].'</a></li>';
                $guideSub .= '<li class="main"><a href="'.base_url('space/showList/'.$space_uid.'/'.$father['space_group_url'].'/'.$father['space_gid']).'">'.$father['space_group_name'].'</a>';
                $guideSub .= $this->getGuide($father['space_gid'], $groups);
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
    
    private function getGuide($gid, $groups){
        $guide = '<ul class="sub">';
        foreach ($groups as $father){
            if($father['space_groupfather_id'] == $gid){
                $guide .= '<li><a href="'.base_url('space/showList/'.$father['space_group_url'].'/'.$father['space_gid'].'/'.$space_uid).'">'.$father['space_group_name'].'</a></li>';
                $this->getGuide($father['space_gid'], $groups);
            }
        }
        $guide .= '</ul>';
        if($guide == '<ul></ul>'){
            return '';
        }
        
        return $guide;
    }
    
    
    public function article($space_uid, $space_groupid, $aid){
        $method = 1;    //the method is get a article
        $space_status = 1;
        $limit= 'start';
        $offset = 'end';
        $space_audit = 1;
        $article = $this->space->searchS($aid, $method, $space_status, $limit, $offset, $space_audit);
        $gid = $article[0]['space_groupid'];
        $guide = $this->getGuideByGid($space_uid, $gid);
        $column = $this->getContentOfColumn($space_uid);
        $nav = $this->echoMenu($space_uid);
        $username = $this->getUsername($space_uid);
        
        $data['uid'] = $space_uid;
        $data['username'] = $username;
        $data['column'] = $column;
        $data['nav'] = $nav['subPage'];
        $data['article'] = $article;
        $data['guide'] = $guide;
        $data['footer'] = '版权所有&copy;中国经济网';
        
        $this->load->view('space/v_header', $data);
        $this->load->view('space/article', $data);
        $this->load->view('space/v_footer', $data);
    }
    
    public function showList( $space_uid = 0, $space_url = '', $gid = 0){
        echo $space_uid;
        //TODO nav
        //make a nav for the group
        $guide = $this->getGuideByGid($space_uid, $gid);

        //getGroupByGroupfather($groupfather_id, $status = 1){
        $groupids = $this->getChildGid($space_uid, $gid);
        
        $groupids[] = $gid;     //add own gid 
        $method = 2;        //the method si getSArticlesOfGroup()
        $limit = 'start';
        $offset = 'end';
        $status = 1;
        //$key,$method,$space_status = 1,$limit=0,$offset = 5 , $space_audit = 0
        $space_audit = 1;
        $aritcles = $this->space->searchS($groupids, $method, $status, $limit, $offset, $space_audit);
        $page = new Page(count($aritcles));
        $limit = $page->getLimit();
        $offset = $page->getOffset();
        $aritcles = $this->space->searchS($groupids, $method, $status, $limit, $offset, $space_audit);
        $pageBar = $page->getPage($aritcles);
        
        $articlesHtml = '<ul>'; 
        if(!empty($aritcles)){
            foreach ($aritcles as $row){
                $time = $row['space_ctime'];
                $time = substr($time, 0, 10);
                $articlesHtml .= '<li><span>'.$time.'</span><a href="'.base_url('space/article/'.$space_uid.'/'.$row['space_groupid'].'/'.$row['space_aid']).'">'.$row['space_title'].'</a></li>';
            }
        } else {
            $articlesHtml .= '<li>该栏目下没有文章</li>';
        }
        $aritcles .= '</ul>';
        
        $column = $this->getContentOfColumn($space_uid);
        $nav = $this->echoMenu($space_uid);
        $username = $this->getUsername($space_uid);
        
        $data['uid'] = $space_uid;
        $data['username'] = $username;
        $data['column'] = $column;
        $data['nav'] = $nav['subPage'];        
        $data['guide'] = $guide;
        $data['pageBar'] = $pageBar;
        $data['articlesHtml'] = $articlesHtml;
        $data['footer'] = '版权所有&copy;中国经济网';
        
        $this->load->view('space/v_header', $data);
        $this->load->view('space/showList', $data);
        $this->load->view('space/v_footer', $data);
        
    }
    
    /**
     * this method is used for get the child gids of a gid,and contains itself
     * @param type $gid
     * @return array the clildGids
     */
    private function getChildGid($space_uid, $gid){
        $childGids = array();
        $result = $this->space->getSGroupByGroupfather($gid);
        if(!empty($result)){
            foreach ($result as $row){
                $childGids[] = $row['space_gid'];
                $gid = $row['space_gid'];
                $this->getChildGid($gid);
            }
        } else {
            return $childGids;
        }
        
        return $childGids;
    }
    
    /**
     * this method is used for get the guide for the chosen group
     * @param type $gid
     * @return string the guide string
     */
    private function getGuideByGid($space_uid, $gid){
        $groupfather_id = -1;
        $guide = '';
        while (1){
            //  public function getGroupByGid($gid, $status = 1){
            $result = $this->space->getSGroupByGid($gid);
            //print_r($result);
            if(!empty($result)){
               $groupfather_id = $result[0]['space_groupfather_id'];
               if($groupfather_id != -1){       //it's not the root of column
                   $gid = $groupfather_id;
                   $guide = '<a href="'.base_url('space/showList/'.$space_uid.'/'.$result[0]['space_group_url'].'/'.$result[0]['space_gid']).'">'.$result[0]['space_group_name'].'</a>>>'.$guide;
               } else {
                   $guide = '<a href="'.base_url('space/index/'.$space_uid).'">首页</a>>>'.$guide;
                   break;
               }
            } else {
                break;
            }
            
        }
        $guide = substr($guide, 0, strlen($guide)-2);       //the end has two charactor 
        return $guide;
    }
    
    
    public function edit($space_uid){
        $power = $this->userbase->getPower();
        if(!$power){
            redirect(base_url('space/login/'));
        }
        $nav = $this->echoMenu($space_uid);
        $username = $this->getUsername($space_uid);
        $uid = $space_uid;
        $space_status = 1;
        $uidadmin = 0;          // get all groups
        $space_groups = $this->space->getAllSGroups($uidadmin, $space_status);
        $data['space_groups'] = $space_groups;
        $data['uid'] = $uid;
        $data['uid'] = $space_uid;
        $data['username'] = $username;
        $data['nav'] = $nav['subPage']; 
        $data['footer'] = '版权所有&copy;中国经济网';
        if(isset($_POST['sub'])){
            $space_groupid = $this->input->post('space_gid');
            $space_title = $this->input->post('space_title');
            $space_content = $this->input->post('space_content'); 
            $space_uid = $uid;
            $method = 3;    //search user by uid
            $res = $this->userbase->search($space_uid, $method);
            $space_username = $res[0]['username'];
            $result = $this->space->createS($space_uid ,$space_username  ,$space_title, $space_content, $space_groupid);

            if($result){
                $data['flag'] = 1;
                $data['message'] = '添加成功,等待管理员审核后可显示';    
                $data['space_gid'] = $space_groupid;

                $this->load->view('space/v_header', $data);
                $this->load->view('space/v_edit', $data);
                $this->load->view('space/v_footer', $data);
            } else {
                $data['flag'] = 0;
                $data['message'] = '添加失败';
                $data['gid'] = $groupid;
                $data['title'] = $title;
                $data['content'] = $content;

                $this->load->view('space/v_header', $data);
                $this->load->view('space/v_edit', $data);
                $this->load->view('space/v_footer', $data);
            }

        } else {         
            $this->load->view('space/v_header', $data);
            $this->load->view('space/v_edit', $data);
            $this->load->view('space/v_footer', $data);
        }
    }
}