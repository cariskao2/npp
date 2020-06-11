<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Petition_f_model extends CI_Model
{
    public function getPetition()
    {
        $this->db->select();
        $this->db->from('petition');
        $this->db->where('petid', 1);

        $query = $this->db->get();

        return $query->row();
    }

    public function getToMail()
    {
        $this->db->select('mail');
        $this->db->from('setup');
        $this->db->where('set_id', 1);

        $query = $this->db->get();

        return $query->row();
    }

    public function delPath($f)
    {
        $this->db->where('my_path', $f);
        $this->db->delete('petition_f');
    }

    public function getOver1Hr()
    {
        $sqlSelect = "SELECT my_path FROM petition_f WHERE creation_date < now() - INTERVAL 1 hour";
        $query     = $this->db->query($sqlSelect);

        $sqlDel = "DELETE FROM petition_f WHERE  creation_date < now() - INTERVAL 1 hour";
        $this->db->query($sqlDel);

        if ($query->num_rows() > 0) {
            $arr = []; //stdClass最佳解決方案

            foreach ($query->result() as $row) {
                array_push($arr, $row->my_path);
            }

            return $arr;
        }
    }
}
