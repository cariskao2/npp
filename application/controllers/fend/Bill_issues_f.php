<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/FendBaseController.php';

class Bill_issues_f extends FendBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('website_model');
        $this->load->model('bill_issues_f_model');
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
    public function index()
    {
        $this->global['pageTitle'] = '法案議題 - 時代力量立法院黨團';

        $data['getIssuesClass']  = $this->bill_issues_f_model->getIssuesClass();
        $data['getBillCategory'] = $this->bill_issues_f_model->getBillCategory();

        $getBillStatus = $this->bill_issues_f_model->getBillStatus();

        $billStatusId      = array();
        $billStatusName    = array();
        $billStatusNumRows = array();

        foreach ($getBillStatus as $k) {
            array_push($billStatusId, $k->status_id);
            array_push($billStatusName, $k->name);
        }

        $data['billStatusName'] = $billStatusName;

        foreach ($billStatusId as $k) {
            $rows = $this->bill_issues_f_model->billStatusNumRows($k);
            array_push($billStatusNumRows, $rows);
        }

        $data['statusNumRows'] = $billStatusNumRows;

        $this->loadViews("fend/bill_issues/home", $this->global, $data, null);
    }
}
