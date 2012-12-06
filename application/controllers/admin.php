<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller{
    private $data = array();


    public function __construct() {
        parent::__construct();
        
        $this->load->helper('url');
        
        $this->load->model('M_admin','admin');
<<<<<<< HEAD
        $this->load->model('M_user_base','userbase');
        $this->load->model('M_cms','cms');
        $this->load->model('M_medium','medium');
        $this->load->model('M_zxpool','zxpool');
        $this->load->model('M_space','space');
        $this->load->model('M_talent','talent');
        $this->load->model('M_topic','topic');        
=======
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
>>>>>>> b0902fe198b118407e852f2ef57a5c31ebac12ae
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
    
<<<<<<< HEAD
    /**
     * 批量导入征信编码
     */
    public function importCode(){
        if($_POST){
            if(!empty($_FILES['file']['name'])){
                $tmp_name = $_FILES['file']['tmp_name'];
                //读取整个文件
                $resourse = file($tmp_name);                      
                //按行遍历数据
                foreach($resourse as $data){                                    
                    $codeArray[] = str_replace("\n",'', $data);                //将数据中\n去除
                }
                //数据不为空则导入数据库
                if(!empty($codeArray)){
                    $result = $this->zxpool->createCode($codeArray);
                    if($result){
                        //成功导入
                        
                    }
                }  else {
                    //文件中数据为空
                    
                }
                
            }  else {
                //未选择导入的文件
                
            }
            
        }# end of post  
    }
    
    
    

}# end of class
=======
    public function left(){
        $this->load->view('admin/left');
        return;
    }
    
}
>>>>>>> b0902fe198b118407e852f2ef57a5c31ebac12ae



//End of file admin.php