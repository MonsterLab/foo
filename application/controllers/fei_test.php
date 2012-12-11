<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fei_test extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('M_admin','admin');
        $this->load->model('M_user_base','userbase');
        $this->load->model('M_cms','cms');
        $this->load->model('M_medium','medium');
        $this->load->model('M_zxpool','zxpool');
        $this->load->model('M_space','space');
        $this->load->model('M_talent','talent');
        $this->load->model('M_topic','topic');        
    }
    
    public function login(){
        if($_POST){
            $username = $this->input->post('username');
            $userpassword = $this->input->post('userpassword');
            
            $login = $this->admin->login($username,$userpassword);
            if($login){
                redirect("{$baseurl}/admin/index/");
            } else {
                $this->load->view();
            }
        }  else {
            $this->load->view();
        }
    }
    
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
            
        }  else {
            
            $this->load->view('fei_test/v_importCode.php');
        }  
    }
    
    
    /**------------------以下为测试用-----------------------**/

    


    
    public function index(){
        echo 'work';
    }

    public function tlogin(){
        $result = $this->admin->login('test','psw2');
//        $result = $this->admin->getPower();
        echo $result;
    }

    public function createAdmin(){
        //create($cuid,$username,$password,$truename,$department,$phone,$power,$email)
        $result = $this->admin->create(1,'test','psw','truename','部门','13944682966','11','test@test.com');
        echo $result;
    }
    
    public function updateAdmin(){
        //updatezx_code($uid,$password,$truename,$department,$phone,$power,$email
        $result = $this->admin->update(1,'psw2','truename2','部门2','13912341234','12','test2@test.com');
        if($result){
            echo 1;
        }  else {
            echo 0;
        }
    }
    public function searchAdmin(){
        //search($key = '',$method = 0,$limit = 10,$offset = 0)
        $result = $this->admin->search('truename2',1);
        if($result){
            echo "<pre>";
            print_r($result);
            echo '</pre>';
        }  else {
            echo '0';
        }
    }
    public function deleteAdmin(){
        $result = $this->admin->delete(1);
        if($result){
            echo 1;
        }  else {
            echo 0;
        }
    }

    public function useCode(){
        $result = $this->zxpool->useCode(1);
        echo $result;
        
    }
    public function searchCode(){
        $result = $this->zxpool->searchCode();
        if($result){
            echo "<pre>";
            print_r($result);
            echo '</pre>';
        }
        
    }
    
    public function addIndustry(){
        //($cuid,$industry_name,$type)
        $result = $this->zxpool->addIndustry(1,'电子行业','topic');
        echo $result;
        
    }
    
    //TODO:
    public function updateIndustry(){
        //updateIndusty($industyId,$industry_name,$type)
        $result = $this->zxpool->updateIndustry(1,'电子行业','topic');
        echo $result;
    }
    
    public function searchIndustry(){
        //searchIndustry($key = '',$method = 0)
        $result = $this->zxpool->searchIndustry('',0);
        echo "<pre>";
        print_r($result);
        echo '</pre>';
    }
    
    public function addFileType(){
        //addFileType($cuid,$file_name,$type)
        $result = $this->zxpool->addFileType(1,'营业执照','topic');
        echo $result;
    }

    public function updateFileType(){
        //updateFileType($fileTypeid,$fileType,$type)
        $result = $this->zxpool->updateFileType(1,'营业执照2','medium');
        echo $result;
    }
    
    public function searchFileType(){
        //searchIndustry($key = '',$method = 0)
        $result = $this->zxpool->searchFileType('',0);
        echo "<pre>";
        print_r($result);
        echo '</pre>';
    }

    /////////////////////////
    public function createCertBase(){
        //createCertBase($cuid,$uid,$com_name,$com_nature,$com_phone,$type,$zipcode,$com_place,$industry_id,$cert_begin,$cert_end)
        $result = $this->topic->createCertBase(1,1,'同袍','青年','12369581234','topic','12301','东北','1','0','0');
        echo $result;
    }


    public function updateCertBase(){
        //updateCertBase($baseId,$com_name,$com_nature,$com_phone,$zipcode,$com_place,$industry_id,$cert_begin,$cert_end)
        $result = $this->topic->updateCertBase(1,'同袍234','青年2','22369581234','topic','12301','东北2','1','0','0');
        echo $result;
    }

    public function searchCertBase(){
        $result = $this->topic->searchCertBase(1);
        echo "<pre>";
        print_r($result);
        echo '</pre>';
    }
    
    public function addCertFile(){
        //addCertFile($cuid,$uid,$file_type_id,$file_name)
        $result = $this->topic->addCertFile(1,1,1,'asds.txt');
        echo $result;
    }
    public function searchCertFile(){
        $result = $this->topic->searchCertFile(1);
        echo "<pre>";
        print_r($result);
        echo '</pre>';
    }
    /**---------------------------------------------------**/
}



//End of file fei_test.php