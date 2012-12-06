<?php

/**
 * 主体征信库认证信息模型
 * 
 * createCertBase()                     添加
 * deleteCertBase()                     删除
 * updateCertBase()                     更新
 * searchCertBase()                     查询
 * 
 * 
 *      
 * 
 */
class M_topic extends CI_Model{
   public function __construct() {
       parent::__construct();
       $this->load->database();
   }
   
   /*-----------------------------------认证基本信息管理------------------------------------*/
   /**
    * 新增认证基本信息
    * 
    * @param type $cuid                             创建人
    * @param type $uid                              客户id
    * @param type $com_name                         公司名称
    * @param type $com_nature                       公司性质
    * @param type $com_phone                        公司电话
    * @param type $industry_id                      行业类型id
    * @param type $zipcode                          邮政编码
    * @param type $com_place                        公司地址
    * @param type $cert_begin                       征信开始时间
    * @param type $cert_end                         征信结束时间
    * 
    * @return bolean                                成功返回true ，失败返回 false                                   
    */
   public function createCertBase($cuid,$uid,$com_name,$com_nature,$com_phone,$industry_id,$zipcode,$com_place,$cert_begin,$cert_end){
       $sqlQuery = array(
           'cuid'=>$cuid,
           'uid'=>$uid,
           'com_name'=>$com_name,
           'com_nature'=>$com_nature,
           'com_phone'=>$com_phone,
           'industry_id'=>$industry_id,
           'zipcode'=>$zipcode,
           'com_place'=>$com_place,
           'cert_begin'=>$cert_begin,
           'cert_end'=>$cert_end,
       );
       $this->db->insert('zx_topic_cert_base',$sqlQuery);
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
       $this->db->update('zx_topic_cert_base',$sqlQuery);
       
       if($this->db->affected_rows() > 0){
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
       
   }
   
   /**
    * 修改征信基本信息
    * 
    * @param type $baseId                           认证信息id
    * @param type $com_name                         公司名称
    * @param type $com_nature                       公司性质
    * @param type $com_phone                        公司电话
    * @param type $industry_id                      行业类型id
    * @param type $zipcode                          邮政编码
    * @param type $com_place                        公司地址
    * @param type $cert_begin                       征信开始时间
    * @param type $cert_end                         征信结束时间
    * 
    * @return bolean                                成功返回true ，失败返回 false 
    */
   public function updateCertBase($baseId,$com_name,$com_nature,$com_phone,$industry_id,$zipcode,$com_place,$cert_begin,$cert_end){
       $sqlQuery = array(
           'com_name'=>$com_name,
           'com_nature'=>$com_nature,
           'com_phone'=>$com_phone,
           'industry_id'=>$industry_id,
           'zipcode'=>$zipcode,
           'com_place'=>$com_place,
           'cert_begin'=>$cert_begin,
           'cert_end'=>$cert_end,
       );
       $this->db->where('id',$baseId);
       $this->db->update('zx_topic_cert_base',$sqlQuery);
       if($this->db->affected_rows() > 0){
           
           return TRUE;
       }  else {
           
           return FALSE;
       }
   }
   
   /**
    * 查询征信基本信息
    * @param int $$uid                  用户id
    * 
    * @return array                     成功返回数组，失败返回false
    */
   public function searchCertBase($uid){
       $this->db->where('uid',$uid);
       $this->db->where('status',1);        //查询没有被弃用的用户
       $this->db->select('id,uid,com_name,com_nature,com_phone,industry_id,zipcode,com_place,cert_begin,cert_end');
       $dbResult = $this->db->get('zx_topic_cert_base');
       if($dbResult->num_rows() > 0){
           $result = $dbResult->row_array();
           
           $dbResult->free_result();
           
           return $result;
       }  else {
           
           return FALSE;
       }
       
       
   }
   
   /*-----------------------------------认证扫描件信息管理------------------------------------*/ 
   
}



//End of m_user_base.php