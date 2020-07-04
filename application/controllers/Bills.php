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

    // 法案草案列表
    public function billCaseList()
    {
        $this->session->unset_userdata('myRedirect');

        $this->global['navTitle']  = '重點法案 - 法案草案管理 - 列表';
        $this->global['navActive'] = base_url('bills/billCaseList/');

        $searchText         = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;

        $count = $this->bills_model->getBillCaseListCount($searchText);

        $returns = $this->paginationCompress('bills/billCaseList/', $count, 10, 3);

        $data['getBillCaseList'] = $this->bills_model->getBillCaseList($searchText, $returns["page"], $returns["segment"]);

        // 進入列表就先將網址儲存起來,到時候編輯的完成後就可導航回原本的列表頁面
        $myRedirect = str_replace('/npp/', '', $_SERVER['REQUEST_URI']);
        $this->session->set_userdata('myRedirect', $myRedirect);

        $this->loadViews('billCaseList', $this->global, $data, null);
    }

    // 法案狀態列表
    public function billStatusList()
    {
        $this->session->unset_userdata('myRedirect');

        $this->global['navTitle']  = '重點法案 - 法案狀態管理 - 列表';
        $this->global['navActive'] = base_url('bills/billStatusList/');

        $searchText         = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;

        $count = $this->bills_model->getBillStatusListCount($searchText);

        $returns = $this->paginationCompress('bills/billStatusList/', $count, 10, 3);

        $data['getBillStatusList'] = $this->bills_model->getBillStatusList($searchText, $returns["page"], $returns["segment"]);

        // 進入列表就先將網址儲存起來,到時候編輯的完成後就可導航回原本的列表頁面
        $myRedirect = str_replace('/npp/', '', $_SERVER['REQUEST_URI']);
        $this->session->set_userdata('myRedirect', $myRedirect);

        $this->loadViews('billStatusList', $this->global, $data, null);
    }

    // 法案類別列表
    public function billCategoryList()
    {
        $this->session->unset_userdata('myRedirect');

        $this->global['navTitle']  = '重點法案 - 法案類別管理 - 列表';
        $this->global['navActive'] = base_url('bills/billCategoryList/');

        $searchText         = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;

        $count = $this->bills_model->getBillCategoryListCount($searchText);

        $returns = $this->paginationCompress('bills/billCategoryList/', $count, 10, 3);

        $data['getBillCategoryList'] = $this->bills_model->getBillCategoryList($searchText, $returns["page"], $returns["segment"]);

        // 進入列表就先將網址儲存起來,到時候編輯的完成後就可導航回原本的列表頁面
        $myRedirect = str_replace('/npp/', '', $_SERVER['REQUEST_URI']);
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

    // 法案草案新增
    public function billCaseAdd()
    {
        $this->global['navTitle']  = '重點法案 - 法案草案管理 - 新增';
        $this->global['navActive'] = base_url('bills/billCaseList/');

        $data = array(
            'getYearsList'    => $this->bills_model->getYearsList(),
            'getBillCategory' => $this->bills_model->getBillCategory(),
            'getBillStatus'   => $this->bills_model->getBillStatus(),
        );

        $this->global['navTitle']  = '本黨立委 - 立委管理 - 新增';
        $this->global['navActive'] = base_url('members/membersList/');

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

                redirect('bills/billCaseList/');

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

        $this->loadViews('billStatusAdd', $this->global, null, null);
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
                'name'  => $name,
                'shows' => $showStatus,
                'color' => $color,
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
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('upload_debug_form', $error);
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
                'name'  => $name,
                'color' => $color,
            );

            if ($showStatusCheck != null || $showStatusCheck != '' || !empty($showStatusCheck)) {
                $showStatus        = $showStatusCheck == 'Y' ? 1 : 0;
                $userInfo['shows'] = $showStatus;
            }

            $result = $this->bills_model->billStatusEditSend($userInfo, $id);

            if ($result) {
                $this->session->set_flashdata('success', '新增成功!');
            } else {
                $this->session->set_flashdata('error', '新增失敗!');
            }

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
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('upload_debug_form', $error);
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
                $this->session->set_flashdata('success', '新增成功!');
            } else {
                $this->session->set_flashdata('error', '新增失敗!');
            }

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

    public function deleteBills()
    {
        $id   = $this->security->xss_clean($this->input->post('id'));
        $type = $this->security->xss_clean($this->input->post('type'));
        $img  = $this->security->xss_clean($this->input->post('img'));

        if ($img != '' || $img != null) {
            unlink(dirname(dirname(__DIR__)) . '/assets/uploads/bill_category/' . $img);
        }

        $result = $this->bills_model->deleteBills($id, $type);

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

    public function billCaseYearCheck($str, $id = '')
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
