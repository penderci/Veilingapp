<?php
class Aankoop_model extends CI_Model{
    public function get_leeggoed(){
        $query = $this->db->query("SELECT * FROM leeggoed");
        return $query->result();
    }

    public function get_artikels(){
        $query = $this->db->query("SELECT * FROM artikels");
        return $query->result();
    }
}