<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/FendBaseController.php';

class Members_f extends FendBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('website_model');
        $this->load->model('members_f_model');
        $this->global['pageTitle']    = '本黨立委 - 時代力量立法院黨團';
        $this->global['getSetupInfo'] = $this->website_model->getSetupInfo();
        $this->global['navActive']    = 3;
        // $this->isLoggedIn();
    }

    public function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';

        $this->loadViews("404", $this->global, null, null);
    }

    // 使用vuejs
    // public function yearsAxios()
    // {
    //     $this->db->select();
    //     $this->db->from('years as y');
    //     $this->db->where('showup', 1);
    //     $this->db->order_by('y.sort', 'ASC');

    //     $query = $this->db->get();

    //     $result = $query->result();

    //     echo json_encode($result);
    // }

    // 使用vuejs
    // public function index()
    // {
    //     $this->loadViews("fend/members/members", $this->global, null, null);
    // }

    public function index()
    {
        $data = array(
            'getYearsList' => $this->members_f_model->getYearsList(),
        );

        $this->loadViews("fend/members/members", $this->global, $data, null);
    }

    public function getYearMembers()
    {
        $id         = $this->security->xss_clean($this->input->post('yid'));
        $memberInfo = $this->members_f_model->getYearMembers($id);
        $res        = ''; //沒先宣告的話會error

        foreach ($memberInfo as $k => $v) {
            $res .= "
      <div class='col-md-3'>
         <a class='m-1 members-card' href='" . base_url('fend/members_f/membersInner/' . $v->memid) . "'>
            <div class='overflow-h'>
                <img src='" . base_url('assets/uploads/members_upload/' . $v->img) . "'" . " alt='NOT FOUND' class='border'>
            </div>
            <h3>{$v->name}</h3>
         </a>
      </div>
    ";
        }

        echo $res;
    }

    public function dateShow()
    {
        $id      = $this->security->xss_clean($this->input->post('yid'));
        $getDate = $this->members_f_model->getDate($id);
        $res     = '';

        foreach ($getDate as $k => $v) {
            $res .= "
    <p>從 " . $v->date_start . " 到 " . $v->date_end . " </p>
    ";
        }

        echo $res;
    }

    public function membersInner($id)
    {
        $data = array(
            'getMemberInfo'   => $this->members_f_model->getMemberInfo($id),
            'getIssuesChoice' => $this->members_f_model->getIssuesChoice($id),
            'getConID1'       => $this->members_f_model->getContacts($id, 1),
            'getConID2'       => $this->members_f_model->getContacts($id, 2),
            'getConID3'       => $this->members_f_model->getContacts($id, 3),
            'getConID4'       => $this->members_f_model->getContacts($id, 4),
            'getConID5'       => $this->members_f_model->getContacts($id, 5),
        );

        $this->loadViews("fend/members/inner", $this->global, $data, null);
    }
}
