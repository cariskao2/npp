<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Members_f_model extends CI_Model
{

    // 獲取showup=1 && sort排序最前面的yid(暫不使用)

    // public function get1stSortYearID()
    // {
    //     $sql   = "SELECT `yid` FROM `years` WHERE `showup`=1 AND `sort`=(SELECT MIN(sort) FROM `years` WHERE `showup`=1)";
    //     $query = $this->db->query($sql);

    //     if ($query->num_rows() > 0) {
    //         $row = $query->row();

    //         return $row->yid;
    //     }
    // }

    public function getDate($id)
    {
        $this->db->select();
        // $this->db->select('date_start', 'date_end');
        $this->db->from('years as y');
        $this->db->where('y.yid', $id);

        // $sql   = "SELECT `date_start`,`date_end` FROM `years` WHERE `yid`=$id";
        // $query = $this->db->query($sql);

        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }

    // 屆期下拉選單
    public function getYearsList()
    {
        $this->db->select();
        $this->db->from('years as y');
        $this->db->where('showup', 1);
        $this->db->order_by('y.sort', 'ASC');

        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }

    // 獲取各個屆期的全部立委info
    public function getYearMembers($id)
    {
        $this->db->select();
        $this->db->from('mem_years_b as my');
        $this->db->join('years as y', 'my.yid = y.yid', 'inner');
        $this->db->join('members as m', 'm.memid = my.memid', 'inner');
        $this->db->where('m.showup', 1);
        $this->db->where('y.yid', $id);

        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }

    // views Inner的member資料表內容
    public function getMemberInfo($id)
    {
        $this->db->select();
        $this->db->from('members as m');
        $this->db->where('m.showup', 1);
        $this->db->where('m.memid', $id);

        $query = $this->db->get();

        return $query->row();
    }

    // 獲取各個黨員的聯絡資料
    public function getContacts($memid, $con_id)
    {
        $this->db->select();
        $this->db->from('mem_cont_records as mcr');
        $this->db->join('contacts as c', 'c.con_id = mcr.con_id', 'inner');
        $this->db->join('members as m', 'm.memid = mcr.memid', 'inner');
        $this->db->where('m.memid', $memid);
        $this->db->where('c.con_id', $con_id);

        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }

    // 獲取各個黨員的議題選擇
    public function getIssuesChoice($id)
    {
        $this->db->select('ic.name,mic.ic_id'); //注意!這裏逗號是在二個引號之內
        $this->db->from('mem_ic_b as mic');
        $this->db->join('issues_class as ic', 'ic.ic_id = mic.ic_id', 'inner');
        $this->db->join('members as m', 'm.memid = mic.memid', 'inner');
        $this->db->where('ic.showup', 1);
        $this->db->where('m.memid', $id);
        $this->db->order_by('ic.sort', 'ASC');

        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }
}
