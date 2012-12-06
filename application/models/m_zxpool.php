<?php
class M_zxpool extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    /*--------------------------------征信编码池管理-------------------------------*/
   
   public function createCode(){
       
   }
   /**
    * 更新征信编码使用状态
    * 
    * @param int $zxCode
    * @return int   -1征信编码未设置   0操作失败   1操作成功
    */
   public function useCode($zxCode = 0){
       if($zxCode == 0){
           return -1;
       }
       $this->db->where('zx_code',$zxCode);
       $this->db->set('status',1);
       
       if($this->db->affected_rows() > 0){
           
           return 1;
       }  else {
           
           return 0;
       }
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


//End of m_zxpool.php