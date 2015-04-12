<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Artikels extends CI_Controller
{

    public function index()
    {
        //$data['artikels'] = $this->Aankoop_model->get_artikels();

        $data['middle'] = '/artikels/artikels';
        $this->load->view('template', $data);

    }

    public function get_list()
    {
        $data = $this->Artikel_model->get_artikels();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function insert_artikel()
    {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata);
        $naam = $request->naam;
        $id = $this->Artikel_model->insert($naam);

        if ($id) {
            echo $result = '{"status":"success"}';
        } else {
            echo $result = '{"status":"failure"}';
        }

    }

    public function delete_artikel()
    {

    }
}