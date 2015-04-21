<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class User_model_oud extends CI_Model{
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
        $query = $this->db->query("SELECT id FROM gebruikers WHERE email = " . $this->session->userdata('email'));
        $user_id = $query->result();

        $query = $this->db->query("SELECT koopt_voor_gebruiker_id FROM koppelingen WHERE gebruiker_id = " . $user_id . " AND primary=1");
        $priamary_user_id = $query->result();

        $query = $this->db->query("SELECT CONCAT(`voornaam`, ' ', `naam`) FROM gebruikers WHERE id = " . $priamary_user_id);
        return $query->result();

    }


}