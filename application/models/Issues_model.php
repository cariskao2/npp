<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Issues_model extends CI_Model
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

    //將issues_class的show存入issue_all欄位
    public function getICshow()
    {
        $this->db->select('ic.ic_id,ic.showup');
        $this->db->from('issues_class as ic');

        $queryResult = $this->db->get()->result();

        foreach ($queryResult as $k) {
            $icId   = $k->ic_id;
            $icShow = $k->showup;

            $this->updateICshow2IA($icId, $icShow);
        }
    }

    public function updateICshow2IA($icId, $icShow)
    {
        $userInfo = array(
            'ic_is_show' => $icShow,
        );

        $this->db->where('ic_id', $icId);
        $this->db->update('issues_all', $userInfo);
    }

    // 議題列表
    public function issuesAllListingCount($searchText = '')
    {
        $this->db->select();
        $this->db->from('issues_all as ia');
        $this->db->join('issues_class as ic', 'ic.ic_id = ia.ic_id', 'inner');

        if (!empty($searchText)) {
            $likeCriteria = "(ia.title LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function issuesAllListing($searchText = '', $page = 0, $segment = 0)
    {
        $this->db->select('ia.ia_id,ia.showup,ia.title,ic.name,ia.img,ia.ic_is_show');
        $this->db->from('issues_all as ia');
        $this->db->join('issues_class as ic', 'ic.ic_id = ia.ic_id', 'inner');

        if (!empty($searchText)) {
            $likeCriteria = "(ia.title LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $this->db->limit($page, $segment);

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    // 議題類別
    public function issuesClassListingCount($searchText = '')
    {
        $this->db->select();
        $this->db->from('issues_class as ic');

        if (!empty($searchText)) {
            $likeCriteria = "(ic.name LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function issuesClassListing($searchText = '', $page = 0, $segment = 0)
    {
        $this->db->select();
        $this->db->from('issues_class as ic');

        if (!empty($searchText)) {
            $likeCriteria = "(ic.name LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $this->db->order_by('ic.sort', 'ASC');
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

    // 議題列表
    public function getIssuesAllInfo($id)
    {
        $this->db->select();
        $this->db->from('issues_all');
        $this->db->where('ia_id', $id);

        $query = $this->db->get();

        return $query->row();
    }

    public function issuesAllEditSend($userInfo, $id)
    {
        $this->db->where('ia_id', $id);
        $this->db->update('issues_all', $userInfo);

        return true;
    }

    // 議題類別
    public function getIssuesClassInfo($id)
    {
        $this->db->select();
        $this->db->from('issues_class');
        $this->db->where('ic_id', $id);

        $query = $this->db->get();

        return $query->row();
    }

    public function issuesClassEditSend($userInfo, $id)
    {
        $this->db->where('ic_id', $id);
        $this->db->update('issues_class', $userInfo);

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

    public function getBillCategory()
    {
        $this->db->select();
        $this->db->from('bill_category as bc');
        $this->db->where('showsup', 1);
        $this->db->order_by('sort', 'ASC');

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    //  獲得議題類別排序列表
    public function issuesClassSort($isIssuesAll = false)
    {
        $this->db->select();
        $this->db->from('issues_class as ic');

        if ($isIssuesAll) {
            $this->db->where('showup', 1);
        }

        $this->db->order_by('ic.sort', 'ASC');

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    // 議題類別排序存入
    public function issuesClassSortSend($sort)
    {
        foreach ($sort as $k => $v) {
            $k++;
            $sql   = "UPDATE `issues_class` SET `sort` = $k WHERE `ic_id` = $v";
            $query = $this->db->query($sql);
        }

        return true;
    }

    /*
    ....###....########..########.
    ...##.##...##.....##.##.....##
    ..##...##..##.....##.##.....##
    .##.....##.##.....##.##.....##
    .#########.##.....##.##.....##
    .##.....##.##.....##.##.....##
    .##.....##.########..########.
     */

    public function issuesAllAddSend($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('issues_all', $userInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    public function issuesClassAddSend($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('issues_class', $userInfo);

        $insert_id = $this->db->insert_id();

        // 在MySQL中不能這樣寫,不能select自己又update自己
        // $sql = "UPDATE `issues_class` SET `sort` = (SELECT MAX(sort) FROM `issues_class`)+1 WHERE `ic_id` = $insert_id";

        // 所以需要更改成以下
        // $sql = "UPDATE `issues_class`, (SELECT MAX(sort)+1 as maxid FROM `issues_class`) as a SET `sort`=a.maxid WHERE `ic_id` = $insert_id";

        // 或是
        $sql = "UPDATE `issues_class` SET `sort` = (SELECT a.maxid FROM (SELECT MAX(sort)+1 as maxid FROM `issues_class`) as a) WHERE `ic_id` = $insert_id";

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

    public function deleteIssues($id, $str)
    {
        if ($str == 'class') {
            $this->db->where('ic_id', $id);
            $this->db->delete('issues_class');
        }
        if ($str == 'all') {
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

    //  議題列表大圖
    public function imgAll_check($img)
    {
        $this->db->trans_start();
        $this->db->select('img');
        $this->db->from('issues_all');
        $this->db->where('img', $img);

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }

    //  議題類別封面圖
    public function img_check($img)
    {
        $this->db->trans_start();
        $this->db->select('img');
        $this->db->from('issues_class');
        $this->db->where('img', $img);

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
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

    // 議題列表
    public function issuesAll_check($title, $id)
    {
        $this->db->trans_start();
        $this->db->select();
        $this->db->from('issues_all as ia');
        $this->db->where('ia.title', $title);
        if ($id != '') {
            $this->db->where('ia_id !=', $id);
        }

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }

    // 議題類別 add edit
    public function issuesClass_check($name, $id)
    {
        $this->db->trans_start();
        $this->db->select();
        $this->db->from('issues_class');
        $this->db->where('name', $name);
        if ($id != '') {
            $this->db->where('ic_id !=', $id);
        }

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }
}
