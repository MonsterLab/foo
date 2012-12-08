<?php
class Xbtest extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('M_cms','cms');
    }
}