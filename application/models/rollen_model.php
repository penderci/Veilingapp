<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rollen_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_rollen()
    {
        $query = $this->db->query("SELECT * FROM rollen");
        return $query->result();
    }
}