<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Artikels extends CI_Controller
{

    public function index()
    {
        if ($this->session->userdata('is_logged_in')) {
            $data['middle'] = '/artikels/artikels';
            $this->load->view('template', $data);
        } else {
            redirect(base_url() . 'login');
        }

    }

    //haal alle artikels op en zet de data in Json formaat
    public function get_list()
    {
        $data = $this->Artikel_model->get_artikels();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function get_list_autofill()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->Artikel_model->get_artikels_autofill($q);
        }
    }



    //voeg een artikel toe in de databanke
    public function insert_artikel()
    {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata);
        $naam = $request->naam;

        //doe de feitelijke insert in het model
        $id = $this->Artikel_model->insert($naam);

        if ($id) {
            echo $result = '{"status":"success"}';
        } else {
            echo $result = '{"status":"failure"}';
        }

    }

    //verwijder een artikel uit de databank
    public function delete()
    {
        $this->Artikel_model->delete();
        redirect(base_url() . 'artikels');
    }

    //Open het scherm om een artikel aan te passen
    public function edit($update_id)
    {
        if ($this->session->userdata('is_logged_in')) {
            $data = $this->get_data_from_db($update_id);
            $data['middle'] = '/artikels/edit';

            $this->load->view('template', $data);
        } else {
            redirect(base_url() . 'login');
        }

    }

    //Schrijf de aanpassing uit het edit scherm weg in de databank
    public function update($id)
    {
        $this->form_validation->set_rules("naam", "Naam", "required|xss_clean");

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            if ($this->input->post('naam') != null) {
                $data = $this->get_data_from_post();
                $data['id'] = $id;
            } else {
                $data['id'] = $id;
                $data['naam'] = $this->input->post('naam', TRUE);
            }

            $this->Artikel_model->update_artikel($data);
            redirect(base_url() . 'artikels');

        }
    }

    //haal een artikelrecord op uit de databank
    public function get_data_from_db($artikel_id)
    {
        $query = $this->Artikel_model->get_where($artikel_id);
        foreach ($query->result() as $row) {
            $data['id'] = $row->id;
            $data['naam'] = $row->naam;
        }
        return ($data);


    }

    //haal de artikelgegevens op die ingevuld werden in het scherm
    public function get_data_from_post()
    {
        $data['naam'] = $this->input->post('naam', TRUE);
        return ($data);
    }
}