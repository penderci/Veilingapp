<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Overdrachten extends CI_Controller
{

    public function index()
    {
        if ($this->session->userdata('is_logged_in')) {

            $data['active'] = 'Overdracht';
            $data['middle'] = '/overdracht/overdrachten';
            $this->load->view('template', $data);
        } else {
            redirect(base_url() . 'login');
        }

    }

    //verwijder een aankoop uit de databank
    public function delete()
    {
        $this->Overdracht_model->delete();
        //redirect(base_url() . 'overzicht');
    }

    public function insert_overdracht(){
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata);
        //print_r($request);

        $gebruiker = $this->Gebruiker_model->get_ingelogde_gebruiker_id();
        //print_r($gebruiker);
        $gebruiker_id = $gebruiker->id;

        //echo('gebruikerid = ' . $gebruiker_id);

        $koopt_voor_gebruiker = $this->Gebruiker_model->get_gekochtVoor_gebruiker_id($request->partner);
        $koopt_voor_gebruiker_id = $koopt_voor_gebruiker->id;

        //echo('koopt_voor_gebruikerid = ' . $koopt_voor_gebruiker_id);

        $koppeling = $this->Gebruiker_model->get_koppeling_id($gebruiker_id,$koopt_voor_gebruiker_id);
        $koppeling_id = $koppeling->id;

        //echo('koppelingid = ');
        //print_r($koppeling_id);

        $myDateTime = DateTime::createFromFormat('Y-m-d\TH:i:s.uO', $request->datum);
        $myDateTime->modify('+1 day');
        $datum = $myDateTime->format('Y-m-d');

        if(isset($request->bedrag)){
            $bedrag = $request->bedrag;
        } else {
            $bedrag = 0;
        }

        if(isset($request->aantal_container)){
            $aantal_container = $request->aantal_container;
        } else {
            $aantal_container = 0;
        }

        if(isset($request->aantal_opzet)){
            $aantal_opzet = $request->aantal_opzet;
        } else {
            $aantal_opzet = 0;
        }

        if(isset($request->aantal_tray)){
            $aantal_tray = $request->aantal_tray;
        } else {
            $aantal_tray = 0;
        }

        if(isset($request->aantal_doos)){
            $aantal_doos = $request->aantal_doos;
        } else {
            $aantal_doos = 0;
        }

        $data = array(
            'koppeling_id' => $koppeling_id,
            'bedrag' => $bedrag,
            'aantal_container' => $aantal_container,
            'aantal_doos' => $aantal_doos,
            'aantal_opzet' => $aantal_opzet,
            'aantal_tray' => $aantal_tray,
            'datum' => $datum
        );

        //doe de feitelijke insert in het model
        $id = $this->Overdracht_model->insert_overdracht($data);

        if ($id) {
            echo $result = '{"status":"success"}';
        } else {
            echo $result = '{"status":"failure"}';
        }


    }

    public function update_overdracht(){
        $postdata = file_get_contents('php://input');
        $overdracht = json_decode($postdata);

       // print_r($overdracht);

        $myDateTime = DateTime::createFromFormat('Y-m-d\TH:i:s.uO', $overdracht->datum);
        $myDateTime->modify('+1 day');
        $datum = $myDateTime->format('Y-m-d');

        $data['id'] = $overdracht->id;
        $data['datum'] = $datum;
        $data['bedrag'] = $overdracht->bedrag;
        $data['aantal_container'] = $overdracht->container;
        $data['aantal_doos'] = $overdracht->doos;
        $data['aantal_opzet'] = $overdracht->opzet;
        $data['aantal_tray'] = $overdracht->tray;

        //print_r($data);
        //die();

        $this->Overdracht_model->update_overdracht($data);
    }

    public function get_betalingen(){
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata);
        //print_r($request);

        $gebruiker = $this->Gebruiker_model->get_ingelogde_gebruiker_id();
        //print_r($gebruiker);
        $gebruiker_id = $gebruiker->id;

        if(isset($request->betaaldAan)){
            $koopt_voor_gebruiker = $this->Gebruiker_model->get_gekochtVoor_gebruiker_id($request->betaaldAan);
            $koopt_voor_gebruiker_id = $koopt_voor_gebruiker->id;
//        } elseif (isset($request->partner)) {
//            $koopt_voor_gebruiker = $this->Gebruiker_model->get_gekochtVoor_gebruiker_id($request->partner);
//            $koopt_voor_gebruiker_id = $koopt_voor_gebruiker->id;
        } else {
            $naam = $this->Gebruiker_model->get_primary_user_tobuyfor();
           // echo ('naam : ');
           // print_r($naam);
            $koopt_voor_gebruiker = $this->Gebruiker_model->get_gekochtVoor_gebruiker_id($naam);
            $koopt_voor_gebruiker_id = $koopt_voor_gebruiker->id;

        }

        $koppeling = $this->Gebruiker_model->get_koppeling_id($gebruiker_id,$koopt_voor_gebruiker_id);
        $koppeling_id = $koppeling->id;

       // echo('koppelingid = ');
       // print_r($koppeling_id);

        $overdrachten = $this->Overdracht_model->get_overdrachten($koppeling_id);

        //echo('overdrachten = ');
       // print_r($overdrachten);
       // echo('na overdrachten');
        //print_r(json_encode($overdrachten));

       $this->output->set_content_type('application/json')->set_output(json_encode($overdrachten));

    }

    /*Bereken het totaal dat je ooit betaalde aan je partner*/
