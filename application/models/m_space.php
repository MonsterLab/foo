<?php
/**
 * 	
    + createS()                  --create article

    + search()                  --search article or articles of user or articles of a group

    - getArticle()		--get a article by aid

    - getUserSAricles()   	--get articles of a user

    - getAriclesOfGroup()	--get articles of a group

    + updateArticleBySuper()  	--update a article by super user

    + deleteArtilce() 		--update the status of a article

    + updateStatus()		--update the status of a article

    + updateSAudit() 		--update the audit of a article

    + updateViewTimes()		--update the viewTiems of a article

    +createGroup()              --create a group of article

    +getAllSGroups()		--get all groups created by someone

    +getShowGroups()		--get the groups displayed at index

    +updateGroup()		--update a group of article

    +deleteGroup()		--delete a group of artilce


 * 
 */
class M_space extends CI_Model{
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * the space model of cms begin
     * 
     */
    
    /**
     * 
     * @param type $space_uid
     * @param type $space_username
     * @param type $space_title
     * @param type $space_content
     * @param type $space_groupid
     * @return int  1: insert article successful 0: insert fail
     */
    public function createS($space_uid , $space_username  , $space_title ,$space_content, $space_groupid){   
       $sql= array(
            'space_uid' => $space_uid,
            'space_username' => $space_username,
            'space_title' => $space_title,
            'space_content' => $space_content,
            'space_groupid' => $space_groupid
          );
       $insertId = $this->db->insert('zx_space_articles',$sql);
       if($insertId > 0){

           return 1;
       }  else {

           return 0;
       }
    }
    
    /**
     * get aricle or space_articles according to status
     * @param type $key
     * @param type $space_status
     * @param type $method
     * @param type $limit
     * @param type $offset
     * @return int
     */
    public function searchS($key,$method,$space_status = 1,$limit=0,$offset = 5 ){
        $result = null;
        switch ($method){
            case 0:
                $space_uid = $key;
                $result = $this->getUserSArticles($space_uid, $limit, $offset, $space_status);
                break;
            case 1:
                $space_aid = $key;
                $result = $this->getSArticle($space_aid);
                break;
            case 2:
                $space_groupid = $key;
                $result = $this->getSArticlesOfGroup($space_groupid, $limit, $offset, $space_status);
                break;
        }
        
        if($result != null && $result != 0){
            return $result;
        } else {
            return array();
        }
    }

