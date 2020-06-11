<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Bill_issues_f_model extends CI_Model
{
    public function getIssuesClass($isAll = false)
    {
        $this->db->select();
        $this->db->from('issues_class as ic');
        $this->db->where('ic.showup', 1);
        $this->db->order_by('ic.sort', 'ASC');

        if (!$isAll) {
            $this->db->limit(5);
        }

        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }
}
