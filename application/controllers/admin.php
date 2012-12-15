<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller{
    private $data = array();


    public function __construct() {
        parent::__construct();
        
        $this->load->helper(array('url','form','html'));
        
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
//        if($power < 1){
//            redirect(base_url("admin/login/"));
//        }  else {
            //$this->load->view('admin/index');
            $this->load->view('admin/index');
//        }
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
    
    public function left(){
        $this->load->view('admin/left');
        return;
    }
    /**--------------------------------CRM管理-------------------------------------**/
    /**
     * 增加客户基本信息
     */
    public function createUserBase($fooType,$fooZxcode){
        $data['type'] = $fooType;
        $data['zxcode'] = $fooZxcode;
        if($_POST){
            $fooSqcode = trim($this->input->post('sqcode'));
            $fooUsername = trim($this->input->post('username'));
            $fooPassword = trim($this->input->post('password'));
            $fooTruename = trim($this->input->post('truename'));
            $fooPosition = trim($this->input->post('position'));
            $fooPhone = trim($this->input->post('phone'));
            $fooEmail = trim($this->input->post('email'));
            
            if($fooSqcode == NULL || $fooUsername == NULL 
                    || $fooPassword == NULL || $fooTruename == NULL || $fooPosition == NULL
                    || $fooPhone == NULL || $fooEmail == NULL || $fooType == NULL){
                $data['flag'] = '请完善信息！';
                $this->load->view('admin/v_createUserBase',$data);
                return;
            }
            $fooCUID = $this->admin->getUID();
            $fooUID = $this->userbase->create($fooCUID,$fooZxcode,$fooSqcode,$fooUsername,$fooPassword,$fooTruename,$fooPosition,$fooPhone,$fooEmail,$fooType);
            
            if($fooUID == -1){
                $data['flag'] = '用户登录名已存在！';
            }elseif ($fooUID == 0) {
                $data['flag'] = '添加失败！';
            }elseif ($fooUID > 0) {
                redirect(base_url("admin/createCertBase/$fooType/$fooUID"));
            }
            
            $this->load->view('admin/v_createUserBase',$data);
            
        }  else {
            $data['flag'] = '';
            $this->load->view('admin/v_createUserBase',$data);
        }
        
    }

    /**
     * 添加征信基本信息
     */
    public function createCertBase($type = '',$uid = 0){
        $data['type'] = $type;
        $data['uid'] = $uid;
        //判断类型topic medium talent
        $data['industrys'] = $this->zxpool->searchIndustry($type);
        
        if($_POST){
            $fooIndustryId = $this->input->post('industry');
            $fooComname = trim($this->input->post('com_name'));
            $fooComnature = trim($this->input->post('com_nature'));
            $fooComphone = trim($this->input->post('com_phone'));
            $fooZipcode = trim($this->input->post('zipcode'));
            $fooComplace = trim($this->input->post('com_place'));
            $fooCertBegin = trim($this->input->post('cert_begin'));          //将$fooCertBegin，$fooCertEnd转换为时间戳
            $fooCertEnd = trim($this->input->post('cert_end'));
            
            if($fooIndustryId == NULL || $fooComname == NULL || $fooComnature == NULL 
                    || $fooComphone == NULL || $fooZipcode == NULL || $fooComplace == NULL
                    || $fooCertBegin == NULL || $fooCertEnd == NULL){
                $data['flag'] = '请完善信息！';
                $this->load->view('admin/v_createCertBase',$data);
                return;
            }
            $fooCUID = $this->admin->getUID();
            //判断类型topic medium talent
            if($type == 'topic'){
                $fooResult = $this->topic->createCertBase($fooCUID,$uid,$fooComname,$fooComnature,$fooComphone,$fooZipcode,$fooComplace,$fooIndustryId,$fooCertBegin,$fooCertEnd);
            }elseif ($type == 'medium') {
                $fooResult = $this->medium->createCertBase($fooCUID,$uid,$fooComname,$fooComnature,$fooComphone,$fooZipcode,$fooComplace,$fooIndustryId,$fooCertBegin,$fooCertEnd);
            }elseif ($type == 'talent') {
                $fooResult = $this->talent->createCertBase($fooCUID,$uid,$fooComname,$fooComnature,$fooComphone,$fooZipcode,$fooComplace,$fooIndustryId,$fooCertBegin,$fooCertEnd);
            }
            
            if($fooResult){
                redirect(base_url("admin/addCertFile/$type/$uid"));
            }  else {
                $data['flag'] = '添加失败!';
            }
            
            $this->load->view('admin/v_createCertBase',$data);
            
        }  else {
            $data['flag'] = '';
            $this->load->view('admin/v_createCertBase',$data);
        }
    }

    /**
     * 上传扫描文件
     */
    public function addCertFile($type = '',$uid = 0){
        $data['type'] = $type;
        $data['uid'] = $uid;
        $data['fileTypes'] = $this->zxpool->searchFileType($type);             
        
        if($_POST){
            $fooFilename = trim($this->input->post('filename'));
            $fooFile = $this->uploadpic('file');
            
            if($fooFilename == null){
                $data['flag'] = "请完善信息！";
                $this->load->view('admin/v_addCertFile',$data);
                return;
            
            }
            
            $fooCUID = $this->admin->getUID();
            
            if($type == 'topic'){
                $fooResult = $this->topic->addCertFile($fooCUID,$uid,$fooFilename,$fooFile);
            }elseif ($type == 'medium') {
                $fooResult = $this->medium->addCertFile($fooCUID,$uid,$fooFilename,$fooFile);
            }elseif ($type == 'talent') {
                $fooResult = $this->talent->addCertFile($fooCUID,$uid,$fooFilename,$fooFile);
            }
            
            echo $fooResult;
            if($fooResult == -1){
                $data['flag'] = '已经上传该类型证书！';
            } elseif ($fooResult == 0){
                $data['flag'] = '上传失败！';
            } elseif ($fooResult == 1){
                redirect(base_url("admin/addCertContent/$type/$uid"));
            }
            
            $this->load->view('admin/v_addCertFile',$data);
            
        }  else {
            $data['flag'] = '';
            $this->load->view('admin/v_addCertFile',$data);
        }
    }
    
    /**
     * 添加认证文字信息
     * 
     */
    public function addCertContent($type = '',$uid = 0){
        $data['type'] = $type;
        $data['uid'] = $uid;
        if($_POST){
            $fooTitle = trim($this->input->post('title'));
            $fooContent = $this->input->post('content');
            
            if($fooTitle == NULL || $fooContent == NULL){
                $data['flag'] = "请完善信息！";
                $this->load->view('admin/v_addCertContent',$data);
                return;
            }
            $fooCUID = $this->admin->getUID();
            
            if($type == 'topic'){
                $fooResult = $this->topic->addCertContent($fooCUID,$uid,$fooTitle,$fooContent);
            }elseif ($type == 'medium') {
                $fooResult = $this->medium->addCertContent($fooCUID,$uid,$fooTitle,$fooContent);
            }elseif ($type == 'talent') {
                $fooResult = $this->talent->addCertContent($fooCUID,$uid,$fooTitle,$fooContent);
            }
            
            if($fooResult == -1){
                $data['flag'] = '已经存在此标题认证内容！';
            } elseif ($fooResult == 0){
                $data['flag'] = '提交失败！';
            } elseif ($fooResult == 1){
                $data['flag'] = '添加成功！';
            }
            
            $this->load->view('admin/v_addCertContent',$data);
            
        }  else {
            $data['flag'] = '';
            $this->load->view('admin/v_addCertContent',$data);
        }
    }

    /**
     * 审核信息
     * @param type $uid                 客户id
     * @param type $type                客户征信库类型
     * @param type $tableType           所审核表类别
     * @param type $tid                 所审核表id
     * @param type $isPass              审核情况，-1未通过，1通过
     */
    public function audit($uid = 1,$type = 'topic',$tableType = '',$tid = 0,$isPass = 0){
        //以下为根据审核情况对表审核
        if($isPass == -1 || $isPass == 1){
           $audit_id = $this->admin->getUID();                                  //获得审核人id
           //对客户基本表审核
           if($tableType == 'userbase'){
               $fooResult = $this->userbase->auditUserBase($audit_id,$tid,$isPass);
           }
           //根据征信库类型分别对客户征信基本信息、征信扫描件信息、征信文字类信息进行审核
           if($type == 'topic'){
               if($tableType == 'certbase'){
                    $fooResult = $this->topic->auditCertBase($audit_id,$tid,$isPass);
                }elseif ($tableType == 'certfile') {
                    $fooResult = $this->topic->auditCertFile($audit_id,$tid,$isPass);
                }elseif ($tableType == 'certcontent') {
                    $fooResult = $this->topic->auditCertContent($audit_id,$tid,$isPass);
                }
           }
           if($type == 'medium'){
               if($tableType == 'certbase'){
                    $fooResult = $this->medium->auditCertBase($audit_id,$tid,$isPass);
                }elseif ($tableType == 'certfile') {
                    $fooResult = $this->medium->auditCertFile($audit_id,$tid,$isPass);
                }elseif ($tableType == 'certcontent') {
                    $fooResult = $this->medium->auditCertContent($audit_id,$tid,$isPass);
                }
           }
           if($type == 'talent'){
               if($tableType == 'certbase'){
                    $fooResult = $this->talent->auditCertBase($audit_id,$tid,$isPass);
                }elseif ($tableType == 'certfile') {
                    $fooResult = $this->talent->auditCertFile($audit_id,$tid,$isPass);
                }elseif ($tableType == 'certcontent') {
                    $fooResult = $this->talent->auditCertContent($audit_id,$tid,$isPass);
                }
           }
           
           if(!$fooResult){
               
           }
        }
        //以下为 显示审核信息
        $fooUserBases = $this->userbase->search($uid,3);                    //按id搜索,获得客户基本信息
        
        if($type == 'topic'){
            $fooCertBases = $this->topic->searchCertBase($uid);             //获得认证基本信息
            $fooCertFiles = $this->topic->searchCertFile($uid);             //获得认证扫描信息
            $fooCertContent = $this->topic->searchCertContent($uid);        //获得认证文字类信息
        }
        if($type == 'medium'){
            $fooCertBases = $this->medium->searchCertBase($uid);
            $fooCertFiles = $this->medium->searchCertFile($uid);
            $fooCertContent = $this->medium->searchCertContent($uid);
        }
        if($type == 'talent'){
            $fooCertBases = $this->talent->searchCertBase($uid);
            $fooCertFiles = $this->talent->searchCertFile($uid);
            $fooCertContent = $this->talent->searchCertContent($uid);
        }
        
        $data['userBases'] = $fooUserBases;
        $data['certBases'] = $fooCertBases;
        $data['certFiles'] = $fooCertFiles;
        $data['certContents'] = $fooCertContent;
        
        $data['uid'] = $uid;
        $data['type'] = $type;
        
        $this->load->view('admin/v_audit',$data);
    }
    
    /**
     * 审核时显示征信扫描件信息、征信文字类信息
     * 以下参数为审核时必须的，故传进来
     * @param type $uid
     * @param type $type
     * @param type $tableType
     * @param type $tid
     */
    public function showFileOrContent($uid,$type,$tableType,$tid){
        $data['uid'] = $uid;
        $data['type'] = $type;
        $data['tableType'] = $tableType;
        $data['tid'] = $tid;
        
        if($tableType == 'certfile'){
            $data['fileName'] = $this->input->post('fileName');
            $this->load->view('admin/v_showFile',$data);
        }elseif ($tableType == 'certcontent') {
            $data['title'] = $this->input->post('title');
            $data['content'] = $this->input->post('content');
            $this->load->view('admin/v_showContent',$data);
        }
        
    }

    /**
     * 查询并显示客户
     * @return type
     */
    public function searchUsers($type = ''){
        $data['flag'] = '';
        
        if($type != ''){
            
            $fooTypeArray = array('topic','medium','talent');
            if( !in_array($type,$fooTypeArray)){
                $data['flag'] = '参数错误！';
                $this->load->view('admin/v_searchUsers',$data);
                return;
            }
            
            if($_POST){
                $fooZxcode = trim($this->input->post('keySearch'));
                if($fooZxcode != NULL){
                    $fooUserBase = $this->userbase->search($fooZxcode,1);               //按征信编码查询
                }  else {
                    $fooUserBase = $this->userbase->search($type,2);                 //按类库查询
                }

                if($fooUserBase){
                    $fooUserBases = $this->forSearchUsers($type, $fooUserBase);
                    $data['userBases'] = $fooUserBases;
                }  else {
                    $data['flag'] = '没有数据！';
                }

                //将类型传入视图
                $data['type'] = $type;
                $this->load->view('admin/v_searchUsers',$data);
                
            }  else {
                
                $fooUserBase = $this->userbase->search($type,2);                     //按类库查询

                if($fooUserBase){
                    $data['userBases'] = $this->forSearchUsers($type, $fooUserBase);
                }  else {
                    $data['flag'] = '没有数据！';
                }

                //将类型传入视图
                $data['type'] = $type;
                $this->load->view('admin/v_searchUsers',$data);
            }
        }
        
    }

    /**
     * 将公司名加入数组中
     * 完全是为查询客户服务，
     * @param type $_type
     * @param type $_userBases
     * @return type
     */
    private function forSearchUsers($_type,$_userBases){
        //查询公司名
        if($_type == 'topic'){
            foreach ($_userBases as $userBase){
                $fooUID = $userBase['id'];
                $fooCertBase = $this->topic->searchCertBase($fooUID);
                $userBase['com_name'] = $fooCertBase[0]['com_name'];
                $fooUserBases[] = $userBase;
            }

        } elseif ($_type == 'medium'){
            foreach ($_userBases as $userBase){
                $fooUID = $userBase['id'];
                $fooCertBase = $this->medium->searchCertBase($fooUID);
                $userBase['com_name'] = $fooCertBase[0]['com_name'];
                $fooUserBases[] = $userBase;
            }

        } elseif ($_type == 'talent'){
            foreach ($_userBases as $userBase){
                $fooUID = $userBase['id'];
                $fooCertBase = $this->talent->searchCertBase($fooUID);
                $userBase['com_name'] = $fooCertBase[0]['com_name'];
                $fooUserBases[] = $userBase;
            }
        }
        
        return $fooUserBases;
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
                    //TODO:windows下边换行符是"\r\n"，记得换
                    $fooData = str_replace("\n",'', $data);
                    if(!preg_match("/^[0-9a-z]+$/",$fooData)){
                        //TODO:数据中含有非数字字母
                        return;
                    }
                    
                    $codeArray[] = $fooData;
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
            
        } else {
            
            $this->load->view('fei_test/v_importCode.php');
        }    
    }
    
    /**
     * 上传方法
     * @return string
     */
    private function uploadpic($file){
        if(!empty($_FILES[$file]['name'])){
             $uploaddir="include/images/";                                  //文件存储路径
             $endname = substr(strrchr($_FILES[$file]['name'],'.'),1);       //截取上传图片的后缀名

             $type=array("jpg","gif","bmp","jpeg","png");                         //图片类型数组  

             //判断是否为以上类型
             if(!in_array(strtolower($endname),$type)){                           //strtolower()转化为小写，         

                 $text = implode("/", $type);                                     //$text = "jpg/gif/bmp/jpeg/png";

                 $data['flag'] = '你只能上传以下类型的文件: '.$text.'！';
                 $this->load->view('admin/v_addCertFile',$data);

             }else{                                                               //是图片将给图片重命名

                 $filename = explode(".", $_FILES[$file]['name']);           //将文件名以"."号为准，做一个数组

                 $time = date("Y-m-d-H-i-s");                                       //当前上传时间

                 $filename[0] = $time."_".rand(0, 9999);                           //将日期加文件名作为新文件名

                 $newName = implode(".", $filename);                             //修改后的文件名

                 $uploadfile_dir = $uploaddir.$newName;                          //文件保存路径


                 if(move_uploaded_file($_FILES[$file]['tmp_name'],$uploadfile_dir)){
                     chmod($uploadfile_dir, 0777);
                     return $newName;

                  }else{

                     $data['flag'] = '文件上传失败!';
                     $this->load->view('admin/v_addCertFile',$data);
                 }
            }
        }  else {

            $data['flag'] = '请上传文件!';
            $this->load->view('admin/v_addCertFile',$data);
        }

    }
    
    public function top(){
        $this->load->view('admin/top');
        return;
    }

    public function main(){
        $this->load->view('admin/main');
        return;
    }

    public function bottom(){
        $this->load->view('admin/footer');
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
                $groupsHtml .= '<option value="'.$group['gid'].'">'.$group['group_name'].'</option>';
            }
            
            
            foreach ($groups as $row){
                $groupid = $row['gid'];
                break;
            }
        } else {
            $groupsHtml .= '<option value="0">没有分类</option>';
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
    
    
    /************************************space******************************************/
    /**
     * this method is used for create article for super user
     */
    public function createSArticle(){ 
        if(isset($_GET['uid'])){        //if the admin click a user 
            $uid = $_GET['uid'];
            //TODO 根据用户id写文章
            //the uid should use session transfer
            //TODO 用户是否可以自定义分组，如果不可以，则不能要uid这个字段，因为任何用户
            //登录都不是管理员，也就是说没有分组
            //$space_uid = 5;
            
            $space_status = 1;
            $uidadmin = 5;// the user who has created the groups of user space
            $space_groups = $this->space->getAllSGroups($uidadmin, $space_status);
            $data['space_groups'] = $space_groups;
            $data['uid'] = $uid;
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
                $this->load->view('admin/v_createSArticle', $data);
            }
            
        } else {
            $m = 'createSArticle';
            $this->userspaceList($m);
        }       
    }
    
    /**
     * it's a private function, used to list all users
     */
    private function userspaceList($m = 'manageSArticle'){
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
                                    <th>用户名</th><th>征信编码</th><th>征信库类型</th><th>是否开通空间</th>
                                </tr>';                
            
            if(!empty($userspaceList)){
                foreach ($userspaceList as $row){
                    $userlistHtml .= '<tr>';
                    $userlistHtml .= '<td><a href="'.base_url('admin/'.$m).'?uid='.$row['id'].'">'.$row['username'].'</a></td>';
                    $userlistHtml .= '<td>'.$row['zx_code'].'</td>';
                    //TODO TYPE
                    $userlistHtml .= '';
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
                    $userlistHtml .= '<td><a href="'.base_url('admin/'.$m).'?uid='.$row['id'].'">'.$row['username'].'</a></td>';
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
    
    public function manageSArticle(){
        if(isset($_GET['uid'])){    //if click the username in list
            
            $uidadmin = 5;// the user who has created the groups of user space
            $space_status = 1;
            $space_groups = $this->space->getAllSGroups($uidadmin, $space_status);
            $groupsHtml = '<select name="space_groupid" id="groupid">';
            if(!empty($space_groups)){
                foreach ($space_groups as $group){
                    $groupsHtml .= '<option value="'.$group['space_gid'].'">'.$group['space_group_name'].'</option>';
                }
//
//
//                foreach ($space_groups as $row){
//                    $groupid = $row['space_gid'];
//                    break;
//                }
            } else {
                $groupsHtml .= '<option value="0">没有分类</option>';
            }
            $groupsHtml .= ' </select>';
            $space_uid = $_GET['uid'];
            $method = 0;    //this represents getUserSArticles()
            $limit = 'start';
            $offset= 'end';
            
            $articles = $this->space->searchS($space_uid, $method, $space_status, $limit, $offset);
            $page = new Page(count($articles));
            $limit = $page->getLimit();
            $offset = $page->getOffset();
            $articles = $this->space->searchS($space_uid, $method, $space_status, $limit, $offset);
            $pageBar = $page->getPage($articles);
            $articleHtml = '<table>';
            $articleHtml .= '<tr>
                            <th>标题(浏览次数)</th><th>作者</th><th>添加时间</th><th colspan="2">操作</th>
                            </tr>';
            if(!empty($articles)){
                foreach ($articles as $row){
                    $articleHtml .= '<tr>';
                    $articleHtml .= '<td>'.$row['space_title'].'('.$row['space_viewtimes'].')</a></td>';
                    $articleHtml .= '<td>'.$row['space_username'].'</td>';
                    $articleHtml .= '<td>'.$row['space_ctime'].'</td>';
                    if($row['space_audit'] == 0){
                        $auditText = '未审核';                
                    } else if ($row['space_audit'] == 1){
                        $auditText = '审核通过';
                    } else if ($row['space_audit'] == -1){
                        $auditText = '审核未通过';
                    }
                    $articleHtml .= '<td><a href="'.base_url('admin/auditArticle?space_aid='.$row['space_aid']).'">【'.$auditText.'】</a>';
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
            
            $this->load->view('admin/v_manageSArticle', $data);
        } else {    // else if(isset($_GET['uid']))
            $m = 'manageSArticle';
            $this->userspaceList($m);
        }
    }
    
}# end of class




//End of file admin.php