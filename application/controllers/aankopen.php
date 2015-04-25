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

    public function insert_aankopen_temp(){


        $postdata = file_get_contents('php://input');
      //  print_r($postdata);
       // die();

        $request = json_decode($postdata);



       /* $this->form_validation->set_rules("aankoopdatum", "Datum", "required|xss_clean");
        $this->form_validation->set_rules("gekocht_voor", "Gekocht voor", "required|xss_clean");
        $this->form_validation->set_rules("artikel", "Naam", "required|xss_clean");*/

       /* if ($this->form_validation->run() == FALSE) {
            echo('false');
            die();
            $this->index();
        } else {
            echo('true');
            die();*/
            //$data = $this->get_data_from_post();

            //$this->Aankoop_model->insert_aankoop_temp($data);

            $id = $this->Aankoop_model->insert_aankoop_temp($request);

            if ($id) {
                echo $result = '{"status":"success"}';
            } else {
                echo $result = '{"status":"failure"}';
            }


            //return $result;
            //redirect(base_url().'aankopen/invoer');

       // }

    }

    public function get_list(){
        $data = $this->Aankoop_model->get_aankopen_temp();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}