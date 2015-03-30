<?php
class Artikel_model extends CI_Model{

    public function get_artikels(){
        $query = $this->db->query("SELECT * FROM artikels");
        return $query->result();
    }

    public function insert($artikel){
        //$query_str = "INSERT INTO artikels (naam) VALUES (?)";

        //$this->db->query($query_str, $artikel);
        $data=array('naam'=>$artikel);
        $this->db->insert('artikels',$data);
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }
}