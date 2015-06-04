<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rollen extends CI_Controller
{

    /*public function index()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data['middle'] = '/artikels/artikels';
            $this->load->view('template', $data);
        } else {
            redirect(base_url() . 'login');
        }

    }*/

    public function get_rollen(){

            $data = $this->Rollen_model->get_rollen();
            $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }
}