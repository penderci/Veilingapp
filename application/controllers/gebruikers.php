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

    /*deze wordt gebruikt om de localstorage op te vullen, vermits in het invoerscherm de db niet beschikbaar is, en de autofill uit de localstorage komt*/
    public function get_gebruikers_list()
    {

        $data = $this->Gebruiker_model->get_gebruikers();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
        /*if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->Gebruiker_model->get_gebruikers($q);
        }*/
    }

    /*deze wordt gebruikt in het overzichtsscherm, omdat de autofill hier uit de database gehaald wordt, er kan na het inladen in de local storage iets gewijzigd zijn*/
    public function get_gebruikers_list_autofill(){
        if (isset($_GET['term'])){
            $q = strtolower($_GET['term']);
            $this->Gebruiker_model->get_gebruikers_autofill($q);
        }
    }

 /*   public function get_koppeling_id(){


    }*/

}