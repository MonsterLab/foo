<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller{
    private $data = array();


    public function __construct() {
        parent::__construct();
        
        $this->load->helper('url');
        
        $this->load->model('M_admin','admin');
        $this->load->model('M_user_base','userbase');
        $this->load->model('M_cms','cms');
        $this->load->model('M_medium','medium');
        $this->load->model('M_zxpool','zxpool');
        $this->load->model('M_space','space');
        $this->load->model('M_talent','talent');
        $this->load->model('M_topic','topic');              
        $this->load->library('Page');
    }
 
    //************************基本操作**********************************************
    public function index(){
        $power = $this->admin->getPower();
        if($power < 1){
            redirect(base_url("admin/login/"));
        }  else {
            $this->load->view('admin/index');
        }
    }
    
    public function login(){
        if($_POST){
            $username = $this->input->post('username');
            $userpassword = $this->input->post('userpassword');
            
            $login = $this->admin->login($username,$userpassword);

            if($login == 1){
                redirect(base_url("admin/index/"));
            } 
            
            return;
        }
        
        $this->load->view('admin/login');
       
        
    }
    
    public function logout(){
        $this->admin->logout();
        redirect(base_url('admin/login/'));
    }
    
    /**
     * 批量导入征信编码
     */
    public function importCode(){
        if($_POST){
            if(!empty($_FILES['file']['name'])){
                $tmp_name = $_FILES['file']['tmp_name'];
                //读取整个文件
                $resourse = file($tmp_name);                      
                //按行遍历数据
                foreach($resourse as $data){                                    
                    $codeArray[] = str_replace("\n",'', $data);                //将数据中\n去除
                }
                //数据不为空则导入数据库
                if(!empty($codeArray)){
                    $result = $this->zxpool->createCode($codeArray);
                    if($result){
                        //成功导入
                        
                    }
                }  else {
                    //文件中数据为空
                    
                }
                
            }  else {
                //未选择导入的文件
                
            }
            
        }# end of post  
    }
    
    public function left(){
        $this->load->view('admin/left');
        return;
    }
    
//**************************CMS操作**********************************************
    /**
     * cms create a article
     * TODO username，uid
     */
    //create($uid , $username  , $title ,$content, $groupid)
    public function createArticle(){        
        //TODO 权限的验证
        $uid = 5;
        $status = 1;    // the group isn't deleted
        $groups = $this->cms->getAllGroups($uid, $status);
        $data['groups'] = $groups;

        if(isset($_POST['sub'])){
            $groupid = $this->input->post('gid');
            $title = $this->input->post('title');
            $content = $this->input->post('content'); 
            $uid = 5;
            $username = 'zhang';
            $result = $this->cms->create($uid ,$username  ,$title, $content, $groupid);
            
            if($result){
                $data['flag'] = 1;
                $data['message'] = '添加成功';    
                
                $this->load->view('admin/v_createArticle', $data);
            } else {
                $data['flag'] = 0;
                $data['message'] = '添加失败';
                $data['gid'] = $groupid;
                $data['title'] = $title;
                $data['content'] = $content;
                
                $this->load->view('admin/v_createArticle', $data);
            }
            
        } else {            
            $this->load->view('admin/v_createArticle', $data);
        }
        
    }
    
    public function manageArticle(){
        //TODO 权限验证 username= zhang uid = 5;
        // $method 0->getUserArticles(), 1->getArticle(), 2->getArticlesOfGroup()
        //public function search($key,$method,$status = 1,$limit=0,$offset = 5 )
        $uid = 5;
        $status = 1;    // the group isn't deleted
        $groups = $this->cms->getAllGroups($uid, $status);
        $groupsHtml = '<select name="groupid" id="groupid">';
        $groupid = 0;
        if($groups){
            foreach ($groups as $group){
                $groupsHtml .= '<option groupid="'.$group['gid'].'">'.$group['group_name'].'</option>';
            }
            
            
            foreach ($groups as $row){
                $groupid = $row['gid'];
                break;
            }
        } else {
            $groupsHtml .= '<option groupid="0">没有分类</option>';
        }
        $groupsHtml .= ' </select>';
        $limit = 'start';
        $offset = 'end';
        $method = 2;    //chose method 
        $data = $this->cms->search($groupid, $method, $status, $limit, $offset);
        $allRows = count($data);
        $offset = 10;
        $page = new Page($allRows);
        $limit = $page->getLimit();
        $offset = $page->getOffset();
        $articles =$this->cms->search($groupid, $method, $status, $limit, $offset);
        $pageBar = $page->getPage($articles);
        $currentPage = $page->getCurrentPage();
        $articleHtml = '<table>';
        $articleHtml .= '<tr>
                        <th>标题(浏览次数)</th><th>作者</th><th>添加时间</th><th colspan="2">操作</th>
                        </tr>';
        if($articles){
            foreach ($articles as $row){
                $articleHtml .= '<tr>';
                $articleHtml .= '<td>'.$row['title'].'('.$row['viewtimes'].')</a></td>';
                $articleHtml .= '<td>'.$row['username'].'</td>';
                $articleHtml .= '<td>'.$row['ctime'].'</td>';
                if($row['audit'] == 0){
                    $auditText = '未审核';                
                } else if ($row['audit'] == 1){
                    $auditText = '审核通过';
                } else if ($row['audit'] == -1){
                    $auditText = '审核未通过';
                }
                $articleHtml .= '<td><a href="'.base_url('admin/auditArticle?page='.$currentPage.'&aid='.$row['aid']).'">【'.$auditText.'】</a>';
                $articleHtml .= '<a href="">【查看】</a>';
                $articleHtml .= '<a href="">【修改】</a>';
                $articleHtml .= '<a href="">【删除】</a>';
                $articleHtml .= '</td>';
                $articleHtml .= '</tr>';
            }
        }
        $articleHtml .= '</table>';
        $data['groupsHtml'] = $groupsHtml;
        $data['pageBar'] = $pageBar;
        $data['articleHtml'] = $articleHtml;    
        
        $this->load->view('admin/v_manageArticle', $data);
    }
    
    /*
     * this method is used for audit the article ,it has three state 
     * 1:represents it's ok,
     * 0:represents it hasn't been audited
     * -1:represents it can't be accepted
     */
    public function auditArticle(){
        //TODO 权限的验证
        $aid = $_GET['aid'];
        $audit = 1;
        $uid = 5;   //TODO
        $audit_id = $uid;
        $result = $this->cms->updateAudit($aid, $audit, $audit_id);
        if($result){
            $this->manageArticle();
        }
    }
    
    /**
     * this method is used for creating a group of article
     * 
     */
    public function createGroup(){
        //TODO 权限的验证
        $uid = 5;
        $status = 1;    // the group isn't deleted
        if(isset($_POST['sub'])){
            $groupfather_id = trim($_POST['groupfather_id']);
            $group_name = trim($_POST['group_name']);
            $group_url = trim($_POST['group_url']);
            $group_summary = trim($_POST['group_summary']);
            $result = 0;
            if($groupfather_id == -1 || empty($group_name) || empty($group_url) || empty($group_summary)){
                $result = 0;
            } else {
                $result = $this->cms->createGroup($uid,$group_name, $group_url, $group_summary, $groupfather_id);
            }
            
            $groups = $this->cms->getAllGroups($uid, $status);
            
            $groupsHtml = '<select name="groupfather_id" id="groupfather_id">';
            $groupsHtml .= '<option value="-1">请选择一个分类</option>';
            if($groups){
                foreach ($groups as $group){
                    if(isset($_POST['sub'])){
                        if($group['gid'] == $_POST['groupfather_id']){
                            $groupsHtml .= '<option selected="selected" value="'.$group['gid'].'">'.$group['group_name'].'</option>';
                            continue;
                        }
                    }
                    $groupsHtml .= '<option value="'.$group['gid'].'">'.$group['group_name'].'</option>';
                }
            }

            $groupsHtml .= ' </select>';
            $data['groupsHtml'] = $groupsHtml;
            
            if($result){
                $data['flag'] = 1;
                $data['message'] = '添加成功';    
                
                $this->load->view('admin/v_createGroup', $data);
            } else {
                $data['flag'] = 0;
                $data['message'] = '添加失败<br/>必须选择分类，必须填写完整
                    ';
                $data['groupfather_id'] = $groupfather_id;
                $data['group_name'] = $group_name;
                $data['group_url'] = $group_url;
                $data['group_summary'] = $group_summary;                
                
                $this->load->view('admin/v_createGroup', $data);
            }
        } else {
            $groups = $this->cms->getAllGroups($uid, $status);
            if(count($groups) == 0){
                $group_name = '首页';
                $group_url = 'sy';
                $group_summary = '这是所有文章分类的父类，不能被删除';
                $groupfather_id = -1;
                $result = $this->cms->createGroup($uid,$group_name, $group_url, $group_summary, $groupfather_id);
                $groups = $this->cms->getAllGroups($uid, $status);
            }
            $groupsHtml = '<select name="groupfather_id" id="groupfather_id">';
            $groupsHtml .= '<option value="-1">请选择一个分类</option>';
            if($groups){
                foreach ($groups as $group){
                    if(isset($_POST['sub'])){
                        if($group['gid'] == $_POST['groupfather_id']){
                            $groupsHtml .= '<option selected="selected" value="'.$group['gid'].'">'.$group['group_name'].'</option>';
                            continue;
                        }
                    }
                    $groupsHtml .= '<option value="'.$group['gid'].'">'.$group['group_name'].'</option>';
                }
            }

            $groupsHtml .= ' </select>';
            $data['groupsHtml'] = $groupsHtml;
            $this->load->view('admin/v_createGroup', $data);
        }
    }
    
    public function manageGroup(){
        //TODO 权限的验证
        //TODOsss
        $uid = 5;
        $status = 1;    // the group isn't deleted
        $groups = $this->cms->getAllGroups($uid, $status);
        $groupsHtml = '<table>';
        $groupsHtml .= '<tr>
                            <th>文章栏目</th><th>上级分组</th><th colspan="2">操作</th>
                        </tr>';
        print_r($groups);
        if($groups){
            foreach ($groups as $groupfather)
                foreach ($groups as $groupChild){
                    if($groupChild['groupfather_id'] == $groupfather['gid']){
                        $groupsHtml .= '<tr>';
                        $groupsHtml .= '<td>'.$groupChild['group_name'].'</td>';
                        $groupsHtml .= '<td>'.$groupfather['group_name'].'</td>';
                        $groupsHtml .= '<td><a href="">修改</td>';
                        $groupsHtml .= '<td><a href="">删除</a></td>';
                        $groupsHtml .= '</tr>';
                    }
                }
        }
        $groupsHtml .= '</table>';
        $data['groupsHtml'] = $groupsHtml;        
        $this->load->view('admin/v_manageGroup', $data);
    }
    
}# end of class




//End of file admin.php