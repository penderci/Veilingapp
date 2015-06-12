<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Aankoop_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_artikels()
    {
        $query = $this->db->query("SELECT * FROM artikels");
        return $query->result();
    }

    public function insert_aankoop_temp($data)
    {
        $this->db->insert('aankopen_temp', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function insert_aankoop($data)
    {
        $this->db->insert('aankopen', $data);
    }

    function delete()
    {
        $this->db->where('id', $this->uri->segment(3));
        $this->db->delete('aankopen');
    }

    public function update_aankoop($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('aankopen', $data);
    }


    public function get_aankopen($vandatum, $totdatum, $koppeling_id)
    {
        $query = $this->db->query("SELECT a.id, a.datum, b.naam, a.eenheidsprijs, a.aantal, a.aantal_container, a.aantal_doos, a.aantal_opzet, a.aantal_tray
                                    FROM aankopen a, artikels b WHERE a.koppeling_id = " . $koppeling_id .
            " AND a.datum BETWEEN '" . $vandatum . "' AND '" . $totdatum . "'
                                    AND a.artikel_id = b.id
                                    ORDER BY a.datum, b.naam");

        return $query->result();
    }

    public function get_delta_ak_gedaan($koppeling_id)
    {
        $query = $this->db->query("SELECT (sum(c.totaal_ak)- sum(c.totaal_bet)) totaal_delta,
                                          (sum(c.container_ak)- sum(c.container_bet)) container_delta,
                                          (sum(c.doos_ak)- sum(c.doos_bet)) doos_delta,
                                          (sum(c.opzet_ak)- sum(c.opzet_bet)) opzet_delta,
                                          (sum(c.tray_ak)- sum(c.tray_bet)) tray_delta
                                  FROM (
                                    SELECT sum(aantal * eenheidsprijs) totaal_ak, sum(aantal_container) container_ak,
                                            sum(aantal_doos) doos_ak, sum(aantal_opzet) opzet_ak, sum(aantal_tray) tray_ak, 0 totaal_bet,
                                            0 container_bet, 0 doos_bet, 0 opzet_bet, 0 tray_bet
                                            FROM aankopen WHERE koppeling_id = " . $koppeling_id .
            " UNION
                                    SELECT 0, 0, 0, 0, 0,sum(bedrag) totaal_bet, sum(aantal_container) container_bet,
                                           sum(aantal_doos) doos_bet, sum(aantal_opzet) opzet_bet, sum(aantal_tray) tray_bet
                                    FROM overdrachten WHERE koppeling_id = " . $koppeling_id . ") c");

        return $query->result();
    }

}