<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class Bills extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->library('ftp');
        // $this->load->library('session');
        $this->load->model('bills_model');
        $this->isLoggedIn();
        $this->global['pageTitle'] = '時代力量後台管理';
    }

    public function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';

        $this->loadViews("404", $this->global, null, null);
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

    // 法案草案的會期列表
    public function billCaseSessionList($case_id)
    {
        $this->output->set_header("Cache-Control: private");

        $data['getBillCaseInfo'] = $this->bills_model->getBillCaseInfo($case_id);

        $this->global['navTitle']  = '重點法案 - 草案 - ' . $data['getBillCaseInfo']->titlename . ' - 立法程序';
        $this->global['navActive'] = base_url('bills/billCaseList');

        $sessionRedirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        if (isset($_GET['key']) && $_GET['key'] != '') {
            // 有$_GET['key']就使用$_GET['key']的值
            $searchText = $_GET['key'];
        } else {
            if ($this->input->post('searchText') != '') {
                // 沒有$_GET['key']且post('searchText')有值
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
                $sessionRedirect .= '?key=' . $searchText; //就將url尾部再加上「?key=$searchText」
            } else {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
        }

        $this->session->set_userdata('sessionRedirect', $sessionRedirect);

        $data['searchText'] = $searchText;

        // 列表部分
        $count = $this->bills_model->getBillCaseSessionListCount($searchText, $case_id);

        $returns = $this->paginationSearchCompress('bills/billCaseSessionList/' . $case_id, $count, 20, 4);

        $data['getBillCaseSessionList'] = $this->bills_model->getBillCaseSessionList($searchText, $case_id, $returns["page"], $returns["segment"]);

        $this->loadViews('billCaseSessionList', $this->global, $data, null);
    }

    // 法案草案列表
    public function billCaseList()
    {
        $this->output->set_header("Cache-Control: private");

        $this->global['navTitle']  = '重點法案 - 法案草案管理 - 列表';
        $this->global['navActive'] = base_url('bills/billCaseList');

        $myRedirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        if (isset($_GET['key']) && $_GET['key'] != '') {
            // 有$_GET['key']就使用$_GET['key']的值
            $searchText = $_GET['key'];
        } else {
            if ($this->input->post('searchText') != '') {
                // 沒有$_GET['key']且post('searchText')有值
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
                $myRedirect .= '?key=' . $searchText; //就將url尾部再加上「?key=$searchText」
            } else {
                $searchText = $this->security->xss_clean($this->input->post('searchText'));
            }
        }

        $this->session->set_userdata('myRedirect', $myRedirect);

        $data['searchText'] = $searchText;

        // float_id部分
        $getIds = $this->bills_model->getId($searchText); // 獲取全部bill_case的id,無論有無搜尋

        $this->bills_model->resetFloatId(); // 先將float_id欄位全部設爲0

        if ($getIds != false) {
            $this->bills_model->updateFloatId($getIds);
        }

        // 先確認全部的狀態id都還在bill_status內,若已不在就自動將該id改爲最前面的,否則資料會遺漏
        $getStatusIdFromBillCase = $this->bills_model->getStatusIdFromBillCase(); //獲取bill_case中的全部status_id
        $getStatusId             = $this->bills_model->getStatusId(); //獲取bill_status中的全部status_id
        $getMinStatusId          = $this->bills_model->getStatusId(true); // 獲取bill_case中的最小status_id

        foreach ($getStatusIdFromBillCase as $k => $v) {
            $isExist = false;

            foreach ($getStatusId as $j => $l) {
                if ($l == $v) {
                    $isExist = true;

                    break;
                }
            }

            if (!$isExist) {
                $this->bills_model->changeBillCaseStatusId($v->status_id, $getMinStatusId->status_id);
            }
        }

        // 列表部分
        $count = $this->bills_model->getBillCaseListCount($searchText);

        $returns = $this->paginationSearchCompress('bills/billCaseList ', $count, 20, 3);

        $data['getBillCaseList'] = $this->bills_model->getBillCaseList($searchText, $returns["page"], $returns["segment"]);

        $this->loadViews('billCaseList', $this->global, $data, null);
    }

    // 法案狀態列表
    public function billStatusList()
    {
        // 會紀錄session導致返回時讀不到session,而且因爲紀錄了之前的狀態,所以影響了views的刷新
        // $this->output->set_header("Cache-Control: private");

        $this->session->unset_userdata('myRedirect');

        $this->global['navTitle']  = '重點法案 - 法案狀態管理 - 列表';
        $this->global['navActive'] = base_url('bills/billStatusList/');

        $searchText         = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;

        $count = $this->bills_model->getBillStatusListCount($searchText);

        $returns = $this->paginationCompress('bills/billStatusList/', $count, 20, 3);

        $data['getBillStatusList'] = $this->bills_model->getBillStatusList($searchText, $returns["page"], $returns["segment"]);

        // 進入列表就先將網址儲存起來,到時候編輯的完成後就可導航回原本的列表頁面
        $myRedirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $this->session->set_userdata('myRedirect', $myRedirect);

        $this->loadViews('billStatusList', $this->global, $data, null);
    }

    // 法案類別列表
    public function billCategoryList()
    {
        // 使用chache使之在任何情況都可返回前一頁,包含搜尋以及編輯,詳細說明請參考書籤
        // $this->output->set_header("Cache-Control: private");

        $this->session->unset_userdata('myRedirect');

        $this->global['navTitle']  = '重點法案 - 法案類別管理 - 列表';
        $this->global['navActive'] = base_url('bills/billCategoryList/');

        $searchText         = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;

        $count = $this->bills_model->getBillCategoryListCount($searchText);

        $returns = $this->paginationCompress('bills/billCategoryList/', $count, 20, 3);

        $data['getBillCategoryList'] = $this->bills_model->getBillCategoryList($searchText, $returns["page"], $returns["segment"]);

        // 進入列表就先將網址儲存起來,到時候編輯的完成後就可導航回原本的列表頁面
        $myRedirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $this->session->set_userdata('myRedirect', $myRedirect);

        $this->loadViews('billCategoryList', $this->global, $data, null);
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

    //  法案草案-立法程序-新增
    public function billCaseSessionAdd($case_id)
    {
        $data['getBillCaseInfo']          = $this->bills_model->getBillCaseInfo($case_id);
        $data['getBillCaseSessionSelect'] = $this->bills_model->getBillCaseSessionSelect();

        $this->global['navTitle']  = '重點法案-草案-' . $data['getBillCaseInfo']->titlename . '-立法程序-新增';
        $this->global['navActive'] = base_url('bills/billCaseList');

        $this->loadViews('billCaseSessionAdd', $this->global, $data, null);
    }

    public function billCaseSessionAddSend($case_id)
    {
        $this->form_validation->set_rules('date_start', '日期', 'trim|required');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('description', '議事事件描述', 'trim|required');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('title', '事件描述標題', 'trim|required');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('editor1', '事件描述的內容', 'required');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->billCaseSessionAdd($case_id);
        } else {
            $ses_id      = $this->security->xss_clean($this->input->post('sessions'));
            $date        = $this->security->xss_clean($this->input->post('date_start'));
            $description = $this->security->xss_clean($this->input->post('description'));
            $title       = $this->security->xss_clean($this->input->post('title'));
            $url         = $this->security->xss_clean($this->input->post('url'));
            $editor      = $this->input->post('editor1');

            $showStatusCheck = $this->input->post('happy');
            $showStatus      = $showStatusCheck != 'N' ? 1 : 0;

            // Insert files data into the database
            $billSessionInfo = array(
                'case_id'     => $case_id,
                'ses_id'      => $ses_id,
                'date'        => $date,
                'description' => $description,
                'title'       => $title,
                'content'     => $editor,
                'url'         => $url,
                'showups'     => $showStatus,
            );

            $insert_id = $this->bills_model->billCaseSessionAddSend($billSessionInfo);

            if ($insert_id > 0) {
                $this->session->set_flashdata('success', '新增成功!');
            } else {
                $this->session->set_flashdata('error', '新增失敗!');
            }

            redirect('bills/billCaseSessionList/' . $case_id);
        }
    }

    // 法案草案新增
    public function billCaseAdd()
    {
        $this->global['navTitle']  = '重點法案 - 法案草案管理 - 新增';
        $this->global['navActive'] = base_url('bills/billCaseList');

        $data = array(
            'getYearsList'    => $this->bills_model->getYearsList(),
            'getBillCategory' => $this->bills_model->getBillCategory(),
            'getBillStatus'   => $this->bills_model->getBillStatus(),
        );

        $this->loadViews("billCaseAdd", $this->global, $data, null);
    }

    public function billCaseAddSend()
    {
        $this->form_validation->set_rules('years', '屆期', 'callback_billCaseYearCheck');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('titlename', '標題', 'trim|required|callback_billCaseTitleNameCheck');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('introduction', '簡介', 'trim|required');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->billCaseAdd();
        } else {
            $category = $this->security->xss_clean($this->input->post('category'));
            $years    = $this->security->xss_clean($this->input->post('years'));
            $title    = $this->security->xss_clean($this->input->post('titlename'));
            $intro    = $this->security->xss_clean($this->input->post('introduction'));
            $status   = $this->security->xss_clean($this->input->post('status'));
            $link     = $this->security->xss_clean($this->input->post('link'));
            $editor   = $this->input->post('editor1');

            // Insert files data into the database
            $billCaseInfo = array(
                'gory_id'      => $category,
                'titlename'    => $title,
                'introduction' => $intro,
                'status_id'    => $status,
                'link'         => $link,
                'editor'       => $editor,
            );

            $insert_caseid = $this->bills_model->billCaseAdd($billCaseInfo);

            // 當回傳成功insert的id且有選擇標籤時,就將此標籤的資料insert到DB
            if ($insert_caseid > 0) {
                if (!empty($years)) {
                    $bills_years_info = array();
                    $one_array        = array();

                    foreach ($years as $k => $v) {
                        $one_array['case_id'] = $insert_caseid;
                        $one_array['yid']     = $v;

                        $bills_years_info[] = $one_array;
                    }

                    $this->bills_model->billCase_Years_b($bills_years_info);
                }

                $array = array(
                    'success' => '新增成功!',
                );

                $this->session->set_flashdata($array);

                redirect('bills/billCaseList');

            } else {
                $this->session->set_flashdata('error', '新增失敗!');
            }
        }
    }

    //  法案狀態新增
    public function billStatusAdd()
    {
        $this->global['navTitle']  = '重點法案 - 法案狀態管理 - 新增';
        $this->global['navActive'] = base_url('bills/billStatusList/');

        $data['status_color'] = $this->bills_model->getBillStatusColor();

        $this->loadViews('billStatusAdd', $this->global, $data, null);
    }

    public function billStatusAddSend()
    {
        $this->form_validation->set_rules('name', '名稱', 'trim|required|max_length[128]|callback_billStatusNameCheck');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->billStatusAdd();
        } else {
            $name            = $this->security->xss_clean($this->input->post('name'));
            $color           = $this->security->xss_clean($this->input->post('color'));
            $showStatusCheck = $this->input->post('happy');
            $showStatus      = $showStatusCheck != 'N' ? 1 : 0;

            $userInfo = array(
                'name'     => $name,
                'shows'    => $showStatus,
                'color_id' => $color,
            );

            $insert_id = $this->bills_model->billStatusAddSend($userInfo);

            if ($insert_id > 0) {
                $this->session->set_flashdata('success', '新增成功!');
            } else {
                $this->session->set_flashdata('error', '新增失敗!');
            }

            redirect('bills/billStatusList/');
        }
    }

    // 法案類別新增
    public function billCategoryAdd()
    {
        $this->global['navTitle']  = '重點法案 - 法案類別管理 - 新增';
        $this->global['navActive'] = base_url('bills/billCategoryList/');

        $this->loadViews('billCategoryAdd', $this->global, null, null);
    }

    public function billCategoryAddSend()
    {
        $this->form_validation->set_rules('file', '圖片', 'callback_billCategoryImgCheck');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('title', '標題', 'trim|required|max_length[128]|callback_billCategoryNameCheck');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->billCategoryAdd();
        } else {
            $title           = $this->security->xss_clean($this->input->post('title'));
            $showStatusCheck = $this->input->post('happy');

            $showStatus = $showStatusCheck != 'N' ? 1 : 0;

            // File upload configuration
            // $uploadPath = dirname(dirname(__DIR__)) . '/assets/uploads/bill_category/';
            $uploadPath            = 'assets/uploads/bill_category/';
            $config['upload_path'] = $uploadPath;
            // $config['allowed_types'] = 'jpg|jpeg|png|gif|svg';
            $config['allowed_types'] = 'jpg|jpeg|png';
            // $config['max_size'] = 1024;

            // Load and initialize upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server
            if ($this->upload->do_upload('file')) {
                $fileData   = $this->upload->data();
                $uploadData = $fileData['file_name'];
            } else {
                // upload debug ,loads the view display.php with error
                // $error = array('error' => $this->upload->display_errors());
                // $this->load->view('upload_debug_form', $error);
            }

            $userInfo = array(
                'showsup' => $showStatus,
                'img'     => $uploadData,
                'title'   => $title,
            );

            $insert_id = $this->bills_model->billCategoryAddSend($userInfo);

            if ($insert_id > 0) {
                $this->session->set_flashdata('success', '新增成功!');
            } else {
                $this->session->set_flashdata('error', '新增失敗!');
            }

            redirect('bills/billCategoryList/');
        }
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
    //  法案草案-立法程序-編輯
    public function billCaseSessionEdit($case_id, $id)
    {
        $data['getBillCaseInfo']          = $this->bills_model->getBillCaseInfo($case_id);
        $data['getBillCaseSessionInfo']   = $this->bills_model->getBillCaseSessionInfo($case_id, $id);
        $data['getBillCaseSessionSelect'] = $this->bills_model->getBillCaseSessionSelect();

        $this->global['navTitle']  = '重點法案-草案-' . $data['getBillCaseInfo']->titlename . '-立法程序-編輯';
        $this->global['navActive'] = base_url('bills/billCaseList');

        $this->loadViews('billCaseSessionEdit', $this->global, $data, null);
    }

    public function billCaseSessionEditSend($case_id, $id)
    {
        $this->form_validation->set_rules('date_start', '日期', 'trim|required');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('description', '議事事件描述', 'trim|required');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('title', '事件描述標題', 'trim|required');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('editor1', '事件描述的內容', 'required');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->billCaseSessionEdit($case_id, $id);
        } else {
            $ses_id      = $this->security->xss_clean($this->input->post('sessions'));
            $date        = $this->security->xss_clean($this->input->post('date_start'));
            $description = $this->security->xss_clean($this->input->post('description'));
            $title       = $this->security->xss_clean($this->input->post('title'));
            $url         = $this->security->xss_clean($this->input->post('url'));
            $editor      = $this->input->post('editor1');

            $showStatusCheck = $this->input->post('happy');

            // Insert files data into the database
            $billSessionInfo = array(
                'case_id'     => $case_id,
                'ses_id'      => $ses_id,
                'date'        => $date,
                'description' => $description,
                'title'       => $title,
                'content'     => $editor,
                'url'         => $url,
            );

            if ($showStatusCheck != null || $showStatusCheck != '' || !empty($showStatusCheck)) {
                $showStatus                 = $showStatusCheck == 'Y' ? 1 : 0;
                $billSessionInfo['showups'] = $showStatus;
            }

            $insert_id = $this->bills_model->billCaseSessionEditSend($billSessionInfo, $id);

            if ($insert_id) {
                $this->session->set_flashdata('success', '新增成功!');
            } else {
                $this->session->set_flashdata('error', '新增失敗!');
            }

            $sessionRedirect = $this->session->userdata('sessionRedirect');
            redirect($sessionRedirect);
            // redirect('bills/billCaseSessionList/' . $case_id);
        }
    }

    // 法案草案編輯
    public function billCaseEdit($id)
    {
        $editProtectChcek = $this->bills_model->editProtectCheck($id, 'bill-case');

        if ($editProtectChcek == 0) {
            redirect('bills/billCaseList');
        }

        $this->global['navTitle']  = '重點法案 - 法案草案管理 - 編輯';
        $this->global['navActive'] = base_url('bills/billCaseList');

        $this->bills_model->clearNotice($id); // 進來編輯頁面就清除紅字備註

        $data = array(
            'getYearsList'    => $this->bills_model->getYearsList(),
            'getYearsChoice'  => $this->bills_model->getYearsChoice($id),
            'getBillCategory' => $this->bills_model->getBillCategory(),
            'getBillStatus'   => $this->bills_model->getBillStatus(),
            'getBillCaseInfo' => $this->bills_model->getBillCaseInfo($id),
        );

        $this->loadViews("billCaseEdit", $this->global, $data, null);
    }

    public function billCaseEditSend($id)
    {
        $this->form_validation->set_rules('years', '屆期', 'callback_billCaseYearCheck');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('titlename', '標題', 'trim|required|callback_billCaseTitleNameCheck[' . $id . ']');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('introduction', '簡介', 'trim|required');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->billCaseEdit($id);
        } else {
            $category = $this->security->xss_clean($this->input->post('category'));
            $years    = $this->security->xss_clean($this->input->post('years'));
            $title    = $this->security->xss_clean($this->input->post('titlename'));
            $intro    = $this->security->xss_clean($this->input->post('introduction'));
            $status   = $this->security->xss_clean($this->input->post('status'));
            $link     = $this->security->xss_clean($this->input->post('link'));
            $editor   = $this->input->post('editor1');

            // Insert files data into the database
            $billCaseInfo = array(
                'gory_id'      => $category,
                'titlename'    => $title,
                'introduction' => $intro,
                'status_id'    => $status,
                'link'         => $link,
                'editor'       => $editor,
            );

            $insert_caseid = $this->bills_model->billCaseUpdate($id, $billCaseInfo);

            // 當回傳成功insert的id且有選擇標籤時,就將此標籤的資料insert到DB
            if ($insert_caseid) {
                if (!empty($years)) {
                    $bills_years_info = array();
                    $one_array        = array();

                    foreach ($years as $k => $v) {
                        $one_array['case_id'] = $id;
                        $one_array['yid']     = $v;

                        $bills_years_info[] = $one_array;
                    }

                    $this->bills_model->billCase_Years_b($bills_years_info);
                }

                $array = array(
                    'success' => '更新成功!',
                );

                $this->session->set_flashdata($array);

                $myRedirect = $this->session->userdata('myRedirect');
                redirect($myRedirect);
                // redirect('bills/billCaseList/');

            } else {
                $this->session->set_flashdata('error', '更新失敗!');
            }
        }
    }

    // 法案狀態編輯
    public function billStatusEdit($id)
    {
        $editProtectChcek = $this->bills_model->editProtectCheck($id, 'bill-status');

        if ($editProtectChcek == 0) {
            redirect('bills/billStatusList/');
        }

        $this->global['navTitle']  = '重點法案 - 法案狀態管理 - 編輯';
        $this->global['navActive'] = base_url('bills/billStatusList/');

        $data = array(
            'getBillStatusInfo' => $this->bills_model->getBillStatusInfo($id),
            'status_color'      => $this->bills_model->getBillStatusColor(),
        );

        $this->loadViews("billStatusEdit", $this->global, $data, null);
    }

    public function billStatusEditSend($id)
    {
        $this->form_validation->set_rules('name', '名稱', 'trim|required|max_length[128]|callback_billStatusNameCheck[' . $id . ']');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->billStatusEdit($id);
        } else {
            $name            = $this->security->xss_clean($this->input->post('name'));
            $color           = $this->security->xss_clean($this->input->post('color'));
            $showStatusCheck = $this->input->post('happy');

            $userInfo = array(
                'name'     => $name,
                'color_id' => $color,
            );

            if ($showStatusCheck != null || $showStatusCheck != '' || !empty($showStatusCheck)) {
                $showStatus        = $showStatusCheck == 'Y' ? 1 : 0;
                $userInfo['shows'] = $showStatus;
            }

            $result = $this->bills_model->billStatusEditSend($userInfo, $id);

            if ($result) {
                $this->session->set_flashdata('success', '更新成功!');
                // $this->session->set_userdata('bill-status-update', true);
            } else {
                $this->session->set_flashdata('error', '更新失敗!');
            }

            // echo '<script>history.go(-2);</script>';
            $myRedirect = $this->session->userdata('myRedirect');
            redirect($myRedirect);
        }
    }

    // 法案類別管理編輯
    public function billCategoryEdit($id)
    {
        $editProtectChcek = $this->bills_model->editProtectCheck($id, 'bill-category');

        if ($editProtectChcek == 0) {
            redirect('bills/billCategoryList/');
        }

        $this->global['navTitle']  = '重點法案 - 法案類別管理 - 編輯';
        $this->global['navActive'] = base_url('bills/billCategoryList/');

        $data = array(
            'getBillCategoryInfo' => $this->bills_model->getBillCategoryInfo($id),
        );

        $this->loadViews("billCategoryEdit", $this->global, $data, null);
    }

    public function billCategoryEditSend($id)
    {
        $this->form_validation->set_rules('file', '圖片', 'callback_billCategoryImgCheck[' . $id . ']');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
        $this->form_validation->set_rules('title', '名稱', 'trim|required|max_length[128]|callback_billCategoryNameCheck[' . $id . ']');
        $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('check', '驗證失敗');
            $this->billCategoryEdit($id);
        } else {
            $title           = $this->security->xss_clean($this->input->post('title'));
            $showStatusCheck = $this->input->post('happy');
            $oldImg          = $this->security->xss_clean($this->input->post('img_name'));

            // File upload configuration
            // $uploadPath = dirname(dirname(__DIR__)) . '/assets/uploads/bill_category/';
            $uploadPath              = 'assets/uploads/bill_category/';
            $config['upload_path']   = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png';
            // $config['allowed_types'] = 'jpg|jpeg|png|gif|svg';
            // $config['max_size'] = 1024;

            // Load and initialize upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server
            if ($this->upload->do_upload('file')) {
                $fileData   = $this->upload->data();
                $uploadData = $fileData['file_name'];
            } else {
                // upload debug ,loads the view display.php with error
                // $error = array('error' => $this->upload->display_errors());
                // $this->load->view('upload_debug_form', $error);
            }

            $userInfo = array(
                'gory_id' => $id,
                'title'   => $title,
            );

            if ($showStatusCheck != null || $showStatusCheck != '' || !empty($showStatusCheck)) {
                $showStatus          = $showStatusCheck == 'Y' ? 1 : 0;
                $userInfo['showsup'] = $showStatus;
            }

            // 當新圖片成功上傳時就刪除舊的圖片
            if (!empty($uploadData)) {
                unlink(dirname(dirname(__DIR__)) . '/assets/uploads/bill_category/' . $oldImg);

                $userInfo['img'] = $uploadData;
            }

            $result = $this->bills_model->billCategoryEditSend($userInfo, $id);

            if ($result) {
                $this->session->set_flashdata('success', '更新成功!');
            } else {
                $this->session->set_flashdata('error', '更新失敗!');
            }

            // echo '<script>history.go(-2);</script>';
            $myRedirect = $this->session->userdata('myRedirect');
            redirect($myRedirect);
        }
    }

