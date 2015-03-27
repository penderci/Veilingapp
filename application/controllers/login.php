<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index()
    {
        //$this->load->view('welcome_message');

        $data['middle'] = '/login/login';
        $this->load->view('template',$data);

    }

    public function login_validation(){
        echo 'hallo';
    }
}