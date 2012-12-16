<?php
class Space extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('M_space', 'space');
        $this->load->model('M_user_base', 'userbase');
        $this->load->library('Page');
    }
    
    public function index($uid = 5){
        
        $this->load->view('space/index');
    }
    
    public function article($space_uid, $space_groupid, $aid){
        //TODO nav
        $method = 1;    //the method is get a article
        $space_status = 1;
        $limit= 'start';
        $offset = 'end';
        $space_audit = 1;
        $article = $this->space->searchS($aid, $method, $space_status, $limit, $offset, $space_audit);
        $gid = $article[0]['space_groupid'];
        $guide = $this->getGuideByGid($space_uid, $gid);
        $data['article'] = $article;
        $data['guide'] = $guide;
        $this->load->view('space/article', $data);
    }
    
    public function showList($space_uid = 0, $gid = 0){
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
        
        $data['guide'] = $guide;
        $data['pageBar'] = $pageBar;
        $data['articlesHtml'] = $articlesHtml;
        $this->load->view('space/showList', $data);
    }
    
    /**
     * this method is used for get the child gids of a gid,and contains itself
     * @param type $gid
     * @return array the clildGids
     */
    private function getChildGid($space_uid, $gid){
        $childGids = array();
        $result = $this->space->getGroupByGroupfather($gid);
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
            $result = $this->space->getGroupByGid($gid);
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
}