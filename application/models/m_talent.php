<?php

/**
 * 纳税人才征信库认证信息模型
 * 
 * createCertBase()                     添加
 * deleteCertBase()                     删除
 * updateCertBase()                     更新
 * searchCertBase()                     查询
 * 
 * 认证扫描件信息管理
 * addCertFile()
 * deleteCertFile()
 * updateCertFile()
 * searchCertFile()
 * 
 * 认证文字信息管理
 * addCertContent()
 * deleteCertContent()
 * updateCertContent()
 * searchCertContent()
 *      
 * 
 */
class M_talent extends CI_Model{
   public function __construct() {
       parent::__construct();
       $this->load->database();
   }
   
   /*-----------------------------------认证基本信息管理------------------------------------*/
   
   /**
    * 新增认证基本信息
    * 
    * @param type $cuid
    * @param type $cert_name
    * @param type $sex
    * @param type $nation
    * @param type $personid
    * @param type $birth_place
    * @param type $live_place
    * @param type $cert_begin
    * @param type $cert_end
    * @return boolean
    */
   public function createCertBase($cuid,$uid,$cert_name='',$sex=0,$nation='',$personid='',$birth_place='',$live_place='',$cert_begin=0,$cert_end=0){
       $sqlQuery = array(
           'cuid'=>$cuid,
           'uid'=>$uid,
           'cert_name'=>$cert_name,
           'sex'=>$sex,
           'nation'=>$nation,
           'personid'=>$personid,
           'birth_place'=>$birth_place,
           'live_place'=>$live_place,
           'cert_begin'=>$cert_begin,
           'cert_end'=>$cert_end,
       );
       $this->db->insert('zx_talent_cert_base',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return true;
       }  else {
           
           return false;
       }
       
   }
   
