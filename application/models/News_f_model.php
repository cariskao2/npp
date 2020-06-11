<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class News_f_model extends CI_Model
{
    public function getNewsInfo($type_id)
    {
        $this->db->select();
        $this->db->from('press_release as pr');

        $this->db->where('pr.showup', 1);
        $this->db->where('pr.pr_type_id', $type_id);

        $this->db->order_by('pr.date_start', 'DESC');
        $this->db->limit(3);

        $query  = $this->db->get();
        $result = $query->result();
        return $result;
    }

    /*
    ##       ####  ######  ########
    ##        ##  ##    ##    ##
    ##        ##  ##          ##
    ##        ##   ######     ##
    ##        ##        ##    ##
    ##        ##  ##    ##    ##
    ######## ####  ######     ##
     */

    // 計算新聞訊息各項列表的總頁數
    public function listingCount($searchFrom = '', $searchEnd = '', $searchKey = '', $type_id)
    {
        $this->db->select();

        $this->db->from('press_release as pr');

        if (!empty($searchKey)) {
            $likeCriteria = "(pr.main_title  LIKE '%" . $searchKey . "%')";
            $this->db->where($likeCriteria);
        }

        if (!empty($searchFrom)) {
            $likeCriteria = "(pr.date_start > '" . $searchFrom . "')";
            $this->db->where($likeCriteria);
        }

        if (!empty($searchEnd)) {
            $likeCriteria = "(pr.date_start < '" . $searchEnd . "')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('pr.pr_type_id', $type_id);
        $this->db->where('pr.showup', 1);

        $query = $this->db->get();

        return $query->num_rows();
    }

    // 計算新聞訊息各項列表的總項目
    public function listing($searchFrom = '', $searchEnd = '', $searchKey = '', $type_id, $page, $segment)
    {
        $this->db->select();

        $this->db->from('press_release as pr');

        if (!empty($searchKey)) {
            $likeCriteria = "(pr.main_title  LIKE '%" . $searchKey . "%')";
            $this->db->where($likeCriteria);
        }

        if (!empty($searchFrom)) {
            $likeCriteria = "(pr.date_start >= '" . $searchFrom . "')";
            $this->db->where($likeCriteria);
        }

        if (!empty($searchEnd)) {
            $likeCriteria = "(pr.date_start <= '" . $searchEnd . "')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('pr.pr_type_id', $type_id);
        $this->db->where('pr.showup', 1);

        $this->db->order_by('pr.date_start', 'DESC');

        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }

    // 計算各項tags總頁數
    public function tagslistingCount($tag_id)
    {

        $this->db->select();
        $this->db->from('pr_tags as pt');
        $this->db->join('press_release as pr', 'pt.pr_id = pr.pr_id', 'inner');
        $this->db->join('tags as t', 't.tags_id = pt.tags_id', 'inner');

        $this->db->where('pr.showup', 1);
        $this->db->where('pt.tags_id', $tag_id);

        $query = $this->db->get();

        return $query->num_rows();
    }

    // 計算tags關聯總項目數
    public function tagsListing($tag_id, $page, $segment)
    {
        $this->db->select();
        $this->db->from('pr_tags as pt');
        $this->db->join('press_release as pr', 'pt.pr_id = pr.pr_id', 'inner');
        $this->db->join('tags as t', 't.tags_id = pt.tags_id', 'inner');

        $this->db->where('pr.showup', 1);
        $this->db->where('pt.tags_id', $tag_id);

        $this->db->order_by('pr.date_start', 'DESC');

        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }
    /*
    .####.##....##.##....##.########.########.
    ..##..###...##.###...##.##.......##.....##
    ..##..####..##.####..##.##.......##.....##
    ..##..##.##.##.##.##.##.######...########.
    ..##..##..####.##..####.##.......##...##..
    ..##..##...###.##...###.##.......##....##.
    .####.##....##.##....##.########.##.....##
     */

    // get inner page  content
    public function getInnerInfo($id)
    {
        $this->db->select();
        $this->db->from('press_release');
        $this->db->where('showup', 1);
        $this->db->where('pr_id', $id);

        $query = $this->db->get();

        return $query->row();
    }

    // 獲取下方分頁的資料
    public function innerPrevNews($type_id, $id)
    {
        // 不要使用「`」,會造成 as error
        // 上、下一則使用id排序來跑,不要使用日期排序來跑,因爲同一天會有多筆文章,到時候會error
        // 而且因爲資料使用SQL語法載入,否則正常輸入資料,id越大日期也會越大才對
        $sql = "SELECT pr.pr_id FROM press_release pr WHERE pr.pr_type_id = $type_id AND pr.showup = 1 AND pr.pr_id < (SELECT pr_id FROM press_release WHERE pr_id = $id) ORDER BY pr.pr_id DESC LIMIT 1 ";

        $query = $this->db->query($sql);

        return $query->row();
    }

    public function innerNextNews($type_id, $id)
    {
        $sql = "SELECT pr.pr_id FROM press_release pr WHERE pr.pr_type_id = $type_id AND pr.showup = 1 AND pr.pr_id > (SELECT pr_id FROM press_release WHERE pr_id = $id) ORDER BY pr.pr_id ASC LIMIT 1 ";

        $query = $this->db->query($sql);

        return $query->row();
    }

    /*
    .########....###.....######....######.
    ....##......##.##...##....##..##....##
    ....##.....##...##..##........##......
    ....##....##.....##.##...####..######.
    ....##....#########.##....##........##
    ....##....##.....##.##....##..##....##
    ....##....##.....##..######....######.
     */
    public function getTagsChoice($id = '')
    {
        $this->db->select();
        $this->db->from('pr_tags as pt');
        $this->db->join('press_release as pr', 'pt.pr_id = pr.pr_id', 'inner');
        $this->db->join('tags as t', 't.tags_id = pt.tags_id', 'inner');

        // newsInner下方tags
        if ($id != '') {
            $this->db->where('pt.pr_id', $id);
        }

        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }
}
