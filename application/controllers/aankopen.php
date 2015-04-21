<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Aankopen extends CI_Controller
{

    public function index()
    {
        //$this->load->view('welcome_message');
        if ($this->session->userdata('is_logged_in')) {

            //$data['gebruikers'] = $this->Gebruiker_model->get_gebruikers();

            //$data['primary'] = $this->Gebruiker_model->get_primary_user_tobuyfor();

            $data['leeggoed'] = $this->Aankoop_model->get_leeggoed();

            $data['artikels'] = $this->Aankoop_model->get_artikels();

            $data['middle'] = '/aankopen/invoer';
            $this->load->view('template', $data);
        } else {
            redirect(base_url() . 'login');
        }

    }
}