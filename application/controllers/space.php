<?php
class Space extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('M_space', 'space');
    }
    
    public function index(){
        //    public function createS($space_uid , $space_username  , $space_title ,$space_content, $space_groupid){
        
        //$this->space->createS(5 , 'zhang'  , '$space_title' ,'$space_content', '$space_groupid');
         //   public function searchS($key,$method,$space_status = 1,$limit=0,$offset = 5 ){
         $this->space->searchS($key,$method,$space_status = 1,$limit=0,$offset = 5 );
        
        $this->load->view('space/index');
    }
    
}