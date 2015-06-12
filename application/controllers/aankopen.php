<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Aankopen extends CI_Controller
{

    public function index()
    {
        if ($this->session->userdata('is_logged_in')) {

            $data['artikels'] = $this->Aankoop_model->get_artikels();

            $data['active'] = 'Registratie';
            $data['middle'] = '/aankopen/invoer';

            $this->load->view('template', $data);
        } else {
            redirect(base_url() . 'login');
        }

    }

    public function overzicht()
    {
        if ($this->session->userdata('is_logged_in')) {

            $data['active'] = 'Overzicht';
            $data['middle'] = '/aankopen/overzicht';

            $this->load->view('template', $data);
        } else {
            redirect(base_url() . 'login');
        }
    }

    //verwijder een aankoop uit de databank
    public function delete()
    {
        $this->Aankoop_model->delete();
    }

    public function update_aankoop()
    {
        $postdata = file_get_contents('php://input');
        $aankoop = json_decode($postdata);

        /*haal het id op van het artikel als dit bestaat, en anders, voeg het toe aan de artikel tabel en haal het id op*/
        $artikel_id = $this->Artikel_model->get_artikel_id($aankoop->artikel);

        $data['id'] = $aankoop->id;
        $data['artikel_id'] = $artikel_id;
        $data['eenheidsprijs'] = $aankoop->ehprijs;
        $data['aantal'] = $aankoop->aantal;
        $data['aantal_container'] = $aankoop->container;
        $data['aantal_doos'] = $aankoop->doos;
        $data['aantal_opzet'] = $aankoop->opzet;
        $data['aantal_tray'] = $aankoop->tray;

        $this->Aankoop_model->update_aankoop($data);

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

        if (is_array($aankopen)) {
            foreach ($aankopen as $aankoop) {

                /*haal de id op van de persoon waarvoor het artikel gekocht werd*/
                $gekochtVoor = $this->Gebruiker_model->get_gekochtVoor_gebruiker_id($aankoop->gekocht_voor);
                $gekochtVoor_id = $gekochtVoor->id;

                $koppeling = $this->Gebruiker_model->get_koppeling_id($aankoper_id, $gekochtVoor_id);
                $koppeling_id = $koppeling->id;

                /*haal het id op van het artikel als dit bestaat, en anders, voeg het toe aan de artikel tabel en haal het id op*/
                $artikel_id = $this->Artikel_model->get_artikel_id($aankoop->artikel);

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
                    'koppeling_id' => $koppeling_id,
                    'datum' => $datum,
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
    } //end synchronize

    //Functies voor het overzichtsscherm

    //haal de aankopen op van de persoon die ingelogd is, en die hij deed voor de gekozen partner
    public function aankopen_gedaan()
    {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata);

        $vanDateTime = DateTime::createFromFormat('Y-m-d\TH:i:s.uO', $request->vandatum);
        $vanDateTime->modify('+1 day');
        $vandatum = $vanDateTime->format('Y-m-d');

        $totDateTime = DateTime::createFromFormat('Y-m-d\TH:i:s.uO', $request->totdatum);
        $totDateTime->modify('+1 day');
        $totdatum = $totDateTime->format('Y-m-d');


        $gekochtVoor = $this->Gebruiker_model->get_gekochtVoor_gebruiker_id($request->partner);
        $gekochtVoor_id = $gekochtVoor->id;

        $aankoper = $this->Gebruiker_model->get_ingelogde_gebruiker_id();
        $aankoper_id = $aankoper->id;

        $koppeling = $this->Gebruiker_model->get_koppeling_id($aankoper_id, $gekochtVoor_id);
        $koppeling_id = $koppeling->id;

        $aankopen = $this->Aankoop_model->get_aankopen($vandatum, $totdatum, $koppeling_id);

        $this->output->set_content_type('application/json')->set_output(json_encode($aankopen));
    }

    //haal de aankopen die de gekozen partner deed voor de persoon die ingelogd is
    public function aankopen_ontvangen()
    {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata);

        $vanDateTime = DateTime::createFromFormat('Y-m-d\TH:i:s.uO', $request->vandatum);
        $vanDateTime->modify('+1 day');
        $vandatum = $vanDateTime->format('Y-m-d');

        $totDateTime = DateTime::createFromFormat('Y-m-d\TH:i:s.uO', $request->totdatum);
        $totDateTime->modify('+1 day');
        $totdatum = $totDateTime->format('Y-m-d');


        $gekochtVoor = $this->Gebruiker_model->get_ingelogde_gebruiker_id();
        $gekochtVoor_id = $gekochtVoor->id;

        $aankoper = $this->Gebruiker_model->get_gekochtVoor_gebruiker_id($request->partner);
        $aankoper_id = $aankoper->id;

        $koppeling = $this->Gebruiker_model->get_koppeling_id($aankoper_id, $gekochtVoor_id);

        $koppeling_id = $koppeling->id;
        $aankopen = $this->Aankoop_model->get_aankopen($vandatum, $totdatum, $koppeling_id);
        $this->output->set_content_type('application/json')->set_output(json_encode($aankopen));
    }

    public function totaal_delta_ak_gedaan()
    {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata);

        $gekochtVoor = $this->Gebruiker_model->get_gekochtVoor_gebruiker_id($request->partner);
        $gekochtVoor_id = $gekochtVoor->id;

        $aankoper = $this->Gebruiker_model->get_ingelogde_gebruiker_id();
        $aankoper_id = $aankoper->id;

        $koppeling = $this->Gebruiker_model->get_koppeling_id($aankoper_id, $gekochtVoor_id);
        $koppeling_id = $koppeling->id;

        $aankopen_delta = $this->Aankoop_model->get_delta_ak_gedaan($koppeling_id);

        $this->output->set_content_type('application/json')->set_output(json_encode($aankopen_delta));
    }

    public function totaal_delta_ak_ontvangen()
    {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata);

        $gekochtVoor = $this->Gebruiker_model->get_ingelogde_gebruiker_id();
        $gekochtVoor_id = $gekochtVoor->id;

        $aankoper = $this->Gebruiker_model->get_gekochtVoor_gebruiker_id($request->partner);
        $aankoper_id = $aankoper->id;

        $koppeling = $this->Gebruiker_model->get_koppeling_id($aankoper_id, $gekochtVoor_id);
        $koppeling_id = $koppeling->id;

        $ontvangen_delta = $this->Aankoop_model->get_delta_ak_gedaan($koppeling_id);

        $this->output->set_content_type('application/json')->set_output(json_encode($ontvangen_delta));
    }

    /*Functies voor het wijzigen van een aankooplijn*/
    public function edit_aankoop()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data['middle'] = '/aankopen/edit_aankoop';
            echo $this->load->view('template', $data);
        } else {
            redirect(base_url() . 'login');
        }
    }

}