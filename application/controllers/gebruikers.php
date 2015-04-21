<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gebruikers extends CI_Controller
{

    public function index()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data['middle'] = '/gebruikers/gebruikers';
            $this->load->view('template', $data);
        } else {
            redirect(base_url() . 'login');
        }

    }

    public function get_primary_user(){
        $data = $this->Gebruiker_model->get_primary_user_tobuyfor();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

    public function get_gebruikers_list()
    {
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->Gebruiker_model->get_gebruikers($q);
        }
    }
}