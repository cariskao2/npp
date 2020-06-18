<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Bills_model extends CI_Model
{
    /*
    ##       ####  ######  ########
    ##        ##  ##    ##    ##
    ##        ##  ##          ##
    ##        ##   ######     ##
    ##        ##        ##    ##
    ##        ##  ##    ##    ##
    ######## ####  ######     ##
     */

    // 法案狀態列表
    public function getBillStatusListCount($searchText = '')
    {
        $this->db->select();
        $this->db->from('bill_status as bs');
        // $this->db->join('issues_class as ic', 'ic.ic_id = ia.ic_id', 'inner');

        if (!empty($searchText)) {
            $likeCriteria = "(bs.name LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getBillStatusList($searchText = '', $page = 0, $segment = 0)
    {
        $this->db->select();
        $this->db->from('bill_status as bs');
        // $this->db->join('issues_class as ic', 'ic.ic_id = ia.ic_id', 'inner');

        if (!empty($searchText)) {
            $likeCriteria = "(ia.title LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $this->db->limit($page, $segment);

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    /*
    .########.########..####.########
    .##.......##.....##..##.....##...
    .##.......##.....##..##.....##...
    .######...##.....##..##.....##...
    .##.......##.....##..##.....##...
    .##.......##.....##..##.....##...
    .########.########..####....##...
     */

    // 法案狀態
    public function getBillStatusInfo($id)
    {
        $this->db->select();
        $this->db->from('bill_status');
        $this->db->where('status_id', $id);

        $query = $this->db->get();

        return $query->row();
    }

    public function billStatusEditSend($userInfo, $id)
    {
        $this->db->where('status_id', $id);
        $this->db->update('bill_status', $userInfo);

        return true;
    }

    /*
    ..######...#######..########..########
    .##....##.##.....##.##.....##....##...
    .##.......##.....##.##.....##....##...
    ..######..##.....##.########.....##...
    .......##.##.....##.##...##......##...
    .##....##.##.....##.##....##.....##...
    ..######...#######..##.....##....##...
     */

    /*
    ....###....########..########.
    ...##.##...##.....##.##.....##
    ..##...##..##.....##.##.....##
    .##.....##.##.....##.##.....##
    .#########.##.....##.##.....##
    .##.....##.##.....##.##.....##
    .##.....##.########..########.
     */

    public function billStatusAddSend($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('bill_status', $userInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /*
    ########  ######## ##       ######## ######## ########
    ##     ## ##       ##       ##          ##    ##
    ##     ## ##       ##       ##          ##    ##
    ##     ## ######   ##       ######      ##    ######
    ##     ## ##       ##       ##          ##    ##
    ##     ## ##       ##       ##          ##    ##
    ########  ######## ######## ########    ##    ########
     */

    public function deleteBills($id, $str)
    {
        if ($str == 'bill-status') {
            $this->db->where('status_id', $id);
            $this->db->delete('bill_status');
        }
        if ($str == 'bill-') {
            $this->db->where('ia_id', $id);
            $this->db->delete('issues_all');

        }

        return $this->db->affected_rows();
    }

    /*
    ..######..##.....##.########..######..##....##
    .##....##.##.....##.##.......##....##.##...##.
    .##.......##.....##.##.......##.......##..##..
    .##.......#########.######...##.......#####...
    .##.......##.....##.##.......##.......##..##..
    .##....##.##.....##.##.......##....##.##...##.
    ..######..##.....##.########..######..##....##
     */

    public function billStatusNameCheck($name, $id)
    {
        $this->db->trans_start();
        $this->db->select();
        $this->db->from('bill_status as bs');
        $this->db->where('bs.name', $name);

        if ($id != '') {
            $this->db->where('status_id !=', $id);
        }

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }

    // 編輯網址防禦
    public function editProtectCheck($id, $item = '')
    {
        $this->db->trans_start();

        if ($item == 'bill-status') {
            $this->db->select('status_id');
            $this->db->from('bill_status');
            $this->db->where('status_id', $id);
        }
        if ($item == 'bill-category') {
            $this->db->select('gory_id');
            $this->db->from('bill_category');
            $this->db->where('gory_id', $id);
        }
        if ($item == 'bill-case') {
            $this->db->select('case_id');
            $this->db->from('bill_case');
            $this->db->where('case_id', $id);
        }

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }
}
