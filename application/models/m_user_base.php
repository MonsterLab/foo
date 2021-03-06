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
    * @return int                                   成功返回 id，失败返回 0，用户名存在返回 所增用户id
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
           'truename'=>$truename,
           'position'=>$position,
           'phone'=>$phone,
           'email'=>$email,
           'type'=>$type
       );
       $this->db->insert('zx_user_base',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           
           
           return $this->db->insert_id();
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
   public function delete($uid,$zxcode,$type=''){
       $sqlQuery = array('status'=>0);
       
       if($type == 'topic'){
            $this->db->trans_start();//开启事务
            $this->db->update('zx_user_base',$sqlQuery,array('id'=>$uid));
            $this->db->update('zx_topic_cert_base',$sqlQuery,array('uid'=>$uid));
            $this->db->update('zx_topic_cert_file',$sqlQuery,array('uid'=>$uid));
            $this->db->update('zx_topic_cert_content',$sqlQuery,array('uid'=>$uid));
            $this->db->update('zx_code',array('status'=>-1),array('zx_code'=>$zxcode));
            $this->db->trans_complete();//提交事务
       }
       if($type == 'medium'){
           $this->db->trans_start();//开启事务
            $this->db->update('zx_user_base',$sqlQuery,array('id'=>$uid));
            $this->db->update('zx_medium_cert_base',$sqlQuery,array('uid'=>$uid));
            $this->db->update('zx_medium_cert_file',$sqlQuery,array('uid'=>$uid));
            $this->db->update('zx_medium_cert_content',$sqlQuery,array('uid'=>$uid));
            $this->db->update('zx_code',array('status'=>-1),array('zx_code'=>$zxcode));
            $this->db->trans_complete();//提交事务
       }
       if($type == 'talent'){
           $this->db->trans_start();//开启事务
            $this->db->update('zx_user_base',$sqlQuery,array('id'=>$uid));
            $this->db->update('zx_talent_cert_base',$sqlQuery,array('uid'=>$uid));
            $this->db->update('zx_talent_cert_file',$sqlQuery,array('uid'=>$uid));
            $this->db->update('zx_talent_cert_content',$sqlQuery,array('uid'=>$uid));
            $this->db->update('zx_code',array('status'=>-1),array('zx_code'=>$zxcode));
            $this->db->trans_complete();//提交事务
       }
       if($this->db->trans_status()){
           return TRUE;
       }  else {
           return FALSE;
       }
       
   }
   
   /**
    * 修改客户基本信息
    * 
    * @param type $sq_code                          授权码
    * @param type $password                         密码
    * @param type $truename                         真实姓名，联系人
    * @param type $position                         职务
    * @param type $phone                            电话
    * @param type $email                            E-mail
    * @param type $type                             客户征信类型 topic、medium、talent 
    * 
    * @return int                       成功返回 1，失败返回 0 
    */
   public function update($uid,$sq_code,$password,$truename,$position,$phone,$email,$type){
       $sqlQuery = array(
           'sq_code'=>$sq_code,
           'password'=>$password,
           'truename'=>$truename,
           'position'=>$position,
           'phone'=>$phone,
           'email'=>$email,
           'type'=>$type
       );
       $this->db->where('id',$uid);
       $dbUpdate = $this->db->update('zx_user_base',$sqlQuery);
       if($dbUpdate > 0){
           
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
    * @param boolean $$isStatus             //判断是否查询status=0的数据，$isStatus=true默认不查询，$isStatus=false则查询
    * @param int $limit 分页每页的显示条数
    * @param int $offset 分页的开始位置
    * 
    * @return array                     //成功返回数组，失败返回false
    */
   public function search($key = '',$method = 0 ,$limit = 10,$offset = 0,$isStatus = true,$type = ''){
       
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
            if($method == 4){                   //创建
                $sqlQuery = 'cuid';
            }
            if($method == 5){                   //审核
                $sqlQuery = 'audit_id';
            }
            
           $this->db->where($sqlQuery,$key);
           
           //这是配合$method=4、5使用，查询出该类行的，自己创造或者审核的用户
           if($type != ''){
               $this->db->where('type',$type);
           }
       }
       
       if(!($limit == 'end' && $offset == 'start')){
           $this->db->limit($limit,$offset);
       }
       if($isStatus){
            $this->db->where('status',1);        //查询没有被弃用的用户
       }
       $this->db->select('id,zx_code,sq_code,username,password,truename,position,phone,email,type,space_id,audit,audit_id,cuid,ctime');
       $this->db->order_by('id','desc');
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
       //$space_id > 0开通空间，  < 0 关闭空间
        $this->db->where('id',$uid);
        $this->db->update('zx_user_base',array('space_id'=>$space_id));

        if($this->db->affected_rows() > 0){

            return TRUE;
        }
       
       return FALSE;
       
   }


   /**
    * 审核  客户基本信息
    * 审核通过置audit 1 
    * 审核未通过置audit -1 ，并且将status置...不能删除
    * @param type $audit_id
    * @param type $base_id
    * @param type $isPass
    * @return boolean
    */
   public function auditUserBase($audit_id,$base_id,$isPass = 0){
       //1、根据审核情况作出处理,2、检查传入审核情况参数值是否正确
       if($isPass == -1){                                    //未通过审核
           $sqlQuery = array(
                'audit_id'=>$audit_id,
                'audit'=>$isPass,
            );
           
       }  elseif($isPass == 1) {                            //通过审核
           $sqlQuery = array(
                'audit_id'=>$audit_id,
                'audit'=>$isPass
            );
           
       }  else {                                            
           //审核情况参数错误
           return FALSE;
       }
       
       $this->db->where('id',$base_id);
       $this->db->update('zx_user_base',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
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
   public function checkUsername($username){
       $this->db->where('username',$username);
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
           if(!empty($_SESSION['user']['id'])){

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