//    public function get_totaal_betaald(){
//        $postdata = file_get_contents('php://input');
//        $request = json_decode($postdata);
//
//        $gebruiker = $this->Gebruiker_model->get_ingelogde_gebruiker_id();
//
//        $gebruiker_id = $gebruiker->id;
//
//        if(isset($request->partner)){
//            $koopt_voor_gebruiker = $this->Gebruiker_model->get_gekochtVoor_gebruiker_id($request->partner);
//            $koopt_voor_gebruiker_id = $koopt_voor_gebruiker->id;
//        } else {
//            $naam = $this->Gebruiker_model->get_primary_user_tobuyfor();
//             $koopt_voor_gebruiker = $this->Gebruiker_model->get_gekochtVoor_gebruiker_id($naam);
//            $koopt_voor_gebruiker_id = $koopt_voor_gebruiker->id;
//        }
//
//        $koppeling = $this->Gebruiker_model->get_koppeling_id($gebruiker_id,$koopt_voor_gebruiker_id);
//        $koppeling_id = $koppeling->id;
//
//        $overdrachten = $this->Overdracht_model->totaal_betalingen($koppeling_id);
//
//        $this->output->set_content_type('application/json')->set_output(json_encode($overdrachten));
//    }

    /*Bereken het totaal dat je partner ooit aan jou betaalde*/
//    public function get_totaal_ontvangen(){
//        $postdata = file_get_contents('php://input');
//        $request = json_decode($postdata);
//
//        $koopt_voor_gebruiker = $this->Gebruiker_model->get_ingelogde_gebruiker_id();
//
//        $koopt_voor_gebruiker_id = $koopt_voor_gebruiker->id;
//
//        if(isset($request->partner)){
//            $gebruiker = $this->Gebruiker_model->get_gekochtVoor_gebruiker_id($request->partner);
//            $gebruiker_id = $gebruiker->id;
//        } else {
//            $naam = $this->Gebruiker_model->get_primary_user_tobuyfor();
//            $gebruiker = $this->Gebruiker_model->get_gekochtVoor_gebruiker_id($naam);
//            $gebruiker_id = $gebruiker->id;
//        }
//
//        $koppeling = $this->Gebruiker_model->get_koppeling_id($gebruiker_id,$koopt_voor_gebruiker_id);
//        $koppeling_id = $koppeling->id;
//
//        $overdrachten = $this->Overdracht_model->totaal_betalingen($koppeling_id);
//
//        $this->output->set_content_type('application/json')->set_output(json_encode($overdrachten));
//    }


}