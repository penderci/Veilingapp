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

    function delete()
    {
        $this->db->where('id', $this->uri->segment(3));
        $this->db->delete('aankopen');
    }

    public function get_aankopen_gedaan($vandatum, $totdatum, $aankoper_id, $gekochtVoor_id){

        $query = $this->db->query("SELECT a.id, a.datum, b.naam, a.eenheidsprijs, a.aantal, a.aantal_container, a.aantal_doos, a.aantal_opzet, a.aantal_tray
                                    FROM aankopen a, artikels b WHERE a.aankoper_id = " . $aankoper_id .
                                    " AND a.gekocht_voor_id = " . $gekochtVoor_id .
                                    " AND a.datum BETWEEN '" . $vandatum ."' AND '" . $totdatum ."'
                                    AND a.artikel_id = b.id
                                    ORDER BY a.datum, b.naam");

        return $query->result();
    }

    public function get_aankopen_ontvangen($vandatum, $totdatum, $aankoper_id, $gekochtVoor_id){

        $query = $this->db->query("SELECT a.id, a.datum, b.naam, a.eenheidsprijs, a.aantal, a.aantal_container, a.aantal_doos, a.aantal_opzet, a.aantal_tray
                                    FROM aankopen a, artikels b WHERE a.aankoper_id = " . $aankoper_id .
            " AND a.gekocht_voor_id = " . $gekochtVoor_id .
            " AND a.datum BETWEEN '" . $vandatum ."' AND '" . $totdatum ."'
                                    AND a.artikel_id = b.id
                                    ORDER BY a.datum, b.naam");

        return $query->result();
    }

}