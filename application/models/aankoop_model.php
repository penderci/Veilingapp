<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Aankoop_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }

    public function get_leeggoed(){
        $query = $this->db->query("SELECT * FROM leeggoed");
        return $query->result();
    }

    public function get_artikels(){
        $query = $this->db->query("SELECT * FROM artikels");
        return $query->result();
    }

    public function insert_aankoop_temp($data){

        echo('in model');
        print_r($data);
       // die();

        $this->db->insert('aankopen_temp', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function get_aankopen_temp(){
        $query = $this->db->query("SELECT * FROM aankopen_temp");
        return $query->result();
    }

    public function insert_aankoop($data){
        $this->db->insert('aankopen', $data);
    }

}