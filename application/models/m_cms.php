<?php
/**
 * 	
    + create()                  --create article

    + search()                  --search article or articles of user or articles of a group

    - getArticle()		--get a article by aid

    - getUserAricles()   	--get articles of a user

    - getAriclesOfGroup()	--get articles of a group

    + updateArticleBySuper()  	--update a article by super user

    + deleteArtilce() 		--update the status of a article

    + updateStatus()		--update the status of a article

    + updateAudit() 		--update the audit of a article

    + updateViewTimes()		--update the viewTiems of a article

    +createGroup()              --create a group of article

    +getAllGroups()		--get all groups created by someone

    +getShowGroups()		--get the groups displayed at index

    +updateGroup()		--update a group of article

    +deleteGroup()		--delete a group of artilce


 * 
 */
class M_cms extends CI_Model{
    function __construct() {
        parent::__construct();
        $this->load->database();
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
     * @param type $content
     * @param type $groupid
     * @return int  1: insert article successful 0: insert fail
     */
    public function create($uid , $username  , $title ,$content, $groupid){   
       $sql= array(
            'uid' => $uid,
            'username' => $username,
            'title' => $title,
            'content' => $content,
            'groupid' => $groupid
          );
       $insertId = $this->db->insert('zx_articles',$sql);
       
       if($insertId > 0){

           return 1;
       }  else {

           return 0;
       }
    }
    
    /**
     * get aricle or articles according to status
     * @param type $key
     * @param type $status
     * @param type $method
     * @param type $limit
     * @param type $offset
     * @return int
     */
    public function search($key,$method,$status = 1,$limit=0,$offset = 5 ){
        $result = null;
        switch ($method){
            case 0:
                $uid = $key;
                $result = $this->getUserArticles($uid, $limit, $offset, $status);
                break;
            case 1:
                $aid = $key;
                $result = $this->getArticle($aid);
                break;
            case 2:
                $gid = $key;
                $result = $this->getArticlesOfGroup($groupid, $limit, $offset, $status);
                break;
        }
        
        if($result != null && $result != 0){
            return $result;
        } else {
            return 0;
        }
    }

    /**
     * get a article by aid
     * @param type $aid
     * @return int if the query is null ,ruturn 0 
     */
    private function getArticle($aid){		
	$this->db->select('aid, uid, username, title, content, groupid, checked, audit, audit_id, status, viewtimes');
                        
	$query = $this->db->get('zx_articles');
        $query->result_array();
        
        $numRows = $this->db->num_rows();
        $query->free_result();
	if($this->db->num_rows() > 0){
            
            return $query;
	} else {
	    
	    return 0;
	}
    }
    
    /**
     * get one's articles by uid from limit and query offset articles
     * @param type $uid
     * @param type $limit
     * @param type $offset
     * @return int
     */
    private function getUserArticles($uid,$limit,$offset, $status){
        $this->db->select('aid, uid, username, title, groupid, checked, audit, audit_id, status, viewtimes');
        $this->db->where('uid', $uid);
        $this->db->where('status', $status);
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get('zx_articles');
        $query->result_array();
        
        $numRows = $this->db->num_rows();
        $query->free_result();
        if($this->db->num_rows() > 0){
            
            return $query;
	} else {
	    
	    return 0;
	}    
    }
    
    /**
     * get articles by groupid from limit and query offset articles
     * @param type $groupid
     * @param type $limit
     * @param type $offset
     * @param type $status
     */
    private function getArticlesOfGroup($groupid, $limit, $offset, $status){
        $this->db->select('aid, uid, username, title, groupid, checked, audit, audit_id, status, viewtimes');
        $this->db->where('groupid', $groupid);
        $this->db->where('status',$status);
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get('zx_articles');
        $query->result_array();
        
        $numRows = $this->db->num_rows();
        $query->free_result();
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
        if( $affectedRows > 0){
            
            return 1;
        } else {
            
            return 0;
        }
    }
    
    /**
     * 1、upadate the audit of article when someone who maybe a auditor 
     * if update successfully ,the article will be display
     * 2、but this action should be recorded in case of someone make a mistake
     * 
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
        if( $affectedRows > 0){
            
            return 1;
        } else {
            
            return 0;
        }
    }
    
     /**
     * update viewtimes  of article 
     * 
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
        if( $affectedRows > 0){
            
            return 1;
        } else {
            
            return 0;
        }
    }
    

    /**
     * the article model of cms end
     */
    
    
    // the group model of cms begin
    /**
     * create a group of article group
     * 
     * @param type $uid
     * @param type $group_name
     * @param type $group_url
     * @param type $group_sumarry
     * @param type $groupfather_id
     * @return int
     */
    public function createGroup($uid,$group_name, $group_url, $group_sumarry, $groupfather_id){
        $sql= array(
            'uid' => $uid,
            'group_name' => $group_name,
            'group_url' => $group_url,
            'group_sumarry' => $group_sumarry,
            'groupfather_id' => $groupfather_id
          );
       $insertId = $this->db->insert('zx_article_groups',$sql);
       if($insertId > 0){

           return 1;
       }  else {

           return 0;
       }
    }
    
    /**
     * get all groups by someone
     * the return set comtains gid ,group_name, group_summary
     * 
     * @param type $uid
     * @return int
     */
    public function getAllGroups($uid, $status){
        $this->db->select("gid, group_name, group_sumarry");
        $this->db->where('uid', $uid); 
        $this->db->where('status',$status);
        $query = $this->db->get('zx_article_groups');
        $query->result_array();
        
        $numRows = $this->db->num_rows();
        $query->free_result();
        if($numRows > 0){
            
            return $query;
	} else {
	    
	    return 0;
	} 
        
    }

    /**
     * 
     * @param type $gid
     * @param type $uid
     * @param type $group_name
     * @param type $group_url
     * @param type $group_sumarry
     * @param type $groupfather_id
     * @return int
     */
    public function updateGroup($gid ,$uid, $group_name, $group_url, $group_sumarry, $groupfather_id, $status){
        $data = array(
            'uid' => $uid,
            'group_name' => $group_name,
            'group_url' => $group_url,
            'group_sumarry' => $group_sumarry,
            'groupfather_id' => $groupfather_id,
            'status' => $status
        );
        $this->db->where('gid', $gid);
        $this->db->update('zx_article_groups', $data); 
        $affectedRows = $this->db->affected_rows();
        $query->free_result();
        if( $affectedRows > 0){
            
            return 1;
        } else {
            
            return 0;
        }
        
    }
    

    /**
     * when someone delete the group ,the group doesn't delete truely 
     * but just change the status of group and still saved in database
     * 
     * @param type $gid
     */
    public function deleteGroup($gid, $status){
        $data = array(
            'status' => $status
        );
        $this->db->where('gid', $gid);
        $this->db->update('zx_article_groups', $data); 
        $affectedRows = $this->db->affected_rows();
        if( $affectedRows > 0){
            
            return 1;
        } else {
            
            return 0;
        }
        
    }
    //the group model of cms end
    
    
}
