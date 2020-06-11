<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home_model extends CI_Model
{
    public function getCarouselInfo()
    {
        $this->db->select();
        $this->db->from('carousel as crs');
        $this->db->where('showup', 1);

        $this->db->order_by('crs.sort', 'ASC');
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    public function getNewsInfo()
    {
        $this->db->select();
        $this->db->from('press_release as pr');
        $this->db->where('showup', 1);

        $this->db->order_by('pr.date_start', 'DESC');
        $this->db->limit(3);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

}
