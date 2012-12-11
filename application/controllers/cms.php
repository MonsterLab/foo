<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cms extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('M_cms','cms');
        $this->load->helper(array('url'));
    }
}
