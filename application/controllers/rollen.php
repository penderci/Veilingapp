<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rollen extends CI_Controller
{

    public function get_rollen(){

            $data = $this->Rollen_model->get_rollen();
            $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }
}