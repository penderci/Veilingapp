<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Artikel_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_table()
    {
        $table = "artikels";
        return $table;
    }

    public function get_artikels()
    {
        $query = $this->db->query("SELECT * FROM artikels ORDER BY naam asc");
        return $query->result();
    }

    public function get_artikels_autofill($q)
    {
        $this->db->select('naam');
        $this->db->like('naam', $q);
        $this->db->order_by("naam", "asc");
        $query = $this->db->get('artikels');

        if ($query->num_rows > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = htmlentities(stripslashes($row['naam'])); //build an array
            }

            echo json_encode($row_set); //format the array into json data
        }
    }

    public function insert($artikel)
    {
        $data = array('naam' => $artikel);
        $this->db->insert('artikels', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public
    function delete()
    {
        $this->db->where('id', $this->uri->segment(3));
        $this->db->delete('artikels');
    }

    public function get_where($id)
    {
        $table = $this->get_table();
        $this->db->where('id', $id);
        $query = $this->db->get($table);
        return $query;
    }

    public
    function update_artikel($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('artikels', $data);
    }

    public function get_artikel_id($artikel)
    {
        $query = $this->db->query("SELECT id FROM artikels WHERE lower(naam) = lower('" . $artikel . "')");
        $aantal = $query->num_rows();

        if ($aantal == 0) {
            $id = $this->insert($artikel);
        } else {
            $result = $query->result();
            $id = $result[0]->id;
        }

        return $id;
    }
}