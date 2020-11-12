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
    public function billCaseCarousel($gory_id, $case_id = 0)
    {
        $this->output->set_header("Cache-Control: private");

        // pageTitle
        $data['getCategoryInfo']   = $this->bill_issues_f_model->getCategoryInfo($gory_id);
        $this->global['pageTitle'] = $data['getCategoryInfo']->title . ' - 重點法案 - 法案議題 - 時代力量立法院黨團';

        $data['categoryIdCheck'] = $this->bill_issues_f_model->categoryIdCheck($gory_id); //進入法案輪播前先確認該法案是否有被選擇

        if ($data['categoryIdCheck'] > 0) {
            // 獲取法案輪播中所設定的全部屆期
            $data['getBillCaseCarouselYears'] = $this->bill_issues_f_model->getBillCaseCarouselYears($gory_id);
            // 點擊下拉選單獲取的值
            $yIdSelect = $this->security->xss_clean($this->input->post('select'));

            // $case_id=0:從home、bill_issues_f/home、billCategoryList_f點擊進來
            // $case_id>0:從billCaseList_f提出法案列表點擊進來
            if ($case_id > 0) {
                if ($yIdSelect == '') {
                    $getCaseMinYId = $this->bill_issues_f_model->getBillCaseCarouselYears($gory_id, $case_id); // 在剛進入頁面時,獲取該法案中所設定排序最優先的屆期id,讓前台下拉選單做預設
                }

                $data['caseIdCheck'] = true; //true表示要讓前台billCaseCarousel_f的下拉選單有預設功能
                $data['matchYId']    = $yIdSelect != '' ? $yIdSelect : $getCaseMinYId;

            } else {
                if ($yIdSelect != '') {
                    $data['caseIdCheck'] = true;
                    $data['matchYId']    = $yIdSelect; // 返回views做屆期預設的select
                } else {
                    $data['caseIdCheck'] = false;
                    $getCaseMinYIdResult = $this->bill_issues_f_model->getBillCaseCarouselYears($gory_id);
                    $getCaseMinYIdArr    = [];

                    foreach ($getCaseMinYIdResult as $k) {
                        array_push($getCaseMinYIdArr, $k->yid);
                    }

                    $data['matchYId'] = min($getCaseMinYIdArr);
                }
            }

            // swiperjs
            $data['getBillCaseCarouselList'] = $this->bill_issues_f_model->getBillCaseCarouselList($gory_id, $data['matchYId']);

            if ($case_id > 0) {
                foreach ($data['getBillCaseCarouselList'] as $k => $v) {
                    if ($v->case_id == $case_id) {
                        $data['currentCaseIdIndex'] = $k;
                        $data['getBillCaseInfo']    = $this->bill_issues_f_model->getBillCaseInfoAjax($v->case_id);
                    }
                }

            } else {
                $caseIdOnly = []; //獲取頁面載入第一筆的billcase資料

                foreach ($data['getBillCaseCarouselList'] as $k => $v) {
                    if ($k == 0) {
                        $data['getBillCaseInfo'] = $this->bill_issues_f_model->getBillCaseInfoAjax($v->case_id);
                    }
                }

                $data['currentCaseIdIndex'] = 0;
            }
        }

        // -------------
        // 會期要用,留着
        // $data['getBillCaseSessions'] = $this->bill_issues_f_model->getBillCaseSessions($caseIdOnly[0]);

        $this->loadViews("fend/bill_issues/billCaseCarousel_f", $this->global, $data, null);
    }

    public function getBillCaseInfoAjax()
    {
        $caseId          = $this->security->xss_clean($this->input->post('caseId'));
        $getBillCaseInfo = $this->bill_issues_f_model->getBillCaseInfoAjax($caseId);

        $e    = $getBillCaseInfo->editor;
        $link = $getBillCaseInfo->link;

        $res = array(
            'editor' => $e,
            'link'   => $link,
        );
        echo json_encode($res);
    }
}
