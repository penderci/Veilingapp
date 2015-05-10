<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Overdrachten extends CI_Controller
{

    public function index()
    {
        if ($this->session->userdata('is_logged_in')) {

            $data['middle'] = '/overdracht/overdrachten';
            $this->load->view('template', $data);
        } else {
            redirect(base_url() . 'login');
        }

    }
}