<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Overdracht_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function delete()
    {
        $this->db->where('id', $this->uri->segment(3));
        $this->db->delete('overdrachten');
    }

    public function insert_overdracht($data)
    {
        $this->db->insert('overdrachten', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function get_overdrachten($koppeling_id){
        $query = $this->db->query("SELECT *
                                    FROM overdrachten
                                    WHERE koppeling_id = " . $koppeling_id .
                                    " ORDER BY datum desc");

        return $query->result();
    }
}