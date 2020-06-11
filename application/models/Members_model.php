<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Members_model extends CI_Model
{

/*
.##.......####..######..########..######.
.##........##..##....##....##....##....##
.##........##..##..........##....##......
.##........##...######.....##.....######.
.##........##........##....##..........##
.##........##..##....##....##....##....##
.########.####..######.....##.....######.
 */

    // 黨員
    public function listingCount($searchText = '')
    {
        // log_message('error', 'News_model listingCount 有錯誤!');
        $this->db->select();

        $this->db->from('members as m');

        if (!empty($searchText)) {
            $likeCriteria = "(m.name  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function listing($isSort, $searchText = '', $page = 0, $segment = 0)
    {
        $this->db->select();
        $this->db->from('members as m');

        if (!empty($searchText)) {
            $likeCriteria = "(m.name  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $this->db->order_by('m.sort', 'ASC');

        if (!$isSort) {
            $this->db->limit($page, $segment);
        }

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    // 屆期
    public function yearsListingCount($searchText = '')
    {
        $this->db->select();
        $this->db->from('years as BaseTbl');

        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.title LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function yearsListing($isSort, $searchText = '', $page = 0, $segment = 0)
    {
        $this->db->select();
        $this->db->from('years as y');

        if (!empty($searchText)) {
            $likeCriteria = "(y.title LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $this->db->order_by('y.sort', 'ASC');

        if (!$isSort) {
            $this->db->limit($page, $segment);
        }

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
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

    // members新增
    public function membersAdd($info)
    {
        $this->db->trans_start();
        $this->db->insert('members', $info);

        $insert_id = $this->db->insert_id();

        $sql   = "UPDATE `members` SET `sort` = (SELECT MAX(sort) FROM `members`)+1 WHERE `memid` = $insert_id";
        $query = $this->db->query($sql);

        $this->db->trans_complete();

        return $insert_id;
    }

    // 其它members相依新增
    public function members_mem_add($memInfo, $num)
    {
        $this->db->trans_start();

        if ($num == 1) {
            $this->db->insert_batch('mem_years_b', $memInfo);
        } else if ($num == 2) {
            $this->db->insert_batch('mem_ic_b', $memInfo);
        } else {
            // 若$memInfo不爲空才執行insert
            if (count($memInfo) > 0) {
                $this->db->insert_batch('mem_cont_records', $memInfo);
            }
        }

        // $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        // return $insert_id;
        return true;
    }

    // 屆期
    public function yearsAddSend($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('years', $userInfo);

        $insert_id = $this->db->insert_id();

        $sql   = "UPDATE `years` SET `sort` = (SELECT MAX(sort) FROM `years`)+1 WHERE `yid` = $insert_id";
        $query = $this->db->query($sql);

        $this->db->trans_complete();

        return $insert_id;
    }

    // 聯絡方式列表
    public function getContactList()
    {
        $this->db->select();
        $this->db->from('contacts as c');

        $this->db->order_by('c.con_id', 'ASC');
        $query = $this->db->get();

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

    public function membersUpdate($who, $id, $info = '')
    {
        $this->db->where('memid', $id);

        if ($who == 'edit') {
            $this->db->update('members', $info);
        } else {
            $this->db->delete('members');
        }

        $this->db->where('memid', $id);
        $this->db->delete('mem_years_b');

        $this->db->where('memid', $id);
        $this->db->delete('mem_ic_b');

        $this->db->where('memid', $id);
        $this->db->delete('mem_cont_records');

        return true;
    }

    // get members info
    public function getMemberInfo($id)
    {
        $this->db->select();
        $this->db->from('members');
        $this->db->where('memid', $id);

        $query = $this->db->get();

        return $query->row();
    }

    public function getYearInfo($id)
    {
        $this->db->select();
        $this->db->from('years');
        $this->db->where('yid', $id);

        $query = $this->db->get();

        return $query->row();
    }

    public function yearsEditSend($userInfo, $id)
    {
        $this->db->where('yid', $id);
        $this->db->update('years', $userInfo);

        return true;
    }

/*
.########..########.##.......########.########.########
.##.....##.##.......##.......##..........##....##......
.##.....##.##.......##.......##..........##....##......
.##.....##.######...##.......######......##....######..
.##.....##.##.......##.......##..........##....##......
.##.....##.##.......##.......##..........##....##......
.########..########.########.########....##....########
 */

    public function deleteYears($id)
    {
        $this->db->where('yid', $id);
        $this->db->delete('years');

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

    //  屆期 add edit
    public function years_check($name, $id)
    {
        $this->db->trans_start();
        $this->db->select();
        $this->db->from('years');
        $this->db->where('title', $name);
        if ($id != '') {
            $this->db->where('yid !=', $id);
        }

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }

    // members add edit
    public function name_check($name, $id)
    {
        $this->db->trans_start();
        $this->db->select();
        $this->db->from('members');
        $this->db->where('name', $name);

        if ($id != '') {
            $this->db->where('memid !=', $id);
        }

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }

    public function img_check($img)
    {
        $this->db->trans_start();
        $this->db->select('img');
        $this->db->from('members');
        $this->db->where('img', $img);

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }

    // 編輯網址防禦
    public function editProtectCheck($id, $item = '')
    {
        $this->db->trans_start();

        if ($item == 'years') {
            $this->db->select('yid');
            $this->db->from('years');
            $this->db->where('yid', $id);
        }

        if ($item == 'members') {
            $this->db->select('memid');
            $this->db->from('members');
            $this->db->where('memid', $id);
        }

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
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

    // 屆期排序update
    public function sort($sort, $who)
    {
        $id = $who == 'members' ? 'memid' : 'yid';

        foreach ($sort as $k => $v) {
            $k++;
            $sql   = "UPDATE $who SET `sort` = $k WHERE $id = $v";
            $query = $this->db->query($sql);
        }

        return true;
    }

/*
..######..########.##.......########..######..########.####.########.########
.##....##.##.......##.......##.......##....##....##.....##.......##..##......
.##.......##.......##.......##.......##..........##.....##......##...##......
..######..######...##.......######...##..........##.....##.....##....######..
.......##.##.......##.......##.......##..........##.....##....##.....##......
.##....##.##.......##.......##.......##....##....##.....##...##......##......
..######..########.########.########..######.....##....####.########.########
 */

    public function getYearsList()
    {
        $this->db->select();
        $this->db->from('years as y');
        $this->db->where('showup', 1);

        // $this->db->order_by('BaseTbl.tags_id', 'DESC');
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    public function getIssuesClassList()
    {
        $this->db->select();
        $this->db->from('issues_class as ic');
        $this->db->where('showup', 1);

        // $this->db->order_by('BaseTbl.tags_id', 'DESC');
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    public function getYearsChoice($id)
    {
        $this->db->select();
        $this->db->from('mem_years_b as my');
        $this->db->join('years as y', 'my.yid = y.yid', 'inner');
        $this->db->join('members as m', 'm.memid = my.memid', 'inner');

        $this->db->where('m.memid', $id);

        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    public function getIssuesClassChoice($id)
    {
        $this->db->select();
        $this->db->from('mem_ic_b as mi');
        $this->db->join('issues_class as ic', 'ic.ic_id = mi.ic_id', 'inner');
        $this->db->join('members as m', 'm.memid = mi.memid', 'inner');

        $this->db->where('m.memid', $id);

        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    public function getContactChoice($id)
    {
        $this->db->select();
        $this->db->from('mem_cont_records as mcr');
        $this->db->join('contacts as c', 'c.con_id = mcr.con_id', 'inner');
        $this->db->join('members as m', 'm.memid = mcr.memid', 'inner');

        $this->db->where('m.memid', $id);

        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }
}