/*
.########..########.##.......########.########.########
.##.....##.##.......##.......##..........##....##......
.##.....##.##.......##.......##..........##....##......
.##.....##.######...##.......######......##....######..
.##.....##.##.......##.......##..........##....##......
.##.....##.##.......##.......##..........##....##......
.########..########.########.########....##....########
 */

    public function deleteBillCase()
    {
        $id = $this->security->xss_clean($this->input->post('id'));

        $result = $this->bills_model->deleteBillCase($id);

        if ($result > 0) {
            echo (json_encode(array('status' => true)));
        } else {
            echo (json_encode(array('status' => false)));
        }
    }

    public function deleteBillStatus()
    {
        $id = $this->security->xss_clean($this->input->post('id'));

        $result = $this->bills_model->deleteBillStatus($id);

        if ($result > 0) {
            echo (json_encode(array('status' => true)));
        } else {
            echo (json_encode(array('status' => false)));
        }
    }

    // 立法程序
    public function deleteBillSessions()
    {
        $id = $this->security->xss_clean($this->input->post('id'));

        $result = $this->bills_model->deleteBillSessions($id);

        if ($result > 0) {
            echo (json_encode(array('status' => true)));
        } else {
            echo (json_encode(array('status' => false)));
        }
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

    public function billCaseYearCheck($str)
    {
        $years = $this->security->xss_clean($this->input->post('years'));

        $r = !empty($years) ? true : false;

        if (!$r) {
            $this->form_validation->set_message('billCaseYearCheck', '屆期 欄位不可空白');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

            return $r;
        }

        return $r;
    }

    public function billCaseTitleNameCheck($str, $id = '')
    {
        $name       = $this->security->xss_clean($this->input->post('titlename'));
        $nameRepeat = $this->bills_model->billCaseTitleNameCheck($name, $id);

        if ($nameRepeat > 0) {
            $this->form_validation->set_message('billCaseTitleNameCheck', '已有同名的法案草案名稱：「' . $str . '」!');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        } else {
            return true;
        }
    }

    public function billStatusNameCheck($str, $id = '')
    {
        $name       = $this->security->xss_clean($this->input->post('name'));
        $nameRepeat = $this->bills_model->billStatusNameCheck($name, $id);

        if ($nameRepeat > 0) {
            $this->form_validation->set_message('billStatusNameCheck', '已有同名的法案狀態名稱：「' . $str . '」!');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        } else {
            return true;
        }
    }

    // 法案類別封面圖
    public function billCategoryImgCheck($str, $id = '')
    {
        $imgName = $_FILES['file']['name'];

        // 若爲新增功能又沒有選擇圖片或圖片名稱爲空就報錯後離開
        if ($id == '') {
            if (!isset($imgName) || $imgName == '') {
                $this->form_validation->set_message('billCategoryImgCheck', '請選擇要上傳的圖片');
                $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

                return false;
            }
        }

        // 如果圖片檔名有空白字元就報錯後離開
        // \s: 任何空白字元(空白,換行,tab)。\S: 任何非空白字元(空白,換行,tab)。
        $pattern = "/\s/";
        if (preg_match($pattern, $imgName)) {
            // echo 'match';
            $this->form_validation->set_message('billCategoryImgCheck', '圖片名稱不可有空白字元');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

            return false;
        }

        $nameRepeat = $this->bills_model->billCategoryImgCheck($imgName);

        if ($nameRepeat > 0) {
            $this->form_validation->set_message('billCategoryImgCheck', '已有同名的圖片名稱：「' . $imgName . '」!');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        } else {

            // 若爲編輯並且沒有選圖片就爲false離開,否則就檢查圖片格式
            if (!($id != '' && $imgName == '')) {

                // $allowed_mime_type_arr = array('image/gif', 'image/jpeg', 'image/png', 'image/x-png', 'image/svg+xml');
                $allowed_mime_type_arr = array('image/jpeg', 'image/png', 'image/x-png');
                $mime                  = get_mime_by_extension($imgName);

                // 檢查圖片格式。
                // in_array() 函数搜索数组中是否存在指定的值。
                if (in_array($mime, $allowed_mime_type_arr)) {
                    return true;
                } else {
                    $this->form_validation->set_message('billCategoryImgCheck', '圖片格式不正確!<br>請選擇jpg|jpeg|png');
                    $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');

                    return false;
                }
            }
        }
    }

    public function billCategoryNameCheck($str, $id = '')
    {
        $title      = $this->security->xss_clean($this->input->post('title'));
        $nameRepeat = $this->bills_model->billCategoryNameCheck($title, $id);

        if ($nameRepeat > 0) {
            $this->form_validation->set_message('billCategoryNameCheck', '已有同名的類別列表名稱：「' . $str . '」!');
            $this->form_validation->set_error_delimiters('<p style="color:red">', '</p>');
            return false;
        } else {
            return true;
        }
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

    public function billCategorySort()
    {

        $this->global['navTitle']  = '重點法案 - 法案類別管理 - 排序';
        $this->global['navActive'] = base_url('bills/billCategoryList/');

        $data['billCategoryListing'] = $this->bills_model->billCategorySortList();

        $this->loadViews("billCategorySort", $this->global, $data, null);
    }

    public function billCategorySortSend()
    {
        $sort   = $this->security->xss_clean($this->input->post('newSort'));
        $result = $this->bills_model->billCategorySort($sort);

        if ($result > 0) {
            $this->session->set_flashdata('success', '排序已更新!');
        } else {
            $this->session->set_flashdata('error', '排序更新失敗!');
        }
        // 這裏要用排序插件的$.ajax({success})來做路徑導引導才能成功
    }

}
