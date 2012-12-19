<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('M_cms','cms');
        $this->load->helper(array('url'));
        $this->load->library('Page');
    }
    
    /**
     * this is a interface for common user
     */
    public function index(){
        $guide = $this->echoMenu();
        $data['guide'] = $guide['index'];       
                
        $this->load->view('cms/index', $data);
    }
    
    private function getRightColumn(){
        $data = array(
            'zxjj' => '',
            'zxfw' => '',
            'bslc' => ''
        );
        $uid = 0;
        $status = 1;
        $groups = $this->cms->getAllGroups($uid, $status);
        $gid = 0;
        // search for father 
        //first 中心简介
        $zxjjGid = 0;   //中心简介
        $zjfwGid = 0;   //征信范围
        $bslcGid = 0;   //办事流程
        foreach ($groups as $father){
            if($father['group_name'] == '中心简介'){
                $zxjjGid = $father['gid'];
            }
            if($father['group_name'] == '征信范围'){
                $zjfwGid = $father['gid'];
            } 
            if($father['group_name'] == '办事流程'){
                $bslcGid = $father['gid'];
            }
        }
        
        $groupids = $this->getChildGid($zxjjGid);
        $groupids[] = $zxjjGid;     //add own gid 
        $method = 2;        //the method si getArticlesOfGroup()
        $limit = 'start';
        $offset = 'end';
        $status = 1;
        $audit = 1;
        $aritcles = $this->cms->search($groupids, $method, $status, $limit, $offset, $audit);
        
        $zxjj = '<ul>';
        foreach ($aritcles as $aritcle){
            $title = $aritcle['title'];
            $title = substr($title, 0, 30);
            $title = strlen($title) > 30? $title.'...' : $title;
            $zxjj .= '<li><a href="'.  base_url('cms/article/'.$aritcle['aid']).'">'.$title.'</a></li>';
        }
        $zxjj .= '</ul>';
        $data['zxjj'] = $zxjj;

        //second 征信范围
        $groupids = $this->getChildGid($zjfwGid);
        $groupids[] = $zjfwGid;     //add own gid 
        $aritcles = $this->cms->search($groupids, $method, $status, $limit, $offset, $audit);
        
        $zxfw = '<ul>';
        foreach ($aritcles as $aritcle){
            $title = $aritcle['title'];
            $title = substr($title, 0, 30);
            $title = strlen($title) > 30? $title.'...' : $title;
            $zxfw .= '<li><a href="'.  base_url('cms/article/'.$aritcle['aid']).'">'.$title.'</a></li>';
        }
        $zxfw .= '</ul>';
        $data['zxfw'] = $zxfw;
        
        //third 办事流程
        $groupids = $this->getChildGid($bslcGid);
        $groupids[] = $bslcGid;     //add own gid 
        $aritcles = $this->cms->search($groupids, $method, $status, $limit, $offset, $audit);
        
        $bslc = '<ul>';
        foreach ($aritcles as $aritcle){
            $title = $aritcle['title'];
            $title = substr($title, 0, 30);
            $title = strlen($title) > 30? $title.'...' : $title;
            $bslc .= '<li><a href="'.  base_url('cms/article/'.$aritcle['aid']).'">'.$title.'</a></li>';
        }
        $bslc .= '</ul>';
        $data['bslc'] = $bslc;

        return $data;
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

    public function article($aid){
        //TODO nav
        $method = 1;    //the method is get a article
        $limit = 'start';
        $offset = 'end';
        $status = 1;
        $audit = 1;
        //$status = 1,$limit=0,$offset = 5, $audit = 0
        $article = $this->cms->search($aid, $method, $status, $limit, $offset, $audit);
        $gid = $article[0]['groupid'];
        $guide = $this->getGuideByGid($gid);
        
        //get right column
        $rightColumn = $this->getRightColumn();
        
        $data['article'] = $article;
        $data['guide'] = $guide;
        $data['rightColumn'] = $rightColumn;
        
        $nav = $this->echoMenu();
        $data['nav'] = $nav['subPage'];
        $data['footer'] = '版权所有&copy中国经济网';
        
        $this->load->view('cms/v_header', $data);
        $this->load->view('cms/article', $data);
        $this->load->view('cms/v_footer', $data);
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
    
    public function showList($group_url ='', $gid = 0){
        //TODO nav
        //make a nav for the group
        $guide = $this->getGuideByGid($gid);
        //getGroupByGroupfather($groupfather_id, $status = 1){
        $groupids = $this->getChildGid($gid);
        $groupids[] = $gid;     //add own gid 
        $method = 2;        //the method si getArticlesOfGroup()
        $limit = 'start';
        $offset = 'end';
        $status = 1;
        //search($key,$method,$status = 1,$limit=0,$offset = 5 ){
        $audit = 1;
        $aritcles = $this->cms->search($groupids, $method, $status, $limit, $offset, $audit);
        
        $page = new Page(count($aritcles));
        $limit = $page->getLimit();
        $offset = $page->getOffset();
        $aritcles = $this->cms->search($groupids, $method, $status, $limit, $offset, $audit);
        $pageBar = $page->getPage($aritcles);
        
        $articlesHtml = '<ul>'; 
        if(!empty($aritcles)){
            foreach ($aritcles as $row){
                $time = $row['ctime'];
                $time = substr($time, 0, 10);
                $articlesHtml .= '<li><span>'.$time.'</span><a href="'.base_url('cms/article/'.$row['aid']).'">'.$row['title'].'</a></li>';
            }
        } else {
            $articlesHtml .= '<li>该栏目下没有文章</li>';
        }
        $aritcles .= '</ul>';
        
        //get right column
        $rightColumn = $this->getRightColumn();
        
        $nav = $this->echoMenu();
        $data['nav'] = $nav['subPage'];
        $data['guide'] = $guide;
        $data['pageBar'] = $pageBar;
        $data['articlesHtml'] = $articlesHtml;
        $data['rightColumn'] = $rightColumn;
        $data['footer'] = '版权所有&copy中国经济网';
        
        $this->load->view('cms/v_header', $data);
        $this->load->view('cms/showList', $data);
        $this->load->view('cms/v_footer', $data);
    }
    
    /**
     * this method is used for get the child gids of a gid,and contains itself
     * @param type $gid
     * @return array the clildGids
     */
    private function getChildGid($gid){
        $childGids = array();
        $result = $this->cms->getGroupByGroupfather($gid);
        if(!empty($result)){
            foreach ($result as $row){
                $childGids[] = $row['gid'];
                $gid = $row['gid'];
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
    private function getGuideByGid($gid){
        $groupfather_id = -1;
        $guide = '';
        while (1){
            //  public function getGroupByGid($gid, $status = 1){
            $result = $this->cms->getGroupByGid($gid);
            //print_r($result);
            if(!empty($result)){
               $groupfather_id = $result[0]['groupfather_id'];
               if($groupfather_id != -1){       //it's not the root of column
                   $gid = $groupfather_id;
                   $guide = '<a href="'.base_url('cms/showList/'.$result[0]['group_url'].'/'.$result[0]['gid']).'">'.$result[0]['group_name'].'</a>>>'.$guide;
               } else {
                   $guide = '<a href="'.base_url('cms/index').'">首页</a>>>'.$guide;
                   break;
               }
            } else {
                break;
            }
            
        }
        $guide = substr($guide, 0, strlen($guide)-2);       //the end has two charactor 
        return $guide;
    }
}
