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
        if($power < 1){
            redirect(base_url("admin/login/"));
        }  else {
            $this->load->view('admin/index');
        }
    }
    
    /**
     * 管理员登录
     * @return type
     */
    public function login(){
        $data['flag'] = ''; 
        if($_POST){
            $username = trim($this->input->post('username'));
            $userpassword = trim($this->input->post('password'));
            
            if($username == NULL || $userpassword == NULL){
                $data['flag'] = '请完善信息!';
                $this->load->view('admin/login',$data);
                return;
            }
            
            $fooLogin = $this->admin->login($username,$userpassword);

            if($fooLogin == -1){
                $data['flag'] = '不存在此用户!';
                $this->load->view('admin/login',$data);
                return;
            }
            if($fooLogin == 0){
                $data['flag'] = '密码错误!';
                $this->load->view('admin/login',$data);
                return;
            }
            if($fooLogin == 1){
                redirect(base_url("admin/index/"));
            } 
            
            return;
        }
        
        $this->load->view('admin/login',$data);
       
        
    }
    /**
     * 登出
     */
    public function logout(){
        $this->admin->logout();
        redirect(base_url('admin/login/'));
    }
    
    /**
     * 加载左部菜单
     * @return type
     */
    public function left(){
        $power = $this->admin->getPower();
        if($power < 1){
            redirect(base_url('admin/login/'));
        }
        //根据power设置left视图显示项目
        $data['power'] = $power;
        $this->load->view('admin/left',$data);
        return;
    }
    
    public function top(){
        $power = $this->admin->getPower();
        if($power < 1){
            redirect(base_url('admin/login/'));
        }
        
        $this->load->view('admin/top');
        return;
    }

    public function main(){
        $power = $this->admin->getPower();
        if($power < 1){
            redirect(base_url('admin/login/'));
        }
        
        $this->load->view('admin/main');
        return;
    }

    public function bottom(){
        $power = $this->admin->getPower();
        if($power < 1){
            redirect(base_url('admin/login/'));
        }
        
        $this->load->view('admin/footer');
        return;
    }
    
    /**-----------------------------管理员、客户管理------------------------------------**/
    
    /**
     * 添加管理员
     * @return type
     */
    public function createAdmin(){
        $power = $this->admin->getPower();
        if($power < 99){
            redirect(base_url('admin/login/'));
        }
        
        $data['flag'] = '';
        if($_POST){
            
            $fooUsername = trim($this->input->post('username'));
            $fooPassword = trim($this->input->post('password'));
            $fooTruename = trim($this->input->post('truename'));
            $fooDepartment = trim($this->input->post('department'));
            $fooPhone = trim($this->input->post('phone'));
            $fooEmail = trim($this->input->post('email'));
            $fooPower = trim($this->input->post('power'));
            
            $fooCUID = $this->admin->getUID();
            //权限、使用人姓名、用户名、密码、部门为必须，其它选填
            if($fooUsername == NULL || $fooPassword == NULL || $fooTruename == NULL 
                    ||$fooDepartment == NULL || $fooPower == NULL){
                
                $data['flag'] = '请完善信息！';
                $this->load->view('admin/v_createAdmin',$data);
                return;
            }
            
            $fooCreateid = $this->admin->create($fooCUID,$fooUsername,$fooPassword,$fooTruename,$fooDepartment,$fooPhone,$fooEmail,$fooPower);
            if($fooCreateid == -1){
                $data['flag'] = '用户登录名已存在！';
            }elseif ($fooCreateid == 0) {
                $data['flag'] = '添加失败！';
            }elseif ($fooCreateid > 0) {
                $data['flag'] = '添加成功！';
            }
            
            $this->load->view('admin/v_createAdmin',$data);
            
        }  else {
            
            $this->load->view('admin/v_createAdmin',$data);
        }
    }
    
    /**
     * 更新管理员信息
     * @param type $adminId
     * @return type
     */
    public function updateAdmin($adminId = 0){
        $power = $this->admin->getPower();
        if($power < 99){
            redirect(base_url('admin/login/'));
        }
        
        //检查参数
        if($adminId < 1){
            $data['adminId'] = $adminId;
            $data['flag'] = '参数错误！';
            $this->load->view('admin/v_updateAdmin',$data);
            return;
        }
        //修改，修改时显示原有数据
        $fooAdmin = $this->admin->search($adminId,3);
        if($fooAdmin){
            $data = array(
                'username'=>$fooAdmin[0]['username'],
                'password'=>$fooAdmin[0]['password'],
                'truename'=>$fooAdmin[0]['truename'],
                'department'=>$fooAdmin[0]['department'],
                'phone'=>$fooAdmin[0]['phone'],
                'email'=>$fooAdmin[0]['email'],
                'power'=>$fooAdmin[0]['power'],
            );
        }
        
        $data['adminId'] = $adminId;
        $data['flag'] = '';
        if($_POST){
            $fooUsername = trim($this->input->post('username'));
            $fooPassword = trim($this->input->post('password'));
            $fooTruename = trim($this->input->post('truename'));
            $fooDepartment = trim($this->input->post('department'));
            $fooPhone = trim($this->input->post('phone'));
            $fooEmail = trim($this->input->post('email'));
            $fooPower = trim($this->input->post('power'));
            
            //权限、使用人姓名、用户名、密码为必须，其它选填
            if($fooUsername == NULL || $fooPassword == NULL || $fooTruename == NULL 
                    ||$fooDepartment == NULL|| $fooPower == NULL){
                
                $data['flag'] = '请完善信息！';
                $this->load->view('admin/v_updateAdmin',$data);
                return;
            }
            
            //修改，将原来数据删除,然后再添加新的数据（修改，即删除老用户,添加新用户）
            $fooUpdate = $this->admin->update($adminId,$fooUsername,$fooPassword,$fooTruename,$fooDepartment,$fooPhone,$fooEmail,$fooPower);
            if($fooUpdate == -1){
                $data['flag'] = '用户登录名已存在！';
            }elseif ($fooUpdate == 0) {
                $data['flag'] = '修改失败！';
            }elseif ($fooUpdate == 1) {
                $data['flag'] = '修改成功！';
            }
            
            $this->load->view('admin/v_updateAdmin',$data);
            
        }  else {
            
            $this->load->view('admin/v_updateAdmin',$data);
        }
    }
    
    /**
     * 删除管理用户
     * @param type $uid
     */
    public function deleteAdmin($uid){
        $power = $this->admin->getPower();
        if($power < 99){
            redirect(base_url('admin/login/'));
        }
        
        $fooResult = $this->admin->delete($uid);
        if($fooResult){
            redirect(base_url('admin/searchAdmins'));
        }
    }

    /**
     * 查询管理用户
     */
    public function searchAdmins(){
        $power = $this->admin->getPower();
        if($power < 99){
            redirect(base_url('admin/login/'));
        }
        
        $data = array(
            'flag'=>'',
            'head'=>'管理用户管理'
        );
        if($_POST){
            $fooKeySearch = trim($this->input->post('keySearch'));
            if($fooKeySearch == NULL){
                $fooAdmins = $this->admin->search();
            }  else {
                $fooAdmins = $this->admin->search($fooKeySearch,0);         //按管理用户名搜索
            }
            
            if($fooAdmins){
                $data['admins'] = $fooAdmins;
            }  else {
                $data['flag'] = '没有数据！';
            }
            
            $this->load->view('admin/v_searchAdmin',$data);
            
        }  else {
            $fooAdmins = $this->admin->search();
            if($fooAdmins){
                $data['admins'] = $fooAdmins;
            }  else {
                $data['flag'] = '没有数据！';
            }
            
            $this->load->view('admin/v_searchAdmin',$data);
        }
    }

    /**
     * 新建客户
     * @param type $zxcode
     * @param type $uid
     * @return type
     */
    public function createUser($zxcode = 0 ,$uid = 0){
        $power = $this->admin->getPower();
        $powerArray = array(13,99);                 //录入、超管
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
        
        //默认为直接添加，即不存在原有数据
        $data = array(
            'zxcode'=>$zxcode,
            'type'=>'',
            'cert_name'=>'',
            'username'=>'',
            'password'=>'',
            'sqcode'=>'',
        );
        //修改，修改时显示原有数据
        if($uid > 0){
            $fooUserbase = $this->userbase->search($uid,3);         //查询用户基本信息
            $fooUser = $this->searchComName($fooUserbase);          //将公司名查询出
            if($fooUser){
                $data = array(
                    'zxcode'=>$zxcode,
                    'type'=>$fooUser[0]['type'],
                    'username'=>$fooUser[0]['username'],
                    'password'=>$fooUser[0]['password'],
                    'sqcode'=>$fooUser[0]['sq_code'],
                    'cert_name'=>$fooUser[0]['cert_name']
                );
            }
        }
        
        if($_POST){
            $fooCUID = $this->admin->getUID();
            $fooType = trim($this->input->post('type'));
            $fooCertname = trim($this->input->post('cert_name'));
            $fooUsername = trim($this->input->post('username'));
            $fooPassword = trim($this->input->post('password'));
            $fooSqcode = trim($this->input->post('sqcode'));
            
            //权限、使用人姓名、用户名、密码为必须，其它选填
            if($fooUsername == NULL || $fooPassword == NULL || $fooSqcode == NULL||$fooCertname==NULL){
                
                $data['flag'] = '请完善信息！';
                $this->load->view('admin/v_createUser',$data);
                return;
            }
            //TODO:$fooUserbase
            
            $fooUID = $this->userbase->create($fooCUID,$zxcode,$fooSqcode,$fooUsername,$fooPassword,'','','','',$fooType);
            if($fooUID == -1){
                $data['flag'] = '用户登录名已存在！';
            }elseif ($fooUID == 0) {
                $data['flag'] = '添加失败！';
            }elseif ($fooUID > 0) {
                
                //增加公司名
                if($fooType == 'topic'){
                    $fooResult = $this->topic->createCertBase($fooCUID,$fooUID,$fooCertname);
                }elseif ($fooType == 'medium') {
                    $fooResult = $this->medium->createCertBase($fooCUID,$fooUID,$fooCertname);
                }elseif ($fooType == 'talent') {
                    //$cuid,$uid,$cert_name,$sex,$nation,$personid,$birth_place,$live_place,$cert_begin,$cert_end
                    $fooResult = $this->talent->createCertBase($fooCUID,$fooUID,$fooCertname,'','','','','','','');
                }
                
                if($uid == 0){
                    //新增客户
                    $fooResult = $this->zxpool->useCode($zxcode);                //使用征信编码
                    if($fooResult == 1){
                        $data['flag'] = '添加成功！';
                    }
                    
                    
                }  else {
                    //修改客户，添加成功则将原来数据删除（修改，即添加新用户，删除老用户）
                    $fooResult = $this->admin->delete($uid);
                    if($fooResult){
                        $data['flag'] = '修改成功！';
                    }
                }
            }
            
            $this->load->view('admin/v_createUser',$data);
            
        }  else {
            $data['flag'] = '';
            $this->load->view('admin/v_createUser',$data);
        }
    }
    
    //暂时没有用
    public function updateUser($zxcode = 0 ,$uid = 0){
        $power = $this->admin->getPower();
        $powerArray = array(13,99);                 //录入、超管
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
        
        //默认为直接添加，即不存在原有数据
        $data = array(
            'zxcode'=>$zxcode,
            'type'=>'',
            'cert_name'=>'',
            'username'=>'',
            'password'=>'',
            'sqcode'=>'',
        );
        //修改，修改时显示原有数据
        if($uid > 0){
            $fooUserbase = $this->userbase->search($uid,3);         //查询用户基本信息
            $fooUser = $this->searchComName($fooUserbase);          //将公司名查询出
            if($fooUser){
                $data = array(
                    'zxcode'=>$zxcode,
                    'type'=>$fooUser[0]['type'],
                    'username'=>$fooUser[0]['username'],
                    'password'=>$fooUser[0]['password'],
                    'sqcode'=>$fooUser[0]['sq_code'],
                    'cert_name'=>$fooUser[0]['cert_name']
                );
            }
        }
        
        if($_POST){
            $fooCUID = $this->admin->getUID();
            $fooType = trim($this->input->post('type'));
            $fooCertname = trim($this->input->post('cert_name'));
            $fooUsername = trim($this->input->post('username'));
            $fooPassword = trim($this->input->post('password'));
            $fooSqcode = trim($this->input->post('sqcode'));
            
            //权限、使用人姓名、用户名、密码为必须，其它选填
            if($fooUsername == NULL || $fooPassword == NULL || $fooSqcode == NULL||$fooCertname==NULL){
                
                $data['flag'] = '请完善信息！';
                $this->load->view('admin/v_createUser',$data);
                return;
            }
            //TODO:$fooUserbase
//            $department = $fooUserbase[0]['department'];
//            $phone = $fooUserbase[0]['phone'];
//            $email = $fooUserbase[0]['email'];
            //update($uid,$zx_code,$sq_code,$password,$truename,$position,$phone,$email,$type
            $fooUID = $this->userbase->update($uid,$fooPassword,fooUsername,'','','','',$fooType);
            if($fooUID == -1){
                $data['flag'] = '用户登录名已存在！';
            }elseif ($fooUID == 0) {
                $data['flag'] = '添加失败！';
            }elseif ($fooUID > 0) {
                
                //增加公司名
                if($fooType == 'topic'){
                    $fooResult = $this->topic->createCertBase($fooCUID,$fooUID,$fooCertname);
                }elseif ($fooType == 'medium') {
                    $fooResult = $this->medium->createCertBase($fooCUID,$fooUID,$fooCertname);
                }elseif ($fooType == 'talent') {
                    $fooResult = $this->talent->createCertBase($fooCUID,$fooUID,$fooCertname);
                }
                
                if($uid == 0){
                    //新增客户,    
                    $fooResult = $this->zxpool->useCode($zxcode);                //使用征信编码
                    if($fooResult == 1){
                        $data['flag'] = '添加成功！';
                    }
                    
                    
                }  else {
                    //修改客户，添加成功则将原来数据删除（修改，即添加新用户，删除老用户）
                    $fooResult = $this->admin->delete($uid);
                    if($fooResult){
                        $data['flag'] = '修改成功！';
                    }
                }
            }
            
            $this->load->view('admin/v_createUser',$data);
            
        }  else {
            $data['flag'] = '';
            $this->load->view('admin/v_createUser',$data);
        }
    }


    /**--------------------------------CRM管理-------------------------------------**/
    /**
     * 增加客户基本信息
     */
    
    public function showLuruView($uid){
        $power = $this->admin->getPower();
        $powerArray = array(13,99);                 //录入、超管
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
        $fooUserBases = $this->userbase->search($uid,3);            //按id查询
        $fooZxcode = $fooUserBases[0]['zx_code'];
        $fooType = $fooUserBases[0]['type'];
        
        $data['industrys'] = $this->zxpool->searchIndustry($fooType);
        $data['fileTypes'] = $this->zxpool->searchFileType($fooType);
        
        if($fooType == 'topic'){
            $fooCertBases = $this->topic->searchCertBase($uid);             //获得认证基本信息
            $fooCertFiles = $this->topic->searchCertFile($uid);             //获得认证扫描信息
            $fooCertContent = $this->topic->searchCertContent($uid);        //获得认证文字类信息
            
            if($fooCertBases[0]['com_nature'] != NULL){
                $data['noneShow2'] = 0;
            }
        }
        if($fooType == 'medium'){
            $fooCertBases = $this->medium->searchCertBase($uid);
            $fooCertFiles = $this->medium->searchCertFile($uid);
            $fooCertContent = $this->medium->searchCertContent($uid);
            
            if($fooCertBases[0]['com_nature']){
                $data['noneShow2'] = 0;
            }
        }
        if($fooType == 'talent'){
            $fooCertBases = $this->talent->searchCertBase($uid);
            $fooCertFiles = $this->talent->searchCertFile($uid);
            $fooCertContent = $this->talent->searchCertContent($uid);
            
            if($fooCertBases[0]['sex']){
                $data['noneShow2'] = 0;
            }
        }
        
        
//        if(!$fooCertBases){
//            $fooCertBases[0] = array(
//                'com_name'=>'',
//                'com_nature'=>'',
//                'com_phone'=>'',
//                'industry_id'=>'',
//                'zipcode'=>'',
//                'com_place'=>'',
//                'cert_begin'=>'',
//                'cert_end'=>''
//            );
//        }
        
        
        $data['userBases'] = $fooUserBases;
        $data['certBases'] = $fooCertBases;
        $data['certFiles'] = $fooCertFiles;
        $data['certContents'] = $fooCertContent;
        
        
        $data['uid'] = $uid;
        $data['zxcode'] = $fooZxcode;
        $data['type'] = $fooType;
        $data['flag'] = '';
        $data['noneShow1'] = 1;
        $data['noneShow2'] = 1;
        $data['noneShow3'] = 1;
        $data['noneShow4'] = 1;
        
        if($fooUserBases[0]['truename'] != NULL){
            $data['noneShow1'] = 0;
        }
        
        if($fooCertFiles){
            $data['noneShow3'] = 0;
        }
        if($fooCertContent){
            $data['noneShow4'] = 0;
        }
        
        $this->load->view('admin/v_createUserBase',$data);
        $this->load->view('admin/v_createCertBase',$data);
        $this->load->view('admin/v_addCertFile',$data);
        $this->load->view('admin/v_addCertContent',$data);
        
    }
    
    public function createUserBase($uid,$fooZxcode){
        $power = $this->admin->getPower();
        $powerArray = array(13,99);                 //录入、超管
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
        //$data['type'] = $fooType;
        $data['uid'] = $uid;
        $data['zxcode'] = $fooZxcode;
        if($_POST){
            $fooTruename = trim($this->input->post('truename'));
            $fooPosition = trim($this->input->post('position'));
            $fooPhone = trim($this->input->post('phone'));
            $fooEmail = trim($this->input->post('email'));
            
            if($fooTruename == NULL || $fooPosition == NULL
                    || $fooPhone == NULL || $fooEmail == NULL){
                $data['flag'] = '请完善信息！';
                $this->load->view('admin/v_createUserBase',$data);
                return;
            }
            
            $fooUserBase = $this->userbase->search($uid,3);            //按id查询
            $fooSqcode = $fooUserBase[0]['sq_code'];
            $fooUsername = $fooUserBase[0]['username'];
            $fooPassword = $fooUserBase[0]['password'];
            $fooZxcode = $fooUserBase[0]['zx_code'];
            $fooType = $fooUserBase[0]['type'];
            
            
            $fooResult = $this->userbase->update($uid,$fooZxcode,$fooSqcode,$fooPassword,$fooTruename,$fooPosition,$fooPhone,$fooEmail,$fooType);
            
            if($fooResult == -1){
                $data['flag'] = '用户登录名已存在！';
            }elseif ($fooResult == 0) {
                $data['flag'] = '添加失败！';
            }elseif ($fooResult == 1) {
                redirect(base_url("admin/showLuruView/$uid"));
                
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
        //权限设定
        $power = $this->admin->getPower();
        $powerArray = array(13,99);                 //录入、超管
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
        $data['type'] = $type;
        $data['uid'] = $uid;
        //
//        if($type == 'topic'){
//            $data['certbases'] = $this->topic->searchCertBase($uid);
//        }
//        if($type == 'medium'){
//            $data['certbases'] = $this->medium->searchCertBase($uid);
//        }
//        if($type == 'talent'){
//            $data['certbases'] = $this->talent->searchCertBase($uid);
//        }
        
        $data['industrys'] = $this->zxpool->searchIndustry($type);
        
        if($_POST){
            
            if($type == 'topic' || $type == 'medium' ){
                $fooIndustryId = $this->input->post('industry');
                $fooComname = trim($this->input->post('com_name'));
                $fooComnature = trim($this->input->post('com_nature'));
                $fooComphone = trim($this->input->post('com_phone'));
                $fooZipcode = trim($this->input->post('zipcode'));
                $fooComplace = trim($this->input->post('com_place'));
                $fooCertBegin = trim($this->input->post('cert_begin'));          //将$fooCertBegin，$fooCertEnd转换为时间戳
                $fooCertEnd = trim($this->input->post('cert_end'));
            
            }
            if($type == 'talent'){
                $fooCertname = trim($this->input->post('cert_name'));
                $fooSex = trim($this->input->post('sex'));
                $fooNation = trim($this->input->post('nation'));
                $fooPersonid = trim($this->input->post('personid'));
                $fooBirthplace = trim($this->input->post('birth_place'));
                $fooLiveplace = trim($this->input->post('live_place'));
                $fooCertBegin = trim($this->input->post('cert_begin'));          //将$fooCertBegin，$fooCertEnd转换为时间戳
                $fooCertEnd = trim($this->input->post('cert_end'));
            
            }
            
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
                $fooResult = $this->talent->createCertBase($fooCUID,$uid,$fooCertname,$fooSex,$fooNation,$fooPersonid,$fooBirthplace,$fooLiveplace,$fooCertBegin,$fooCertEnd);
            }
            
            if($fooResult){
                redirect(base_url("admin/showLuruView/$uid"));
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
        //权限设定
        $power = $this->admin->getPower();
        $powerArray = array(13,99);                 //录入、超管
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
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
                redirect(base_url("admin/showLuruView/$uid"));
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
        //权限设定
        $power = $this->admin->getPower();
        $powerArray = array(13,99);                 //录入、超管
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
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
                redirect(base_url("admin/showLuruView/$uid"));
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
        
        //权限设定
        $power = $this->admin->getPower();
        $powerArray = array(14,99);                 //审核、超管
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
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
            $fooCertBase = $this->talent->searchCertBase($uid);             //获得认证基本信息
            $fooCertBases = $this->turnIndustryidtoName($fooCertBase);
            
            $fooCertFile = $this->talent->searchCertFile($uid);             //获得认证扫描信息
            $fooCertFiles = $this->turnFileTypeidtoName($fooCertFile);
            
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
     * 审核时显示征信扫描件信息、征信文字类信息
     * 以下参数为审核时必须的，故传进来
     * @param type $uid
     * @param type $type
     * @param type $tableType
     * @param type $tid
     */
    public function showFileOrContent($uid,$type,$tableType,$tid){
        //权限设定
        $power = $this->admin->getPower();
        $powerArray = array(14,99);                 //审核、超管
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
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
     * 此处供纳税主体、中介机构、财税人才和客户管理四处查询使用
     * $type = ''时客户管理使用
     * $type != ''时三种征信库使用
     * @return type
     */
    public function searchUsers($type = ''){
        $power = $this->admin->getPower();
        $powerArray = array(13,14,99);
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        $data['power'] = $power;
        $data['flag'] = '';
        if( $type != ''){
            $fooTypeArray = array('topic','medium','talent');
            if( !in_array($type,$fooTypeArray)){
                $data['flag'] = '参数错误！';
                $this->load->view('admin/v_searchUsers',$data);
                return;
            }
            
        }
        
        //使用处表头
        if($type == 'topic'){
            $data['head'] = '纳税主体征信库管理';
        }elseif ($type == 'medium') {
            $data['head'] = '中介机构征信库管理';
        }elseif ($type == 'talent') {
            $data['head'] = '财税人才征信库管理';
        }elseif($type == '') {
            $data['head'] = '客户管理';
        }
        
        if($_POST){
            $fooZxcode = trim($this->input->post('keySearch'));

            //按征信编码查询
            if($fooZxcode != NULL){
                $fooUserBase = $this->userbase->search($fooZxcode,1);               
            } 
            //按类库查询
            if($fooZxcode == NULL && $type != NULL) {
                $fooUserBase = $this->userbase->search($type,2);                 
            }
            //查询全部
            if($fooZxcode == NULL && $type == NULL) {
                $fooUserBase = $this->userbase->search();         
            }

            if($fooUserBase){
                $fooUserBases = $this->searchComName($fooUserBase);
                $data['userBases'] = $fooUserBases;
            }  else {
                $data['flag'] = '没有数据！';
            }

            //将类型传入视图
            $data['type'] = $type;
            if($type != ''){
                $this->load->view('admin/v_searchUsers',$data);
            }  else {
                
                if($power == 13 || $power == 99){
                    $this->load->view('admin/v_manageUsers',$data);
                } 
            }

        }  else {

            if($type != NULL){
                $fooUserBase = $this->userbase->search($type,2);                     //按类库查询
            }  else {
                $fooUserBase = $this->userbase->search();                           //查询全部
            }

            if($fooUserBase){
                $data['userBases'] = $this->searchComName($fooUserBase);
            }  else {
                $data['flag'] = '没有数据！';
            }

            //将类型传入视图
            $data['type'] = $type;
            if($type != ''){
                
                    $this->load->view('admin/v_searchUsers',$data);
                
            }  else {
                
                if($power == 13 || $power == 99){
                    $this->load->view('admin/v_manageUsers',$data);
                } 
                
            }
            
        }
            
    }

    /**
     * 将公司名加入数组中
     * 完全是为查询客户服务，
     * @param type $_userBases
     * @return type
     */
    private function searchComName($_userBases){
        //查询公司名
        if($_userBases){
            foreach ($_userBases as $userBase){
                $fooUID = $userBase['id'];
                $fooType = $userBase['type'];
                if($fooType == 'topic'){
                    $fooCertBase = $this->topic->searchCertBase($fooUID);
                    $userBase['cert_name'] = $fooCertBase[0]['com_name'];
                }elseif ($fooType == 'medium') {
                    $fooCertBase = $this->topic->searchCertBase($fooUID);
                    $userBase['cert_name'] = $fooCertBase[0]['com_name'];
                }elseif ($fooType == 'talent') {
                    $fooCertBase = $this->topic->searchCertBase($fooUID);
                    $userBase['cert_name'] = $fooCertBase[0]['cert_name'];
                }
                
                $fooUserBases[] = $userBase;
            }
            
            return $fooUserBases;
        } 
        
    }

    /**
     * 查看征信编码
     * 新增用户也会用到此方法
     */
    public function searchCode(){
        //权限管理
        $power = $this->admin->getPower();
        $powerArray = array(13,99);                     //录入、超管 
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
        $data = array(
            'power'=>$power,
            'flag' => '',
            'head'=>'征信编码池管理'
        );
        
        if($_POST){
            $fooCode = trim($this->input->post('keySearch'));
            if($fooCode != NULL){
                $fooCodes = $this->zxpool->searchCode($fooCode);
            }  else {
                $fooCodes = $this->zxpool->searchCode();
            }
            
        }  else {
            $fooCodes = $this->zxpool->searchCode();
        }
        
        if($fooCodes){
            $data['zxcodes'] = $fooCodes;
        }  else {
            $data['flag'] = '没有数据！';
        }
        
        $this->load->view('admin/v_searchCode',$data);
        
    }
    
    /**
     * 显示用户信息
     * 征信编码处，通过征信编码查询
     * 
     * TODO：只能查看自己录入的信息
     * 
     * @param type $zxcode
     * @return type
     */
    public function showUserInfos($zxcode){
        //权限管理
        $power = $this->admin->getPower();
        $powerArray = array(13,99);                     //录入、超管 
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
        $data = array(
            'flag'=>'',
            'zxcode' => 0,
            'com_name' => 'known'
        );
        
        $fooUserBase = $this->userbase->search($zxcode,1);

        if($fooUserBase == FALSE){
            $data['flag'] = '没有数据！';
            $this->load->view('admin/v_showUserInfos',$data);
            return;
        }
        
        $fooType = $fooUserBase['0']['type'];
        $fooUID = $fooUserBase['0']['id'];

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

        $this->load->view('admin/v_showUserInfos',$data);
            
    }

    /**
     * 批量导入征信编码
     */
    public function importCode(){
        //权限管理
        $power = $this->admin->getPower();
        $powerArray = array(99);                     //超管 
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
        $data['flag'] = '';
        if($_POST){
            if(!empty($_FILES['file']['name'])){
                
                $endname = substr(strrchr($_FILES['file']['name'],'.'),1);          //截取上传文件的后缀名
                //判断是否为txt格式
                if(!in_array(strtolower($endname),array('txt'))){                  //strtolower()转化为小写，只能打开txt文件    
                    
                    $data['flag'] = '文件格式错误！';
                    $this->load->view('admin/v_importCode',$data);
                    return;
                }                             
                
                $tmp_name = $_FILES['file']['tmp_name'];
                //读取整个文件
                $resourse = file($tmp_name);                      
                //按行遍历数据
                foreach($resourse as $data){                                    
                    //TODO:windows下边换行符是"\r\n"，记得换
                    $fooData = str_replace("\n",'', $data);
                    if(!preg_match("/^[0-9a-z]+$/",$fooData)){
                        //TODO:数据中含有非数字字母
                        $data['flag'] = '文件数据格式错误！';
                        $this->load->view('admin/v_importCode',$data);
                        return;
                    }
                    
                    $codeArray[] = $fooData;
                }
                //数据不为空则导入数据库
                if(!empty($codeArray)){
                    $result = $this->zxpool->createCode($codeArray);
                    if($result){
                        //成功导入
                        //TODO:此处导入成功之后有错误，说没有定义flag，但是找不出原因
                        $data['flag'] = '成功导入！';
                    }
                    
                }  else {
                    //文件中数据为空
                    $data['flag'] = '文件中数据为空！';
                }
                
                $this->load->view('admin/v_importCode',$data);
                
            }  else {
                //未选择导入的文件
                $data['flag'] = '请选择文件！';
                $this->load->view('admin/v_importCode',$data);
            }
            
        } else {
            
            $this->load->view('admin/v_importCode',$data);
        }    
    }
    
    /**
     * 添加征信项目类型,比如营业执照、组织机构代码...
     */
    public function addFileType(){
        //权限管理
        $power = $this->admin->getPower();
        $powerArray = array(99);                     //超管 
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
        $data['flag'] = '';
        if($_POST){
            $fooType = trim($this->input->post('type'));
            $fooFilename = trim($this->input->post('filename'));
            if($fooFilename == NULL){
                $data['flag'] = '请完善信息！';
                $this->load->view('admin/v_addFileType',$data);
                return;
            }
            
            $fooCUID = $this->admin->getUID();
            $fooResult = $this->zxpool->addFileType($fooCUID,$fooFilename,$fooType);
            
            if($fooResult == -1){
                $data['flag'] = '此标题已经存！';
            } elseif ($fooResult == 0){
                $data['flag'] = '提交失败！';
            } elseif ($fooResult == 1){
                $data['flag'] = '添加成功！';
            }
            
            $this->load->view('admin/v_addFileType',$data);
            
        }  else {
            $this->load->view('admin/v_addFileType',$data);
        }
    }


    /**
     * 搜索征信项目类型,比如营业执照、组织机构代码...
     */
    public function searchFileType(){
        //权限管理
        $power = $this->admin->getPower();
        if($power < 1){
            redirect(base_url('admin/login/'));
        }
        
        $data = array(
            'flag'=>'',
            'head'=>'征信项目设置'
        );
        if($_POST){
            $fooType = $this->input->post('type');
            if($fooType == 'topic' || $fooType == 'medium' || $fooType == 'talent'){
                $fooFileTypes = $this->zxpool->searchFileType($fooType,0);          //按所属类型查询
            }
            
        }  else {
            $fooFileTypes = $this->zxpool->searchFileType('topic',0);
        }
        
        if($fooFileTypes){
            $data['fileTypes'] = $fooFileTypes;
        }  else {
            $data['flag'] = '没有数据！';
        }
        
        $this->load->view('admin/v_searchFileType',$data);
    }

    /**
     * 删除征信项目类型,比如营业执照、组织机构代码...
     * @param type $fid
     */
    public function deleteFileType($fid){
        //权限管理
        $power = $this->admin->getPower();
        $powerArray = array(99);                     //超管 
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
        $fooResult = $this->zxpool->deleteFileType($fid);
        if($fooResult){
            redirect(base_url('admin/searchFileType'));
        }
    }
    
    public function addIndustry(){
        //权限管理
        $power = $this->admin->getPower();
        $powerArray = array(99);                     //超管 
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
        $data['flag'] = '';
        if($_POST){
            $fooType = trim($this->input->post('type'));
            $fooFilename = trim($this->input->post('industryName'));
            if($fooFilename == NULL){
                $data['flag'] = '请完善信息！';
                $this->load->view('admin/v_addIndustry',$data);
                return;
            }
            
            $fooCUID = $this->admin->getUID();
            $fooResult = $this->zxpool->addIndustry($fooCUID,$fooFilename,$fooType);
            
            if($fooResult == -1){
                $data['flag'] = '此标题已经存！';
            } elseif ($fooResult == 0){
                $data['flag'] = '提交失败！';
            } elseif ($fooResult == 1){
                $data['flag'] = '添加成功！';
            }
            
            $this->load->view('admin/v_addIndustry',$data);
            
        }  else {
            $this->load->view('admin/v_addIndustry',$data);
        }
    }

    /**
     * 查看行业类别
     */
    public function searchIndustry(){
        //权限管理
        $power = $this->admin->getPower();
        if($power < 1){
            redirect(base_url('admin/login/'));
        }
        
        $data = array(
            'flag'=>'',
            'head'=>'征信项目设置'
        );
        if($_POST){
            $fooType = $this->input->post('type');
            if($fooType == 'topic' || $fooType == 'medium' || $fooType == 'talent'){
                $fooIndustrys = $this->zxpool->searchIndustry($fooType,0);          //按所属类型查询
            }
            
        }  else {
            $fooIndustrys = $this->zxpool->searchIndustry('topic',0);
        }
        
        if($fooIndustrys){
            $data['industrys'] = $fooIndustrys;
        }  else {
            $data['flag'] = '没有数据！';
        }
        
        $this->load->view('admin/v_searchIndustry',$data);
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
    
    
    
//**************************CMS操作**********************************************
    /**
     * cms create a article
     * TODO username，uid
     */
    //create($uid , $username  , $title ,$content, $groupid)
    public function createArticle(){        
        $power = $this->admin->getPower();
        $powerArray = array(12, 99);     //超管 平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        $uid = 0;        //get all group created by everyone
        $status = 1;    // the group isn't deleted
        $groups = $this->cms->getAllGroups($uid, $status);
        $data['groups'] = $groups;

        if(isset($_POST['sub'])){
            $groupid = $this->input->post('gid');
            $title = $this->input->post('title');
            $content = $this->input->post('content'); 
            $uid = $_SESSION['admin']['id'];
            $username = $_SESSION['admin']['username'];
            $result = $this->cms->create($uid ,$username  ,$title, $content, $groupid);
            
            if($result){
                $data['flag'] = 1;
                $data['message'] = '添加成功';   
                $data['gid'] = $groupid;
                
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
        $power = $this->admin->getPower();
        $powerArray = array(12, 99);      //超管 平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        $uid = 0;        //get all group created by everyone
        $status = 1;    // the group isn't deleted
        $groups = $this->cms->getAllGroups($uid, $status);
        
        $groupid = 0;
        if(isset($_GET['groupid'])){
            $groupid = $_GET['groupid'];
        } else {
            foreach ($groups as $row){
                $groupid = $row['gid'];
                break;
            }
        }
        $ajaxGroupsHtml = '';
        $groupsHtml = '<select name="groupid" id="groupid">';
        
        if($groups){
            foreach ($groups as $group){
                if($group['gid'] == $groupid){
                    $groupsHtml .= '<option value="'.$group['gid'].'" selected="selected">'.$group['group_name'].'</option>';
                    $ajaxGroupsHtml .= '<option value="'.$group['gid'].'" selected="selected">'.$group['group_name'].'</option>';
                    continue;;
                }
                $groupsHtml .= '<option value="'.$group['gid'].'">'.$group['group_name'].'</option>';
                $ajaxGroupsHtml .= '<option value="'.$group['gid'].'">'.$group['group_name'].'</option>';
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
        
        $articlehead = '<table>';
        $articleHtml = '<tr>
                        <th>标题(浏览次数)</th><th>作者</th><th>添加时间</th><th>状态</th><th colspan="2">操作</th>
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
                $articleHtml .= '<td>【'.$auditText.'】</td>';
                $articleHtml .= '<td><a href="'.base_url('admin/viewArticle?page='.$currentPage.'&aid='.$row['aid']).'">【查看】</a>';
                $articleHtml .= '<a href="'.base_url('admin/updateArticle?page='.$currentPage.'&aid='.$row['aid']).'">【修改】</a>';
                $articleHtml .= '<a onclick = "alert_deleteArticle('.$row['aid'].','.$row['groupid'].')">【删除】</a>';
                $articleHtml .= '</td>';
                $articleHtml .= '</tr>';
            }
        }
        $articleEnd = '</table>';
        $ajaxArtilceHtml = $articleHtml;
        $articleHtml = $articlehead.$articleHtml.$articleEnd;
        $data['groupsHtml'] = $groupsHtml;
        $data['pageBar'] = $pageBar;
        $data['articleHtml'] = $articleHtml; 
        $ajaxPageBar = substr($pageBar, (strpos($pageBar, '>') + 1), (strlen($pageBar)-24));
        if(isset($_GET['fun']) && $_GET['fun'] == 'ajax'){
            $return = array(
                'groupsHtml'=> $ajaxGroupsHtml,
                'pageBar'=>$ajaxPageBar,
                'articleHtml'=> $ajaxArtilceHtml
            );
            $json = json_encode($return, JSON_FORCE_OBJECT);
            echo $json;
        } else {        
            $this->load->view('admin/v_manageArticle', $data);
        }
    }
    
    /*
     * this method is used for audit the article ,it has three state 
     * 1:represents it's ok,
     * 0:represents it hasn't been audited
     * -1:represents it can't be accepted
     */
    public function auditArticle(){
        //TODO 暂时属于平台管理
        $power = $this->admin->getPower();
        $powerArray = array(12, 14, 99);      //超管 审核权限
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        $aid = $_GET['aid'];
        $audit = $this->input->post('audit');
        $audit_id = $_SESSION['admin']['id'];
        $result = $this->cms->updateAudit($aid, $audit, $audit_id);
        if($result){
            $mess = '审核成功';
            $this->viewArticle($mess);
        }
    }
    
    /**
     * 
     * @param type $mess the pram is used to transfer messege
     */
    public function viewArticle($mess = ''){
        $power = $this->admin->getPower();
        $powerArray = array(12, 14, 99);      //超管 审核权限 平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        $aid = $_GET['aid'];
        $method = 1;    //the method is get a article
        $article = $this->cms->search($aid, $method);

        $selectHtml = '<select name="audit" id="au">';
        if($article[0]['audit'] == 0){
            $selectHtml .= '<option value="0" selected="selected">未审核</option>';
            $selectHtml .= '<option value="1">审核通过</option>';
            $selectHtml .= '<option value="-1">审核不通过</option>';
        } else if($article[0]['audit'] == 1) {
            $selectHtml .= '<option value="1" selected="selected">审核通过</option>';
            $selectHtml .= '<option value="-1">审核不通过</option>';
        } else if($article[0]['audit'] == -1){
            $selectHtml .= '<option value="1">审核通过</option>';
            $selectHtml .= '<option value="-1" selected="selected">审核不通过</option>';
        }
        $selectHtml .= '</select>';
        $data['selectHtml'] = $selectHtml;
        $data['aid'] = $aid;
        $data['article'] = $article;
        $data['mess'] = $mess;
        
        $this->load->view('admin/v_viewArticle', $data);
    }

    /**
     * upate the article ,but we don't update it truely,
     * just create a new article,and the previous article
     * is saved in database
     */
    public function updateArticle(){
        $power = $this->admin->getPower();
        $powerArray = array(12, 99);      //超管 平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        $aid = $_GET['aid'];
        $uid = 0;        //get all group created by everyone
        $status = 1;    // the group isn't deleted
        $groups = $this->cms->getAllGroups($uid, $status);
        $data['groups'] = $groups;
        if(isset($_POST['sub'])){   // if click update article
            $groupid = $this->input->post('gid');
            $title = $this->input->post('title');
            $content = $this->input->post('content'); 
            $username = $_SESSION['admin']['username'];
            $uid = $_SESSION['admin']['id'];
            //step1 insert the article
            $insertId = $this->cms->create($uid ,$username  ,$title, $content, $groupid);
            //step2 if insert article successful ,then update the previous article
            if($insertId > 0){ 
                //    public function updateStatus($aid, $status){
                $status = 0;       // the article is unvisible
                $result = $this->cms->updateStatus($aid, $status);
                if($result){    //if update success ,show current article
                    $data['flag'] = 1;
                    $data['message'] = '修改成功！';
                    $data['aid'] = $insertId;
                    $data['gid'] = $groupid;
                    $data['title'] = $title;
                    $data['content'] = $content;
                    
                    $this->load->view('admin/v_updateArticle', $data);
                } else {    //if upate fail ,delete current article ,and show privious aritcle
                    //delete the current article
                    $re = $this->cms->deleteArticle($insertId);
                    if($re){ // show previous article
                        //get the artilce 
                        $method = 1;    //the method is get a article
                        $article = $this->cms->search($aid, $method);
                        $data['flag'] = 1;
                        $data['message'] = '修改失败！';
                        $data['aid'] = $aid;
                        $data['gid'] = $article[0]['groupid'];
                        $data['title'] = $article[0]['title'];
                        $data['content'] = $article[0]['content'];
                        
                        $this->load->view('admin/v_updateArticle', $data);
                    }
                }
            } else {        //if insert fail ,show previous article
                //get the artilce 
                $method = 1;    //the method is get a article
                $article = $this->cms->search($aid, $method);
                $data['flag'] = 1;
                $data['message'] = '修改失败！';
                $data['aid'] = $aid;
                $data['gid'] = $article[0]['groupid'];
                $data['title'] = $article[0]['title'];
                $data['content'] = $article[0]['content'];

                $this->load->view('admin/v_updateArticle', $data);                
            }
            
        } else {                    //if not click update article            
            //get the artilce 
            $method = 1;    //the method is get a article
            $article = $this->cms->search($aid, $method);
            $data['aid'] = $aid;
            $data['gid'] = $article[0]['groupid'];
            $data['title'] = $article[0]['title'];
            $data['content'] = $article[0]['content'];
            
            $this->load->view('admin/v_updateArticle', $data);
        }
    }

    /**
     * this method is used to delete a article,but not delete it truely
     * just update its status = 0
     */
    public function deleteArticle(){
        $power = $this->admin->getPower();
        $powerArray = array(12, 99);      //超管  平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        $aid = $_GET['aid'];
        $status = 0;
        $result = $this->cms->updateStatus($aid, $status);
        if($result){
            $this->manageArticle();
        }        
    }


    /**
     * this method is used for creating a group of article
     * 
     */
    public function createGroup(){
        $power = $this->admin->getPower();
        $powerArray = array(12, 99);      //超管  平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        $uid = $_SESSION['admin']['id'];
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
            $uid = 0;   //get all groups
            $groupsHtml = $this->getGroupsHtml($uid, $status);

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
            $uid = 0;       //get all groups;
            $groups = $this->cms->getAllGroups($uid, $status);
            if(count($groups) == 0){
                $group_name = '首页';
                $group_url = 'sy';
                $group_summary = '这是所有文章分类的父类，不能被删除';
                $groupfather_id = -1;
                $result = $this->cms->createGroup($uid,$group_name, $group_url, $group_summary, $groupfather_id);
                $groups = $this->cms->getAllGroups($uid, $status);
            }
            $groupsHtml = $this->getGroupsHtml($uid, $status);
            $data['groupsHtml'] = $groupsHtml;
            $this->load->view('admin/v_createGroup', $data);
        }
    }
    
    public function manageGroup(){
        $power = $this->admin->getPower();
        $powerArray = array(12, 99);      //超管 平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        $uid = 0;       //get all groups
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
                        $groupsHtml .= '<td><a href="'.base_url('admin/updateGroup?gid='.$groupChild['gid']).'">修改</td>';
                        $groupsHtml .= '<td><a onclick="alert_deleteGroup('.$groupChild['gid'].')">删除</a></td>';
                        $groupsHtml .= '</tr>';
                    }
                }
        }
        $groupsHtml .= '</table>';
        $data['groupsHtml'] = $groupsHtml; 
        
        $this->load->view('admin/v_manageGroup', $data);
    }
    
    private function getGroupsHtml($uid, $status){
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
        
        return $groupsHtml;
    }

    public function updateGroup(){
        $power = $this->admin->getPower();
        $powerArray = array(12, 99);      //超管 平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
        $gid = $_GET['gid'];
        if(isset($_POST['sub'])) {// if post
            //step1 create a group
            $groupfather_id = trim($_POST['groupfather_id']);
            $group_name = trim($_POST['group_name']);
            $group_url = trim($_POST['group_url']);
            $group_summary = trim($_POST['group_summary']);
            $result = 0;
            if($groupfather_id == -1 || empty($group_name) || empty($group_url) || empty($group_summary)){
                $result = 0;
            } else {
                $uid = $_SESSION['admin']['id'];
                $insertId = $this->cms->createGroup($uid,$group_name, $group_url, $group_summary, $groupfather_id);
                $result = $insertId;
            }
            
            // update the current group's status = 0
            if($result){
                $status = 0;
                $this->cms->updateGroupStatus($gid, $status);
                //getGroupByGroupfather($groupfather_id, $status = 1){
                $status = 1;
                $groupfather_id = $gid;         // update all the prev gid's child
                $childGids = $this->cms->getGroupByGroupfather($groupfather_id, $status);
                //  update all children
                $status = 0;
                foreach ($childGids as $child){  
                    //    public function updateGroup($gid, $groupfather_id = 0,
                    $this->cms->updateGroup($child['gid'], $insertId);
                }
                $data['flag'] = 1;
                $data['message'] = '修改成功！';
                $data['gid'] = $insertId;
                $data['group_name'] = $group_name;
                $data['group_url'] = $group_url;
                $data['group_summary'] = $group_summary;   
                $uid = 0;       //get all groups
                $status = 1;
                $groupsHtml = $this->getGroupsHtml($uid, $status);
                $data['groupsHtml'] = $groupsHtml;
                
                $this->load->view("admin/v_updateGroup", $data);
            } else {    //update fail
                $uid = 0;
                $status = 1;
                $group = $this->cms->getGroupByGid($gid, $status);
                $groups = $this->cms->getAllGroups($uid, $status);
                $groupsHtml = '<select name="groupfather_id" id="groupfather_id">';
                $groupsHtml .= '<option value="-1">请选择一个分类</option>';
                if($groups){
                    foreach ($groups as $row){
                        if($row['gid'] == $group[0]['groupfather_id']){
                            $groupsHtml .= '<option selected="selected" value="'.$row['gid'].'">'.$row['group_name'].'</option>';
                            continue;
                        }
                        $groupsHtml .= '<option value="'.$row['gid'].'">'.$row['group_name'].'</option>';
                    }
                }

                $groupsHtml .= ' </select>';
                
                $data['flag'] = 1;
                $data['message'] = '修改失败！';
                $data['gid'] = $gid;
                $data['group_name'] = $group[0]['group_name'];
                $data['group_url'] = $group[0]['group_url'];
                $data['group_summary'] = $group[0]['group_sumarry'];   
                $data['groupsHtml'] = $groupsHtml;
                
                $this->load->view("admin/v_updateGroup", $data);
            }
            
        } else {    //if not post
            $uid = 0;
            $status = 1;
            $group = $this->cms->getGroupByGid($gid, $status);
            $groups = $this->cms->getAllGroups($uid, $status);
            $groupsHtml = '<select name="groupfather_id" id="groupfather_id">';
            $groupsHtml .= '<option value="-1">请选择一个分类</option>';
            if($groups){
                foreach ($groups as $row){
                    if($row['gid'] == $group[0]['groupfather_id']){
                        $groupsHtml .= '<option selected="selected" value="'.$row['gid'].'">'.$row['group_name'].'</option>';
                        continue;
                    }
                    $groupsHtml .= '<option value="'.$row['gid'].'">'.$row['group_name'].'</option>';
                }
            }

            $groupsHtml .= ' </select>';
            
            $data['gid'] = $gid;
            $data['group_name'] = $group[0]['group_name'];
            $data['group_url'] = $group[0]['group_url'];
            $data['group_summary'] = $group[0]['group_sumarry'];   
            $data['groupsHtml'] = $groupsHtml;
            $this->load->view("admin/v_updateGroup", $data);
        }
    }


    public function deleteGroup(){
        $gid = $_GET['gid'];
        $this->deleteGroup_back($gid);
        
        $this->manageGroup();
        
    }
    
    private function deleteGroup_back($gid){
        $status = 1;
        $childGids = $this->cms->getGroupByGroupfather($gid, $status);
        $status = 0;
        //delete itself
        $this->cms->updateGroupStatus($gid, $status);
        //delete all children
        foreach ($childGids as $child){
            $this->cms->updateGroupStatus($child['gid'], $status);
            $this->deleteGroup_back($child['gid']);
        }
    }
    




    /************************************space******************************************/
    /**
     * this method is used for create article for super user
     */
    public function createSArticle(){ 
        $power = $this->admin->getPower();
        $powerArray = array(12, 99);      //超管 平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        if(isset($_GET['uid'])){        //if the admin click a user 
            $uid = $_GET['uid'];
            $space_status = 1;
            $uidadmin = 0;          // get all groups
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
                    $data['space_gid'] = $space_groupid;
                    
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
                    $username = trim($key);
                    $method = 0;        //search users by username
                    $userspaceList = $this->userbase->search($username, $method);
                    $allRows = count($userspaceList);
                    $page = new Page($allRows);
                    $limit = $page->getLimit(); //the start position        
                    $offset = $page->getOffset();//the offset of count
                    $userspaceList = $this->userbase->search($username, $method, $offset, $limit);
                    break;
                case 'zx_code':
                    $zx_code = trim($key);
                    $method = 1;        //search users by zx_code
                    $userspaceList = $this->userbase->search($zx_code, $method);
                    $allRows = count($userspaceList);
                    $page = new Page($allRows);
                    $limit = $page->getLimit(); //the start position        
                    $offset = $page->getOffset();//the offset of count
                    $userspaceList = $this->userbase->search($zx_code, $method, $offset, $limit);
                    break;
                case 'type':
                    $type = trim($key);
                    if($type == '纳税主体征信库'){
                        $type = 'topic';
                    } else if($type == '中介机构征信库'){
                        $type = 'medium';
                    } else if($type == '财税个人征信库'){
                        $type = 'talent';
                    }
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
                    $type = $row['type'];
                    if($type == 'topic'){
                        $type = '纳税主体征信库';
                    } else if($type == 'medium'){
                        $type = '中介机构征信库';
                    } else if($type == 'talent'){
                        $type = '财税个人征信库';
                    }
                    $userlistHtml .= '<td>'.$type.'</td>';
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
                                    <th>用户名</th><th>征信编码</th><th>征信库类型</th><th>是否开通空间</th>
                                </tr>';                
            if(!empty($userspaceList)){
                foreach ($userspaceList as $row){
                    $userlistHtml .= '<tr>';
                    $userlistHtml .= '<td><a href="'.base_url('admin/'.$m).'?uid='.$row['id'].'">'.$row['username'].'</a></td>';
                    $userlistHtml .= '<td>'.$row['zx_code'].'</td>';
                    $type = $row['type'];
                    if($type == 'topic'){
                        $type = '纳税主体征信库';
                    } else if($type == 'medium'){
                        $type = '中介机构征信库';
                    } else if($type == 'talent'){
                        $type = '财税个人征信库';
                    }
                    $userlistHtml .= '<td>'.$type.'</td>';
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
        $power = $this->admin->getPower();
        $powerArray = array(12, 14, 99);      //超管 审核管理 平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        if(isset($_GET['uid']) || isset($_GET['space_groupid']) || isset($_GET['fun'])){    //if click the username in list
            
            $uidadmin = 0;      // get all groups
            $space_status = 1;
            $space_groups = $this->space->getAllSGroups($uidadmin, $space_status);
            $space_groupid = 0;
            if(isset($_GET['space_groupid'])){
                $space_groupid = $_GET['space_groupid'];
            } else {
                foreach ($space_groups as $row){
                    $space_groupid = $row['space_gid'];
                    break;
                }
            }
            
            $space_uidGid['space_groupid'] = $space_groupid;
            
            $groupsHtml = '';
            $groupsHead = '<select name="space_groupid" id="groupid">';
            if(!empty($space_groups)){
                foreach ($space_groups as $group){
                    if($space_groupid == $group['space_gid']){
                        $groupsHtml .= '<option value="'.$group['space_gid'].'" selected="selected">'.$group['space_group_name'].'</option>';
                        continue;
                    }
                    $groupsHtml .= '<option value="'.$group['space_gid'].'">'.$group['space_group_name'].'</option>';
                }
            } else {
                $groupsHtml .= '<option value="0">没有分类</option>';
            }
            $groupsEnd = ' </select>';
            $ajaxGroupHtml = $groupsHtml;
            $groupsHtml = $groupsHead.$groupsHtml.$groupsEnd;
            
            $space_uid = $_GET['uid'];
            $space_uidGid['space_uid'] = $space_uid;
            $method = 0;    //this represents getUserSArticles()
            $limit = 'start';
            $offset= 'end';
            
            $articles = $this->space->searchS($space_uidGid, $method, $space_status, $limit, $offset);
            $page = new Page(count($articles));
            $limit = $page->getLimit();
            $offset = $page->getOffset();
            $articles = $this->space->searchS($space_uidGid, $method, $space_status, $limit, $offset);
            $pageBar = $page->getPage($articles);
            
            $articleHtml = '';
            $articleHead = '<table>';
            $articleHtml = '<tr>
                            <th>标题(浏览次数)</th><th>作者</th><th>添加时间</th><th>状态</th><th colspan="2">操作</th>
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
                    $articleHtml .= '<td>【'.$auditText.'】</td>';
                    $articleHtml .= '<td><a href="'.base_url('admin/viewSArticle?space_aid='.$row['space_aid']).'">【查看】</a>';
                    $articleHtml .= '<a href="'.base_url('admin/updateSArticle?space_aid='.$row['space_aid']).'">【修改】</a>';
                    $articleHtml .= '<a onclick="alert_deleteSArticle('.$row['space_aid'].','.$row['space_groupid'].','.$space_uid.')">【删除】</a>';
                    $articleHtml .= '</td>';
                    $articleHtml .= '</tr>';
                }
            }
            $articleEnd = '</table>';
            
            $ajaxArticleHtml = $articleHtml;
            $articleHtml = $articleHead.$articleHtml.$articleEnd;
            
            $data['groupsHtml'] = $groupsHtml;
            $data['pageBar'] = $pageBar;
            $data['articleHtml'] = $articleHtml;
            $data['uid'] = $space_uid;
            $ajaxPageBar = substr($pageBar, (strpos($pageBar, '>') + 1), (strlen($pageBar)-24));
            if(isset($_GET['fun']) && $_GET['fun'] = 'ajax'){
                $return = array(
                    'groupsHtml'=> $ajaxGroupHtml,
                    'pageBar'=>$ajaxPageBar,
                    'articleHtml'=> $ajaxArticleHtml
                );
                $json = json_encode($return, JSON_FORCE_OBJECT);
                echo $json;
            } else {        
                 $this->load->view('admin/v_manageSArticle', $data);
            }           
        } else {    // else if(isset($_GET['uid']))
            $m = 'manageSArticle';
            $this->userspaceList($m);
        }
    }
    
   public function auditSArticle(){
        $power = $this->admin->getPower();
        $powerArray = array(12, 14, 99);      //超管 审核权限 平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        $space_aid = $_GET['space_aid'];
        $space_audit = $this->input->post('space_audit');
        $space_uid = $_SESSION['admin']['id'];  
        $space_audit_id = $space_uid;
        $result = $this->space->updateSAudit($space_aid, $space_audit, $space_audit_id);
        if($result){
            $mess = '审核成功';
            $this->viewSArticle($mess);
        }
    }
    
    /**
     * 
     * @param type $mess the pram is used to transfer messege
     */
    public function viewSArticle($mess = ''){
        $power = $this->admin->getPower();
        $powerArray = array(12, 14, 99);      //超管 审核权限 平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        $space_aid = $_GET['space_aid'];
        $method = 1;    //the method is get a article
        $article = $this->space->searchS($space_aid, $method);
        
        $selectHtml = '<select name="space_audit" id="au">';
        if($article[0]['space_audit'] == 0){
            $selectHtml .= '<option value="0" selected="selected">未审核</option>';
            $selectHtml .= '<option value="1">审核通过</option>';
            $selectHtml .= '<option value="-1">审核不通过</option>';
        } else if($article[0]['space_audit'] == 1) {
            $selectHtml .= '<option value="1" selected="selected">审核通过</option>';
            $selectHtml .= '<option value="-1">审核不通过</option>';
        } else if($article[0]['space_audit'] == -1){
            $selectHtml .= '<option value="1">审核通过</option>';
            $selectHtml .= '<option value="-1" selected="selected">审核不通过</option>';
        }
        $selectHtml .= '</select>';
        $data['selectHtml'] = $selectHtml;
        $data['space_aid'] = $space_aid;
        $data['article'] = $article;
        $data['mess'] = $mess;
        
        $this->load->view('admin/v_viewSArticle', $data);
    }
    
    
/**
     * upate the article ,but we don't update it truely,
     * just create a new article,and the previous article
     * is saved in database
     */
    public function updateSArticle(){
        $power = $this->admin->getPower();
        $powerArray = array(12, 99);      //超管 平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        $space_aid = $_GET['space_aid'];
        $uid = 0;        //get all group created by everyone
        $status = 1;    // the group isn't deleted
        echo 'sssssss';
        $groups = $this->space->getAllSGroups($uid, $status);
        echo 'eeeeeeee';
        $data['space_groups'] = $groups;
        if(isset($_POST['sub'])){   // if click update article
            $space_groupid = $this->input->post('space_gid');
            $space_title = $this->input->post('space_title');
            $space_content = $this->input->post('space_content'); 
            $username = $_SESSION['admin']['username'];
            $uid = $_SESSION['admin']['id'];
            //step1 insert the article
            $insertId = $this->space->createS($uid ,$username  ,$space_title, $space_content, $space_groupid);
            echo 'isertid  '.$insertId;
            //step2 if insert article successful ,then update the previous article
            if($insertId > 0){ 
                //    public function updateStatus($aid, $status){
                echo 'suss';
                $status = 0;       // the article is unvisible
                $result = $this->space->updateSStatus($space_aid, $status);
                if($result){    //if update success ,show current article
                    $data['flag'] = 1;
                    $data['message'] = '修改成功！';
                    $data['space_aid'] = $insertId;
                    $data['space_gid'] = $space_groupid;
                    $data['space_title'] = $space_title;
                    $data['space_content'] = $space_content;
                    
                    $this->load->view('admin/v_updateSArticle', $data);
                } else {    //if upate fail ,delete current article ,and show privious aritcle
                    //delete the current article
                    echo 'delet';
                    $re = $this->space->deleteSArticle($insertId);
                    if($re){ // show previous article
                        //get the artilce 
                        $method = 1;    //the method is get a article
                        $article = $this->space->searchS($space_aid, $method);
                        $data['flag'] = 1;
                        $data['message'] = '修改失败！';
                        $data['space_aid'] = $space_aid;
                        $data['space_gid'] = $article[0]['space_groupid'];
                        $data['space_title'] = $article[0]['space_title'];
                        $data['space_content'] = $article[0]['space_content'];
                        
                        $this->load->view('admin/v_updateSArticle', $data);
                    }
                }
            } else {        //if insert fail ,show previous article
                //get the artilce 
                $method = 1;    //the method is get a article
                echo 'fail';
                $article = $this->space->searchS($space_aid, $method);
                $data['flag'] = 1;
                $data['message'] = '修改失败！';
                $data['space_aid'] = $aid;
                $data['space_gid'] = $article[0]['space_groupid'];
                $data['space_title'] = $article[0]['space_title'];
                $data['space_content'] = $article[0]['space_content'];

                $this->load->view('admin/v_updateSArticle', $data);                
            }
            
        } else {                    //if not click update article            
            //get the artilce 
            $method = 1;    //the method is get a article
            $article = $this->space->searchS($space_aid, $method);
            $data['space_aid'] = $space_aid;
            $data['space_gid'] = $article[0]['space_groupid'];
            $data['space_title'] = $article[0]['space_title'];
            $data['space_content'] = $article[0]['space_content'];
            
            $this->load->view('admin/v_updateSArticle', $data);
        }
    }
    
    /**
     * this method is used to delete a article,but not delete it truely
     * just update its status = 0
     */
    public function deleteSArticle(){
        $power = $this->admin->getPower();
        $powerArray = array(12, 99);      //超管  平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        $space_aid = $_GET['space_aid'];
        $space_status = 0;
        $result = $this->space->updateSStatus($space_aid, $space_status);
        if($result){
            $this->manageSArticle();
        }        
    }
    /**
     * this method is used for creating a group of article
     * 
     */
    public function createSGroup(){
        $power = $this->admin->getPower();
        $powerArray = array(12, 99);      //超管 平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        $uid = $_SESSION['admin']['id'];
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
                $result = $this->space->createSGroup($uid,$group_name, $group_url, $group_summary, $groupfather_id);
            }
            $uid = 0;   //get all groups
            $groups = $this->space->getAllSGroups($uid, $status);
            $groupsHtml = '<select name="groupfather_id" id="groupfather_id">';
            $groupsHtml .= '<option value="-1">请选择一个分类</option>';
            if($groups){
                foreach ($groups as $group){
                    if(isset($_POST['sub'])){
                        if($group['space_gid'] == $_POST['groupfather_id']){
                            $groupsHtml .= '<option selected="selected" value="'.$group['space_gid'].'">'.$group['space_group_name'].'</option>';
                            continue;
                        }
                    }
                    $groupsHtml .= '<option value="'.$group['space_gid'].'">'.$group['space_group_name'].'</option>';
                }
            }

            $groupsHtml .= ' </select>';
            $data['groupsHtml'] = $groupsHtml;
            
            if($result){
                $data['flag'] = 1;
                $data['message'] = '添加成功';    
                
                $this->load->view('admin/v_createSGroup', $data);
            } else {
                $data['flag'] = 0;
                $data['message'] = '添加失败<br/>必须选择分类，必须填写完整
                    ';
                $data['groupfather_id'] = $groupfather_id;
                $data['group_name'] = $group_name;
                $data['group_url'] = $group_url;
                $data['group_summary'] = $group_summary;                
                
                $this->load->view('admin/v_createSGroup', $data);
            }
        } else {
            $groups = $this->space->getAllSGroups($uid, $status);
            if(count($groups) == 0){
                $group_name = '首页';
                $group_url = 'sy';
                $group_summary = '这是所有文章分类的父类，不能被删除';
                $groupfather_id = -1;
                $result = $this->space->createSGroup($uid,$group_name, $group_url, $group_summary, $groupfather_id);
                $groups = $this->space->getAllSGroups($uid, $status);
            }
            $groupsHtml = '<select name="groupfather_id" id="groupfather_id">';
            $groupsHtml .= '<option value="-1">请选择一个分类</option>';
            if($groups){
                foreach ($groups as $group){
                    if(isset($_POST['sub'])){
                        if($group['space_gid'] == $_POST['space_groupfather_id']){
                            $groupsHtml .= '<option selected="selected" value="'.$group['space_gid'].'">'.$group['space_group_name'].'</option>';
                            continue;
                        }
                    }
                    $groupsHtml .= '<option value="'.$group['space_gid'].'">'.$group['space_group_name'].'</option>';
                }
            }

            $groupsHtml .= ' </select>';
            $data['groupsHtml'] = $groupsHtml;
            $this->load->view('admin/v_createSGroup', $data);
        }
    }
    
    public function manageSGroup(){
        $power = $this->admin->getPower();
        $powerArray = array(12, 99);      //超管 平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        $uid = 0;       // get all groups 
        $status = 1;    // the group isn't deleted
        $groups = $this->space->getAllSGroups($uid, $status);

        $groupsHtml = '<table>';
        $groupsHtml .= '<tr>
                            <th>文章栏目</th><th>上级分组</th><th colspan="2">操作</th>
                        </tr>';
        if($groups){
            foreach ($groups as $groupfather)
                foreach ($groups as $groupChild){
                    if($groupChild['space_groupfather_id'] == $groupfather['space_gid']){
                        $groupsHtml .= '<tr>';
                        $groupsHtml .= '<td>'.$groupChild['space_group_name'].'</td>';
                        $groupsHtml .= '<td>'.$groupfather['space_group_name'].'</td>';
                        $groupsHtml .= '<td><a href="'.base_url('admin/updateSGroup?space_gid='.$groupChild['space_gid']).'">修改</td>';
                        $groupsHtml .= '<td><a onclick="alert_deleteSGroup('.$groupChild['space_gid'].')">删除</a></td>';
                        $groupsHtml .= '</tr>';
                    }
                }
        } else {
            $groupsHtml .= '<tr>没有分组</tr>';
        }
        $groupsHtml .= '</table>';
        $data['groupsHtml'] = $groupsHtml;        
        $this->load->view('admin/v_manageGroup', $data);
    }
    
    public function updateSGroup(){
        $power = $this->admin->getPower();
        $powerArray = array(12, 99);      //超管 平台管理
        if(!in_array($power, $powerArray)){
            redirect(base_url('admin/login/'));
        }
        
        $space_gid = $_GET['space_gid'];
        if(isset($_POST['sub'])) {// if post
            //step1 create a group
            $space_groupfather_id = trim($_POST['space_groupfather_id']);
            $space_group_name = trim($_POST['space_group_name']);
            $space_group_url = trim($_POST['space_group_url']);
            $space_group_summary = trim($_POST['space_group_summary']);
            $result = 0;
            if($space_groupfather_id == -1 || empty($space_group_name) || empty($space_group_url) || empty($space_group_summary)){
                $result = 0;
            } else {
                $uid = $_SESSION['admin']['id'];
                $insertId = $this->space->createSGroup($uid,$space_group_name, $space_group_url, $space_group_summary, $space_groupfather_id);
                $result = $insertId;
            }
            
            // update the current group's status = 0
            if($result){
                $status = 0;
                $this->space->updateSGroupStatus($space_gid, $status);
                //getGroupByGroupfather($groupfather_id, $status = 1){
                $status = 1;       
                // update all the prev gid's child
                $childGids = $this->space->getSGroupByGroupfather($space_gid, $status);
                //  update all children
                $status = 0;;
                foreach ($childGids as $child){  
                    //    public function updateGroup($gid, $groupfather_id = 0,
                    $this->space->updateSGroup($child['space_gid'], $insertId);
                }
                $data['flag'] = 1;
                $data['message'] = '修改成功！';
                $data['space_gid'] = $insertId;
                $data['group_name'] = $space_group_name;
                $data['group_url'] = $space_group_url;
                $data['group_summary'] = $space_group_summary;   
                $uid = 0;       //get all groups
                $status = 1;
                $uidadmin = 0;      // get all groups
                $space_status = 1;
                $space_groups = $this->space->getAllSGroups($uidadmin, $space_status);
                $groupsHtml = '';
                $groupsHead = '<select name="space_groupid" id="groupid">';
                if(!empty($space_groups)){
                    foreach ($space_groups as $group){
                        if($space_groupfather_id == $group['space_gid']){
                            $groupsHtml .= '<option value="'.$group['space_gid'].'" selected="selected">'.$group['space_group_name'].'</option>';
                            continue;
                        }
                        $groupsHtml .= '<option value="'.$group['space_gid'].'">'.$group['space_group_name'].'</option>';
                    }
                } else {
                    $groupsHtml .= '<option value="0">没有分类</option>';
                }
                $groupsEnd = ' </select>';
                $ajaxGroupHtml = $groupsHtml;
                $groupsHtml = $groupsHead.$groupsHtml.$groupsEnd;
                $data['groupsHtml'] = $groupsHtml;
                
                $this->load->view("admin/v_updateSGroup", $data);
            } else {    //update fail
                $uid = 0;
                $status = 1;
                $group = $this->cms->getGroupByGid($gid, $status);
                $groups = $this->cms->getAllGroups($uid, $status);
                $groupsHtml = '<select name="groupfather_id" id="groupfather_id">';
                $groupsHtml .= '<option value="-1">请选择一个分类</option>';
                if($groups){
                    foreach ($groups as $row){
                        if($row['gid'] == $group[0]['groupfather_id']){
                            $groupsHtml .= '<option selected="selected" value="'.$row['gid'].'">'.$row['group_name'].'</option>';
                            continue;
                        }
                        $groupsHtml .= '<option value="'.$row['gid'].'">'.$row['group_name'].'</option>';
                    }
                }

                $groupsHtml .= ' </select>';
                
                $data['flag'] = 1;
                $data['message'] = '修改失败！';
                $data['gid'] = $gid;
                $data['group_name'] = $group[0]['group_name'];
                $data['group_url'] = $group[0]['group_url'];
                $data['group_summary'] = $group[0]['group_sumarry'];   
                $data['groupsHtml'] = $groupsHtml;
                
                $this->load->view("admin/v_updateSGroup", $data);
            }
            
        } else {    //if not post
            $uid = 0;
            $status = 1;
            $group = $this->space->getSGroupByGid($space_gid, $status);
            $groups = $this->space->getAllSGroups($uid, $status);
            $groupsHtml = '<select name="space_groupfather_id" id="groupfather_id">';
            $groupsHtml .= '<option value="-1">请选择一个分类</option>';
            if($groups){
                foreach ($groups as $row){
                    if($row['space_gid'] == $group[0]['space_groupfather_id']){
                        $groupsHtml .= '<option selected="selected" value="'.$row['space_gid'].'">'.$row['space_group_name'].'</option>';
                        continue;
                    }
                    $groupsHtml .= '<option value="'.$row['space_gid'].'">'.$row['space_group_name'].'</option>';
                }
            }

            $groupsHtml .= ' </select>';
            $data['space_gid'] = $space_gid;
            $data['group_name'] = $group[0]['space_group_name'];
            $data['group_url'] = $group[0]['space_group_url'];
            $data['group_summary'] = $group[0]['space_group_sumarry'];   
            $data['groupsHtml'] = $groupsHtml;
            $this->load->view("admin/v_updateSGroup", $data);
        }
    }
    
    public function deleteSGroup(){
        $space_gid = $_GET['space_gid'];
        $this->deleteSGroup_back($space_gid);
        
        $this->manageSGroup();
        
    }
    
    private function deleteSGroup_back($space_gid){
        $status = 1;
        $childGids = $this->space->getSGroupByGroupfather($space_gid, $status);
        $status = 0;
        //delete itself
        $this->space->updateSGroupStatus($space_gid, $status);
        //delete all children
        foreach ($childGids as $child){
            $this->space->updateSGroupStatus($child['space_gid'], $status);
            $this->deleteGroup_back($child['space_gid']);
        }
    }
    
}# end of class




//End of file admin.php