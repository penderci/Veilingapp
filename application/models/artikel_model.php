<?php
class Artikel_model extends CI_Model{

    public function get_artikels(){
        $query = $this->db->query("SELECT * FROM artikels");
        return $query->result();
    }
}