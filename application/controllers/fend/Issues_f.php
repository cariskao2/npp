<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/FendBaseController.php';

class Issues_f extends FendBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('website_model');
        $this->load->model('bill_issues_f_model');
        $this->load->model('issues_f_model');
        $this->global['getSetupInfo'] = $this->website_model->getSetupInfo();
        $this->global['navActive']    = 2;
        // $this->isLoggedIn();
    }

    public function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';

        $this->loadViews("404", $this->global, null, null);
    }

    // 新聞訊息首頁
    public function Issues_class_f()
    {
        $this->global['pageTitle'] = '關注議題 - 時代力量立法院黨團';

        $data = array(
            'getIssuesClass' => $this->bill_issues_f_model->getIssuesClass(true),
        );

        $this->loadViews("fend/bill_issues/issuesClass_f", $this->global, $data, null);
    }

    // 關注議題列表
    public function issuesAllList_f($ic_id)
    {
        $editProtectChcek = $this->issues_f_model->editProtectCheck($ic_id, 'issues-class');

        if ($editProtectChcek == 0) {
            redirect('fend/home');
        }

        $count = $this->issues_f_model->issuesAllListingCount($ic_id);
        // echo ' count: ' . $count . '<br>';
        $returns = $this->paginationCompress("fend/Issues_f/issuesAllList_f/" . $ic_id . '/', $count, 12, 5);
        // echo ' segment-News: ' . $returns['segment'];
        $data['issuesAllList'] = $this->issues_f_model->issuesAllListing($ic_id, $returns["page"], $returns["segment"]);

        foreach ($data['issuesAllList'] as $k => $v) {
            $name = $v->name;
        }

        $this->global['pageTitle']     = $name . ' - 關注議題 - 時代力量立法院黨團';
        $this->global['breadcrumbTag'] = $name;

        $this->loadViews("fend/bill_issues/issuesAllList_f", $this->global, $data, null);
    }

    public function issuesAllInner_f($id)
    {
        // 在views使用?xx=xx
        // $id      = $this->input->get('d');

        $editProtectChcek = $this->issues_f_model->editProtectCheck($id, 'issues-all');

        if ($editProtectChcek == 0) {
            redirect('fend/home');
        }

        $data = array(
            'getIssuesAllInnerInfo' => $this->issues_f_model->getIssuesAllInnerInfo($id),
        );

        foreach ($data['getIssuesAllInnerInfo'] as $k => $v) {
            if ($k == 'ia_id' && $v == '') {
                $test = $v;
                redirect('fend/issues_f/issuesAllList_f/' . $id . '/');
            }
            if ($k == 'title') {
                $v1 = $v;
            }
            if ($k == 'name') {
                $v2 = $v;
            }
        }
        $this->global['pageTitle'] = $v1 . ' - ' . $v2 . ' - 關注議題 - 時代力量立法院黨團';

        $this->loadViews("fend/bill_issues/issuesAllInner", $this->global, $data, null);
    }
}
