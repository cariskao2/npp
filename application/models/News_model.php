<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class News_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */

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
    public function listingCount($searchText = '', $type_id)
    {
        // log_message('error', 'News_model listingCount 有錯誤!');
        $this->db->select();

        $this->db->from('press_release as pr');

        if (!empty($searchText)) {
            $likeCriteria = "(pr.main_title  LIKE '%" . $searchText . "%'
                OR  pr.sub_title  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('pr.pr_type_id', $type_id);

        $query = $this->db->get();

        return $query->num_rows();
    }

    // 計算新聞訊息各項列表的總項目
    public function listing($searchText = '', $type_id, $page, $segment)
    {
        // log_message('error', 'News_model listing 有錯誤!');
        $this->db->select();

        $this->db->from('press_release as pr');

        if (!empty($searchText)) {
            $likeCriteria = "(pr.main_title  LIKE '%" . $searchText . "%'
                OR  pr.sub_title  LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('pr.pr_type_id', $type_id);
        $this->db->order_by('pr.pr_id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    // 標籤
    public function tagsListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('tags as BaseTbl');

        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.name LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function tagsListing($searchText = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from('tags as BaseTbl');

        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.name LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $this->db->order_by('BaseTbl.tags_id', 'DESC');
        $this->db->limit($page, $segment);
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

    public function getPressReleaseInfo($id)
    {
        $this->db->select();
        $this->db->from('press_release');
        // $this->db->where('isDeleted', 0);
        // $this->db->where('roleId !=', 1);
        $this->db->where('pr_id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function pressReleaseUpdate($userInfo, $id)
    {
        $this->db->where('pr_id', $id);
        $this->db->update('press_release', $userInfo);

        return true;
    }

    public function tagsEditSend($userInfo, $userId)
    {
        $this->db->where('tags_id', $userId);
        $this->db->update('tags', $userInfo);

        return true;
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

    // 網址防禦
    public function editProtectCheck($id, $isTag = false, $pr_tags_check = false)
    {
        $this->db->trans_start();

        if ($isTag) {
            $this->db->select('tags_id');
            $this->db->from('tags');
            $this->db->where('tags_id', $id);
        } else {
            $this->db->select('pr_id');

            if ($pr_tags_check) {
                $this->db->from('pr_tags');
            } else {
                $this->db->from('press_release');
            }
            $this->db->where('pr_id', $id);
        }

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }

    public function imgNameCheck($imgName, $type = 1)
    {
        $this->db->trans_start();
        $this->db->select('img');
        $this->db->from('press_release');
        $this->db->where('img', $imgName);
        $this->db->where('pr_type_id', $type);

        // if ($pr_id != "") {
        //     $this->db->where('pr_id !=', $pr_id);
        // }

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }

    public function mainTitleCheck($name, $type, $mode, $id)
    {
        $this->db->trans_start();
        $this->db->select('main_title');
        $this->db->from('press_release');
        $this->db->where('main_title', $name);
        $this->db->where('pr_type_id', $type);

        if ($mode == 2) {
            $this->db->where('pr_id !=', $id);
        }

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }

    public function tagsCheck($name, $id)
    {
        $this->db->trans_start();
        $this->db->select(); // 空白預設爲*
        $this->db->from('tags');
        $this->db->where('name', $name);
        if ($id != '') {
            $this->db->where('tags_id !=', $id);
        }

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }

    /*
    ###    ########  ########
    ## ##   ##     ## ##     ##
    ##   ##  ##     ## ##     ##
    ##     ## ##     ## ##     ##
    ######### ##     ## ##     ##
    ##     ## ##     ## ##     ##
    ##     ## ########  ########
     */

    public function pressReleaseAdd($press_release_info)
    {
        $this->db->trans_start();
        $this->db->insert('press_release', $press_release_info);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    public function tagsAddSend($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tags', $userInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    public function prTagsAdd($pr_tags_info)
    {
        $this->db->trans_start();
        $this->db->insert_batch('pr_tags', $pr_tags_info); // insert陣列

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

    // 新聞訊息update時將舊的圖片刪除,先獲取圖片名稱
    public function imgNameRepeatDel($id)
    {
        $this->db->select();
        $this->db->from('press_release');
        $this->db->where('pr_id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     * 刪除新聞訊息列表
     */
    public function newsListDel($pr_id)
    {
        $this->db->where('pr_id', $pr_id);
        $this->db->delete('press_release');

        $this->db->where('pr_id', $pr_id);
        $this->db->delete('pr_tags');

        // 可能這裏做了二個刪除的動作,所以會return 0
        // return $this->db->affected_rows();
        // 改成
        return true;
    }

    // 刪除標籤列表
    public function deleteNewsTag($id)
    {
        $this->db->where('tags_id', $id);
        $this->db->delete('tags');

        return $this->db->affected_rows();
    }

    // 刪除編輯中在pr_tags的舊資料
    public function prTagsDel($pr_id)
    {
        $this->db->where('pr_id', $pr_id);
        $this->db->delete('pr_tags');

        return $this->db->affected_rows();
    }

    /*
    ########    ###     ######           ########  ##       ##     ##  ######   #### ##    ##
    ##      ## ##   ##    ##          ##     ## ##       ##     ## ##    ##   ##  ###   ##
    ##     ##   ##  ##                ##     ## ##       ##     ## ##         ##  ####  ##
    ##    ##     ## ##   #### ####### ########  ##       ##     ## ##   ####  ##  ## ## ##
    ##    ######### ##    ##          ##        ##       ##     ## ##    ##   ##  ##  ####
    ##    ##     ## ##    ##          ##        ##       ##     ## ##    ##   ##  ##   ###
    ##    ##     ##  ######           ##        ########  #######   ######   #### ##    ##
     */

    public function getTagsEditInfo($id)
    {
        $this->db->select();
        $this->db->from('tags');
        $this->db->where('tags_id', $id);

        $query = $this->db->get();

        return $query->row();
    }

    public function getTagsList()
    {
        $this->db->select();
        $this->db->from('tags as BaseTbl');
        $this->db->where('showup', 1);

        // $this->db->order_by('BaseTbl.tags_id', 'DESC');
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    public function getTagsChoice($id = '')
    {
        $this->db->select();
        $this->db->from('pr_tags as pt');
        $this->db->join('press_release as pr', 'pt.pr_id = pr.pr_id', 'inner');
        $this->db->join('tags as t', 't.tags_id = pt.tags_id', 'inner');

        if ($id != '') {
            $this->db->where('pt.pr_id', $id);
        }

        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }
}
