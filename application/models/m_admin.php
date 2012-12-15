<?php

/**
 * 管理员模型
 * create()                     新增管理员
 * delete()                     删除
 * update()                     更新管理员信息
 * search()                     查询
 * login()                      登录
 * logout()                     登出
 * getPower()                   获得管理员权限
 *      
 * private checkUsername()      检查用户名是否存在
 * private setSession()         设置session
 *  
 */
class M_admin extends CI_Model{
   public function __construct() {
       parent::__construct();
       $this->load->database();
   }
   
   /**
    * 新增管理员
    * 
    * @param int $cuid                      //创建人id
    * @param type $username                 //用户名
    * @param type $password                 //密码
    * @param type $truename                 //真实姓名，使用人
    * @param type $department               //部门
    * @param type $phone                    //电话
    * @param type $email                    //E-mail
    * 
    * @return boolean                       //成功返回 1，失败返回 0，用户名存在返回 -1
    */
   public function create($cuid,$username,$password,$truename,$department,$phone,$power,$email){
       $isExist = $this->checkUsername($username);
       if($isExist){
           //用户名存在，返回-1
           return -1;
       }
       
       $sqlQuery = array(
           'cuid'=>$cuid,
           'username'=>$username,
           'password'=>$password,
           'truename'=>$truename,
           'department'=>$department,
           'phone'=>$phone,
           'power'=>$power,
           'email'=>$email
       );
       $this->db->insert('zx_admin',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return 1;
       }  else {
           
           return 0;
       }
       
   }
   
   /**
    * 删除管理员
    * 
    * 不提共删除，只是将该管理员状态status 置 0，弃用
    * 
    * @param type $uid
    * @return boolean       成功返回true，失败返回false
    */
   public function delete($uid){
       $sqlQuery = array('status'=>0);
       
       $this->db->where('id',$uid);
       $this->db->update('zx_admin',$sqlQuery);
       
       if($this->db->affected_rows() > 0){
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
   }
   
   /**
    * 修改管理员信息
    * 
    * @param type $uid                          //用户id
    * @param type $password                     //用户密码
    * @param type $truename                     //真实姓名，使用人
    * @param type $department                   //部门
    * @param type $phone                        //电话
    * @param type $email                        //E-mail
    * 
    * @return boobean                       
    */
   public function update($uid,$password,$truename,$department,$phone,$power,$email){
       $sqlQuery = array(
           'password'=>$password,
           'truename'=>$truename,
           'department'=>$department,
           'phone'=>$phone,
           'power'=>$power,
           'email'=>$email
       );
       $this->db->where('id',$uid);
       $this->db->update('zx_admin',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return TRUE;
       }  else {
           
           return false;
       }
   }
   
   /**
    * 查询管理员
    * 
    * @param type $key          关键字，默认为空 ； 如果关键字为空，则全部查询
    * @param int $method        选择搜索方法，默认0； 0用户名，1真实姓名，2部门，3id
    * @param int $limit         分页每页的显示条数
    * @param int $offset        分页的开始位置
    * 
    * @return array             成功返回数组，失败返回false
    */
   public function search($key = '',$method = 0,$limit = 10,$offset = 0){
        //若关键字不为空，设置查询条件
        if($key != ''){
           
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
           
           $this->db->where($sqlQuery,$key);
       }
       
       $this->db->where('status',1);        //查询没有被弃用的用户
       $this->db->select('id,username,truename,department,phone,power,email,cuid,ctime');
       $dbResult = $this->db->get('zx_admin',$limit,$offset);
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
       $dbResult = $this->db->get('zx_admin');
       if($dbResult->num_rows() > 0){
           $result = $dbResult->row_array();
           
           $dbResult->free_result();
           
           $sessionArray = array(
               'id'=>$result['id'],
               'username'=>$username,
               'power'=>$result['power']
           );
           $this->setSession($sessionArray);                //设置session
           
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
       $dbResult = $this->db->get('zx_admin');
       
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
    * 检查管理员是否登录，并获得管理员权限
    * 
    * @return int / boolean
    */
   public function getPower(){
       if(isset($_SESSION['admin'])){
           if(empty($_SESSION['admin']['power'])){
               
               return FALSE;
           }  else {
               
               return $_SESSION['admin']['power'];
           }          
       }  else {       
           
           return FALSE;
       }
   }
   
   /**
    * 获得管理员id
    * @return boolean
    */
   public function getUID(){
       if(isset($_SESSION['admin'])){
           if(empty($_SESSION['admin']['id'])){
               
               return FALSE;
           }  else {
               
               return $_SESSION['admin']['id'];
           }          
       }  else {       
           
           return FALSE;
       }
   }

   
}


//End of m_admin.php