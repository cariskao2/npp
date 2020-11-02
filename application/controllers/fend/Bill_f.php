<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/FendBaseController.php';

class Bill_f extends FendBaseController
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

    // 重點法案首頁
    public function billCategoryList_f()
    {
        $this->global['pageTitle'] = '重點法案 - 法案議題 - 時代力量立法院黨團';

        $data = array(
            'getBillCategory' => $this->bill_issues_f_model->getBillCategory(true),
        );

        $this->loadViews("fend/bill_issues/billCategory_f", $this->global, $data, null);
    }

    // 重點法案 - 提出法案列表
    public function billCaseList_f()
    {
        $this->global['pageTitle'] = '提出法案列表 - 法案議題 - 時代力量立法院黨團';

        $count   = $this->bill_issues_f_model->getBillCaseListCount();
        $returns = $this->paginationCompress("fend/bill_f/billCaseList_f/", $count, 20, 4, true);

        $data['getBillCaseList'] = $this->bill_issues_f_model->getBillCaseList($returns["page"], $returns["segment"]);

        $this->loadViews("fend/bill_issues/billCaseList_f", $this->global, $data, null);
    }

    // 重點法案輪播
    public function billCaseCarousel($gory_id)
    {
        $this->output->set_header("Cache-Control: private");

        $data['getCategoryInfo'] = $this->bill_issues_f_model->getCategoryInfo($gory_id); // for pageTitle

        $yIdMin    = $this->bill_issues_f_model->getBillCaseCarouselYears($gory_id, true);
        $yIdSelect = $this->security->xss_clean($this->input->post('select'));

        $yId = $yIdSelect != '' ? $yIdSelect : $yIdMin;

        $this->global['pageTitle'] = $data['getCategoryInfo']->title . ' - 重點法案 - 法案議題 - 時代力量立法院黨團';

        $data['getBillCaseCarouselYears'] = $this->bill_issues_f_model->getBillCaseCarouselYears($gory_id);
        $data['getBillCaseCarouselList']  = $this->bill_issues_f_model->getBillCaseCarouselList($gory_id, $yId);
        $data['sendYId']                  = $yId;

        $this->loadViews("fend/bill_issues/billCaseCarousel_f", $this->global, $data, null);
    }
}
