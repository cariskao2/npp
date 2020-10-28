<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Bill_issues_f_model extends CI_Model
{
    // 法案議題 & 關注議題的分類列表
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

    // 法案議題 & 重點法案的分類列表
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

    // 法案草案列表總數
    public function getBillCaseListCount()
    {
        $this->db->select();
        $this->db->from('bill_case as bc');
        $this->db->join('bill_status as bs', 'bs.status_id = bc.status_id', 'inner');
        $this->db->join('bill_category as bcg', 'bcg.gory_id = bc.gory_id', 'inner');
        // $this->db->join('billcase_years_b as bcyb', 'bcyb.case_id = bc.case_id', 'inner');

        $query = $this->db->get();

        return $query->num_rows();
    }

    // 法案草案列表
    public function getBillCaseList($page = 0, $segment = 0)
    {
        $this->db->select();
        $this->db->from('bill_case as bc');
        $this->db->join('bill_status as bs', 'bs.status_id = bc.status_id', 'inner');
        $this->db->join('bill_category as bcg', 'bcg.gory_id = bc.gory_id', 'inner');
        // $this->db->join('billcase_years_b as bcyb', 'bcyb.case_id = bc.case_id', 'inner');

        $this->db->order_by('bc.case_id', 'DESC');
        $this->db->limit($page, $segment);

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    // for pageTitle
    public function getCateGoryTitle($goryId)
    {
        $this->db->select('title');
        $this->db->from('bill_category as bc');
        $this->db->where('showsup', 1);
        $this->db->where('bc.gory_id', $goryId);

        $query = $this->db->get();
        $r     = $query->row();

        return $r->title;
    }

    // 重點法案輪播
    public function getBillCaseCarouselYears($goryId)
    {
        $this->db->select('y.yid,y.title');
        $this->db->from('billcase_years_b as bcyb');
        $this->db->join('bill_case as bc', 'bc.case_id = bcyb.case_id', 'inner');
        $this->db->join('years as y', 'y.yid = bcyb.yid', 'inner');
        $this->db->where('y.showup', 1);
        $this->db->where('bc.gory_id', $goryId);
        $this->db->group_by(array('y.yid', 'y.title')); //過濾重複資料
        $this->db->order_by('y.sort', 'ASC');

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }
}
