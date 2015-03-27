<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aankopen extends CI_Controller
{

    public function index()
    {
        //$this->load->view('welcome_message');

        $data['middle'] = '/aankopen/invoer';
        $this->load->view('template', $data);

    }
}