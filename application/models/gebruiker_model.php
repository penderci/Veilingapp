<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Gebruiker_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }

    public function can_login(){
        $this->db->where('email',$this->input->post('inputEmail'));
        $this->db->where('paswoord',md5($this->input->post('inputPassword')));

        $query = $this->db->get('gebruikers');

        if ($query->num_rows()== 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_primary_user_tobuyfor(){
        $query = $this->db->query("SELECT id FROM gebruikers WHERE email = '" . $this->session->userdata('email'). "'");
        $result=$query->result();
        $user_id = $result[0]->id;

        $query = $this->db->query("SELECT koopt_voor_gebruiker_id FROM koppelingen WHERE gebruiker_id = " . $user_id . " AND primair=1");
        $result = $query->result();
        $priamary_user_id = $result[0]->koopt_voor_gebruiker_id;

        $query = $this->db->query("SELECT CONCAT(`voornaam`, ' ', `naam`) newnaam FROM gebruikers WHERE id = " . $priamary_user_id);
        $result = $query->result();

        return  $result[0]->newnaam;

    }

    public function get_gebruikers(){
        $query = $this->db->query("SELECT CONCAT(`voornaam`, ' ', `naam`) naam FROM gebruikers WHERE email != '" . $this->session->userdata('email') ."'");
        return $query->result();
    }

    public function get_ingelogde_gebruiker_id(){
        $query = $this->db->query("SELECT id FROM gebruikers WHERE email = '" . $this->session->userdata('email') ."'");
        $id = $query->result();
        return $id[0];
    }

    public function get_gekochtVoor_gebruiker_id($naam){
        $query = $this->db->query("SELECT id FROM gebruikers WHERE CONCAT(`voornaam`, ' ', `naam`) = '" . $naam ."'");
        $id = $query->result();
        return $id[0];
    }

    /*public function get_gebruikers($q){
       // $query = $this->db->query("SELECT CONCAT(`voornaam`, ' ', `naam`) naam FROM gebruikers WHERE email != '" . $this->session->userdata('email') . "' AND naam like '%$q%'");
        $this->db->select('voornaam');
        $this->db->like('voornaam', $q);
        $this->db->order_by("voornaam", "asc");

        $query = $this->db->get('gebruikers');

        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $row_set[] = htmlentities(stripslashes($row['voornaam'])); //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }


    }*/


}