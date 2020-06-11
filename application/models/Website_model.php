<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Website_model extends CI_Model
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

    // 標籤
    public function carouselListCount($searchText = '')
    {
        $this->db->select();
        $this->db->from('carousel as BaseTbl');

        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.title LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function carouselListing($isSort, $searchText = '', $page = 0, $segment = 0)
    {
        $this->db->select();
        $this->db->from('carousel as BaseTbl');

        if (!empty($searchText)) {
            $likeCriteria = "(BaseTbl.title LIKE '%" . $searchText . "%')";
            $this->db->where($likeCriteria);
        }

        $this->db->order_by('BaseTbl.sort', 'ASC');

        if (!$isSort) {
            $this->db->limit($page, $segment);

            // $this->db->limit(10, 20);
            // 產生： LIMIT 20, 10
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

    // 陳情內容編輯
    public function getPetition()
    {
        $this->db->select();
        $this->db->from('petition');
        $this->db->where('petid', 1);

        $query = $this->db->get();

        return $query->row();
    }

    public function petitionUpdate($userInfo)
    {
        $this->db->where('petid', 1);
        $this->db->update('petition', $userInfo);

        return true;
    }

    // 其它設定
    public function getSetupInfo()
    {
        $this->db->select();
        $this->db->from('setup');
        $this->db->where('set_id', 1);

        $query = $this->db->get();

        return $query->row();
    }

    public function setupUpdate($userInfo)
    {
        $this->db->where('set_id', 1);
        $this->db->update('setup', $userInfo);

        return true;
    }

    // 輪播
    public function getCarouselInfo($id)
    {
        $this->db->select();
        $this->db->from('carousel');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function carouselUpdate($userInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('carousel', $userInfo);

        return true;
    }

    // 輪播 - sort
    public function sort($sort)
    {
        foreach ($sort as $k => $v) {
            $k++;
            $sql   = "UPDATE `carousel` SET `sort` = $k WHERE `id` = $v";
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

    public function carouselAdd($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('carousel', $userInfo);

        $insert_id = $this->db->insert_id();

        $sql   = "UPDATE `carousel` SET `sort` = (SELECT MAX(sort) FROM `carousel`)+1 WHERE `id` = $insert_id";
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

    // 輪播update時將舊的圖片刪除,先獲取圖片名稱
    public function imgNameRepeatDel($id)
    {
        $this->db->select('img');
        $this->db->from('carousel');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    // 輪播
    public function deleteCarousel($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('carousel');

        return $this->db->affected_rows();
    }

    /*
    ######  ##     ## ########  ######  ##    ##
    ##    ## ##     ## ##       ##    ## ##   ##
    ##       ##     ## ##       ##       ##  ##
    ##       ######### ######   ##       #####
    ##       ##     ## ##       ##       ##  ##
    ##    ## ##     ## ##       ##    ## ##   ##
    ######  ##     ## ########  ######  ##    ##
     */

    // 網址防禦
    public function editProtectCheck($id)
    {
        $this->db->trans_start();

        $this->db->select('id');
        $this->db->from('carousel');
        $this->db->where('id', $id);

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }

    // 輪播
    public function carouselTitleCheck($id = '', $title)
    {
        $this->db->trans_start();
        $this->db->select('title');
        $this->db->from('carousel');
        $this->db->where('title', $title);

        if ($id != '') {
            $this->db->where('id !=', $id);
        }

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }

    public function carouselImgCheck($imgName)
    {
        $this->db->trans_start();
        $this->db->select('img');
        $this->db->from('carousel');
        $this->db->where('img', $imgName);

        $query = $this->db->get();

        $this->db->trans_complete();

        return $query->num_rows();
    }
}
