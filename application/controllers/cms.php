<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('M_cms','cms');
        $this->load->helper(array('url'));
    }
    
    /**
     * this is a interface for common user
     */
    public function index(){
        $this->load->view('cms/index');
    }
    
    public function showList(){
        
        $this->load->view('cms/showList');
    }
    
    public function article(){
        $this->load->view('cms/article');
    }
}
