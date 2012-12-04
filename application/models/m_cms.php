<?php
class M_cms extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    /**
     * the article model of cms begin
     * 
     */
    
    /**
     * 
     * @param type $aid
     * @param type $uid
     * @param type $username
     * @param type $title
     * @param type $groupid
     * @return int  1: insert article successful 0: insert fail
     */
    public function createArticle($aid, $uid , $username  , $title , $groupid){   
        $sql= array(
            'aid' => $aid,
            'uid' => $uid,
            'username' => $username,
            'title' => $title,
            'groupid' => $groupid
          );
       $insertId = $this->db->insert('zx_articles',$sql);
       $this->db->close();
       if($insertId > 0){

           return 1;
       }  else {

           return 0;
       }
    }
    
    /**
     * get a article by aid
     * @param type $aid
     * @return int if the query is null ,ruturn 0 
     */
    public function getArticle($aid){		
	$this->db->select('aid, uid, username, title, groupid, checked, audit, audit_id, status, viewtimes');
                        
	$query = $this->db->get('zx_articles');
        $query->result_array();
        
        $numRows = $this->db->num_rows();
        $this->db->close();
	if($this->db->num_rows() > 0){
            
            return $query;
	} else {
	    
	    return 0;
	}
    }
    
    /**
     * get one's articles by uid from start and query offset articles
     * @param type $uid
     * @param type $start
     * @param type $offset
     * @return int
     */
    public function getOnesArticles($uid,$start,$offset){
        $this->db->where('uid', $uid);
        $this->db->limit($start, $offset);
        
        $query = $this->db->get('zx_articles');
        $query->result_array();
        
        $numRows = $this->db->num_rows();
        $this->db->close();
        if($this->db->num_rows() > 0){
            
            return $query;
	} else {
	    
	    return 0;
	}    
    }
    
    /**
     * get articles by groupid from start and query offset articles
     * @param type $groupid
     * @param type $start
     * @param type $offset
     */
    public function getArticlesOfGroup($groupid, $start, $offset){
        $this->db->where('groupid', $groupid);
        $this->db->limit($start, $offset);
        
        $query = $this->db->get('zx_articles');
        $query->result_array();
        
        $numRows = $this->db->num_rows();
        $this->db->close();
        if($numRows > 0){
            
            return $query;
	} else {
	    
	    return 0;
	} 
        
    }
    
    /**
     * update particular article by aid ,but the metheod only can be used by supper user
     * 
     * @param type $aid
     * @param type $uid
     * @param type $username
     * @param type $title
     * @param type $groupid
     * @param type $checked
     * @param type $audit
     * @param type $audit_id
     * @param type $status
     * @param type $viewtimes
     * @return int
     */
    public function updateArticleBySuper($aid, $uid, $username, $title, $groupid, 
                                  $checked, $audit, $audit_id, $status, $viewtimes ){
        $data = array(
                'uid' => $uid,
                'username' => $username,
                'title'=> $title,
                'groupid' => $groupid,
                'checked' => $checked,
                'audit' => $audit,
                'audit_id' => $audit_id,
                'status' => $status,
                'viewtimes' => $viewtimes
            );

        $this->db->where('aid', $aid);
        $this->db->update('zx_articles', $data); 
        $affectedRows = $this->db->affected_rows();
        $this->db->close();
        if( $affectedRows > 0){
            
            return 1;
        } else {
            
            return 0;
        }
	
        
    }
    
    /**
     * this method is the same as the method updateStatus,
     * both of them just change the status ,but not delete the article truely
     * 
     * @param type $aid
     * @param type $status
     * @return int
     */
    public function deleteArticle($aid, $status){
        $data = array(
            'status' => $status
        );
        $this->db->where('aid', $aid);
        $this->db->update('zx_articles', $data); 
        $affectedRows = $this->db->affected_rows();
        $this->db->close();
        if( $affectedRows > 0){
            
            return 1;
        } else {
            
            return 0;
        }
    }
    /**
     * update the status of article 
     * @param type $aid
     * @param type $status
     * @return int
     */
    public function updateStatus($aid, $status){
        $data = array(
            'status' => $status
        );
        $this->db->where('aid', $aid);
        $this->db->update('zx_articles', $data); 
        $affectedRows = $this->db->affected_rows();
        $this->db->close();
        if( $affectedRows > 0){
            
            return 1;
        } else {
            
            return 0;
        }
    }
    
    /**
     * upadate the audit of article when someone who maybe a auditor 
     * if update successfully ,the article will be display
     * @param type $aid
     * @param type $audit
     * @return int
     */
    public function updateAudit($aid, $audit, $uid){
        $data = array(
            'audit' => $audit,
            'audit_id' => $audit_id
        );
        $this->db->where('aid', $aid);
        $this->db->update('zx_articles', $data); 
        $affectedRows = $this->db->affected_rows();
        $this->db->close();
        if( $affectedRows > 0){
            
            return 1;
        } else {
            
            return 0;
        }
    }
    
     /**
     * update viewtimes  of article 
     * @param type $aid
     * @return int  if update the viewtimes successfully ,return 1,else return 0
     */
    public function updateViewTimes($aid){
        $data = array(
            'viewtimes' => 'viewtimes + 1'
        );
        $this->db->where('aid', $aid);
        $this->db->update('zx_articles', $data); 
        $affectedRows = $this->db->affected_rows();
        $this->db->close();
        if( $affectedRows > 0){
            
            return 1;
        } else {
            
            return 0;
        }
    }
    

    /**
     * the article model of cms end
     * 
     */
    
}
