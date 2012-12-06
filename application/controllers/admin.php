<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller{
    private $data = array();


    public function __construct() {
        parent::__construct();
        
        $this->load->helper('url');
        
        $this->load->model('M_admin','admin');
//        $this->load->model('M_user_base','userbase');
//        $this->load->model('M_cms','cms');
//        $this->load->model('m_medium','medium');
//        $this->load->model('M_space','space');
//        $this->load->model('M_talent','talent');
//        $this->load->model('M_topic','topic');        
    }
    
    public function index(){
        $power = $this->admin->getPower();
        if($power < 1){
            redirect(base_url("admin/login/"));
        }  else {
            $this->load->view('admin/index');
        }
    }
    
    public function login(){
        if($_POST){
            $username = $this->input->post('username');
            $userpassword = $this->input->post('userpassword');
            
            $login = $this->admin->login($username,$userpassword);

            if($login == 1){
                redirect(base_url("admin/index/"));
            } 
            
            return;
        }
        
        $this->load->view('admin/login');
       
        
    }
    
    public function logout(){
        $this->admin->logout();
        redirect(base_url('admin/login/'));
    }
    
    public function left(){
        $this->load->view('admin/left');
        return;
    }
    
}



//End of file admin.php