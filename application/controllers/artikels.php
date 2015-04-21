<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Artikels extends CI_Controller
{

    public function index()
    {
        //$data['artikels'] = $this->Aankoop_model->get_artikels();

        $data['middle'] = '/artikels/artikels';
        $this->load->view('template', $data);

    }

    public function get_list()
    {
        $data = $this->Artikel_model->get_artikels();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function insert_artikel()
    {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata);
        $naam = $request->naam;
        $id = $this->Artikel_model->insert($naam);

        if ($id) {
            echo $result = '{"status":"success"}';
        } else {
            echo $result = '{"status":"failure"}';
        }

    }

    public function delete()
    {
        $this->Artikel_model->delete();
        redirect(base_url().'artikels');
    }

    public function edit($update_id){
       // $update_id = $this->uri->segment(3);
        $data= $this->get_data_from_db($update_id);
        $data['middle'] = '/artikels/edit';

       //print_r($data);
        //die();

        $this->load->view('template', $data);

       // $this->load->view('/artikels/edit',$data);
    }

    public function update($id){
        $this->form_validation->set_rules("naam", "Naam", "required|xss_clean");

        if ($this->form_validation->run() == FALSE) {
            echo('valid false');
            die();
            $this->edit($id);
            //$this->load->view('/users/users_view');
        } else {
            if ($this->input->post('naam') != null) {

                $data = $this->get_data_from_post();
                $data['id'] = $id;
            } else {
                $data['id'] = $id;
                $data['naam'] = $this->input->post('naam',TRUE);
            }

            //print_r($data);
            // die();
            $this->Artikel_model->update_artikel($data);
            redirect(base_url().'artikels');
            /*$description = $this->input->post('description');

            $this->Todo_model->insert($description);

            redirect (base_url().'todo');*/
            //$this->index();
        }
    }

    public function get_data_from_db($artikel_id){
        $query=$this->Artikel_model->get_where($artikel_id);
        foreach($query ->result() as $row){
            $data['id'] = $row->id;
            $data['naam'] = $row->naam;
        }
        return($data);

        //op 4:43 in video 2 over CRUD, hier verder werken

    }

    public function get_data_from_post(){
        $data['naam'] = $this->input->post('naam',TRUE);
        return($data);
    }
}