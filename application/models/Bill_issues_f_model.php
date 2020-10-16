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

    public function getBillCategory($isAll = false)
    {
        $this->db->select();
        $this->db->from('bill_category as bc');
        $this->db->where('bc.showsup', 1);
        $this->db->order_by('bc.sort', 'ASC');

        if (!$isAll) {
            $this->db->limit(5);
        }

        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }

    // 法案草案列表
    public function getBillCaseListCount()
    {
        $this->db->select();
        $this->db->from('bill_case as bc');
        $this->db->join('bill_status as bs', 'bs.status_id = bc.status_id', 'inner');

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getBillCaseList($page = 0, $segment = 0)
    {
        $this->db->select();
        $this->db->from('bill_case as bc');
        $this->db->join('bill_status as bs', 'bs.status_id = bc.status_id', 'inner');

        $this->db->order_by('bc.case_id', 'DESC');
        $this->db->limit($page, $segment);

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }
}
