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

    // 先將float_id欄位全部設爲0
    public function resetFloatId()
    {
        $info = array(
            'float_id' => 0,
        );

        $this->db->where('float_id >', 0);
        $this->db->update('bill_case', $info);
    }

    // 浮動id部分,若沒搜尋就獲取全部case_id
    // 若有搜尋到,就獲取相關的case_id
    // 若無搜尋到,就返回false
    public function getId($searchText)
    {
        $this->db->select();
        $this->db->from('bill_case as bc');

        if (!empty($searchText)) {
            $likeCriteria = "(bc.titlename LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        // 這裡ASC才可在updateFloatId時,使用$k來順序更新
        $this->db->order_by('bc.case_id', 'ASC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $arr = []; //stdClass最佳解決方案

            foreach ($query->result() as $row) {
                array_push($arr, $row->case_id);
            }

            return $arr;
        }
        // $result = $query->result();
        return false;
    }

    // 使用case_id爲條件並藉由$k來順序更新
    public function updateFloatId($getId)
    {
        foreach ($getId as $k => $v) {
            $info = array(
                'float_id' => $k + 1,
            );

            $this->db->where('case_id', $v);
            $this->db->update('bill_case', $info);
        }
    }

    // 法案草案列表
    public function getBillCaseListCount($searchText = '')
    {
        $this->db->select();
        $this->db->from('bill_case as bc');
        $this->db->join('bill_status as bs', 'bs.status_id = bc.status_id', 'inner');

        if (!empty($searchText)) {
            $likeCriteria = "(bc.titlename LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getBillCaseList($searchText = '', $page = 0, $segment = 0)
    {
        $this->db->select();
        $this->db->from('bill_case as bc');
        $this->db->join('bill_status as bs', 'bs.status_id = bc.status_id', 'inner');

        if (!empty($searchText)) {
            $likeCriteria = "(bc.titlename LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $this->db->order_by('bc.case_id', 'DESC');
        $this->db->limit($page, $segment);

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

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

        $this->db->order_by('bc.sort', 'ASC');
        $this->db->limit($page, $segment);

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    // 法案草案立法程序列表
    public function getBillCaseSessionListCount($searchText = '', $case_id)
    {
        $this->db->select();
        $this->db->from('billcase_session_b as bcsb');
        $this->db->join('billcase_session as bcs', 'bcs.ses_id = bcsb.ses_id', 'inner');

        if (!empty($searchText)) {
            $likeCriteria = "(bcsb.title LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('case_id', $case_id);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function getBillCaseSessionList($searchText = '', $case_id, $page = 0, $segment = 0)
    {
        $this->db->select();
        $this->db->from('billcase_session_b as bcsb');
        $this->db->join('billcase_session as bcs', 'bcs.ses_id = bcsb.ses_id', 'inner');

        if (!empty($searchText)) {
            $likeCriteria = "(bcsb.title LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('case_id', $case_id);

        $this->db->order_by('bcs.ses_id', 'ASC');
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

    //  法案草案 - bill_case - update
    public function billCaseUpdate($who, $id, $info = '')
    {
        $this->db->where('case_id', $id);

        if ($who == 'edit') {
            $this->db->update('bill_case', $info);
        } else {
            // $this->db->delete('bill_case');
        }

        $this->db->where('case_id', $id);
        $this->db->delete('billcase_years_b');

        return true;
    }

    //  法案草案 - billcase_year_b - get
    public function getYearsChoice($id)
    {
        $this->db->select();
        $this->db->from('billcase_years_b as bcyb');
        $this->db->join('years as y', 'bcyb.yid = y.yid', 'inner');
        $this->db->join('bill_case as bc', 'bcyb.case_id = bc.case_id', 'inner');
        $this->db->where('bc.case_id', $id);

        $query = $this->db->get();

        $arr = []; //stdClass最佳解決方案

        foreach ($query->result() as $row) {
            array_push($arr, $row->yid);
        }

        return $arr;
    }

    //  法案草案 - bill_case - get
    public function getBillCaseInfo($id)
    {
        $this->db->select();
        $this->db->from('bill_case');
        $this->db->where('case_id', $id);

        $query = $this->db->get();

        return $query->row();
    }

    // 法案狀態
    public function getBillStatusInfo($id)
    {
        $this->db->select();
        $this->db->from('bill_status as bs');
        $this->db->join('bill_status_color as bsc', 'bsc.color_id = bs.color_id', 'inner');
        $this->db->where('bs.status_id', $id);

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
..######...#######..##........#######..########...######.
.##....##.##.....##.##.......##.....##.##.....##.##....##
.##.......##.....##.##.......##.....##.##.....##.##......
.##.......##.....##.##.......##.....##.########...######.
.##.......##.....##.##.......##.....##.##...##.........##
.##....##.##.....##.##.......##.....##.##....##..##....##
..######...#######..########..#######..##.....##..######.
 */
// bill status color
    public function getBillStatusColor()
    {
        $this->db->select();
        $this->db->from('bill_status_color as bsc');
        $this->db->order_by('bsc.color_id', 'ASC');

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
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

    //  獲得法案類別排序列表
    public function billCategorySortList()
    {
        $this->db->select();
        $this->db->from('bill_category as bc');
        $this->db->order_by('bc.sort', 'ASC');

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    // 法案類別排序存入
    public function billCategorySort($sort)
    {
        foreach ($sort as $k => $v) {
            $k++;
            $sql   = "UPDATE `bill_category` SET `sort` = $k WHERE `gory_id` = $v";
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

    // 其它bills相依新增 - billCase_Years_b
    public function billCase_Years_b($Info)
    {
        $this->db->trans_start();
        $this->db->insert_batch('billcase_years_b', $Info);
        $this->db->trans_complete();

        // return $insert_id;
        return true;
    }

    //  法案草案新增 - insert
    public function billCaseAdd($info)
    {
        $this->db->trans_start();
        $this->db->insert('bill_case', $info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    //  法案草案新增 - selectizejs
    public function getYearsList()
    {
        $this->db->select();
        $this->db->from('years as y');
        $this->db->where('showup', 1);
        // $this->db->order_by('sort', 'ASC');

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    //  法案草案新增 - 類別下拉選單
    public function getBillCategory()
    {
        $this->db->select();
        $this->db->from('bill_category as bc');
        $this->db->where('showsup', 1);

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    //  法案草案 - billCaseSession - 會期下拉選單
    public function getBillCaseSession()
    {
        $this->db->select();
        $this->db->from('billcase_session as bcs');
        $this->db->order_by('bcs.ses_id', 'ASC');

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    //  法案草案新增 - 狀態下拉選單
    public function getBillStatus()
    {
        $this->db->select();
        $this->db->from('bill_status as bs');
        $this->db->where('shows', 1);

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

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

    //  法案草案名稱
    public function billCaseTitleNameCheck($name, $id)
    {
        $this->db->trans_start();
        $this->db->select();
        $this->db->from('bill_case as bc');
        $this->db->where('bc.titlename', $name);

        if ($id != '') {
            $this->db->where('case_id !=', $id);
        }

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }

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
