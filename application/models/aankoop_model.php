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

    public function get_aankopen_ontvangen($vandatum, $totdatum, $aankoper_id, $gekochtVoor_id){

        $query = $this->db->query("SELECT * FROM aankopen WHERE aankoper_id = " . $aankoper_id .
                                    " AND gekocht_voor_id = " . $gekochtVoor_id .
                                    " AND datum BETWEEN '" . $vandatum ."' AND '" . $totdatum ."'");
//
        return $query->result();
    }

}