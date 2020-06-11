<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Issues_f_model extends CI_Model
{
    public function issuesAllListingCount($ic_id)
    {

        $this->db->select();
        $this->db->from('issues_all as ia');
        $this->db->join('issues_class as ic', 'ia.ic_id = ic.ic_id', 'inner');

        $this->db->where('ia.showup', 1);
        $this->db->where('ia.ic_id', $ic_id);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function issuesAllListing($ic_id, $page, $segment)
    {
        $this->db->select('ia.img,ia.ia_id,ia.title,ia.introduction,ia.editor,ic.name,ic.ic_id');
        $this->db->from('issues_all as ia');
        $this->db->join('issues_class as ic', 'ia.ic_id = ic.ic_id', 'inner');

        $this->db->where('ia.showup', 1);
        $this->db->where('ia.ic_id', $ic_id);

        $this->db->order_by('ia_id', 'DESC');

        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }

    public function getIssuesAllInnerInfo($id)
    {
        $this->db->select('ia.img,ia.ia_id,ia.title,ia.introduction,ia.editor,ic.name,ic.ic_id');
        $this->db->from('issues_all as ia');
        $this->db->join('issues_class as ic', 'ia.ic_id = ic.ic_id', 'inner');
        $this->db->where('ia.showup', 1);
        $this->db->where('ia_id', $id);

        $query = $this->db->get();

        return $query->row();
    }

    // 編輯網址防禦
    public function editProtectCheck($id, $item = '')
    {
        $this->db->trans_start();

        if ($item == 'issues-class') {
            $this->db->select('ic_id');
            $this->db->from('issues_class');
            $this->db->where('ic_id', $id);
        }
        if ($item == 'issues-all') {
            $this->db->select('ia_id');
            $this->db->from('issues_all');
            $this->db->where('ia_id', $id);
        }

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }
}
