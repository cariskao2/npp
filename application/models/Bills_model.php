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
            $likeCriteria = "(bs.name LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $this->db->limit($page, $segment);

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    // 法案類別列表
    public function getBillCategoryListCount($searchText = '')
    {
        $this->db->select();
        $this->db->from('bill_category as bc');
        // $this->db->join('issues_class as ic', 'ic.ic_id = ia.ic_id', 'inner');

        if (!empty($searchText)) {
            $likeCriteria = "(bc.title LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getBillCategoryList($searchText = '', $page = 0, $segment = 0)
    {
        $this->db->select();
        $this->db->from('bill_category as bc');
        // $this->db->join('issues_class as ic', 'ic.ic_id = ia.ic_id', 'inner');

        if (!empty($searchText)) {
            $likeCriteria = "(bc.title LIKE '%" . $searchText . "%')";
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

    // 法案類別
    public function getBillCategoryInfo($id)
    {
        $this->db->select();
        $this->db->from('bill_category');
        $this->db->where('gory_id', $id);

        $query = $this->db->get();

        return $query->row();
    }

    public function billCategoryEditSend($userInfo, $id)
    {
        $this->db->where('gory_id', $id);
        $this->db->update('bill_category', $userInfo);

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

    // 法案狀態新增
    public function billStatusAddSend($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('bill_status', $userInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    // 法案類別新增
    public function billCategoryAddSend($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('bill_category', $userInfo);

        $insert_id = $this->db->insert_id();

        // 在MySQL中不能這樣寫,不能select自己又update自己
        // $sql = "UPDATE `bill_category` SET `sort` = (SELECT MAX(sort) FROM `bill_category`)+1 WHERE `gory_id` = $insert_id";

        // 所以需要更改成以下
        // $sql = "UPDATE `bill_category`, (SELECT MAX(sort)+1 as maxid FROM `bill_category`) as a SET `sort`=a.maxid WHERE `gory_id` = $insert_id";

        // 或是
        $sql = "UPDATE `bill_category` SET `sort` = (SELECT a.maxid FROM (SELECT MAX(sort)+1 as maxid FROM `bill_category`) as a) WHERE `gory_id` = $insert_id";

        $query = $this->db->query($sql);

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

    public function deleteBills($id, $type)
    {
        if ($type == 'bill-status') {
            $this->db->where('status_id', $id);
            $this->db->delete('bill_status');
        }
        if ($type == 'bill-category') {
            $this->db->where('gory_id', $id);
            $this->db->delete('bill_category');

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

    // 法案狀態名稱
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

    // 法案類別名稱
    public function billCategoryNameCheck($name, $id)
    {
        $this->db->trans_start();
        $this->db->select();
        $this->db->from('bill_category as bc');
        $this->db->where('bc.title', $name);

        if ($id != '') {
            $this->db->where('gory_id !=', $id);
        }

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }

    // 法案類別圖片名稱
    public function billCategoryImgCheck($img)
    {
        $this->db->trans_start();
        $this->db->select('img');
        $this->db->from('bill_category');
        $this->db->where('img', $img);

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
