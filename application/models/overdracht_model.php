<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Overdracht_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function insert_overdracht($data)
    {
        $this->db->insert('overdrachten', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
}