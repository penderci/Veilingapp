<?php
class Artikel_model extends CI_Model{

    function get_table() {
        $table = "artikels";
        return $table;
    }

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

    public function delete(){
        $this->db->where('id',$this->uri->segment(3));
        $this->db->delete('artikels');
    }

    function get_where($id) {
        $table = $this->get_table();
        $this->db->where('id', $id);
        $query=$this->db->get($table);
        return $query;
    }

    public function update_artikel($data){
        $this->db->where('id',$data['id']);
        $this->db->update('artikels',$data);
    }
}