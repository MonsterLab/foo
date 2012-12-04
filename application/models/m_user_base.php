<?php
//开启session
if(!isset($_SESSION)){
    session_start();
}
/**
 * 管理员模型
 * createAdmin()
 * deleteAdmin()
 * updateAdmin()
 * searchAdmin()
 * login()
 * logout()
 * 
 * 
 * 
 * private checkUsername()
 * private setSession()
 * 
 */
class M_admin extends CI_Controller{
   public function __construct() {
       parent::__construct();
       $this->load->database();
   }
   
   /**
    * 新增管理员
    * 
    * @param type $username
    * @param type $password
    * @param type $truename
    * @param type $department
    * @param type $phone
    * @param type $email
    * @return boolean           成功返回 1，失败返回 0，用户名存在返回 -1
    */
   public function createAdmin($username,$password,$truename,$department,$phone,$power,$email){
       $isExist = $this->checkUsername($username);
       if($isExist){
           //用户名存在，返回-1
           return -1;
       }
       
       $sqlQuery = array(
           'username'=>$username,
           'password'=>$password,
           '$truename'=>$truename,
           'department'=>$department,
           'phone'=>$phone,
           'power'=>$power,
           'email'=>$email
       );
       $this->db->insert('admin',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return 1;
       }  else {
           
           return 0;
       }
       
   }
   
   /**
    * 删除管理员
    * 
    * @param type $uid
    * @return boolean       成功返回true，失败返回false
    */
   public function deleteAdmin($uid){
       $this->db->where('id',$uid);
       $this->db->delete('admin');
       if($this->db->affected_rows() > 0){
           
           return true;
       }  else {
           
           return FALSE;
       }
       
   }
   
   /**
    * 修改管理员信息
    * 
    * @param type $uid
    * @param type $username
    * @param type $password
    * @param type $truename
    * @param type $department
    * @param type $phone
    * @param type $email
    * @return int                       成功返回 1，失败返回 0 ，用户名存在返回 -1
    */
   public function updateAdmin($uid,$username,$password,$truename,$department,$phone,$power,$email){
       $isExist = $this->checkUsername($username);
       if($isExist){
           //用户名存在返回-1
           return -1;
       }
       $sqlQuery = array(
           'username'=>$username,
           'password'=>$password,
           '$truename'=>$truename,
           'department'=>$department,
           'phone'=>$phone,
           'power'=>$power,
           'email'=>$email
       );
       $this->db->where('id',$uid);
       $this->db->update('admin',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return 1;
       }  else {
           
           return 0;
       }
   }
   
   /**
    * 查询管理员
    * 
    * @param type $key          关键字，默认为空 ； 如果关键字为空，则全部查询
    * @param int $method        选择搜索方法，默认0； 0用户名，1真实姓名，2部门，3id
    * @return array             成功返回数组，失败返回false
    */
   public function searchAdmin($key = '',$method = 0){
       //设置查询方法
       if($method == 0){
           $sqlQuery = 'username';      //按用户名查询
       }
       if($method == 1){
           $sqlQuery = 'truename';      //按真实名查询
       }
       if($method == 2){
           $sqlQuery = 'department';    //按部门查询
       }
       if($method == 3){
           $sqlQuery = 'id';            //按管理员id查询
       }
       //若关键字不为空，设置查询条件
       if($key != ''){
           $this->db->where($sqlQuery,$key);
       }
       $this->db->select('id,username,password,department,phone,power,email');
       $dbResult = $this->db->get('admin');
       if($dbResult->num_rows() > 0){
           foreach ($dbResult->result_array() as $row){
               $result[] = $row;
           }
           $dbResult->free_result();
           
           return $result;
       }  else {
           
           return FALSE;
       }
       
       
   }
   
   /**
    * 管理员登录
    * 
    * @param type $username
    * @param type $password
    * @return int               成功返回1 ，不存在此用户返回 -1 ，密码错误返回 0 ；
    */
   public function login($username,$password){
       $isExist = $this->checkUsername($username);
       if(!$isExist){
           //不存在此用户，返回-1
           return -1;
       }
       $this->db->where('username',$username);
       $this->db->where('password',$password);
       $this->db->select('id,power');
       $dbResult = $this->db->get('admin');
       if($dbResult->num_rows() > 0){
           $result = $dbResult->row_array();
           
           $dbResult->free_result();
           
           $sessionArray = array(
               'id'=>$result['id'],
               'username'=>$username,
               'password'=>$password,
               'power'=>$result['power']
           );
           $this->setSession($sessionArray);
           
           return 1;
       }  else {
           //密码错误，返回0
           return 0;
       }
   }
   
   /**
    * 登出
    */
   public function logout(){
       session_destroy();
   }

      
   /**
    * 检验用户名是否存在
    * 存在，return true
    * 不存在，return false
    * @param type $_username
    * @return boolean
    */
   private function checkUsername($_username){
       $this->db->where('username',$_username);
       $this->db->select('id');
       $dbResult = $this->db->get('admin');
       
       if($dbResult->num_rows() > 0){
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
   }
   /**
    * 设置session
    * @param type $_sessionArray
    */
   private function setSession($_sessionArray){
       
       $_SESSION['admin'] = $_sessionArray;
   }
   
   /**
    * 获得管理员权限
    * @return int / boolean
    */
   public function getPower(){
       if(isset($_SESSION['admin'])){
           
           return $_SESSION['power'];
       }  else {
           
           return FALSE;
       }
   }
   
   
   
}