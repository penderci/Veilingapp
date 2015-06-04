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

    public function insert_gebruiker(){
        $postdata = file_get_contents('php://input');
        $gebruiker = json_decode($postdata);

        /*        print_r($gebruiker);
                die();*/

        $data = array(
            'voornaam'=> $gebruiker->voornaam,
            'naam'=>$gebruiker->naam,
            'email'=>$gebruiker->email,
            'paswoord'=>md5($gebruiker->paswoord),
            'rol_id'=>$gebruiker->rol

        );

        $this->Gebruiker_model->insert_gebruiker($data);
    }

    public function get_alle_gebruikers(){
        $data = $this->Gebruiker_model->get_alle_gebruikers();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));

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


    public function reset_paswoord(){
        if ($this->session->userdata('is_logged_in')) {
            $data['middle'] = '/gebruikers/reset_paswoord';
            $this->load->view('template', $data);
        } else {
            redirect(base_url() . 'login');
        }
    }

    public function save_nieuw_paswoord(){
        /*opgelet geen echo's hier zetten, anders wordt dit naar success van de angular call gestuurd ipv ok of nok*/

        $postdata = file_get_contents('php://input');
        $posted = json_decode($postdata);

        /*TODO : geen check doen, maar update in de tabel waar email gelijk en paswoord gelijk : indien geen match geeft dit geen id terug cfr id na insert
        dan iets terug sturen met $this->output->set_output($data);*/

        if ($this->Gebruiker_model->check_pwd_exists($posted->oud_pwd, $posted->nieuw_pwd)) {
            echo 'ok';
        } else {
            echo 'nok';
        }

    }




}