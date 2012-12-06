<?php

/**
 * 客户基本信息
 * 
 * create()                     添加用户基本信息
 * delete()                     删除
 * update()                     更新用户基本信息
 * search()                     查询
 * login()                      登录
 * logout()                     登出
 * getPower()                   检查用户是否登录
 *      
 * private checkUsername()      检查用户名是否存在
 * private setSession()         设置session
 * 
 */
class M_user_base extends CI_Model{
   public function __construct() {
       parent::__construct();
       $this->load->database();
   }
   
   
   /**
    * 新增客户基本信息
    * 
    * @param type $cuid                             新建人id
    * @param type $zx_code                          征信编码
    * @param type $sq_code                          授权码
    * @param type $username                         用户名
    * @param type $password                         密码
    * @param type $truename                         真实姓名，联系人
    * @param type $position                         职务
    * @param type $phone                            电话
    * @param type $email                            E-mail
    * @param type $type                             客户征信类型 topic、medium、talent 
    * 
    * @return int                                   成功返回 1，失败返回 0，用户名存在返回 -1
    */
   public function create($cuid,$zx_code,$sq_code,$username,$password,$truename,$position,$phone,$email,$type){
       $isExist = $this->checkUsername($username);
       if($isExist){
           //用户名存在，返回-1
           return -1;
       }
       
       $sqlQuery = array(
           'cuid'=>$cuid,
           'zx_code'=>$zx_code,
           'sq_code'=>$sq_code,
           'username'=>$username,
           'password'=>$password,
           '$truename'=>$truename,
           'position'=>$position,
           'phone'=>$phone,
           'email'=>$email,
           'type'=>$type
       );
       $this->db->insert('zx_user_base',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return 1;
       }  else {
           
           return 0;
       }
       
   }
   
   /**
    * 删除用户基本信息
    * 
    * 不提共删除，只是将该管理员状态status 置 0，弃用
    * 
    * @param type $uid
    * @return boolean       成功返回true，失败返回false
    */
   public function delete($uid){
       $sqlQuery = array('status'=>0);
       
       $this->db->where('id',$uid);
       $this->db->update('zx_user_base',$sqlQuery);
       
       if($this->db->affected_rows() > 0){
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
       
   }
   
   /**
    * 修改客户基本信息
    * 
    * @param type $zx_code                          征信编码
    * @param type $sq_code                          授权码
    * @param type $username                         用户名
    * @param type $password                         密码
    * @param type $truename                         真实姓名，联系人
    * @param type $position                         职务
    * @param type $phone                            电话
    * @param type $email                            E-mail
    * @param type $type                             客户征信类型 topic、medium、talent 
    * 
    * @return int                       成功返回 1，失败返回 0 ，用户名存在返回 -1
    */
   public function update($uid,$zx_code,$sq_code,$password,$truename,$position,$phone,$email,$type){
       $sqlQuery = array(
           'zx_code'=>$zx_code,
           'sq_code'=>$sq_code,
           'password'=>$password,
           '$truename'=>$truename,
           'position'=>$position,
           'phone'=>$phone,
           'email'=>$email,
           'type'=>$type
       );
       $this->db->where('id',$uid);
       $this->db->update('zx_user_base',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return 1;
       }  else {
           
           return 0;
       }
   }
   
   /**
    * 查询用户基本信息
    * 
    * @param type $key                  //关键字，默认为空 ； 如果关键字为空，则全部查询
    * @param int $method                //选择搜索方法，默认0； 0用户名，1征信编码，2 征信库类别 ， 3 用户id
    * @return array                     //成功返回数组，失败返回false
    */
   public function search($key = '',$method = 0){
       
       //若关键字不为空，设置查询条件
       if($key != ''){
           //设置查询方法
            if($method == 0){
                $sqlQuery = 'username';      //按用户名查询
            }
            if($method == 1){
                $sqlQuery = 'zx_code';       //按征信编码
            }
            if($method == 2){
                $sqlQuery = 'type';          //按客户征信库类型搜索
            }
            if($method == 3){
                $sqlQuery = 'id';            //用户id查询
            }
            
           $this->db->where($sqlQuery,$key);
       }
       
       $this->db->where('status',1);        //查询没有被弃用的用户
       $this->db->select('id,zx_code,sq_code,username,password,truename,position,phone,power,email');
       $dbResult = $this->db->get('zx_user_base');
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
    * 为用户开通空间
    * 将空间id 即 space_id 置为制定id
    * 
    * @param type $uid
    * @param type $space_id
    * @return boolean                   成功返回true，失败false
    */
   public function setSpaceId($uid,$space_id){
       //检验space_id必须大于0 
       if($space_id > 0){
            $this->db->where('id',$uid);
            $this->db->update('zx_user_base',array('space_id',$space_id));
            
            if($this->db->affected_rows() > 0){
                
                return TRUE;
            }
       }
       
       return FALSE;
       
   }


   /**
    * 用户登录
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
       $this->db->select('id');
       $dbResult = $this->db->get('zx_user_base');
       if($dbResult->num_rows() > 0){
           $result = $dbResult->row_array();
           
           $dbResult->free_result();
           
           $sessionArray = array(
               'id'=>$result['id'],
               'username'=>$username,
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
    * 
    * 存在，return true
    * 不存在，return false
    * 
    * @param type $_username
    * @return boolean
    */
   private function checkUsername($_username){
       $this->db->where('username',$_username);
       $this->db->where('status',1);
       $this->db->select('id');
       $dbResult = $this->db->get('zx_user_base');
       
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
       
       $_SESSION['user'] = $_sessionArray;
   }
   
   /**
    * 检查用户是否登录
    * 
    * 登录返回true，没有返回false
    * @return boolean
    */
   public function getPower(){
       if(isset($_SESSION['user'])){
           if(empty($_SESSION['user']['id'])){
               
               return TRUE;
           }  else {
               
               return FALSE;
           }
           
       }  else {
           
           return FALSE;
       }
   }
   
   
   
}



//End of m_user_base.php