    /**
     * get a article by aid
     * @param type $aid
     * @return int if the query is null ,ruturn 0 
     */
    private function getSArticle($space_aid){		
	$this->db->select('space_aid, space_uid, space_username, space_title, 
            space_content, space_groupid, space_audit,
            space_audit_id, space_status, space_ctime, space_viewtimes');
        $this->db->where('space_aid',$space_aid);       
	$query = $this->db->get('zx_space_articles');
        $result = $query->result_array();
        
        $numRows = $query->num_rows();
        $query->free_result();
	if($numRows > 0){
            
            return $result;
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
    private function getUserSArticles($space_uid,$limit,$offset, $space_status){
        $this->db->select('space_aid, space_uid, space_username, space_title,
            space_groupid, space_audit, space_audit_id, space_status, 
            space_ctime, space_viewtimes');
        $this->db->where('space_uid', $space_uid);
        $this->db->where('space_status', $space_status);
        if(!($limit == 'start' && $offset == 'end')){
            $this->db->limit($offset,$limit);
        }
        $query = $this->db->get('zx_space_articles');
        $result = $query->result_array();
        $numRows = $query->num_rows();
        $query->free_result();
        if($numRows > 0){
            
            return $result;
	} else {
	    
	    return array();
	}    
    }
    
    /**
     * get articles by groupid from limit and query offset articles
     * @param type $groupid
     * @param type $limit
     * @param type $offset
     * @param type $space_status
     */
    private function getSArticlesOfGroup($space_groupid, $limit, $offset, $space_status){
        $this->db->select('space_aid, space_uid, space_username, space_title,  space_groupid, space_audit, space_audit_id, space_status, space_ctime, space_viewtimes');
        if(is_array($space_groupid)){
            $this->db->where_in('space_groupid', $space_groupid);
        } else {
            $this->db->where('space_groupid', $space_groupid);
        }
        $this->db->where('space_status',$space_status);
        if(!($limit == 'start' && $offset == 'end')){
            $this->db->limit($offset,$limit);
        }
        
        $query = $this->db->get('zx_space_articles');
        $result = $query->result_array();
        
        $numRows = $query->num_rows();
        $query->free_result();
        if($numRows > 0){
            
            return $result;
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
     * @param type $space_status
     * @param type $viewtimes
     * @return int
     */
    public function updateSArticleBySuper($space_aid, $uid, $space_username, $space_title, $space_groupid, 
                                 $space_audit, $space_audit_id, $space_status, $space_viewtimes ){
        $data = array(
                'space_uid' => $uid,
                'space_username' => $space_username,
                'space_title'=> $space_title,
                'space_groupid' => $space_groupid,
                'space_audit' => $space_audit,
                'space_audit_id' => $space_audit_id,
                'space_status' => $space_status,
                'space_viewtimes' => $space_viewtimes
            );

        $this->db->where('space_aid', $space_aid);
        $this->db->update('zx_space_articles', $data); 
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
     * @param type $space_status
     * @return int
     */
    public function deleteSArticle($space_aid, $space_status){
        $data = array(
            'space_status' => $space_status
        );
        $this->db->where('space_aid', $space_aid);
        $this->db->update('zx_space_articles', $data); 
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
     * @param type $space_status
     * @return int
     */
    public function updateSStatus($space_aid, $space_status){
        $data = array(
            'space_status' => $space_status
        );
        $this->db->where('space_aid', $space_aid);
        $this->db->update('zx_space_articles', $data); 
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
    public function updateSAudit($space_aid, $space_audit, $space_audit_id){
        $data = array(
            'space_audit' => $space_audit,
            'space_audit_id' => $space_audit_id
        );
        $this->db->where('space_aid', $space_aid);
        $this->db->update('zx_space_articles', $data); 
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
    public function updateSViewTimes($aid){
        $data = array(
            'viewtimes' => 'viewtimes + 1'
        );
        $this->db->where('space_aid', $aid);
        $this->db->update('zx_space_articles', $data); 
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
    public function createSGroup($uid,$space_group_name, $space_group_url, $space_group_sumarry, $space_groupfather_id){
        $sql= array(
            'uid' => $uid,
            'space_group_name' => $space_group_name,
            'space_group_url' => $space_group_url,
            'space_group_sumarry' => $space_group_sumarry,
            'space_groupfather_id' => $space_groupfather_id
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
    public function getAllSGroups($uid = 0, $space_status = 1){
        $this->db->select("space_gid, space_group_name, space_group_sumarry");
        if($uid != 0){
            $this->db->where('uid', $uid); 
        }
        $this->db->where('space_status',$space_status);
        $query = $this->db->get('zx_space_article_groups');
        $numRows = $query->num_rows();
        $result = $query->result_array();
        $query->free_result();
        if($numRows > 0){
            
            return $result;
	} else {
	    
	    return array();
	} 
        
    }
    
        /**
     * this method is used for getting a group info by it's gid
     * @param type $gid
     * @param type $status
     * @return type
     */
    public function getGroupByGid($space_gid, $space_status = 1){
        $this->db->select("space_gid, space_group_url, space_group_name, space_groupfather_id");
        $this->db->where('space_status',$space_status);
        $this->db->where('space_gid', $space_gid);
        $query = $this->db->get('zx_space_article_groups');
        
        $numRows = $query->num_rows();
        $result = $query->result_array();
        $query->free_result();
        if($numRows > 0){
            return $result;
	} else {
	    
	    return array();
	} 
    }
    
        /**
     * this method is used for get the child groups by groupfahter_id
     * @param type $space_groupfather_id
     * @param type $space_status
     * @return type
     */
    public function getGroupByGroupfather($space_groupfather_id, $space_status = 1){
        $this->db->select("space_gid, space_group_url, space_group_name, space_groupfather_id");
        $this->db->where('space_status',$space_status);
        $this->db->where('space_groupfather_id', $space_groupfather_id);
        $query = $this->db->get('zx_space_article_groups');
        
        $numRows = $query->num_rows();
        $result = $query->result_array();
        $query->free_result();
        if($numRows > 0){
            return $result;
	} else {
	    
	    return array();
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
    public function updateSGroup($space_gid ,$uid, $space_group_name, $space_group_url, $space_group_sumarry, $space_groupfather_id, $space_status){
        $data = array(
            'uid' => $uid,
            'space_group_name' => $space_group_name,
            'space_group_url' => $space_group_url,
            'space_group_sumarry' => $space_group_sumarry,
            'space_groupfather_id' => $space_groupfather_id,
            'space_status' => $space_status
        );
        $this->db->where('space_gid', $space_gid);
        $this->db->update('zx_article_groups', $data); 
        $affectedRows = $this->db->affected_rows();
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
    public function deleteSGroup($space_gid, $space_status = 0){
        $data = array(
            'space_status' => $space_status
        );
        $this->db->where('space_gid', $space_gid);
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
