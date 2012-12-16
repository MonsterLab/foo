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
        
        $this->load->view('cms/index');
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
        $data['article'] = $article;
        $data['guide'] = $guide;
        $this->load->view('cms/article', $data);
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
        
        $data['guide'] = $guide;
        $data['pageBar'] = $pageBar;
        $data['articlesHtml'] = $articlesHtml;
        $this->load->view('cms/showList', $data);
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
