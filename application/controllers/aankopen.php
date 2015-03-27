<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aankopen extends CI_Controller
{

    public function index()
    {
        //$this->load->view('welcome_message');
        $data['leeggoed'] = $this->Aankoop_model->get_leeggoed();

        $data['artikels'] = $this->Aankoop_model->get_artikels();

        $data['middle'] = '/aankopen/invoer';
        $this->load->view('template', $data);

    }
}