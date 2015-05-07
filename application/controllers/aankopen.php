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

    public function overzicht()
    {
        if ($this->session->userdata('is_logged_in')) {

            //$data['leeggoed'] = $this->Aankoop_model->get_leeggoed();

            $data['middle'] = '/aankopen/overzicht';
            $this->load->view('template', $data);
        } else {
            redirect(base_url() . 'login');
        }
    }

    public function insert_aankopen_temp()
    {


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

    public function get_list()
    {
        $data = $this->Aankoop_model->get_aankopen_temp();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function synchronize()
    {
        /*alle records uit de local storage*/
        $postdata = file_get_contents('php://input');
        $aankopen = json_decode($postdata);  /*array*/

        /*haal de id op van de ingelogde persoon adhv het mailadres*/
        $aankoper = $this->Gebruiker_model->get_ingelogde_gebruiker_id();
        $aankoper_id = $aankoper->id;

        $aankopen_batch = array();

        if (is_array($aankopen)) {
            foreach ($aankopen as $aankoop) {
                echo('aankoop : <br>');
                print_r($aankoop);

                /*haal de id op van de persoon waarvoor het artikel gekocht werd*/
                $gekochtVoor = $this->Gebruiker_model->get_gekochtVoor_gebruiker_id($aankoop->gekocht_voor);
                $gekochtVoor_id = $gekochtVoor->id;

                /*haal het id op van het artikel als dit bestaat, en anders, voeg het toe aan de artikel tabel en haal het id op*/
                $artikel_id = $this->Artikel_model->get_artikel_id($aankoop->artikel);

                echo('artikel');
                echo($artikel_id);

                if (property_exists($aankoop, 'eenheidsprijs')) {
                    $eenheidsprijs = $aankoop->eenheidsprijs;
                } else {
                    $eenheidsprijs = NULL;
                }

                if (property_exists($aankoop, 'aantal')) {
                    $aantal = $aankoop->aantal;
                } else {
                    $aantal = NULL;
                }

                if (property_exists($aankoop, 'aantal_container')) {
                    $aantal_container = $aankoop->aantal_container;
                } else {
                    $aantal_container = NULL;
                }

                if (property_exists($aankoop, 'aantal_doos')) {
                    $aantal_doos = $aankoop->aantal_doos;
                } else {
                    $aantal_doos = NULL;
                }

                if (property_exists($aankoop, 'aantal_opzet')) {
                    $aantal_opzet = $aankoop->aantal_opzet;
                } else {
                    $aantal_opzet = NULL;
                }

                if (property_exists($aankoop, 'aantal_tray')) {
                    $aantal_tray = $aankoop->aantal_tray;
                } else {
                    $aantal_tray = NULL;
                }

                $myDateTime = DateTime::createFromFormat('Y-m-d\TH:i:s.uO', $aankoop->datum);
                $myDateTime->modify('+1 day');
                $datum = $myDateTime->format('Y-m-d');

                $data = array(
                    'aankoper_id' => $aankoper_id,
                    'gekocht_voor_id' => $gekochtVoor_id,
                    'datum' => $datum, //$aankoop->datum,
                    'artikel_id' => $artikel_id,
                    'eenheidsprijs' => $eenheidsprijs,
                    'aantal' => $aantal,
                    'aantal_container' => $aantal_container,
                    'aantal_doos' => $aantal_doos,
                    'aantal_opzet' => $aantal_opzet,
                    'aantal_tray' => $aantal_tray
                );

                $this->Aankoop_model->insert_aankoop($data);

            }
        }
    }
}