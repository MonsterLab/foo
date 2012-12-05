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
           '$truename'=>$truename,
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
    * @return int                       成功返回 1，失败返回 0 ，用户名存在返回 -1
    */
   public function update($uid,$password,$truename,$department,$phone,$power,$email){
       $sqlQuery = array(
           'password'=>$password,
           '$truename'=>$truename,
           'department'=>$department,
           'phone'=>$phone,
           'power'=>$power,
           'email'=>$email
       );
       $this->db->where('id',$uid);
       $this->db->update('zx_admin',$sqlQuery);
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
    * @param int $limit 分页每页的显示条数
    * @param int $offset 分页的开始位置
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
       $this->db->select('id,username,password,truename,department,phone,power,email');
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
   
   /*--------------------------------征信编码池管理-------------------------------*/
   
   public function createCode(){
       
   }
   
   /**
    * 查询征信编码
    * 
    * 输入编码空则全部返回
    * @param type $zxCode
    * @return boolean
    */
   public function searchCode($zxCode = ''){
       if($zxCode != ''){
           $this->db->where('zx_code',$zxCode);
       }
       
       $this->db->select('id,zx_code,status');
       $dbResult = $this->db->get('zx_code');
       
       if($dbResult->num_rows() > 0){
           foreach ($dbResult->result_array() as $row){
               $result[] = $row;
           }
           
           return $result;
       }  else {
           
           return FALSE;
       }
       
   }


   /**-------------------------------行业分类管理--------------------------------**/
   /**
    * 添加行业分类
    * 
    * @param type $cuid                         添加人
    * @param type $industry_name                行业类名      
    * @param type $type                         所属征信库类型，topic、medium、talent
    * @return int                               成功返回 1 ，失败 返回 0，行业名存在返回 -1
    */
   public function addIndustry($cuid,$industry_name,$type){
       $isExist = $this->checkIndustryName($industry_name,$type);
       if($isExist){
           //行业名已经存在
           return -1;
       }
       
       $sqlQuery = array(
           'cuid'=>$cuid,
           'industry_name'=>$industry_name,
           'type'=>$type
       );
       $this->db->insert('zx_industry_type',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return 1;
       }  else {
           
           return 0;
       }
   }
   
   /**
    * 删除行业分类
    * 
    * @param type $industryId
    * @return boolean
    */
   public function deleteIndustry($industryId){
       
       $this->db->where('id',$industryId);
       $this->db->update('zx_industry_type',array('status'=>0));
       
       if($this->db->affected_rows() > 0){
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
       
   }
   
   /**
    * 修改行业类型信息
    * @param type $industyId
    * @param type $industry_name
    * @param type $type                         所属征信库
    * @return int                               -1 行业名存在，0 失败 ，1 成功
    */
   public function updateIndusty($industyId,$industry_name,$type){
       $isExist = $this->checkIndustryName($industry_name, $type);
       if($isExist){
           
           return -1;
       }
       
       $sqlQuery = array(
           'industry_name'=>$industry_name,
           'type'=>$type
       );
       $this->db->where('id',$industyId);
       $this->db->update('zx_industry_type',$sqlQuery);
       
       if($this->db->affected_rows() > 0){
           
           return 1;
       }  else {
           
           return 0;
       }
   }

   /**
    * 查询行业类型
    * @param type $key                      关键字
    * @param type $method                   查方法默认0 ； 0 所属征信库类型，1 行业名  
    * @return boolean                       
    */
   public function searchIndustry($key = '',$method = 0){
       //若关键字不为空，设置查询条件
       if($key != ''){
           //设置查询方法
           if($method == 0){
               $this->db->where('type',$key);                  //按所属征信库类型查询
           }
           if($method == 1){
               $this->db->where('industry_name',$key);
           }
       }
       $this->db->where('status',1);
       $this->db->select('id,industry_name,type');
       $dbResult = $this->db->get('zx_industry_type');
       
       if($dbResult->num_rows() > 0){
           foreach ($dbResult->result_array() as $row){
               $result[] = $row;
           }
           
           return $result;
       }  else {
           
           return false;
       }
       
   }

   /**
    * 检查某个征信库中行业类型名是否存在
    * 存在返回true，没有返回false
    * @param type $_industryName
    * @return boolean
    */
   private function checkIndustryName($_industryName,$_type){
       $this->db->where('industry_name',$_industryName);
       $this->db->where('type',$_type);
       $this->db->select('id');
       $dbResult = $this->db->get('zx_industry_type');
       
       if($dbResult->num_rows() > 0){
           $dbResult->free_result();
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
   }
   
   
   /*----------------------------------上传扫描键类型管理---------------------------------*/
   /**
    * 添加上传扫描键类型
    * 
    * @param type $cuid                         添加人
    * @param type $industry_name                上传扫描键类型名      
    * @param type $type                         所属征信库类型，topic、medium、talent
    * @return int                               成功返回 1 ，失败 返回 0，上传扫描键类型名存在返回 -1
    */
   public function addFileType($cuid,$file_type,$type){
       $isExist = $this->checkIndustryName($file_type,$type);
       if($isExist){
           //行业名已经存在
           return -1;
       }
       
       $sqlQuery = array(
           'cuid'=>$cuid,
           'file_type'=>$file_type,
           'type'=>$type
       );
       $this->db->insert('zx_file_type',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return 1;
       }  else {
           
           return 0;
       }
   }
   
   /**
    * 删除扫描件类型
    * 
    * @param type $fileTypeId
    * @return boolean
    */
   public function deleteFileType($fileTypeId){
       
       $this->db->where('id',$fileTypeId);
       $this->db->update('zx_file_type',array('status'=>0));
       
       if($this->db->affected_rows() > 0){
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
       
   }
   
   /**
    * 修改扫描键类型信息
    * @param type $fileTypeid
    * @param type $fileType
    * @param type $type                         所属征信库
    * @return int                               -1 名存在，0 失败 ，1 成功
    */
   public function updateFileType($fileTypeid,$fileType,$type){
       $isExist = $this->checkFileType($fileType, $type);
       if($isExist){
           return -1;
       }
       
       $sqlQuery = array(
           'file_type'=>$fileType,
           'type'=>$type
       );
       $this->db->where('id',$fileTypeid);
       $this->db->update('zx_file_type',$sqlQuery);
       
       if($this->db->affected_rows() > 0){
           
           return 1;
       }  else {
           
           return 0;
       }
   }

   /**
    * 查询扫描键类型
    * @param type $key                      关键字
    * @param type $method                   查方法默认0 ； 0 所属征信库类型，1 行业名  
    * @return boolean                       
    */
   public function searchFileType($key = '',$method = 0){
       //若关键字不为空，设置查询条件
       if($key != ''){
           //设置查询方法
           if($method == 0){
               $this->db->where('type',$key);                  //按所属征信库类型查询
           }
           if($method == 1){
               $this->db->where('file_type',$key);              //类型名
           }
       }
       $this->db->where('status',1);
       $this->db->select('id,file_type,type');
       $dbResult = $this->db->get('zx_file_type');
       
       if($dbResult->num_rows() > 0){
           foreach ($dbResult->result_array() as $row){
               $result[] = $row;
           }
           
           return $result;
       }  else {
           
           return false;
       }
       
   }

   /**
    * 检查某个征信库中类型名是否存在
    * 存在返回true，没有返回false
    * @param type $_fileType
    * @param type $_type
    * @return boolean
    */
   private function checkFileType($_fileType,$_type){
       $this->db->where('industry_name',$_fileType);
       $this->db->where('type',$_type);
       $this->db->select('id');
       $dbResult = $this->db->get('zx_file_type');
       
       if($dbResult->num_rows() > 0){
           $dbResult->free_result();
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
   }
   
}


//End of m_admin.php