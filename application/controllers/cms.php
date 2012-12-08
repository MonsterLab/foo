<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('M_cms','cms');
        $this->load->helper(array('url'));
    }
    
    public function createArticle(){        
        //TODO 权限的验证
        if(isset($_POST['sub'])){
            
        } else {
            //TODO uid = 5
            $uid = 5;
            $status = 1;    // the group isn't deleted
            $groups = $this->cms->getAllGroups($uid, $status);
            print_r($groups);
            $data['groups'] = $groups;
            $this->load->view('admin/v_createArticle', $data);
        }
        
    }
}
