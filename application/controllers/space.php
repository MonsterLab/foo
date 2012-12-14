<?php
class Space extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('M_space', 'space');
        $this->load->model('M_user_base', 'userbase');
        $this->load->library('Page');
    }
    
    public function index(){
        //    public function createS($space_uid , $space_username  , $space_title ,$space_content, $space_groupid){
        
        //$this->space->createS(5 , 'zhang'  , '$space_title' ,'$space_content', '$space_groupid');
         //   public function searchS($key,$method,$space_status = 1,$limit=0,$offset = 5 ){
         $this->space->searchS($key,$method,$space_status = 1,$limit=0,$offset = 5 );
        
        $this->load->view('space/index');
    }
    
    public function createSArticle(){ 
        if(isset($_GET['uid'])){        //if the admin click a user 
            $space_uid = $_GET['uid'];
            //TODO 根据用户id写文章
            //TODO 用户是否可以自定义分组，如果不可以，则不能要uid这个字段，因为任何用户
            //登录都不是管理员，也就是说没有分组
            $space_uid = 5;
            $space_status = 1;
            $space_groups = $this->space->getAllSGroups($space_uid, $space_status);
            $data['space_groups'] = $space_groups;

            if(isset($_POST['sub'])){
                $space_groupid = $this->input->post('space_gid');
                $space_title = $this->input->post('space_title');
                $space_content = $this->input->post('space_content'); 
                $space_uid = $this->input->post('space_uid');
                $method = 3;     //search user by id of user
                $space_user = $this->userbase->search();
                $result = $this->cms->create($space_uid ,$space_username  ,$space_title, $space_content, $space_groupid);

                if($result){
                    $data['flag'] = 1;
                    $data['message'] = '添加成功';    

                    $this->load->view('admin/v_createSArticle', $data);
                } else {
                    $data['flag'] = 0;
                    $data['message'] = '添加失败';
                    $data['gid'] = $groupid;
                    $data['title'] = $title;
                    $data['content'] = $content;

                    $this->load->view('admin/v_createSArticle', $data);
                }

            } else { //if the admin don't position at a user            
                $this->load->view('admin/v_createArticle', $data);
            }
            
        } else {
            $this->userspaceList();
        }       
    }
    
    private function userspaceList(){
        if(isset($_POST['sub'])){       //if the admin choose to search
            $key = $_POST['key'];
            $search = $_POST['search'];
            switch ($search){
                case 'username':
                    $username = $key;
                    $method = 0;        //search users by username
                    $userspaceList = $this->userbase->search($username, $method);
                    $allRows = count($userspaceList);
                    $page = new Page($allRows);
                    $limit = $page->getLimit(); //the start position        
                    $offset = $page->getOffset();//the offset of count
                    $userspaceList = $this->userbase->search($username, $method, $offset, $limit);
                    break;
                case 'zx_code':
                    $zx_code = $key;
                    $method = 1;        //search users by zx_code
                    $userspaceList = $this->userbase->search($zx_code, $method);
                    $allRows = count($userspaceList);
                    $page = new Page($allRows);
                    $limit = $page->getLimit(); //the start position        
                    $offset = $page->getOffset();//the offset of count
                    $userspaceList = $this->userbase->search($zx_code, $method, $offset, $limit);
                    break;
                case 'type':
                    $type = $key;
                    $method = 2;        //search users by type 
                    $userspaceList = $this->userbase->search($type, $method);
                    $allRows = count($userspaceList);
                    $page = new Page($allRows);
                    $limit = $page->getLimit(); //the start position        
                    $offset = $page->getOffset();//the offset of count
                    $userspaceList = $this->userbase->search($type, $method, $offset, $limit);
                    break;
            }
            
            $pageBar = $page->getPage($userspaceList);
            $userlistHtml = '<table>
                                <tr>
                                    <th>用户名</th><th>征信编码</th><th>是否开通空间</th>
                                </tr>';                
            
            if(!empty($userspaceList)){
                foreach ($userspaceList as $row){
                    $userlistHtml .= '<tr>';
                    $userlistHtml .= '<td><a href="'.base_url('space/createSArticle').'?uid='.$row['id'].'">'.$row['username'].'</a></td>';
                    $userlistHtml .= '<td>'.$row['zx_code'].'</td>';
                    $pass = $row['space_id'] > 0 ? '是' : '否';
                    $userlistHtml .= '<td>'.$pass.'</td>';
                    $userlistHtml .= '</tr>';
                }
            }
            
            $userlistHtml .= '</table>';
            
            
            $data['pageBar'] = $pageBar;
            $data['userlistHtml'] = $userlistHtml;
            
            $this->load->view('admin/v_userspaceList', $data);
        } else {    //if the admin don't choose to search 
            $userspaceList = $this->userbase->search();
            $allRows = count($userspaceList);
            $page = new Page($allRows);
            $limit = $page->getLimit(); //the start position        
            $offset = $page->getOffset();//the offset of count
            //use the default value for searching ,just require offset and limit
            $userspaceList = $this->userbase->search('', 0, $offset, $limit);
            $pageBar = $page->getPage($userspaceList);
            $userlistHtml = '<table>
                                <tr>
                                    <th>用户名</th><th>征信编码</th><th>是否开通空间</th>
                                </tr>';                
            
            if(!empty($userspaceList)){
                foreach ($userspaceList as $row){
                    $userlistHtml .= '<tr>';
                    $userlistHtml .= '<td><a href="'.base_url('space/createSArticle').'?uid='.$row['id'].'">'.$row['username'].'</a></td>';
                    $userlistHtml .= '<td>'.$row['zx_code'].'</td>';
                    $pass = $row['space_id'] > 0 ? '是' : '否';
                    $userlistHtml .= '<td>'.$pass.'</td>';
                    $userlistHtml .= '</tr>';
                }
            }
            
            $userlistHtml .= '</table>';
            
            
            $data['pageBar'] = $pageBar;
            $data['userlistHtml'] = $userlistHtml;
            
            $this->load->view('admin/v_userspaceList', $data);
        }
    }
}