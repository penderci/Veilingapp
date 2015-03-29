<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Artikels extends CI_Controller
{

    public function index()
    {
        //$data['artikels'] = $this->Aankoop_model->get_artikels();

        $data['middle'] = '/artikels/artikels';
        $this->load->view('template', $data);

    }

    public function get_list() {
        $data = $this->Artikel_model->get_artikels();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}