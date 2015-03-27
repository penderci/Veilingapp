<?php
class User_model extends CI_Model{
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
}