   /**
    * 删除征信基本信息
    * 
    * 不提共删除，只是将该管理员状态status 置 0，弃用
    * 
    * @param type $id                   征信信息id
    * @return boolean                   成功返回true，失败返回false
    */
   public function deleteCertBase($baseId){
       $sqlQuery = array('status'=>0);
       
       $this->db->where('id',$baseId);
       $this->db->update('zx_talent_cert_base',$sqlQuery);
       
       if($this->db->affected_rows() > 0){
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
       
   }
   
   /**
    * 修改征信基本信息
    * 
    * @param type $cuid
    * @param type $cert_name
    * @param type $sex
    * @param type $nation
    * @param type $personid
    * @param type $birth_place
    * @param type $live_place
    * @param type $cert_begin
    * @param type $cert_end
    * 
    * @return bolean                                成功返回true ，失败返回 false 
    */
   public function updateCertBase($baseId,$cert_name,$sex,$nation,$personid,$birth_place,$live_place,$cert_begin,$cert_end){
       $sqlQuery = array(
           'cert_name'=>$cert_name,
           'sex'=>$sex,
           'nation'=>$nation,
           'personid'=>$personid,
           'birth_place'=>$birth_place,
           'live_place'=>$live_place,
           'cert_begin'=>$cert_begin,
           'cert_end'=>$cert_end,
       );
       $this->db->where('id',$baseId);
       $dbUpdate = $this->db->update('zx_talent_cert_base',$sqlQuery);
       if($dbUpdate > 0){
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
   }
   
   /**
    * 查询征信基本信息
    * @param int $uid                  用户id
    * 
    * @return array                     成功返回数组，失败返回false
    */
   public function searchCertBase($uid,$isStatus = TRUE){
       $this->db->where('uid',$uid);
       if($isStatus){
            $this->db->where('status',1);
        } 
       $this->db->select('id,uid,cert_name,sex,nation,personid,birth_place,live_place,cert_begin,cert_end,audit,audit_id,cuid,ctime');
       $dbResult = $this->db->get('zx_talent_cert_base');
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
   
   /*-----------------------------------认证扫描件信息管理------------------------------------*/ 
   
   /**
    * 上传扫描文件
    * 
    * @param type $cuid                                     创建人
    * @param type $uid                                      客户id
    * @param type $file_type_id                             上传文件名id
    * @param type $file_name                                上传文件保存名
    * @return int                                           成功返回1，失败返回0 ，已经存在返回-1
    */
   public function addCertFile($cuid,$uid,$file_type_id,$file_name){
       //检查上传文件是否存在
       $isExist = $this->checkCertFile($uid, $file_type_id);
       if($isExist){
           
           return -1;
       }
       $sqlQuery = array(
           'cuid'=>$cuid,
           'uid'=>$uid,
           'file_type_id'=>$file_type_id,
           'file_name'=>$file_name
       );
       $this->db->insert('zx_talent_cert_file',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return 1;
       }  else {
           
           return 0;
       }
   }
   
   /**
    * 删除扫描件
    * 
    * @param type $certFileId                   文件id
    * @return boolean
    */
   public function deleteCertFile($certFileId){
       
       $this->db->where('id',$certFileId);
       $this->db->update('zx_talent_cert_file',array('status'=>0));
       
       if($this->db->affected_rows() > 0){
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
       
   }

   /**
    * 更新上传扫描件信息
    * 
    * @param type $certFileId                       文件id
    * @param type $file_type_id                     文件类型id
    * @param type $file_name                        上传文件保存名
    * @return boolean
    */
   public function updateCertFile($certFileId,$file_type_id,$file_name){
       $sqlQuery = array(
           'file_type_id'=>$file_type_id,
           'file_name'=>$file_name
       );
       $this->db->where('id',$certFileId);
       $this->db->update('zx_talent_cert_file',$sqlQuery);
       
       if($this->db->affected_rows() > 0){
           
           return true;
       }  else {
           
           return false;
       }
   }

   /**
    * 查询用户的上传文件
    * 
    * @param type $uid
    * @return boolean
    */
    public function searchCertFile($uid,$isStatus = TRUE){
        $this->db->where('uid',$uid);
        if($isStatus){
            $this->db->where('status',1);
        } 
        $this->db->select('id,uid,file_type_id,file_name,audit,audit_id,cuid,ctime');
        $dbResult = $this->db->get('zx_talent_cert_file');
       
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
    * 检查上传文件是否已经存在
    * 
    * @param type $_uid
    * @param type $_fileTypeId
    * @return boolean
    */
   public function checkCertFile($_uid,$_fileTypeId){
       $this->db->where('uid',$_uid);
       $this->db->where('file_type_id',$_fileTypeId);
       $this->db->where('status',1);
       $this->db->select('id');
       $dbResult = $this->db->get('zx_talent_cert_file');
       
       if($dbResult->num_rows() > 0){
           $dbResult->free_result();
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
   }
   
   
   /**----------------------------------认证文字信息管理-------------------------------**/
   
   /**
    * 上传扫描文件
    * 
    * @param type $cuid                                     创建人
    * @param type $uid                                      客户id
    * @param type $title                             上传文件名id
    * @param type $content                                上传文件保存名
    * @return int                                           成功返回1，失败返回0 ，已经存在返回-1
    */
   public function addCertContent($cuid,$uid,$title,$content){
       //检查内容名是否存在
       $isExist = $this->checkCertContent($uid, $title);
       if($isExist){
           
           return -1;
       }
       $sqlQuery = array(
           'cuid'=>$cuid,
           'uid'=>$uid,
           'title'=>$title,
           'content'=>$content
       );
       $this->db->insert('zx_talent_cert_content',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return 1;
       }  else {
           
           return 0;
       }
   }
   
   /**
    * 删除
    * 
    * @param type $id                               文件id
    * @return boolean
    */
   public function deleteCertContent($id){
       
       $this->db->where('id',$id);
       $this->db->update('zx_talent_cert_fcontent',array('status'=>0));
       
       if($this->db->affected_rows() > 0){
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
       
   }

   /**
    * 更新
    * 
    * @param type $Id                               文件id
    * @param type $title                            文件标题
    * @param type $content                          文件保存名
    * @return boolean
    */
   public function updateCertContent($id,$title,$content){
       $sqlQuery = array(
           'title'=>$title,
           'content'=>$content
       );
       $this->db->where('id',$id);
       $dbUpdate = $this->db->update('zx_talent_cert_content',$sqlQuery);
       
       if($dbUpdate > 0){
           
           return true;
       }  else {
           
           return false;
       }
   }

   /**
    * 查询
    * 
    * @param type $uid
    * @return boolean
    */
    public function searchCertContent($uid,$isStatus = TRUE){
        $this->db->where('uid',$uid);
        if($isStatus){
            $this->db->where('status',1);
        } 
        $this->db->select('id,uid,title,content,audit,audit_id,cuid,ctime');
        $dbResult = $this->db->get('zx_talent_cert_content');
       
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
    * 检查标题是否已经存在
    * 
    * @param type $_uid
    * @param type $_fileTypeId
    * @return boolean
    */
   private function checkCertContent($_uid,$_title){
       $this->db->where('uid',$_uid);
       $this->db->where('title',$_title);
       $this->db->where('status',1);
       $this->db->select('id');
       $dbResult = $this->db->get('zx_talent_cert_content');
       
       if($dbResult->num_rows() > 0){
           $dbResult->free_result();
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
   }
   
   /**------------------------------审核信息----------------------------------**/
   
   /**
    * 审核 认证基本信息
    * 审核通过置audit 1 
    * 审核未通过置audit -1 ，并且将status置0（删除）
    * @param type $audit_id
    * @param type $base_id
    * @param type $isPass
    * @return boolean
    */
   public function auditCertBase($audit_id,$base_id,$isPass = 0){
       //1、根据审核情况作出处理,2、检查传入审核情况参数值是否正确
       if($isPass == -1){                                    //未通过审核
           $sqlQuery = array(
                'audit_id'=>$audit_id,
                'audit'=>$isPass,
                'status'=>0                                 //审核未通过即删除    
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
       $this->db->update('zx_talent_cert_base',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
   }
   
   /**
    * 审核 认证文件扫描键信息
    * 审核通过置audit 1 
    * 审核未通过置audit -1 ，并且将status置0（删除）
    * @param type $audit_id
    * @param type $base_id
    * @param type $isPass
    * @return boolean
    */
   public function auditCertFile($audit_id,$base_id,$isPass = 0){
       //1、根据审核情况作出处理,2、检查传入审核情况参数值是否正确
       if($isPass == -1){                                    //未通过审核
           $sqlQuery = array(
                'audit_id'=>$audit_id,
                'audit'=>$isPass,
                'status'=>0                                 //审核未通过即删除    
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
       $this->db->update('zx_talent_cert_file',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
   }
   
   /**
    * 审核  认证文字类信息
    * 审核通过置audit 1 
    * 审核未通过置audit -1 ，并且将status置0（删除）
    * @param type $audit_id
    * @param type $base_id
    * @param type $isPass
    * @return boolean
    */
   public function auditCertContent($audit_id,$base_id,$isPass = 0){
       //1、根据审核情况作出处理,2、检查传入审核情况参数值是否正确
       if($isPass == -1){                                    //未通过审核
           $sqlQuery = array(
                'audit_id'=>$audit_id,
                'audit'=>$isPass,
                'status'=>0                                 //审核未通过即删除    
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
       $this->db->update('zx_talent_cert_content',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
   }
   
   
   
   
}



//End of m_telent.php