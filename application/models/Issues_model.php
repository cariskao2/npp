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
        $this->db->select('ia.ia_id,ia.showup,ia.title,ic.name,ia.img');
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

    public function issuesClassListing($isSort, $searchText = '', $page = 0, $segment = 0)
    {
        $this->db->select();
        $this->db->from('issues_class as ic');

        if (!empty($searchText)) {
            $likeCriteria = "(ic.name LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        // $isSort=true,select下拉選單使用,所以只撈出showup=1的值(但是這樣排序不會顯示,所以排序獨自再做一個)
        if ($isSort) {
            $this->db->where('ic.showup', 1);
        }

        $this->db->order_by('ic.sort', 'ASC');

        // $isSort=true,不產生分頁,select下拉選單使用
        if (!$isSort) {
            $this->db->limit($page, $segment);
        }

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

    //  獲得議題類別排序列表
    public function sortList()
    {
        $this->db->select();
        $this->db->from('issues_class as ic');
        $this->db->order_by('ic.sort', 'ASC');

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    // 議題類別排序存入
    public function sort($sort)
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

        $sql   = "UPDATE `issues_class` SET `sort` = (SELECT MAX(sort) FROM `issues_class`)+1 WHERE `ic_id` = $insert_id";
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
