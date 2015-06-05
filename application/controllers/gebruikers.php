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

    public function insert_gebruiker()
    {
        $postdata = file_get_contents('php://input');
        $gebruiker = json_decode($postdata);

        /*        print_r($gebruiker);
                die();*/

        $data = array(
            'voornaam' => $gebruiker->voornaam,
            'naam' => $gebruiker->naam,
            'email' => $gebruiker->email,
            'paswoord' => md5($gebruiker->paswoord),
            'rol_id' => $gebruiker->rol

        );

        $this->Gebruiker_model->insert_gebruiker($data);
    }

    public function delete_gebruiker()
    {
        $this->Gebruiker_model->delete_gebruiker();
        redirect(base_url() . 'gebruikers');
    }

    public function edit()
    {
        if ($this->session->userdata('is_logged_in')) {
            if ($this->session->userdata('rol') && $this->session->userdata('rol') == '2') {
                $id = $this->uri->segment(3);

                $query = $this->Gebruiker_model->get_where($id);

                foreach ($query->result() as $row) {
                    $data['id'] = $row->id;
                    $data['naam'] = $row->naam;
                    $data['voornaam'] = $row->voornaam;
                    $data['email'] = $row->email;
                    $data['rol_id'] = $row->rol_id;
                }

                $data['middle'] = '/gebruikers/edit_gebruiker';
                $this->load->view('template', $data);
            }
        } else {
            redirect(base_url() . 'login');
        }

    }

    public function update($id)
    {
        // $test = $this->input->post();
        //print_r($test);
        //die();

        $this->form_validation->set_rules("naam", "Naam", "required|xss_clean");
        $this->form_validation->set_rules("voornaam", "Voornaam", "required|xss_clean");
        $this->form_validation->set_rules("email", "Email", "required|valid_email|xss_clean");
        $this->form_validation->set_rules("var_rol_id2", "Gebruikerstype", "required|xss_clean");

        if ($this->form_validation->run() == FALSE) {
            //echo('valid false');
            //die();
            $this->edit($id);

        } else {
            $data['naam'] = $this->input->post('naam', TRUE);
            $data['voornaam'] = $this->input->post('voornaam', TRUE);
            $data['email'] = $this->input->post('email', TRUE);
            $data['rol_id'] = $this->input->post('var_rol_id2', TRUE);
            $data['id'] = $id;

            print_r($data);

            $this->Gebruiker_model->update_gebruiker($data);
            redirect(base_url() . 'gebruikers/edit/' . $id);

        }
    }

    public function koppeling()
    {
        if ($this->session->userdata('is_logged_in')) {
            if ($this->session->userdata('rol') && $this->session->userdata('rol') == '2') {
                $id = $this->uri->segment(3);

                $data['id'] = $id;

 /*               echo('id = ');
                print_r($data);
                die();*/

                $data['middle'] = '/gebruikers/koppeling';
                $this->load->view('template', $data);
            }
        } else {
            redirect(base_url() . 'login');
        }

    }

    public function get_alle_gebruikers()
    {
        $data = $this->Gebruiker_model->get_alle_gebruikers();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

    public function get_alle_gekoppelde_gebruikers()
    {   $postdata = file_get_contents('php://input');
        $posted = json_decode($postdata);

        $id = $posted->id;

        $data = $this->Gebruiker_model->get_alle_gekoppelde_gebruikers($id);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function get_alle_niet_gekoppelde_gebruikers()
    {   $postdata = file_get_contents('php://input');
        $posted = json_decode($postdata);

        $id = $posted->id;

        $data = $this->Gebruiker_model->get_alle_niet_gekoppelde_gebruikers($id);
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function get_primary_user()
    {
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
    public function get_gebruikers_list_autofill()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->Gebruiker_model->get_gebruikers_autofill($q);
        }
    }


    public function reset_paswoord()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data['middle'] = '/gebruikers/reset_paswoord';
            $this->load->view('template', $data);
        } else {
            redirect(base_url() . 'login');
        }
    }

    public function save_nieuw_paswoord()
    {
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


    public function admin_reset_paswoord()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data['middle'] = '/gebruikers/admin_reset_paswoord';
            $data['id'] = $this->uri->segment(3);
            $voornaam = $this->uri->segment(4);
            $naam = $this->uri->segment(5);
            $data['naam'] = $voornaam . ' ' . $naam;

            $this->load->view('template', $data);
        } else {
            redirect(base_url() . 'login');
        }

    }

    public function admin_save_nieuw_paswoord()
    {
        /*opgelet geen echo's hier zetten, anders wordt dit naar success van de angular call gestuurd ipv ok of nok*/

        $postdata = file_get_contents('php://input');
        $posted = json_decode($postdata);

        /*TODO : geen check doen, maar update in de tabel waar email gelijk en paswoord gelijk : indien geen match geeft dit geen id terug cfr id na insert
        dan iets terug sturen met $this->output->set_output($data);*/

        if ($this->Gebruiker_model->admin_save_nieuw_paswoord($posted->id, $posted->nieuw_pwd)) {
            echo 'ok';
        } else {
            echo 'nok';
        }

    }


}